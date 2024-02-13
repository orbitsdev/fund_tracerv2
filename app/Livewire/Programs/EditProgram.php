<?php

namespace App\Livewire\Programs;

use Filament\Forms;
use App\Models\Program;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use App\Models\MonitoringAgency;
use Filament\Infolists\Infolist;
use App\Models\ImplementingAgency;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class EditProgram extends Component implements HasForms
{
    use InteractsWithForms;
    use InteractsWithInfolists;
    use InteractsWithForms;
    public ?array $data = [];

    public Program $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
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
                                        self::setProgramLeader($get, $set);
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
                                    ->hint(function () {
                                        if (ImplementingAgency::count() > 0) {
                                            return '';
                                        } else {
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
                                    ->hint(function () {
                                        if (MonitoringAgency::count() > 0) {
                                            return '';
                                        } else {
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
            ->columns(4)
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


        return redirect()->route('program.index');
    }

    public function render(): View
    {
        return view('livewire.programs.edit-program');
    }
}
