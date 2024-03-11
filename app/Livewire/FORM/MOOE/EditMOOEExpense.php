<?php

namespace App\Livewire\FORM\MOOE;

use Filament\Forms;
use Filament\Forms\Get;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\MOOEExpense;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class EditMOOEExpense extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public MOOEExpense $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([


                // Checkbox::make('has_sub_options')->inline()->label('Has Sub')

                // ->live(debounce: 500),

                TableRepeater::make('mooe_expense_subs')

                    ->withoutHeader()
                    ->label('Sub Options')
                    ->addActionLabel('Option')
                    ->relationship('m_o_o_e_expense_subs')
                    ->defaultItems(0)
                    ->reorderable(false)
                    // ->withoutHeader()
                    ->emptyLabel('No Options')
                    ->hideLabels()
                    ->schema([
                        TextInput::make('title')
                            ->hiddenLabel()

                            ->label('Sub description'),


                        // TableRepeater::make('mooe_items')

                        //     // ->withoutHeader()
                        //     ->label('Sub Options')
                        //     ->addActionLabel('Option')
                        //     ->relationship('m_o_o_e_items')
                        //     ->defaultItems(0)
                        //     ->reorderable(false)
                        //     // ->withoutHeader()
                        //     ->emptyLabel('No Options')
                        //     ->hideLabels()
                        //     ->schema([
                        //         TextInput::make('title')
                        //             ->hiddenLabel()

                        //             ->label('Sub description'),

                        //     ]),



                    ])
                    ->columnSpan('full')
                    ->visible(function (Get $get, $record) {
                        if (!empty($get('has_sub_options'))) {

                            // if($this){

                            // }

                            return true;
                        } else {
                            return false;
                        }
                    })
                    ,

                // TableRepeater::make('mooe_expenses')

                // ->columnWidths([
                //     'title' => '300px',
                //     'has_sub_options' => '200px',
                //     'mooe_expense_subs' => '500px',
                // ])
                // ->withoutHeader()
                // ->relationship('m_o_o_e_expenses')
                // ->label('')
                // // ->emptyLabel('There are no options added')
                // ->addActionLabel('Add Option')
                // ->schema([]);
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save()
    {
        $data = $this->form->getState();

        $this->record->update($data);

        Notification::make()
        ->title('Saved successfully')
        ->success()
        ->send();

      return redirect()->route('mooe.expense.list',['record'=> $this->record->m_o_o_e_group_id]);

    }

    public function render(): View
    {
        return view('livewire.f-o-r-m.m-o-o-e.edit-m-o-o-e-expense');
    }
}
