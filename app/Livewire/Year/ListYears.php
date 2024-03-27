<?php

namespace App\Livewire\Year;

use App\Models\Year;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListYears extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Year::query())
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
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
            ->headerActions([

                CreateAction::make()
                    ->modalHeading('Create Year Option')
                    ->label('Add New')
                    ->icon('heroicon-m-sparkles')
                    ->form([

                        TextInput::make('title')->maxLength(191)->required()->columnSpanFull(),




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])->disableCreateAnother(),
            ])
            ->actions([
                EditAction::make('edit')
                ->modalHeading('Edit Group')
                ->using(function (Model $record, array $data): Model {


                    $record->update($data);

                    return $record;
                })
                // ->color('info')
                ->form([
                    TextInput::make('title')->maxLength(191)->required()->columnSpanFull(),
                    // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                ]),
            DeleteAction::make('delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.year.list-years');
    }
}
