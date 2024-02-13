<?php

namespace App\Livewire;

use App\Models\MOOEGroup;
use Livewire\Component;


use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Particular;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Filament\Tables\Actions\Action;
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

class ListMOOE extends Component  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        return $table
            ->query(MOOEGroup::query())
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('m_o_o_e_expenses')
                ->label('Options')
                ->formatStateUsing(function($state){
                    return $state->title;
                })
                    ->listWithLineBreaks()
                    ->bulleted()

            ])
            ->filters([
                // ...
            ])
            ->headerActions([

                CreateAction::make()
                    ->modalHeading('Ceate Group')
                    ->label('New Group')
                    ->icon('heroicon-m-sparkles')
                    ->form([

                        TextInput::make('title')->maxLength(191)->required()->columnSpanFull(),


                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])->disableCreateAnother(),
            ])

            ->actions([
                Action::make('Manage')
                    ->label('Manage')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn ($record): string => route('mooe.edit', ['record' => $record])),
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
            ->bulkActions([]);
    }
    public function render()
    {
        return view('livewire.list-m-o-o-e');
    }
}
