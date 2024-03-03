<?php

namespace App\Livewire\MOOEGroup;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\MOOEGroup;
use Filament\Support\RawJs;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Notifications\Notification;

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

                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                    ->relationship('m_o_o_e_expenses')
                    ->label('')
                    // ->emptyLabel('There are no options added')
                    ->addActionLabel('Add Option')
                    ->schema([
                        TextInput::make('title')
                        ->label('Description')
                        ->columnSpan(4)
                        ->required()
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
