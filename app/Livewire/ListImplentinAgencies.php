<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;

use App\Models\Shop\Product;
use App\Models\ImplementingAgency;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListImplentinAgencies extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ImplementingAgency::query())
            ->columns([
                TextColumn::make('title')->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->headerActions([

                CreateAction::make()
                    ->modalHeading('Create Implimenting Agency')
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
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.list-implentin-agencies');
    }
}
