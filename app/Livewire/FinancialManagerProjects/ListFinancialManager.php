<?php

namespace App\Livewire\FinancialManagerProjects;

use Filament\Tables;
use App\Models\Project;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Tables\Actions\Action as TAction;
class ListFinancialManager extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;


    public function assignedProjectsAction(): Action
    {
        return Action::make('assignedProjects')
            ->label('Manage')
            ->url(fn () => route('financial-manager.assigned.projects'))
            ->icon('heroicon-m-paper-clip')

            // ->extraAttributes([
            //     'style' => 'outline: none;
            //      box-shadow: none ;
            //      font-size: 10px;
            //      color: #9ca3af;
            //  ',
            // ])

            ;
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Project::query())
            ->columns([

                TextColumn::make('assigned_project')
                ->formatStateUsing(function ($state) {
                    if(!empty($state->assigned_projectable)){

                        return $state->assigned_projectable->first_name.' '.$state->assigned_projectable->first_name;
                    }else{
                        return '';
                    }
                })
                ->badge()
                ->color('primary')
                ,
                ViewColumn::make('')->view('tables.columns.project-total-budget')->label('Total Budget'),
                TextColumn::make('title')
                    ->searchable()->label('Project Title')->wrap(),
                // TextColumn::make('allocated_fund')
                //     ->money('PHP')
                //     ->numeric(
                //         decimalPlaces: 0,
                //     )

                //     ->prefix('₱ ')
                //     ->sortable(),

                TextColumn::make('start_date')
                    ->date()

                    ->label('Start Date')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('program_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('title')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('project_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('implementing_agency')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('monitoring_agency')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('project_leader')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('allocated_fund')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('total_usage')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('start_date')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('end_date')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('status')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                TAction::make('manage')
                ->icon('heroicon-m-pencil-square')
                ->label('Manage Lib')
                ->url(fn (Model $record): string => route('project.line-item-budget', ['record'=> $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('assigned_project', function ($query) {
                $query->where('assigned_projectable_id', Auth::user()->id);
            }));
    }

    public function render(): View
    {
        $projects = Project::whereHas('assigned_project', function ($query) {
            return $query->where('assigned_projectable_id', Auth::user()->id);
        })->get();

        return view('livewire.financial-manager-projects.list-financial-manager', compact('projects'));
    }
}
