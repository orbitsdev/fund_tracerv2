<?php

namespace App\Livewire\Programs;

use Filament\Forms;
use App\Models\Program;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Illuminate\Support\Carbon;
use App\Models\MonitoringAgency;
use App\Models\ImplementingAgency;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateProgram extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()
                ->schema([

                    Section::make('Program Information')
                    ->icon('heroicon-m-pencil-square')

                    ->description('Provide program details below to better understand and support funding needs.')

                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 9,
                    ])


                    ->schema([
                        TextInput::make('title')
                            ->label('Program Title')
                            ->maxLength(191)
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('program_leader')

                        ->live()
                        ->debounce(700)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::setProgramLeader($get ,$set);
                        })
                            ->label('Program Leader')
                            ->maxLength(191)
                            ->required()
                            ->columnSpanFull(),


                        // Select::make('status')
                        //     ->options([
                        //         'Pending' => 'Pending',
                        //         'Planning' => 'Planning',
                        //         'Active' => 'Active',
                        //         'Cancelled' => 'Cancelled',
                        //         'On Hold' => 'On Hold',
                        //         'Completed' => 'Completed',
                        //     ])
                        //     ->required()
                        //     ->native(false)
                        //     ->columnSpan(3),

                        DatePicker::make('start_date')->date()->native(false)->columnSpan(3)
                        ->live()
                        ->suffixIcon('heroicon-m-calendar-days')
                        ->debounce(700)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::calculateTotalMonthDurationn($get, $set);
                            self::setCurrentDuration($get, $set);
                        })
                            ->required(),

                        DatePicker::make('end_date')->date()->native(false)->columnSpan(3)
                        ->live()
                        ->suffixIcon('heroicon-m-calendar-days')
                        ->debounce(700)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::calculateTotalMonthDurationn($get, $set);
                            self::setCurrentDuration($get, $set);
                        })
                            ->required(),

                            TextInput::make('duration_overview')
                            ->disabled()
                            ->label('Total Duration')
                            // ->prefix('₱ ')
                            // ->numeric()

                            ->columnSpan(3)
                            // ->maxLength(191)
                            ->readOnly(),

                            Select::make('implementing_agency')
                            ->label('Implementing Agency')
                            ->options(ImplementingAgency::all()->pluck('title', 'title'))
                            ->hint(function(){
                                if(ImplementingAgency::count() > 0){
                                    return '';
                                }else{
                                    return 'No implementing agency agency found';
                                }
                            })
                            ->searchable()
                            ->columnSpan(3)
                            ->required()
                            ->native(false),
                                            Select::make('monitoring_agency')
                            ->label('Monitoring Agency')
                            ->options(MonitoringAgency::all()->pluck('title', 'title'))
                            ->required()
                            ->hint(function(){
                                if(MonitoringAgency::count() > 0){
                                    return '';
                                }else{
                                    return 'No monitoring agency found';
                                }
                            })
                            ->columnSpan(3)
                            ->searchable()
                            ->native(false),

                            TextInput::make('total_budget')

                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')

                                // ->mask(RawJs::make('$money($input)'))
                                // ->stripCharacters(',')
                                ->prefix('₱')
                                ->numeric()
                                // ->maxValue(9999999999)
                                ->default(0)
                                ->columnSpan(3)
                                ->required(),



                    ]),




                ])->columnSpan(['lg' => 4]),

                Group::make()
                ->schema([

                    // Section::make('Overview')

                    // ->columnSpanFull()
                    // ->schema([

                    //     TextInput::make('program_leader_overview')
                    //     ->label('Program Leader')
                    //     // ->prefix('₱ ')
                    //     // ->numeric()
                    //     ->columnSpan(3)

                    //     ->columnSpanFull()
                    //     // ->maxLength(191)
                    //     ->readOnly(),
                    //     TextInput::make('current_duration_overview')
                    //     ->label('Current Duration')
                    //     // ->prefix('₱ ')
                    //     // ->numeric()
                    //     ->columnSpan(3)

                    //     ->columnSpanFull()
                    //     // ->maxLength(191)
                    //     ->readOnly(),
                    //     // Placeholder::make('duration')





                    // ])

                ])->columnSpan(['lg' => 1]),



            ])
            ->statePath('data')
            ->model(Program::class)
            ->columns(4)
            ;
    }

    public function create()
    {
        $data = $this->form->getState();

        $record = Program::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();


        return redirect()->route('program.index');
    }


    public static function setProgramLeader(Get $get, Set $set)
    {

         $set('program_leader_overview',$get('program_leader'));
        //   $set('program_leader_overview', $get('project_leader'));
         //  $set('project_leader_overview'. $get('project_leader'));
    }
    public static function setCurrentDuration(Get $get, Set $set)
    {

        $startDate = $get('start_date');
        $endDate = $get('end_date');
        if (!empty($startDate) && !empty($endDate)) {

            // dd(Carbon::parse($startDate)->format('F d, Y'), Carbon::parse($startDate)->format('F d, Y'));

        $currentDuration = Carbon::parse($startDate)->format('F d, Y') . ' - '. Carbon::parse($endDate)->format('F d, Y');

            $set('current_duration_overview', $currentDuration);



        }
    }

    public static function calculateTotalMonthDurationn(Get $get, Set $set)
    {


        $startDate = $get('start_date');
        $endDate = $get('end_date');

        if (!empty($startDate) && !empty($endDate)) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);

            // Calculate the difference in months
            $totalMonths = $endDate->diffInMonths($startDate);

            // Set the duration in months
            $set('duration_overview', $totalMonths . ' months');
        }
        // $set('project_fund', number_format($get('allocated_fund')));
        // // $set('total_expenses', (int)$get('allocated_fund'));
        // self::updateTotal($get, $set);
    }

    public function render(): View
    {
        return view('livewire.programs.create-program');
    }
}
