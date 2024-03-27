<?php

namespace App\Livewire\Payee;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\PayeeMember;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListPayee extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(PayeeMember::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([

                CreateAction::make()
                    ->modalHeading('Payee Name')
                    ->label('Add New Member')
                    ->icon('heroicon-m-sparkles')
                    ->form([

                        TextInput::make('name')->maxLength(191)->required()->columnSpanFull(),




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])->disableCreateAnother(),
            ])
            ->actions([
                EditAction::make('edit')
                ->modalHeading('Edit Payee')
                ->using(function (Model $record, array $data): Model {


                    $record->update($data);

                    return $record;
                })
                // ->color('info')
                ->form([
                    TextInput::make('name')->maxLength(191)->required()->columnSpanFull(),
                    // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                ]),
            DeleteAction::make('delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make(),

                ])->label('Actions'),
            ]);
    }

    public function render(): View
    {
        return view('livewire.payee.list-payee');
    }
}
