<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectYear;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class LineItemBudget extends Component implements HasForms, HasActions
{

    use InteractsWithActions;
    use InteractsWithForms;


    public ProjectYear $record;


    public function addPersonalServiceAction(): Action
    {
        return Action::make('addPersonalService')
        ->icon('heroicon-m-plus')
        ->extraAttributes([
            'style' => 'border-radius: 100px;',
        ])
        ->form([
            Select::make('cost_type')
            ->options([
                'Direct Cost' => 'Direct Cost',
                'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                'Indirect Cost PCAARD' => 'Indirect Cost PCAARD',
            ])

                ->required(),
        ])
        ->modalHeading('Add/Edit Personnel Services')
        ->modalWidth(MaxWidth::SevenExtraLarge)
        ->action(function (array $data) {

            dd($data);
        });
        // ->action(fn () => dd('addPersonalService'));
    }
    public function addMOOEAction(): Action
    {
        return Action::make('addMOOE')
        ->icon('heroicon-m-plus')
        ->action(fn () => dd('addMOOE'));
    }


    public function render()
    {
        return view('livewire.line-item-budget');
    }
}
