<?php

namespace App\Livewire;

use App\Models\PSGroup;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use App\Models\CoOption;
use App\Models\MOOEGroup;
use App\Models\PSExpense;
use App\Enums\AppConstant;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\MOOEExpense;
use App\Models\ProjectYear;
use Filament\Support\RawJs;
use App\Models\SelectedMOOE;
use Filament\Actions\Action;
use App\Models\MOOEExpenseSub;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Support\Enums\MaxWidth;
use App\Enums\LineItemBudgetConstant;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
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



    public function forReviewAction(): Action
    {
        return Action::make('forReview')
        ->label('Forward For Review')
            ->size(ActionSize::Large)
            // ->iconButton()
            ->modalAlignment(Alignment::Center)
            ->icon('heroicon-m-paper-airplane')
            ->color('gray')
            ->requiresConfirmation()
            ->modalHeading('Forward for Review')
            ->modalDescription('Please review the changes before proceeding. Once forwarded, you will be unable to make further modifications until approved by Financial. Are you sure you want to proceed?')
            ->modalSubmitActionLabel('Yes, Forward')

            ->action(function (array $arguments) {
                $this->record->status = ProjectYear::STATUS_FOR_REVIEW;
                $this->record->update();
                // $ps =  SelectedCo::find($arguments['co']);
                // $ps?->delete();

                Notification::make()
                    ->title('Forwarded Successfully')
                    ->success()
                    ->send();
            });
    }
    public function cancelReviewAction(): Action
{
    return Action::make('cancelReview')
        ->label('Cancel Review')
        ->size(ActionSize::Large)
        ->icon('heroicon-m-x-circle')
        ->color('gray')

        ->requiresConfirmation()
        ->modalHeading('Cancel Review')
        ->modalDescription('Are you sure you want to cancel the review process? Any changes made will be discarded.')
        ->modalSubmitActionLabel('Yes, Cancel Review')
        ->action(function (array $arguments) {
            $this->record->status = ProjectYear::STATUS_FOR_EDITING; // Assuming you want to go back to editing status
            $this->record->update();

            Notification::make()
                ->title('Review Cancelled Successfully')
                ->success()
                ->send();
        });
}

public function denyApprovalAction(): Action
{
    return Action::make('denyApproval')
        ->label('Deny Approval')
        ->size(ActionSize::Large)
        ->icon('heroicon-m-x-circle')
        ->color('gray')

        ->requiresConfirmation()
        ->modalHeading('Deny Approval')
        ->modalDescription('Are you sure you want to deny approval for this project? Any changes made will not be accepted.')
        ->modalSubmitActionLabel('Yes, Deny Approval')
        ->action(function (array $arguments) {
            $this->record->status = ProjectYear::STATUS_REJECTED;
            $this->record->update();

            Notification::make()
                ->title('Approval Denied Successfully')
                ->success()
                ->send();
        });
}

