<?php

namespace App\Livewire\MOOEGroup;

use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\MOOEGroup;
use Filament\Support\RawJs;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class EditMOOEGroup extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public MOOEGroup $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                TableRepeater::make('mooe_expenses')

                    ->columnWidths([
                        'title' => '300px',
                        'has_sub_options' => '200px',
                        'mooe_expense_subs' => '500px',
                    ])
                    ->withoutHeader()
                    ->relationship('m_o_o_e_expenses')
                    ->label('')
                    // ->emptyLabel('There are no options added')
                    ->addActionLabel('Add Option')
                    ->schema([
                        TextInput::make('title')
                            ->label('Description')
                            ->required(),

                        Checkbox::make('has_sub_options')->inline()->label('Has Sub')
                            ->formatStateUsing(function ($state, Get $get, Set $set) {
                                $set('a', $state);
                            })
                            ->live(debounce: 500),
                            TableRepeater::make('mooe_expense_subs')


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

                                        ->label('Sub description')

                                ])
                                ->columnSpan('full')
                                ->visible(function (Get $get, $record) {
                                    if(!empty($get('has_sub_options'))){

                                        return true;
                                    }else{
                                        return false;
                                    }
                                })
                                ,





                    ])
                    ->columnSpan('full')
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

        return redirect()->route('mooe.index');
    }

    public function render(): View
    {
        return view('livewire.m-o-o-e-group.edit-m-o-o-e-group');
    }
}
