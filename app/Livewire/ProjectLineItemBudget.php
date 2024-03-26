<?php

namespace App\Livewire;

use Closure;
use App\Models\Year;
use App\Models\Project;
use Livewire\Component;
use App\Enums\AppConstant;
use Filament\Tables\Table;
use App\Models\ProjectYear;

use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\Action as TAction;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;


class ProjectLineItemBudget extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithForms;
    public Project $record;


    public function table(Table $table): Table
    {
        return $table
            ->query(ProjectYear::query())
            ->headerActions([

                TAction::make('add')
            ->icon('heroicon-m-plus')
            ->label('Add Year')
            ->form([
                Select::make('year_id')

                    ->label('Year')
                    ->options(Year::query()->whereDoesntHave('project_years', function ($query) {
                        $query->where('project_id', $this->record->id);
                    })->pluck('title', 'id'))
                    ->rules([
                        function () {
                            return function (string $attribute, $value, Closure $fail) {
                                $exist_project_year = ProjectYear::where('project_id', $this->record->id)
                                    ->where('year_id', $value)
                                    ->exists();

                                if ($exist_project_year) {
                                    $fail('Cannot create, it already exists.');
                                }
                            };
                        },
                    ])
                    ->required(),
            ])
            ->action(function (array $data) {
                DB::beginTransaction();

                try {
                    // Perform database operations inside the transaction

                    $project_years = ProjectYear::where('project_id', $this->record->id)->where('is_active', true)->get();
                    $new_record = ProjectYear::create([
                        'project_id' => $this->record->id,
                        'year_id' => $data['year_id'],
                        'is_active' => count($project_years) === 0,
                    ]);



                    if (!empty($new_record)) {
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                        // Commit the transaction
                        DB::commit();
                        return redirect()->route('project.line-items', ['record' => $new_record]);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();


                    Notification::make()
                        ->title('Failed to save data: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    // Redirect back or to an error page
                    return redirect()->route('project.line-items');
                }
            })

            ])
            ->columns([
                TextColumn::make('year.title')->formatStateUsing(function ($state) {
                    return $state . ' LIB';
                }),
                ViewColumn::make('')->label('Total Year Budget')->view('tables.columns.total-line-item-budget'),
                TextColumn::make('status')->label('LIB STATUS')->badge()
                ->color(fn (string $state): string => match ($state) {
                    ProjectYear::STATUS_FOR_EDITING => 'gray',
                    ProjectYear::STATUS_FOR_REVIEW => 'gray',
                    ProjectYear::STATUS_REVIEWING => 'gray',
                    ProjectYear::STATUS_REJECTED => 'danger',
                    ProjectYear::STATUS_APPROVED => 'success',
                    default => 'gray',
                })
                ,
                ToggleColumn::make('is_active')
                    ->label('Currently in Use')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->onColor('success')


                    ->updateStateUsing(function ($record, $state) {
                        $activeYear = ProjectYear::where('is_active', true)->exists();

                        if ($record->is_active) {
                            // Deactivate the current active year
                            $record->update(['is_active' => false]);
                            Notification::make()
                                ->title('Project Year was set to Inactive')
                                ->success()
                                ->send();
                        } else {
                            if ($activeYear) {
                                Notification::make()
                                    ->title('Operation Failed')
                                    ->body('You can only activate one (1) project year at a time.')
                                    ->danger()
                                    ->send();
                                // Prevent activation if another year is already active
                            } else {
                                // Activate the year if no other year is active
                                $record->update(['is_active' => true]);
                                Notification::make()
                                    ->title('Project Year was set to Active')
                                    ->success()
                                    ->send();
                            }
                        }
                    })




            ])
            ->filters([
                // ...
            ])
            ->actions([
                // TAction::make('monitor')->icon('heroicon-m-cursor-arrow-rays')->button()->label('MONITOR LIB')
                //     ->outlined()
                //     // ->extraAttributes([
                //     //     'style' => 'border-radius: 100px; font-size: 14px',

                //     // ])
                //     ->url(fn (Model $record): string => route('project.line-items-view', ['record' => $record->id])),
                TAction::make('view')->icon('heroicon-m-eye')->label('VIEW')->color('gray')
                ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->button()
                    ->outlined()
                    ->url(fn (Model $record): string => route('project.line-items-view-v3', ['record' => $record->id])),

                TAction::make('edit')->icon('heroicon-m-pencil-square')->label('EDIT LIB')->color('primary')
                ->extraAttributes(AppConstant::ACTION_STYLE)

                    ->button()
                    ->outlined()


                    ->url(fn (Model $record): string => route('project.line-items', ['record' => $record->id])),
                TAction::make('copy')->icon('heroicon-m-clipboard-document')->label('COPY LIB')
                ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->color('gray')

                    ->button()
                    ->outlined()

                    ->form([
                        Select::make('year_id')

                            ->label('Year')
                            // ->options(Year::query()->whereDoesntHave('project_years', function ($query) {
                            //     $query->where('project_id', $this->record->id);
                            // })->pluck('title', 'id'))
                            ->relationship(
                                name: 'year',
                                titleAttribute: 'title',
                                modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('project_years', function ($query) {
                                    $query->where('project_id', $this->record->id);
                                })
                            )
                            ->createOptionForm([
                                TextInput::make('title')
                                    ->required(),

                            ])
                            // ->relationship(
                            //     name: 'year',
                            //     titleAttribute: 'title',
                            //     ignoreRecord: true,
                            //     modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('project_years', function ($query) {
                            //             $query->where('project_id', $this->record->id);
                            //         }),
                            //     )
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, Closure $fail) {


                                        $exist_project_year = ProjectYear::where('project_id', $this->record->id)->where('year_id', $value)->exists();


                                        if ($exist_project_year) {
                                            $fail('Cannot create, it already exists.');
                                        }
                                    };
                                },
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data,  Model $record) {
                        // $record->with(['selected_p_ses', 'selected_m_o_o_es', 'selected_c_os']);

                        if ($record) {
                            // Detach the relationships to avoid duplication


                            // Start a database transaction to ensure atomicity
                            DB::beginTransaction();

                            try {
                                // Replicate the main ProjectYear instance
                                $new_project_year = $record->replicate();
                                $new_project_year->year_id = $data['year_id'];
                                // Save the new instance
                                $new_project_year->save();

                                // Replicate and attach associated relationships if they exist
                                if ($record->selected_p_ses->isNotEmpty()) {
                                    foreach ($record->selected_p_ses as $selected_p_se) {
                                        $new_selected_p_se = $selected_p_se->replicate();
                                        $new_selected_p_se->project_year_id = $new_project_year->id; // Override project_year_id
                                        $new_selected_p_se->save();
                                    }
                                }

                                if ($record->selected_m_o_o_es->isNotEmpty()) {
                                    foreach ($record->selected_m_o_o_es as $selected_m_o_o_e) {
                                        $new_selected_m_o_o_e = $selected_m_o_o_e->replicate();
                                        $new_selected_m_o_o_e->project_year_id = $new_project_year->id; // Override project_year_id
                                        $new_selected_m_o_o_e->save();
                                    }
                                }

                                if ($record->selected_c_os->isNotEmpty()) {
                                    foreach ($record->selected_c_os as $selected_c_o) {
                                        $new_selected_c_o = $selected_c_o->replicate();
                                        $new_selected_c_o->project_year_id = $new_project_year->id; // Override project_year_id
                                        $new_selected_c_o->save();
                                    }
                                }

                                // Commit the transaction if everything is successful
                                DB::commit();

                                Notification::make()
                                    ->title('Saved successfully')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                // Rollback the transaction if an error occurs
                                DB::rollBack();
                                echo "Error: " . $e->getMessage();
                                Notification::make()
                                    ->title('Failed to Copy' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }


                        // dd($new_copy);

                        // ProjectYear::create([
                        //     'project_id' => $this->record->id,
                        //     'year_id' => $data['year_id'],
                        // ]);

                        // Notification::make()
                        // ->title('Saved successfully')
                        // ->success()
                        // ->send();
                        // return redirect()->route('project.line-item-budget');
                        // $record->author()->associate($data['authorId']);
                        // $record->save();
                    }),
                DeleteAction::make('delete')->icon('heroicon-m-x-mark')
                ->color('gray')
                    ->button()
                    ->outlined()
                    ->extraAttributes(AppConstant::ACTION_STYLE)
                    ,
                // ActionGroup::make([


                // ]),


            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->where('project_id', $this->record->id));
    }




    public function addAction(): Action
    {
        return Action::make('add')
            ->icon('heroicon-m-plus')
            ->label('Add Year')
            ->form([
                Select::make('year_id')

                    ->label('Year')
                    ->options(Year::query()->whereDoesntHave('project_years', function ($query) {
                        $query->where('project_id', $this->record->id);
                    })->pluck('title', 'id'))
                    ->rules([
                        function () {
                            return function (string $attribute, $value, Closure $fail) {
                                $exist_project_year = ProjectYear::where('project_id', $this->record->id)
                                    ->where('year_id', $value)
                                    ->exists();

                                if ($exist_project_year) {
                                    $fail('Cannot create, it already exists.');
                                }
                            };
                        },
                    ])
                    ->required(),
            ])
            ->action(function (array $data) {
                DB::beginTransaction();

                try {
                    // Perform database operations inside the transaction

                    $project_years = ProjectYear::where('project_id', $this->record->id)->where('is_active', true)->get();
                    $new_record = ProjectYear::create([
                        'project_id' => $this->record->id,
                        'year_id' => $data['year_id'],
                        'is_active' => count($project_years) === 0,
                    ]);



                    if (!empty($new_record)) {
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                        // Commit the transaction
                        DB::commit();
                        return redirect()->route('project.line-items', ['record' => $new_record]);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();


                    Notification::make()
                        ->title('Failed to save data: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    // Redirect back or to an error page
                    return redirect()->route('project.line-items');
                }
            });
        // ->action(fn () => $this->test());
    }

    public function test()
    {
    }
    public function render()
    {

        $project_total_budget =  ProjectYear::where('project_id', $this->record->id)->get()->sum(function ($item) {
            $total_ps = $item->selected_p_ses()->with('p_s_expense')->get()->sum('p_s_expense.amount');
            $total_mooe = $item->selected_m_o_o_es()->sum('amount');
            $total_co = $item->selected_c_os()->sum('amount');
            $year_total = ($total_ps  + $total_mooe + $total_co);
            return $year_total;


            // $project_total_budget += $year_total;

        });


        //     $project_total_budget = 0;
        //    foreach ($project_years as $project_year) {
        //     $total_ps = $project_year->selected_p_ses()->with('p_s_expense')->get()->sum('p_s_expense.amount');
        //     $total_mooe = $project_year->selected_m_o_o_es()->sum('amount');
        //     $total_co = $project_year->selected_c_os()->sum('amount');
        //     $year_total = ($total_ps  +$total_mooe + $total_co);
        //     $project_total_budget += $year_total;
        //    }



        return view('livewire.project-line-item-budget', [
            'project_total_budget' => $project_total_budget,
        ]);
    }
}
