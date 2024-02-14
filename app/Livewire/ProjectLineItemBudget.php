<?php

namespace App\Livewire;

use Closure;
use App\Models\Year;
use App\Models\Project;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\ProjectYear;
use Filament\Actions\Action;

use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Tables\Actions\Action as TAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class ProjectLineItemBudget extends Component implements HasForms, HasActions ,HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithForms;
    public Project $record;


    public function table(Table $table): Table
    {
        return $table
            ->query(ProjectYear::query())
            ->columns([
                TextColumn::make('year.title'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                TAction::make('edit')->icon('heroicon-m-pencil')->label('Edit')->color('info')->button()
                ->extraAttributes([
                    'style' => 'border-radius: 100px;',

                ])
                ->url(fn (Model $record): string => route('project.line-items', ['record' => $record->id]))
                ,
                TAction::make('copy')->icon('heroicon-m-clipboard-document')->label('Copy Lib')->color('warning')->button()
                ->extraAttributes([
                    'style' => 'border-radius: 100px; background-color: #16a34a',
                ])
                ,
                DeleteAction::make('delete')->icon('heroicon-m-x-mark')

                ->extraAttributes([
                    'style' => 'border-radius: 100px; background-color: #be123c',
                ])
                ->button()->extraAttributes([
                    'style' => 'border-radius: 100px;',

                ]),
            ])
            ->bulkActions([
                // ...
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->where('project_id', $this->record->id))
            ;
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

                ProjectYear::create([
                    'project_id' => $this->record->id,
                    'year_id' => $data['year_id'],
                ]);

                Notification::make()
                ->title('Saved successfully')
                ->success()
                ->send();
                // return redirect()->route('project.line-item-budget');
                // $record->author()->associate($data['authorId']);
                // $record->save();
            });
        // ->action(fn () => $this->test());
    }

    public function test()
    {
    }
    public function render()
    {

        return view('livewire.project-line-item-budget',[
            'project_years' => ProjectYear::all(),
        ]);
    }
}
