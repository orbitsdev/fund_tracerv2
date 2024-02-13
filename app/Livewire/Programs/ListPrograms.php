<?php

namespace App\Livewire\Programs;

use Filament\Tables;
use App\Models\Program;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListPrograms extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Program::query())
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable(
                        // isIndividual:true,
                    ),
                TextColumn::make('program_leader')
                    ->wrap()
                    ->label('Program Leader')
                    ->searchable(
                        // isIndividual:true,
                    ),

                TextColumn::make('total_budget')
                    ->label('Total Budget')
                    ->prefix('₱ ')
                    ->numeric()
                    // ->weight(FontWeight::Bold)
                    // ->badge()
                    ->sortable(),




                TextColumn::make('projects')
                    ->listWithLineBreaks()
                    ->label('Project & Allocated Fund')
                    ->wrap()
                    ->color('primary')
                    ->separator(',')
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->formatStateUsing(function ($state) {
                        return $state->title . ' - ₱' . number_format($state->allocated_fund);
                        // return $state->title;
                    })
                    ->tooltip(function (Model $record): string {
                        return "\n" . $record->projects->map(function ($project, $index) {
                            return ($index + 1) . ". {$project->title}";
                        })->implode("\n");
                    }),

                TextColumn::make('start_date')

                    ->date()
                    ->label('Start'),
                TextColumn::make('end_date')


                    ->date()
                    ->label('End'),



                TextColumn::make('total_budget')
                    ->numeric()
                    ->summarize([
                        Sum::make()->label('Total')
                    ]),





            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('edit')
                    ->icon('heroicon-m-plus')
                    ->label('Create')
                    ->url(fn (): string => route('program.create'))
            ])
            ->actions([
                //
                Action::make('edit')
                ->icon('heroicon-m-pencil')
                ->label('Edit')
                ->url(fn (Model $record): string => route('program.edit', ['record'=> $record])),
                // Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->recordUrl(null)
            ->modifyQueryUsing(fn (Builder $query) => $query->latest());
    }

    public function render(): View
    {
        return view('livewire.programs.list-programs');
    }
}
