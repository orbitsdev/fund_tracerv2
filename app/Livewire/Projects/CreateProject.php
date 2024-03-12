<?php

namespace App\Livewire\Projects;

use Closure;
use Filament\Forms;
use App\Models\Program;
use App\Models\Project;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Illuminate\Support\Carbon;
use App\Models\MonitoringAgency;
use App\Models\ImplementingAgency;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class CreateProject extends Component implements HasForms
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
            ->schema(
                [
                    Group::make()
                        ->schema([

                            Section::make('Project Details')


                                ->columns([
                                    'sm' => 3,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                ->schema([
                                    Section::make('')


                                    ->columns([
                                        'sm' => 3,
                                        'xl' => 6,
                                        '2xl' => 8,
                                    ])
                                    ->schema([

                                        Radio::make('project_type')
                                        ->label('Project Type')
                                        ->options([
                                            'Dependent' => 'Program',
                                            'Independent' => 'Project',
                                        ])
                                        ->default('Dependent')
                                        // ->descriptions([
                                        //     'Dipendent' => 'Project is belong to program',
                                        //     'Independent' => 'Project is not belong to any program',
                                        // ])
                                        ->helperText('Choose whether this is a program or project')
                                        ->live()
                                        ->debounce(700)
                                        ->inline()
                                        ->columnSpanFull()
                                        ->hidden(function (string $operation) {
                                            return $operation === 'edit' ? true : false;
                                        }),


                                        Select::make('program_id')
                                        ->live()
                                        ->debounce(700)
                                        // ->required()
                                        ->label('Choose Program')
                                        ->relationship(
                                            name: 'program',
                                            titleAttribute: 'title'
                                        )
                                        ->hint('Program  & Budget')
                                        ->columnSpanFull()
                                        //->helperText(new HtmlString('Program  & Budget'))
                                        // ->hintColor('primary')
                                        ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->title} - ₱ " . number_format($record->total_budget))

                                        //     ->live()
                                        //     ->debounce(700)
                                        //     ->afterStateUpdated(function(Get $get , Set $set){
                                        //         // $program = Program::find($get('program_id'));
                                        //         // if(!empty($program)){
                                        //         //      set('allocated_fund', $program->total_budget);
                                        //         // }
                                        // subtract the allocate ddun to the total budget of
                                        // })
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            // self::updateProgramOverviewDetails($get, $set);
                                            // self::calculateTotalMonthDurationn($get, $set);
                                            // self::setCurrentDuration($get, $set);
                                        })

                                        ->hidden(function (Get $get, Set $set) {
                                            //if project has program
                                            if ($get('project_type')  !=  'Dependent') {

                                                // self::resetSelectedProgram($get, $set);

                                                return true;
                                            } else {
                                                return false;
                                            }
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->native(false),

                                    ]),



                                        Section::make('')


                                        ->columns([
                                            'sm' => 3,
                                            'xl' => 6,
                                            '2xl' => 12,
                                        ])
                                        ->schema([





                                        TextInput::make('title')
                                            ->label('Project Title')
                                            ->required()
                                            ->maxLength(191)
                                            ->columnSpan(6),

                                        TextInput::make('project_leader')
                                            ->label('Project Leader')
                                            ->required()
                                            ->maxLength(191)
                                            ->columnSpan(6),


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
                                            ->columnSpan(6)
                                            ->required()


                                            ->native(function (Get $get, Set $set) {
                                                // return self::disabledDate($get, $set);
                                            }),
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
                                            ->columnSpan(6)
                                            ->searchable()

                                            ->native(function (Get $get, Set $set) {
                                                // return self::disabledDate($get, $set);
                                            }),

                                        ]),

                                        Section::make('')


                                        ->columns([
                                            'sm' => 3,
                                            'xl' => 6,
                                            '2xl' => 12,
                                        ])
                                        ->schema([

                                            DatePicker::make('start_date')->date()
                                            ->columnSpan(4)
                                            ->live()
                                            ->debounce(700)
                                            ->afterStateUpdated(function (Get $get, Set $set) {

                                                self::calculateTotalMonthDurationn($get, $set);
                                                self::setCurrentDuration($get, $set);
                                            })
                                            ->readOnly(function (Get $get, Set $set) {
                                                // return self::disabledDate($get, $set);
                                            })
                                            ->native(function (Get $get, Set $set) {
                                                // return self::disabledDate($get, $set);
                                            })
                                            ->suffixIcon('heroicon-m-calendar-days')

                                            ->required(),


                                        DatePicker::make('end_date')->date()
                                            ->columnSpan(4)
                                            ->live()
                                            ->debounce(700)
                                            ->afterStateUpdated(function (Get $get, Set $set) {
                                                self::calculateTotalMonthDurationn($get, $set);
                                                self::setCurrentDuration($get, $set);
                                            })
                                            ->readOnly(function (Get $get, Set $set) {
                                                // return self::disabledDate($get, $set);
                                            })
                                            ->native(function (Get $get, Set $set) {
                                                // return self::disabledDate($get, $set);
                                            })
                                            ->suffixIcon('heroicon-m-calendar-days')

                                            ->required(),

                                            
                                        TextInput::make('duration_overview')
                                            ->disabled()
                                            ->label('Total Duration')
                                            // ->prefix('₱ ')
                                            // ->numeric()

                                            ->columnSpan(4)
                                            // ->maxLength(191)
                                            ->readOnly(),
                                        ]),










                            Section::make('')


                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 12,
                            ])
                            ->schema([




                                        Password::make('pass_key')
                                        ->label('Pass Key')
                                        ->password()
                                        // ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->required()
                                        ->columnSpan(4),



                                    // Select::make('status')
                                    //     ->options([
                                    //         'Not Started' => 'Not Started',
                                    //         'Planning' => 'Planning',
                                    //         'In Progress' => 'In Progress',
                                    //         'On Hold' => 'On Hold',
                                    //         'Cancelled' => 'Cancelled',
                                    //         'Under Revision' => 'Under Revision',
                                    //     ])
                                    //     ->default('In Progress')
                                    //     ->searchable()
                                    //     ->native(false)
                                    //     ->columnSpanFull(),

                                ])

                                // ->collapsible(),

                                ])




                            // Section::make('Project Documents')
                            //     ->icon('heroicon-m-folder')
                            //     ->description('Manage and organize your Project documents. Upload files here')
                            //     ->columnSpanFull()
                            //     ->schema([
                            //         TableRepeater::make('project_files')
                            //         ->withoutHeader()

                            //         ->emptyLabel('None')
                            //             ->relationship('files')
                            //             ->label('Documents')

                            //             ->columnWidths([
                            //                 // 'fourth_layer_id' => '200px',
                            //                 'file' => '200px',
                            //             ])
                            //             ->schema([
                            //                 TextInput::make('file_name')
                            //                     ->label('File Name')
                            //                     ->maxLength(191)
                            //                     ->required(),
                            //                 FileUpload::make('file')
                            //                     ->required()

                            //                     // ->columnSpanFull()
                            //                     // ->image()
                            //                     ->preserveFilenames()
                            //                     ->maxSize(200000)
                            //                     ->label('File')
                            //                     ->disk('public')
                            //                     ->directory('program-files')
                            //             ])
                            //             ->deleteAction(
                            //                 fn (Action $action) => $action->requiresConfirmation(),
                            //             )
                            //             ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                            //                 // $data['user_id'] = auth()->id();

                            //                 return $data;
                            //             })
                            //             ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                            //                 // $filePath = storage_path('app/public/' . $data['file']);


                            //                 $filePath = storage_path('app/public/' . $data['file']);

                            //                 $fileInfo = [
                            //                     'file' => $data['file'],
                            //                     'file_name' => $data['file_name'],
                            //                     'file_type' => mime_content_type($filePath),
                            //                     'file_size' => call_user_func(function ($bytes) {
                            //                         $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                            //                         $i = 0;

                            //                         while ($bytes >= 1024 && $i < count($units) - 1) {
                            //                             $bytes /= 1024;
                            //                             $i++;
                            //                         }

                            //                         return round($bytes, 2) . ' ' . $units[$i];
                            //                     }, filesize($filePath)),
                            //                 ];
                            //                 return $fileInfo;
                            //                 // $data['user_id'] = auth()->id();

                            //                 // return $data;
                            //             })
                            //             ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {


                            //                 $filePath = storage_path('app/public/' . $data['file']);

                            //                 $fileInfo = [
                            //                     'file' => $data['file'],
                            //                     'file_name' => $data['file_name'],
                            //                     'file_type' => mime_content_type($filePath),
                            //                     'file_size' => call_user_func(function ($bytes) {
                            //                         $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                            //                         $i = 0;

                            //                         while ($bytes >= 1024 && $i < count($units) - 1) {
                            //                             $bytes /= 1024;
                            //                             $i++;
                            //                         }

                            //                         return round($bytes, 2) . ' ' . $units[$i];
                            //                     }, filesize($filePath)),
                            //                 ];

                            //                 // dd($fileInfo);
                            //                 // dd($data);

                            //                 return $fileInfo;
                            //             })
                            //             // ->collapsed()
                            //             // ->collapsible()
                            //             ->reorderable(true)
                            //             ->columnSpanFull()
                            //             ->columns(2)
                            //             ->defaultItems(0)
                            //             ->addActionLabel('Add File')


                            //     ])
                            //     ->collapsed()
                            //     ->collapsible(),


                        ])->columnSpan(['lg' => 3]),
                    // Group::make()
                    //     ->schema(
                    //         [

                    //             Section::make('Overview')
                    //                 ->columns([
                    //                     'sm' => 3,
                    //                     'xl' => 6,
                    //                     '2xl' => 8,
                    //                 ])
                    //                 //  ->icon('heroicon-m-chart-bar')
                    //                 // ->description('Manage and organize project expenses here. You can only add expense in edit')
                    //                 ->columnSpanFull()
                    //                 ->schema([
                    //                     TextInput::make('program_name_overview')
                    //                         ->label('Selected Program')
                    //                         // ->prefix('₱ ')
                    //                         // ->numeric()

                    //                         ->columnSpanFull()
                    //                         // ->maxLength(191)
                    //                         ->disabled()
                    //                         ->readOnly(),
                    //                     TextInput::make('program_budget_overview')
                    //                         ->label('Program Budget')
                    //                         // ->default(0)
                    //                         ->prefix('₱ ')
                    //                         // ->numeric()
                    //                         ->disabled()
                    //                         ->columnSpan(4)

                    //                         // ->maxLength(191)
                    //                         ->readOnly(),
                    //                     // TextInput::make('program_use_budget_overview')
                    //                     //     ->label('Total Used')
                    //                     //     // ->prefix('₱ ')
                    //                     //     // ->numeric()
                    //                     //     ->columnSpan(4)

                    //                     //     // ->maxLength(191)
                    //                     //     ->readOnly(),
                    //                     TextInput::make('program_remaining_budget_overview')
                    //                         ->label('Program Remaining Budget')
                    //                         ->prefix('₱ ')
                    //                         // ->numeric()
                    //                         ->columnSpan(4)
                    //                         ->disabled()
                    //                         // ->maxLength(191)
                    //                         ->readOnly(),




                    //                     TextInput::make('current_allocated_budget')
                    //                         ->label('Current Project Budget')
                    //                         ->prefix('₱ ')
                    //                         // ->numeric()
                    //                         ->columnSpanFull(4)
                    //                         ->disabled()
                    //                         // ->maxLength(191)
                    //                         ->readOnly()
                    //                         ->hidden(function (string $operation) {
                    //                             return $operation === 'edit' ? false : true;
                    //                         }),

                    //                 ]),

                    //             Section::make('Financial Summary')
                    //                 ->description('Live calculations based on your inputs')

                    //                 ->columns([
                    //                     'sm' => 3,
                    //                     'xl' => 6,
                    //                     '2xl' => 8,
                    //                 ])
                    //                 ->columnSpanFull()
                    //                 ->schema([


                    //                     // TextInput::make('project_fund')
                    //                     //     ->label(function (string $operation) {
                    //                     //         return $operation === 'edit' ? 'New Project Budget' : 'Current Project Budget';
                    //                     //     })
                    //                     //     ->mask(RawJs::make('$money($input)'))
                    //                     //     ->stripCharacters(',')
                    //                     //     ->prefix('-')
                    //                     //     ->numeric()
                    //                     //     ->columnSpanFull()
                    //                     //     ->default(0)
                    //                     //     ->disabled()
                    //                     //     // ->maxLength(191)
                    //                     //     ->readOnly(),
                    //                     TextInput::make('left_budget')
                    //                         ->prefix('=')
                    //                         ->label('Remaining Budget of Program After Project Deduction')
                    //                         ->mask(RawJs::make('$money($input)'))
                    //                         ->stripCharacters(',')
                    //                         ->numeric()
                    //                         ->columnSpanFull()
                    //                         ->default(0)
                    //                         ->disabled()
                    //                         // ->maxLength(191)
                    //                         ->readOnly(),
                    //                 ]
                    //             ),
                    //         ]
                    //     )
                ]
            )
            ->columns(3)
            ->statePath('data')
            ->model(Project::class);
    }

    public static function setCurrentDuration(Get $get, Set $set)
    {

        $startDate = $get('start_date');
        $endDate = $get('end_date');
        if (!empty($startDate) && !empty($endDate)) {

            // dd(Carbon::parse($startDate)->format('F d, Y'), Carbon::parse($startDate)->format('F d, Y'));

            $currentDuration = Carbon::parse($startDate)->format('F d, Y') . ' - ' . Carbon::parse($endDate)->format('F d, Y');

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

    public function create()
    {
        $data = $this->form->getState();

        $record = Project::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();


        return redirect()->route('project.index');
    }

    public function render(): View
    {
        return view('livewire.projects.create-project');
    }
}
