<?php

namespace App\Livewire\PSGroup;

use Filament\Forms;
use App\Models\PSGroup;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;

use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;


class EditPsGroup extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public PSGroup $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
        // dd($this->record);
    }

    protected function getForms(): array
{
    return [
        'form',

    ];
}

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TableRepeater::make('ps_expenses')

                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                    ->relationship('p_s_expenses')
                    ->label('')
                    // ->emptyLabel('There are no options added')
                    ->addActionLabel('Add Option')
                    ->schema([
                        TextInput::make('title')
                        ->label('description')
                        ->columnSpan(4),
                        TextInput::make('amount')
                        ->columnSpan(4)
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                        ->prefix('₱')
                        ->numeric()
                        // ->maxValue(9999999999)
                        ->default(0)

                        ->required(),
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

             return redirect()->route('personal-service.index');
    }

    public function render(): View
    {
        return view('livewire.p-s-group.edit-ps-group');
    }
}
