<?php

namespace App\Livewire;

use App\Models\PSGroup;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use App\Models\PSExpense;
use App\Models\SelectedPS;
use App\Models\ProjectYear;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
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
    public function editPersonalServiceAction(): Action
    {
        return Action::make('editPersonalService')
        ->icon('heroicon-m-pencil-square')
        ->iconButton()
        ->fillForm(function (array $arguments){
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
             ->afterStateUpdated(function(Set $set){
                $set('p_s_expense_id', null);
             })
             ->native(false)
             ->searchable(),
             Select::make('p_s_expense_id')
             ->label('Position/Designation')

             ->options(function(Get $get ,Set $set){
                if(!empty($get('p_s_group_id'))){
                    return PSExpense::where('p_s_group_id', $get('p_s_group_id'))->get()->pluck('title', 'id');

                }else{
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
                'project_year_id' => $this->record->id,
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
            // $selected_record =SelectedPS::where('', $data[''])->first();


            // $ps_expenses = PSExpense::where('id', $data['p_s_expense_id'])->first();
            // $amount = $ps_expenses->amount;
            // $final_data = [
            //     'project_year_id'=> $this->record->id,
            //     'cost_type'=> $data['cost_type'],
            //     'p_s_group_id'=> $data['p_s_group_id'],
            //     'p_s_expense_id'=> $data['p_s_expense_id'],
            //     'amount'=> $amount,
            // ];



            // SelectedPS::create($final_data);

            // Notification::make()
            // ->title('Saved successfully')
            // ->success()
            // ->send();
            // dd($data);
        });
        // ->action(fn () => dd('addPersonalService'));
    }
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
                'Indirect Cost PCAARRD' => 'Indirect Cost PCAARRD',
            ])
            ->native(false)
             ->required(),
             Select::make('p_s_group_id')
             ->label('PS Type')
             ->options(PSGroup::all()->pluck('title', 'id'))
             ->live()
             ->afterStateUpdated(function(Set $set){
                $set('p_s_expense_id', null);
             })
             ->native(false)
             ->searchable(),
             Select::make('p_s_expense_id')
             ->label('Position/Designation')

             ->options(function(Get $get ,Set $set){
                if(!empty($get('p_s_group_id'))){
                    return PSExpense::where('p_s_group_id', $get('p_s_group_id'))->get()->pluck('title', 'id');

                }else{
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
                'project_year_id'=> $this->record->id,
                'cost_type'=> $data['cost_type'],
                'p_s_group_id'=> $data['p_s_group_id'],
                'p_s_expense_id'=> $data['p_s_expense_id'],
                'amount'=> $amount,
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
        ->icon('heroicon-m-plus')
        ->action(fn () => dd('addMOOE'));
    }


    public function render()
    {


        // $personal_services = User::all()->groupBy('role')->map(function ($usersInRole) {
        //     return $usersInRole->groupBy('age')->map(function ($usersByAge) {
        //         return $usersByAge->groupBy(function ($user) {
        //             return $user->parent->title;
        //         });
        //     });
        // });

        $personal_services = SelectedPS::all()->groupBy('cost_type')->map(function ($cost_type) {
            return $cost_type->groupBy(function($cost) {
                return $cost->p_s_group->title;
            });
        });


        // $totalAmount = SelectedPS::where('project_year_id', $this->record->id)->with('p_s_expense')->sum('p_s_expense.amount');
        // $totalAmount = SelectedPS::with('p_s_expense')->get()->flatten()->sum(function ($selectedPS) {
        //     return $selectedPS->p_s_expense->amount;
        // });

        $total_ps = SelectedPS::with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_dc = SelectedPS::where('cost_type','Direct Cost')->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_sksu = SelectedPS::where('cost_type','Indirect Cost SKSU')->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_pcaarrd = SelectedPS::where('cost_type','Indirect Cost PCAARRD')->with('p_s_expense')->get()->sum('p_s_expense.amount');


        // dd($totalAmount);

        // $total_ps = SelectedPS::sum(function ($item) {
        //     // Check if the related p_s_expense exists and has an amount
        //     return optional($item->p_s_expense)->amount ?? 0;
        // });

        // dd($total_ps);


        //  dd('', $personal_services);
        return view('livewire.line-item-budget',[
            'record'=> $this->record,
            'personal_services'=> $personal_services,
            'total_ps'=> $total_ps,
            'total_dc'=> $total_dc,
            'total_sksu'=> $total_sksu,
            'total_pcaarrd'=> $total_pcaarrd,
            // 'total_ps'=> $total_ps,

        ]);
    }
}
