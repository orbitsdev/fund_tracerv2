<?php

namespace App\Livewire;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use App\Models\Particular;

use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListParticulars extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        return $table
            ->query(Particular::query())
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('abbreviation')->searchable()->badge(),
            ])
            ->filters([
                // ...
            ])
            ->headerActions([
                //   Action::make('dasd'),
                CreateAction::make()
                ->label('New Particular')
                ->icon('heroicon-m-sparkles')
                ->form([
                    TextInput::make('title')->maxLength(191)->required()->columnSpanFull()
                    ->live()
                    ->debounce(700)

                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::setRecommendedAbbreviation ($get, $set);
                    })
                    ,
                    TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                ])->disableCreateAnother(),
            ])

            ->actions([
                EditAction::make('edit')
                // ->color('info')
                ->form([
                    TextInput::make('title')->maxLength(191)->required()->columnSpanFull()
                    ->live()
                    ->debounce(700)

                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::setRecommendedAbbreviation ($get, $set);
                    })
                    ,
                    TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                ]),
                DeleteAction::make('delete'),
            ])
            ->bulkActions([

            ]);
    }

    public function render()
    {
        return view('livewire.list-particulars');
    }

    public static function setRecommendedAbbreviation(Get $get , Set $set){


        if (!empty($get('title'))) {

            $set('abbreviation', Str::acronym($get('title')));
        }

    }

}
