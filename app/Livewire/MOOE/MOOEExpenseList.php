<?php

namespace App\Livewire\MOOE;

use Filament\Tables;
use Livewire\Component;
use App\Models\MOOEGroup;
use Filament\Tables\Table;
use App\Models\MOOEExpense;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class MOOEExpenseList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public MOOEGroup $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(MOOEExpense::query()->where('m_o_o_e_group_id', $this->record->id))
            ->columns([
                TextColumn::make('title')->searchable(),
                CheckboxColumn::make('has_sub_options')
                    ->afterStateUpdated(function ($record, $state) {
                        Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                    }),
                TextColumn::make('m_o_o_e_expense_subs')
                    ->label('Options')
                    ->formatStateUsing(function ($state) {
                        return $state->title;
                    })
                    ->listWithLineBreaks()
                    ->bulleted()
            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()
                    ->modalHeading('Create MOOE Subcategories')
                    ->label('MOE SUBCategories')
                    ->icon('heroicon-m-sparkles')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['m_o_o_e_group_id'] = $this->record->id;

                        return $data;
                    })
                    ->form([

                        TextInput::make('title')->maxLength(191)->required()->columnSpanFull(),


                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])->disableCreateAnother(),
            ])
            ->actions([
                Action::make('Manage')
                    ->label('Manage SUB')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn ($record): string => route('mooe.edit.expense.mooe', ['record' => $record]),)
                    ->hidden(function(Model $record){
                        if($record->has_sub_options){
                            return false;
                        }else{
                            return true;
                        }
                    })
                    ,
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
        return view('livewire.m-o-o-e.m-o-o-e-expense-list');
    }
}