public function returnToEditingAction(): Action
{
    return Action::make('returnToEditing')
        ->label('Return to Editing')
        ->size(ActionSize::Large)
        ->icon('heroicon-m-pencil-square')
        ->color('gray')
        ->requiresConfirmation()
        ->modalHeading('Return to Editing')
        ->modalDescription('Are you sure you want to return this project to the editing phase? Any changes made will be saved for further modifications.')
        ->modalSubmitActionLabel('Yes, Return to Editing')
        ->action(function (array $arguments) {
            $this->record->status = ProjectYear::STATUS_FOR_EDITING;
            $this->record->update();

            Notification::make()
                ->title('Returned to Editing Successfully')
                ->success()
                ->send();
        });
}


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
                    // 'cost_type' => $ps?->cost_type,
                    // 'cost_type' => $ps?->cost_type,
                    // 'p_s_group_id' => $ps?->p_s_group_id,
                    // 'p_s_expense_id' => $ps?->p_s_expense_id,
                    // 'number_of_positions' => $ps?->number_of_positions,
                    // 'duration' => $ps?->duration,
                    // 'amount' => $ps?->amount,

                    'cost_type' =>  $ps?->cost_type,
                    'indirect_cost_type' => $ps?->indirect_cost_type,
                    'implementing_monitoring_agency' =>$ps?->implementing_monitoring_agency,
                    'project_year_id' => $this->record->id,
                    'p_s_group_id' => $ps?->p_s_group_id,
                    'p_s_expense_id' => $ps?->p_s_expense_id,
                    'number_of_positions' =>$ps?->number_of_positions,
                    'amount' => $ps?->amount,
                    'duration' =>$ps?->duration,
                    'funding_agency' => $ps?->funding_agency,
                    'amount_of_counterpart_fund' =>  $ps?->amount_of_counterpart_fund,
                    'agency_where_dost_fund_will_be_allocated' =>   $ps?->agency_where_dost_fund_will_be_allocated,
                    'percent_time_devoted_to_the_project' => $ps?->percent_time_devoted_to_the_project,
                    'responsibilities' =>  $ps?->responsibilities,
                ];
            })
            ->form($this->personalServiceForm())
            ->modalHeading('Add/Edit Personnel Services')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data, array $arguments) {

                $ps = SelectedPS::find($arguments['ps']);
                $ps_expenses = PSExpense::where('id', $data['p_s_expense_id'])->first();
                $number_of_positions = $data['number_of_positions'];
                $duration = $data['duration'];



                $amount_by_position = ($ps_expenses->amount * $number_of_positions);
                $amount = ($amount_by_position * $duration);


                $final_data = [
                    // 'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'p_s_group_id' => $data['p_s_group_id'],
                    'p_s_expense_id' => $data['p_s_expense_id'],
                    'number_of_positions' => $number_of_positions,
                    'duration' => $duration,
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


    public function personalServiceForm(): array{
        return [
            Select::make('cost_type')
            ->label('Cost Type')
            ->options(LineItemBudgetConstant::COST_TYPES)
                ->native(false)
                ->live()
                ->debounce(500)
                ->required(),

                Radio::make('indirect_cost_type')
                ->options(LineItemBudgetConstant::INDIRECT_COST_TYPE)
               ->default(LineItemBudgetConstant::SKSU)
                ->inline()
                ->label('Indirect Cost (Type)')
                ->columnSpanFull()

                ->hidden(function(Get $get){
                    if(empty($get('cost_type')) || $get('cost_type') != LineItemBudgetConstant::INDIRECT_COST){
                        return true;
                    }else{
                        return false;
                    }

                })
                ,


                // Select::make('implementing_monitoring_agency')
                // ->label('Implementing/Monitoring Agency')
                // ->options(LineItemBudgetConstant::IMPLEMENTING_MONITORING_AGENCY)
                //     ->native(false)
                //     ->live()
                //     ->debounce(500)
                //     ->required()
                //     ->hidden(function(Get $get){
                //         if( $get('cost_type') != LineItemBudgetConstant::INDIRECT_COST){
                //             return true;
                //         }else{
                //             return false;
                //         }

                //     })
                //     ,




            Select::make('p_s_group_id')
                ->label('PS Type')
                ->options(PSGroup::all()->pluck('title', 'id'))
                ->live()
                ->afterStateUpdated(function (Set $set) {
                    $set('p_s_expense_id', null);
                    $set('amount_of_counterpart_fund', null);
                })

                ->native(false)
                ->searchable()
                ->required(),
            Select::make('p_s_expense_id')
                ->required()
                ->label('Position/Designation')
                ->live()
                ->afterStateUpdated(function (Get $get, Set $set) {
                    if (!empty($get('p_s_expense_id'))) {
                        $ex  = PSExpense::where('p_s_group_id', $get('p_s_group_id'))->where('id', $get('p_s_expense_id'))->first();

                        if($ex){
                            $set('amount_of_counterpart_fund',$ex->amount);
                        }else{
                            $set('amount_of_counterpart_fund',null);
                        }

                    }else{
                        $set('amount_of_counterpart_fund',null);
                    }

                })
                ->options(function (Get $get, Set $set) {
                    if (!empty($get('p_s_group_id'))) {
                        return PSExpense::where('p_s_group_id', $get('p_s_group_id'))->get()->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'title' => $item->title . ' - ' . number_format($item->amount),
                            ];
                        })->pluck('title', 'id');
                    } else {
                        return [];
                    }
                })
                ->native(false)
                ->searchable(),

            TextInput::make('number_of_positions')
                ->numeric()

                ->default(1)
                ->label('Number of Position/s')
                ->required(),

            TextInput::make('duration')
                ->required()
                ->numeric()
                ->default(1)
                ->label('Period of Involvement'),

                // Select::make('funding_agency')
                // ->label('Funding Agency')
                // ->options(LineItemBudgetConstant::FUNDING_AGENCY)
                //     ->native(false)
                //     ->live()
                //     ->debounce(500)
                //     ->required(),

                // Select::make('agency_where_dost_fund_will_be_allocated')
                // ->label('Agency Where DOST fund will be allocated')
                // ->options(LineItemBudgetConstant::AGENCY_WHERE_DOST_FUND_WILL_BE_ALLOCATED)
                //     ->native(false)
                //     ->live()
                //     ->debounce(500)
                //     ->required()
                //     ->hidden(function(Get $get){
                //         if( $get('funding_agency') != LineItemBudgetConstant::DOST){
                //             return true;
                //         }else{
                //             return false;
                //         }

                //     })
                //     ,

                // TextInput::make('amount_of_counterpart_fund')
                // ->label('Amount of counterpart fund')
                // ->mask(RawJs::make('$money($input)'))
                // ->stripCharacters(',')
                // ->required()
                // ->maxValue(1000000000)
                // ->numeric()
                // ->columnSpanFull()
                // ->default(0)
                // ->hidden(function(Get $get){
                //     if( $get('funding_agency') != LineItemBudgetConstant::LOCAL_GOVERMENT_UNIT){
                //         return true;
                //     }else{
                //         return false;
                //     }

                // })
                // ,

                // Textarea::make('responsibilities')
                // ->rows(5)
                // // ->required()
                // ->columnSpanFull(),
        ];
    }
    public function addPersonalServiceAction(): Action
    {
        return Action::make('addPersonalService')
            ->label('Add Personal Service')
            ->size(ActionSize::ExtraSmall)
            ->icon('heroicon-m-plus')
            ->extraAttributes([
                'style' => 'border-radius: 100px;',
            ])
            ->form($this->personalServiceForm())
            ->modalHeading('Add/Edit Personnel Services')
            ->modalWidth(MaxWidth::SevenExtraLarge)
            ->action(function (array $data) {
                $ps_expenses = PSExpense::where('id', $data['p_s_expense_id'])->first();

                $number_of_positions = $data['number_of_positions'];
                $duration = $data['duration'];



                $amount_by_position = ($ps_expenses->amount * $number_of_positions);
                $amount = ($amount_by_position * $duration);

                // $amount = ;
                $final_data = [
                    'cost_type' => $data['cost_type'],
                    'indirect_cost_type' => $data['indirect_cost_type'] ?? null,
                    'implementing_monitoring_agency' => $data['implementing_monitoring_agency'] ?? null,
                    'project_year_id' => $this->record->id,
                    'p_s_group_id' => $data['p_s_group_id'],
                    'p_s_expense_id' => $data['p_s_expense_id'],
                    'number_of_positions' => $number_of_positions,
                    'amount' => $amount,
                    'duration' => $duration,
                    'funding_agency' =>  $data['funding_agency'] ?? null,
                    'amount_of_counterpart_fund' =>  $data['amount_of_counterpart_fund'] ?? 0,
                    'agency_where_dost_fund_will_be_allocated' =>  $data['agency_where_dost_fund_will_be_allocated']?? null,
                    'percent_time_devoted_to_the_project' =>  $data['percent_time_devoted_to_the_project'] ?? null,
                    'responsibilities' =>  $data['responsibilities'] ?? null,

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


    public function mooeForm(): array{
        return [
            Group::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([

                        Select::make('cost_type')
                        ->label('Cost Type')
                        ->options(LineItemBudgetConstant::COST_TYPES)
                            ->native(false)
                            ->live()
                            ->debounce(500)
                            ->columnSpanFull()
                            ->required(),

                            Radio::make('indirect_cost_type')
                            ->options(LineItemBudgetConstant::INDIRECT_COST_TYPE)
                           ->default(LineItemBudgetConstant::SKSU)
                            ->inline()
                            ->label('Indirect Cost (Type)')
                            ->columnSpanFull()

                            ->hidden(function(Get $get){
                                if(empty($get('cost_type')) || $get('cost_type') != LineItemBudgetConstant::INDIRECT_COST){
                                    return true;
                                }else{
                                    return false;
                                }

                            })
                            ,

                            // Select::make('implementing_monitoring_agency')
                            // ->label('Implementing/Monitoring Agency')
                            // ->columnSpanFull()
                            // ->options(LineItemBudgetConstant::IMPLEMENTING_MONITORING_AGENCY)
                            //     ->native(false)
                            //     ->live()
                            //     ->debounce(500)
                            //     ->required()
                            //     ->hidden(function(Get $get){
                            //         if( $get('cost_type') != LineItemBudgetConstant::INDIRECT_COST){
                            //             return true;
                            //         }else{
                            //             return false;
                            //         }

                            //     })
                            //     ,

                        Select::make('m_o_o_e_group_id')
                            ->label('MOOE')
                            ->options(MOOEGroup::all()->pluck('title', 'id'))
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $set('m_o_o_e_expense_id', null);
                            })
                            ->columnSpanFull()
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
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $set('m_o_o_e_expense_sub_id', null);
                            })
                            ->columnSpanFull()
                            ->native(false)
                            ->searchable(),

                        Select::make('m_o_o_e_expense_sub_id')
                            ->label('MOOE item')
                            // ->required()
                            ->options(function (Get $get, Set $set) {
                                if (!empty($get('m_o_o_e_expense_id'))) {
                                    return MOOEExpenseSub::where('m_o_o_e_expense_id', $get('m_o_o_e_expense_id'))->get()->pluck('title', 'id');
                                } else {
                                    return [];
                                }
                            })
                            ->columnSpanFull()
                            ->native(false)
                            ->searchable(),

                            // TextInput::make('specification')
                            // ->required()
                            // ->columnSpanFull()
                            // ->label('MOOE Specification')
                            // // ->required()
                            // ,


                        TextInput::make('amount')
                        ->required()
                        ->columnSpanFull()
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->default(0)
                        ->label('Amount')
                        ->required()
                        ->maxLength(10),

                //             Select::make('funding_agency')
                //             ->label('Funding Agency')
                //             ->options(LineItemBudgetConstant::FUNDING_AGENCY)
                //                 ->native(false)
                //                 ->live()
                //                 ->columnSpanFull()
                //                 ->debounce(500)
                //                 ->required(),

                //                 Select::make('agency_where_dost_fund_will_be_allocated')
                // ->label('Agency Where DOST fund will be allocated')
                // ->options(LineItemBudgetConstant::AGENCY_WHERE_DOST_FUND_WILL_BE_ALLOCATED)
                //     ->native(false)
                //     ->live()
                //     ->debounce(500)
                //     ->required()
                //     ->columnSpanFull()
                //     ->hidden(function(Get $get){
                //         if( $get('funding_agency') != LineItemBudgetConstant::DOST){
                //             return true;
                //         }else{
                //             return false;
                //         }

                //     })
                //     ,



                    ]),

        ];
    }
    public function addMOOEAction(): Action
    {
        return Action::make('addMOOE')
            ->extraAttributes([
                'style' => 'border-radius: 100px;',
            ])
            ->size(ActionSize::ExtraSmall)
            ->icon('heroicon-m-plus')
            ->label('Add MOOE')
            ->form($this->mooeForm())
            ->modalHeading('Add/Edit MMOOE')
            ->modalWidth(MaxWidth::SevenExtraLarge)
            ->action(function (array $data) {

                $ps_expenses = MOOEExpense::find($data['m_o_o_e_group_id']);
                $amount = $data['amount'];
                // dd($data);
                // $quantity = $data['quantity'];

                // $calculated_amount = ($amount * $quantity);
                $final_data = [
                    'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'indirect_cost_type' => $data['indirect_cost_type'] ?? null,
                    'implementing_monitoring_agency' => $data['implementing_monitoring_agency'] ?? null,
                    'm_o_o_e_group_id' => $data['m_o_o_e_group_id'],
                    'm_o_o_e_expense_id' => $data['m_o_o_e_expense_id'],
                    'm_o_o_e_expense_sub_id' => $data['m_o_o_e_expense_sub_id'] ?? null,
                    'specification' => $data['specification']?? null,
                    'funding_agency' => $data['funding_agency']?? null,
                    'agency_where_dost_fund_will_be_allocated' => $data['agency_where_dost_fund_will_be_allocated']?? null,
                    'amount' => $amount,
                    // 'quantity' => $quantity,
                    // 'new_amount' => $calculated_amount,
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
        ->size(ActionSize::Large)
            ->icon('heroicon-m-plus')
            ->iconButton()
            ->fillForm(function (array $arguments) {
                $mooe = SelectedMOOE::find($arguments['mooe']);


                return [


                    'cost_type' => $mooe?->cost_type,
                    'indirect_cost_type' => $mooe?->indirect_cost_type,
                    'implementing_monitoring_agency' => $mooe?->implementing_monitoring_agency,
                    'm_o_o_e_group_id' => $mooe?->m_o_o_e_group_id,
                    'm_o_o_e_expense_id' => $mooe?->m_o_o_e_expense_id,
                    'm_o_o_e_expense_sub_id' => $mooe?->m_o_o_e_expense_sub_id ?? null,
                    'specification' => $mooe?->specification,
                    'amount' => intVal($mooe?->amount),
                    'funding_agency' => $mooe?->specification,
                    'agency_where_dost_fund_will_be_allocated' => $mooe?->agency_where_dost_fund_will_be_allocated,
                    // 'quantity' => $mooe?->quantity,

                ];
            })
            ->form($this->mooeForm())
            ->modalHeading('Add/Edit MMOOE')
            ->icon('heroicon-m-pencil-square')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data, array $arguments) {

                $mooe = SelectedMOOE::find($arguments['mooe']);
                // $mooe_expense = MOOEExpense::where('id', $data['m_o_o_e_expense_id'])->first();
                $amount = $data['amount'];

                // $quantity = $data['quantity'];

                // $calculated_amount = ($amount * $quantity);

                $final_data = [

                    // 'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'indirect_cost_type' => $data['indirect_cost_type'] ?? null,
                    'implementing_monitoring_agency' => $data['implementing_monitoring_agency'] ?? null,
                    'm_o_o_e_group_id' => $data['m_o_o_e_group_id'],
                    'm_o_o_e_expense_id' => $data['m_o_o_e_expense_id'],
                    'm_o_o_e_expense_sub_id' => $data['m_o_o_e_expense_sub_id'] ?? null,
                    'specification' => $data['specification']?? null,
                    'funding_agency' => $data['funding_agency']?? null,
                    'agency_where_dost_fund_will_be_allocated' => $data['agency_where_dost_fund_will_be_allocated']?? null,
                    'amount' => $amount,
                    // 'project_year_id' => $this->record->id,

                    // 'cost_type' => $data['cost_type'],
                    // 'm_o_o_e_group_id' => $data['m_o_o_e_group_id'],
                    // 'm_o_o_e_expense_id' => $data['m_o_o_e_expense_id'],
                    // 'm_o_o_e_expense_sub_id' => $data['m_o_o_e_expense_sub_id'],
                    // // 'specification' => $data['specification'],
                    // 'amount' => $amount,
                    // 'new_amount' => $calculated_amount,
                    // 'quantity' => $quantity,
                ];

                $mooe->update($final_data); // Corrected update method

                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            });
        // ->action(fn () => dd('addPersonalService'));
    }


    public function coForm(): array{
        return [



                    Group::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([



                        Select::make('cost_type')
                        ->label('Cost Type')
                        ->options(LineItemBudgetConstant::COST_TYPES)
                            ->native(false)
                            ->live()
                            ->debounce(500)
                            ->columnSpanFull()
                            ->required(),

                            Radio::make('indirect_cost_type')
                            ->options(LineItemBudgetConstant::INDIRECT_COST_TYPE)
                           ->default(LineItemBudgetConstant::SKSU)
                            ->inline()
                            ->label('Indirect Cost (Type)')
                            ->columnSpanFull()

                            ->hidden(function(Get $get){
                                if(empty($get('cost_type')) || $get('cost_type') != LineItemBudgetConstant::INDIRECT_COST){
                                    return true;
                                }else{
                                    return false;
                                }

                            })
                            ,

                            // Select::make('implementing_monitoring_agency')
                            // ->label('Implementing/Monitoring Agency')
                            // ->columnSpanFull()
                            // ->options(LineItemBudgetConstant::IMPLEMENTING_MONITORING_AGENCY)
                            //     ->native(false)
                            //     ->live()
                            //     ->debounce(500)
                            //     ->required()
                            //     ->hidden(function(Get $get){
                            //         if( $get('cost_type') != LineItemBudgetConstant::INDIRECT_COST){
                            //             return true;
                            //         }else{
                            //             return false;
                            //         }

                            //     })
                            //     ,
                                TextInput::make('quantity')
                                ->required()
                                ->columnSpanFull()
                                ->default(1)
                                ->numeric()
                                ->label('Quantity'),


                                Checkbox::make('specify')->inline()
                                ->live()
                                ->label('Specify Description')
                                ->inline()
                                ->columnSpan(2)

                                ,

                                Select::make('description')
    ->options(CoOption::all()->pluck('title','title'))
    ->columnSpan(6)
    ->required()
    ->hidden(function(Get $get){
        if( !empty($get('specify')) || $get('specify') == true){
            return true;
        }else{
            return false;
        }

    })
    ->searchable()
    ,

                        TextInput::make('description')
                            ->required()
                            ->columnSpan(6)
                            ->hidden(function(Get $get){
                                if( !empty($get('specify')) || $get('specify') == true){
                                    return false;
                                }else{
                                    return true;
                                }

                            })
                            ,


                        TextInput::make('amount')
                            ->required()
                            ->columnSpanFull()

                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->default(0)
                            ->label('Amount')
                            ->required()
                            ->columnSpanFull()

                            ,


                //             Select::make('funding_agency')
                //             ->label('Funding Agency')
                //             ->options(LineItemBudgetConstant::FUNDING_AGENCY)
                //                 ->native(false)
                //                 ->live()
                //                 ->columnSpanFull()
                //                 ->debounce(500)
                //                 ->required(),

                //                 Select::make('agency_where_dost_fund_will_be_allocated')
                // ->label('Agency Where DOST fund will be allocated')
                // ->options(LineItemBudgetConstant::AGENCY_WHERE_DOST_FUND_WILL_BE_ALLOCATED)
                //     ->native(false)
                //     ->live()
                //     ->debounce(500)
                //     ->required()
                //     ->columnSpanFull()
                //     ->hidden(function(Get $get){
                //         if( $get('funding_agency') != LineItemBudgetConstant::DOST){
                //             return true;
                //         }else{
                //             return false;
                //         }

                //     })
                //     ,

                    ])

        ];
    }
    public function addCOAction(): Action
    {
        return Action::make('addCO')
        ->size(ActionSize::ExtraSmall)
            ->extraAttributes(AppConstant::ACTION_STYLE)
            ->icon('heroicon-m-plus')
            ->label('Add CO')
            ->form($this->coForm())
            ->modalHeading('Add/Edit CO')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data) {



                $quantity = $data['quantity'];
                $calculated_amount  = ($data['amount'] * $quantity);
                $final_data = [
                    'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'indirect_cost_type' => $data['indirect_cost_type'] ?? null,
                    'implementing_monitoring_agency' => $data['implementing_monitoring_agency'] ?? null,
                    // 'specify' => $data['specify'],
                    'description' => $data['description'],
                    'quantity' => $data['quantity'],
                    'amount' => $data['amount'],
                    'new_amount' => $calculated_amount,
                    'funding_agency' => $data['funding_agency']?? null,
                    'agency_where_dost_fund_will_be_allocated' => $data['agency_where_dost_fund_will_be_allocated']?? null,
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
                $co = SelectedCO::find($arguments['co']);
                return [
                    'cost_type' => $co?->cost_type,
                    'indirect_cost_type' => $co?->indirect_cost_type,
                    'implementing_monitoring_agency' => $co?->implementing_monitoring_agency,
                    // 'specify' => $co?->specify,
                    'description' => $co?->description,
                    'quantity' => $co?->quantity,
                    'amount' => intVal($co?->amount),
                    'funding_agency' =>$co?->funding_agency,
                    'agency_where_dost_fund_will_be_allocated' =>$co?->agency_where_dost_fund_will_be_allocated,
                ];
            })

            ->label('Edit CO')
            ->form($this->coForm())
            ->modalHeading('Add/Edit CO')
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->action(function (array $data, array $arguments) {


                $co = SelectedCO::find($arguments['co']);

                $quantity = $data['quantity'];
                $calculated_amount  = ($data['amount'] * $quantity);

                $final_data = [
                    // 'project_year_id' => $this->record->id,
                    'cost_type' => $data['cost_type'],
                    'indirect_cost_type' => $data['indirect_cost_type'] ?? null,
                    'implementing_monitoring_agency' => $data['implementing_monitoring_agency'] ?? null,
                    // 'specify' => $data['specify'],
                    'description' => $data['description'],
                    'quantity' => $data['quantity'],
                    'amount' => $data['amount'],
                    'new_amount' => $calculated_amount,
                    'funding_agency' => $data['funding_agency']?? null,
                    'agency_where_dost_fund_will_be_allocated' => $data['agency_where_dost_fund_will_be_allocated']?? null,

                ];


                $co->update($final_data); // Corrected update method








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

        $mooes = SelectedMOOE::all()->groupBy('cost_type')->map(function ($cost_type) {
            return $cost_type->groupBy(function($cost) {
                return $cost->m_o_o_e_group->title;
            });
        });

        // $personal_services = SelectedPS::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
        //     switch ($key) {
        //         case LineItemBudgetConstant::DIRECT_COST:
        //             return 1;
        //         case LineItemBudgetConstant::DIRECT_COST:
        //             return 2;
        //         // case 'Indirect Cost DOST':
        //         //     return 3;
        //         default:
        //             return 4; // Handle any other cases if needed
        //     }
        // })->map(function ($cost_type) {
        //     return $cost_type->groupBy(function ($cost) {
        //         return $cost->p_s_group->title;
        //     });
        // });

    //     $personal_services = SelectedPS::where('project_year_id', $this->record->id)
    // ->get()
    // ->groupBy('cost_type')
    // ->map(function ($group, $key) {
    //     if ($key === 'Indirect Cost') {
    //         return $group->groupBy('indirect_cost_type');
    //     } else {
    //         return [$key => $group];
    //     }
    // });
    $personal_services = SelectedPS::where('project_year_id', $this->record->id)
    ->get()
    ->groupBy(function ($item) {
        if ($item->cost_type === 'Indirect Cost') {
            if(empty($item->indirect_cost_type)){

                return 'Indirect Cost ';
            }else{
                return 'Indirect Cost (' . ($item->indirect_cost_type ?: 'Unknown') . ')';
            }
        }
        return $item->cost_type;
    })
    ->map(function ($group) {

        return $group->groupBy(function ($cost) {
                    return $cost->p_s_group->title;
         });

        // return $group; // Assuming 'id' is the primary key field
    })
    ->sortKeys();



    //     $personal_services = SelectedPS::where('project_year_id', $this->record->id)
    // ->get()
    // ->groupBy('cost_type')
    // ->sortBy(function ($group, $key) {
    //     switch ($key) {
    //         case LineItemBudgetConstant::DIRECT_COST:
    //             return 1;
    //         case LineItemBudgetConstant::INDIRECT_COST:
    //             return 2;
    //         default:
    //             return 3; // Handle any other cases if needed
    //     }
    // })
    // ->map(function ($cost_type) {
    //     return $cost_type->groupBy(function ($cost) {
    //         if ($cost->cost_type === LineItemBudgetConstant::INDIRECT_COST) {
    //             return $cost->indirect_cost_type;
    //         } else {
    //             return $cost->p_s_group->title;
    //         }
    //     });
    // });


        $total_ps = SelectedPS::where('project_year_id', $this->record->id)->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_dc = SelectedPS::where('project_year_id', $this->record->id)->where('cost_type', 'Direct Cost')->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_sksu = SelectedPS::where('project_year_id', $this->record->id)->where('cost_type', 'Indirect Cost SKSU')->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_dost = SelectedPS::where('project_year_id', $this->record->id)->where('cost_type', 'Indirect Cost DOST')->with('p_s_expense')->get()->sum('p_s_expense.amount');




    //     $personal_services = SelectedPS::where('project_year_id', $this->record->id)
    // ->get()
    // ->groupBy(function ($item) {
    //     if ($item->cost_type === 'Indirect Cost') {
    //         return 'Indirect Cost (' . ($item->indirect_cost_type ?: '') . ')';
    //     }
    //     return $item->cost_type;
    // })
    // ->map(function ($group) {
    //     return $group; // Assuming 'id' is the primary key field
    // })
    // ->sortKeys();


        $mooes = SelectedMOOE::where('project_year_id', $this->record->id)->get()->groupBy(function ($item) {
            if ($item->cost_type === 'Indirect Cost') {
                if(empty($item->indirect_cost_type)){

                    return 'Indirect Cost ';
                }else{
                    return 'Indirect Cost (' . ($item->indirect_cost_type ?: 'Unknown') . ')';
                }
            }
            return $item->cost_type;
        })
        ->map(function ($group) {
            return $group->groupBy(function ($cost) {
                        return $cost->m_o_o_e_group->title;
                    });
        })
        ->sortKeys();





        // $mooes = SelectedMOOE::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
        //     switch ($key) {
        //         case 'Direct Cost':
        //             return 1;
        //         case 'Indirect Cost SKSU':
        //             return 2;
        //         case 'Indirect Cost DOST':
        //             return 3;
        //         default:
        //             return 4; // Handle any other cases if needed
        //     }
        // })->map(function ($cost_type) {
        //     return $cost_type->groupBy(function ($cost) {
        //         return $cost->m_o_o_e_group->title;
        //     });
        // });


        $total_mooe = SelectedMOOE::where('project_year_id', $this->record->id)->sum('amount');

        $cos = SelectedCO::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost DOST':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        });


        $total_co = SelectedCO::where('project_year_id', $this->record->id)->sum('new_amount');
        // dd($cos);


        $total_budet = ($total_ps + $total_mooe + $total_co);




        // MOOE INFORMATION
        return view('livewire.line-item-budget', [
            'record' => $this->record,
            'personal_services' => $personal_services,
            'total_ps' => $total_ps,
            'total_dc' => $total_dc,
            'total_sksu' => $total_sksu,
            'total_dost' => $total_dost,
            'mooes' => $mooes,
            'total_mooe' => $total_mooe,
            'total_budet' => $total_budet,
            'cos' => $cos,
            'total_co' => $total_co,
            // 'total_ps'=> $total_ps,

        ]);
    }
}
