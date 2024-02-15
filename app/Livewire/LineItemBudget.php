<?php

namespace App\Livewire;

use App\Models\PSGroup;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use App\Models\MOOEGroup;
use App\Models\PSExpense;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\MOOEExpense;
use App\Models\ProjectYear;
use Filament\Support\RawJs;
use App\Models\SelectedMOOE;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class LineItemBudget extends Component implements HasForms, HasActions
{

    use InteractsWithActions;
    use InteractsWithForms;


    public ProjectYear $record;


    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->size(ActionSize::Large)
            ->iconButton()
            ->icon('heroicon-m-x-mark')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $ps = SelectedPS::find($arguments['ps']);
                $ps?->delete();

                Notification::make()
                    ->title('Delete successfully')
                    ->success()
                    ->send();
            });
    }

    public function deleteMooeAction(): Action
    {
        return Action::make('deleteMooe')
            ->size(ActionSize::Large)
            ->iconButton()
            ->icon('heroicon-m-x-mark')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $ps = SelectedMOOE::find($arguments['mooe']);
                $ps?->delete();

                Notification::make()
                    ->title('Delete successfully')
                    ->success()
                    ->send();
            });
    }


    public function deleteCoAction(): Action
    {
        return Action::make('deleteCo')
            ->size(ActionSize::Large)
            ->iconButton()
            ->icon('heroicon-m-x-mark')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $ps =  SelectedCo::find($arguments['co']);
                $ps?->delete();

                Notification::make()
                    ->title('Delete successfully')
                    ->success()
                    ->send();
            });
    }
    public function editPersonalServiceAction(): Action
    {
        return Action::make('editPersonalService')
            ->size(ActionSize::Large)
            ->icon('heroicon-m-pencil-square')
            ->iconButton()
            ->fillForm(function (array $arguments) {
                $ps = SelectedPS::find($arguments['ps']);
                return [
                    'cost_type' => $ps?->cost_type,
                    'p_s_group_id' => $ps?->p_s_group_id,
                    'p_s_expense_id' => $ps?->p_s_expense_id,
                ];
            })
            ->form([
                Select::make('cost_type')
                    ->options([
                        'Direct Cost' => 'Direct Cost',
                        'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                        'Indirect Cost PCAARD' => 'Indirect Cost PCAARD',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('p_s_group_id')
                    ->label('PS Type')
                    ->options(PSGroup::all()->pluck('title', 'id'))
                    ->live()
                    ->searchable()
                    ->afterStateUpdated(function (Set $set) {
                        $set('p_s_expense_id', null);
                    })
                    ->native(false)
                    ->required()
                    ->searchable(),
                Select::make('p_s_expense_id')
                    ->label('Position/Designation')
                    ->required()
                    ->options(function (Get $get, Set $set) {
                        if (!empty($get('p_s_group_id'))) {
                            return PSExpense::where('p_s_group_id', $get('p_s_group_id'))->get()->pluck('title', 'id');
                        } else {
                            return [];
                        }
                    })
                    ->native(false)
                    ->searchable()
            ])
            ->modalHeading('Add/Edit Personnel Services')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data, array $arguments) {

                $ps = SelectedPS::find($arguments['ps']);
                $ps_expenses = PSExpense::where('id', $data['p_s_expense_id'])->first();
                $amount = $ps_expenses->amount;

                $final_data = [
                    // 'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'p_s_group_id' => $data['p_s_group_id'],
                    'p_s_expense_id' => $data['p_s_expense_id'],
                    'amount' => $amount,
                ];

                $ps->update($final_data); // Corrected update method

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            });
        // ->action(fn () => dd('addPersonalService'));
    }
    public function addPersonalServiceAction(): Action
    {
        return Action::make('addPersonalService')
            ->label('Add Personal Service')
            ->icon('heroicon-m-plus')
            ->extraAttributes([
                'style' => 'border-radius: 100px;',
            ])
            ->form([
                Select::make('cost_type')
                    ->options([
                        'Direct Cost' => 'Direct Cost',
                        'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                        'Indirect Cost PCAARRD' => 'Indirect Cost PCAARRD',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('p_s_group_id')
                    ->label('PS Type')
                    ->options(PSGroup::all()->pluck('title', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('p_s_expense_id', null);
                    })

                    ->native(false)
                    ->searchable()
                    ->required(),
                Select::make('p_s_expense_id')
                    ->required()
                    ->label('Position/Designation')

                    ->options(function (Get $get, Set $set) {
                        if (!empty($get('p_s_group_id'))) {
                            return PSExpense::where('p_s_group_id', $get('p_s_group_id'))->get()->pluck('title', 'id');
                        } else {
                            return [];
                        }
                    })
                    ->native(false)
                    ->searchable()
            ])
            ->modalHeading('Add/Edit Personnel Services')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data) {
                $ps_expenses = PSExpense::where('id', $data['p_s_expense_id'])->first();
                $amount = $ps_expenses->amount;
                $final_data = [
                    'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'p_s_group_id' => $data['p_s_group_id'],
                    'p_s_expense_id' => $data['p_s_expense_id'],
                    'amount' => $amount,
                ];



                SelectedPS::create($final_data);

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
                // dd($data);
            });
        // ->action(fn () => dd('addPersonalService'));
    }

    public function addMOOEAction(): Action
    {
        return Action::make('addMOOE')
            ->extraAttributes([
                'style' => 'border-radius: 100px;',
            ])
            ->icon('heroicon-m-plus')
            ->label('Add MOOE')
            ->form([
                Select::make('cost_type')
                    ->options([
                        'Direct Cost' => 'Direct Cost',
                        'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                        'Indirect Cost PCAARRD' => 'Indirect Cost PCAARRD',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('m_o_o_e_group_id')
                    ->label('MOOE Type')
                    ->options(MOOEGroup::all()->pluck('title', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('m_o_o_e_expense_id', null);
                    })
                    ->required()
                    ->native(false)
                    ->searchable(),

                Select::make('m_o_o_e_expense_id')
                    ->label('MOOE Subcategories')
                    ->required()
                    ->options(function (Get $get, Set $set) {
                        if (!empty($get('m_o_o_e_group_id'))) {
                            return MOOEExpense::where('m_o_o_e_group_id', $get('m_o_o_e_group_id'))->get()->pluck('title', 'id');
                        } else {
                            return [];
                        }
                    })
                    ->native(false)
                    ->searchable(),

                TextInput::make('amount')
                    ->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->prefix('₱')
                    ->numeric()
                    ->default(0)
                    ->label('Allocated Amount')
                    ->required()



            ])
            ->modalHeading('Add/Edit MMOOE')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data) {

                $ps_expenses = MOOEExpense::find($data['m_o_o_e_group_id']);
                $final_data = [
                    'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'm_o_o_e_group_id' => $data['m_o_o_e_group_id'],
                    'm_o_o_e_expense_id' => $data['m_o_o_e_expense_id'],
                    'amount' => $data['amount'],
                ];



                // SelectedM::create($final_data);
                SelectedMOOE::create($final_data);

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            });
    }


    public function editMooeAction(): Action
    {
        return Action::make('editMooe')

            ->icon('heroicon-m-plus')
            ->iconButton()
            ->fillForm(function (array $arguments) {
                $mooe = SelectedMOOE::find($arguments['mooe']);
                return [
                    'cost_type' => $mooe?->cost_type,
                    'm_o_o_e_group_id' => $mooe?->m_o_o_e_group_id,
                    'm_o_o_e_expense_id' => $mooe?->m_o_o_e_expense_id,
                    'amount' => $mooe?->amount,
                ];
            })
            ->form([
                Select::make('cost_type')
                    ->options([
                        'Direct Cost' => 'Direct Cost',
                        'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                        'Indirect Cost PCAARRD' => 'Indirect Cost PCAARRD',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('m_o_o_e_group_id')
                    ->label('MOOE Type')
                    ->options(MOOEGroup::all()->pluck('title', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('m_o_o_e_expense_id', null);
                    })
                    ->required()
                    ->native(false)
                    ->searchable(),

                Select::make('m_o_o_e_expense_id')
                    ->label('MOOE Subcategories')
                    ->required()
                    ->options(function (Get $get, Set $set) {
                        if (!empty($get('m_o_o_e_group_id'))) {
                            return MOOEExpense::where('m_o_o_e_group_id', $get('m_o_o_e_group_id'))->get()->pluck('title', 'id');
                        } else {
                            return [];
                        }
                    })
                    ->native(false)
                    ->searchable(),

                TextInput::make('amount')
                    ->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->prefix('₱')
                    ->numeric()
                    ->default(0)
                    ->label('Allocated Amount')
                    ->required()



            ])
            ->modalHeading('Add/Edit MMOOE')
            ->icon('heroicon-m-pencil-square')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data, array $arguments) {

                $mooe = SelectedMOOE::find($arguments['mooe']);
                $mooe_expense = MOOEExpense::where('id', $data['m_o_o_e_expense_id'])->first();


                $final_data = [
                    // 'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'm_o_o_e_group_id' => $data['m_o_o_e_group_id'],
                    'm_o_o_e_expense_id' => $data['m_o_o_e_expense_id'],
                    'amount' => $data['amount'],
                ];

                $mooe->update($final_data); // Corrected update method

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            });
        // ->action(fn () => dd('addPersonalService'));
    }

    public function addCOAction(): Action
    {
        return Action::make('addCO')
            ->extraAttributes([
                'style' => 'border-radius: 100px;',
            ])
            ->icon('heroicon-m-plus')
            ->label('Add CO')
            ->form([
                Select::make('cost_type')
                    ->options([
                        'Direct Cost' => 'Direct Cost',
                        'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                        'Indirect Cost PCAARRD' => 'Indirect Cost PCAARRD',
                    ])
                    ->native(false)
                    ->required(),


                TextInput::make('description')
                    ->required(),




                TextInput::make('amount')
                    ->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->prefix('₱')
                    ->numeric()
                    ->default(0)
                    ->label('Allocated Amount')
                    ->required(),



            ])
            ->modalHeading('Add/Edit CO')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data) {


                $final_data = [
                    'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'description' => $data['description'],
                    'amount' => $data['amount'],
                ];



                // SelectedM::create($final_data);
                SelectedCO::create($final_data);

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            });
    }
    public function editCOAction(): Action
    {
        return Action::make('editCO')
            ->extraAttributes([
                'style' => 'border-radius: 100px;',
            ])
            ->size(ActionSize::Large)
            ->icon('heroicon-m-pencil-square')
            ->iconButton()
            ->fillForm(function (array $arguments) {
                $mooe = SelectedCO::find($arguments['co']);
                return [
                    'cost_type' => $mooe?->cost_type,
                    'description' => $mooe?->description,
                    'amount' => $mooe?->amount,
                ];
            })
           
            ->label('Add CO')
            ->form([
                Select::make('cost_type')
                    ->options([
                        'Direct Cost' => 'Direct Cost',
                        'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                        'Indirect Cost PCAARRD' => 'Indirect Cost PCAARRD',
                    ])
                    ->native(false)
                    ->required(),


                TextInput::make('description')
                    ->required(),




                TextInput::make('amount')
                    ->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->prefix('₱')
                    ->numeric()
                    ->default(0)
                    ->label('Allocated Amount')
                    ->required(),



            ])
            ->modalHeading('Add/Edit CO')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data, array $arguments) {


                $co = SelectedCO::find($arguments['co']);



                $final_data = [
                    // 'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'description' => $data['description'],
                    'amount' => $data['amount'],
                ];


                $co->update($final_data); // Corrected update method

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();




                // SelectedM::create($final_data);
                SelectedCO::create($final_data);

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            });
    }


    public function render()
    {


        // PERSONAL SERVICE INFORMATION

        // $personal_services = SelectedPS::all()->groupBy('cost_type')->map(function ($cost_type) {
        //     return $cost_type->groupBy(function($cost) {
        //         return $cost->p_s_group->title;
        //     });
        // });

         // $mooes = SelectedMOOE::all()->groupBy('cost_type')->map(function ($cost_type) {
        //     return $cost_type->groupBy(function($cost) {
        //         return $cost->m_o_o_e_group->title;
        //     });
        // });

        $personal_services = SelectedPS::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost PCAARRD':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        })->map(function ($cost_type) {
            return $cost_type->groupBy(function ($cost) {
                return $cost->p_s_group->title;
            });
        });

        $total_ps = SelectedPS::where('project_year_id', $this->record->id)->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_dc = SelectedPS::where('project_year_id', $this->record->id)->where('cost_type', 'Direct Cost')->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_sksu = SelectedPS::where('project_year_id', $this->record->id)->where('cost_type', 'Indirect Cost SKSU')->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_pcaarrd = SelectedPS::where('project_year_id', $this->record->id)->where('cost_type', 'Indirect Cost PCAARRD')->with('p_s_expense')->get()->sum('p_s_expense.amount');




        $mooes = SelectedMOOE::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost PCAARRD':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        })->map(function ($cost_type) {
            return $cost_type->groupBy(function ($cost) {
                return $cost->m_o_o_e_group->title;
            });
        });


        $total_mooe = SelectedMOOE::where('project_year_id', $this->record->id)->sum('amount');

        $cos = SelectedCO::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost PCAARRD':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        });


        $total_co = SelectedCO::where('project_year_id', $this->record->id)->sum('amount');
        // dd($cos);


        $total_budet = ($total_ps + $total_mooe + $total_co);


        // MOOE INFORMATION
        return view('livewire.line-item-budget', [
            'record' => $this->record,
            'personal_services' => $personal_services,
            'total_ps' => $total_ps,
            'total_dc' => $total_dc,
            'total_sksu' => $total_sksu,
            'total_pcaarrd' => $total_pcaarrd,
            'mooes' => $mooes,
            'total_mooe' => $total_mooe,
            'total_budet' => $total_budet,
            'cos' => $cos,
            'total_co' => $total_co,
            // 'total_ps'=> $total_ps,

        ]);
    }
}
