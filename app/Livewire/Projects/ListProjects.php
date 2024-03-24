<?php

namespace App\Livewire\Projects;

use Filament\Tables;
use App\Models\Project;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListProjects extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Project::query())
            ->columns([

                TextColumn::make('assigned_project')
                    ->formatStateUsing(function ($state) {
                        if (!empty($state->assigned_projectable)) {

                            return $state->assigned_projectable->first_name . ' ' . $state->assigned_projectable->first_name;
                        } else {
                            return '';
                        }
                    })
                    ->label('BUDGER MANAGER')
                    ->badge()
                    ->color('primary'),

                ViewColumn::make('')->view('tables.columns.project-total-budget')->label('DOST FUND'),
                TextColumn::make('title')
                    ->searchable()->label('PROJECT TITLE')->wrap(),
                // TextColumn::make('allocated_fund')
                //     ->money('PHP')
                //     ->numeric(
                //         decimalPlaces: 0,
                //     )

                //     ->prefix('₱ ')
                //     ->sortable(),

                TextColumn::make('start_date')
                    ->date()

                    ->label('START DATE')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('END DATE')
                    ->date()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([

                CreateAction::make('create')
                    ->icon('heroicon-m-plus')
                    ->label('Create')
                    ->url(fn (): string => route('project.create'))

                // CreateAction::make('create')->form([
                // ])

            ])
            ->actions([
                Action::make('view')
                    ->icon('heroicon-m-pencil-square')
                    ->label('MANAGE LIB')
                    ->url(fn (Model $record): string => route('project.line-item-budget', ['record' => $record])),
                // Action::make('monitor')

                // ->label('Monitor Lib')
                // ->url(fn (Model $record): string => route('project.line-item-budget', ['record'=> $record]))
                // ->button()
                // ->color('gray')
                // ->outlined()
                // ,

                ActionGroup::make([
                    // Action::make('view')
                    //     ->icon('heroicon-m-eye')
                    //     ->color('primary')
                    //     ->label('View')
                    //     ->url(fn (Model $record): string => route('project.view', ['record' => $record])),

                    Action::make('edit')
                        ->icon('heroicon-m-pencil')
                        ->label('Edit')
                        ->color('primary')

                        ->url(fn (Model $record): string => route('project.edit', ['record' => $record])),

                    // Tables\Actions\EditAction::make()->label('Edit'),
                    Tables\Actions\DeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                    ->label('Actions'),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->latest());;
    }

    public function render(): View
    {
        return view('livewire.projects.list-projects');
    }
}
