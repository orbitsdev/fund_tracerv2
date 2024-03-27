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
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
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


    public function myForm(): array{
        return [
            
        ];
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    Section::make('Project Details')


                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                        // Section::make('')


                        // ->columns([
                        //     'sm' => 3,
                        //     'xl' => 6,
                        //     '2xl' => 8,
                        // ])
                        // ->schema([

                        //     Radio::make('project_type')
                        //     ->label('Project Type')
                        //     ->options([
                        //         'Dependent' => 'Program',
                        //         'Independent' => 'Project',
                        //     ])
                        //     ->default('Dependent')
                        //     // ->descriptions([
                        //     //     'Dipendent' => 'Project is belong to program',
                        //     //     'Independent' => 'Project is not belong to any program',
                        //     // ])
                        //     ->helperText('Choose whether this is a program or project')
                        //     ->live()
                        //     ->debounce(700)
                        //     ->inline()
                        //     ->columnSpanFull()
                        //     ->hidden(function (string $operation) {
                        //         return $operation === 'edit' ? true : false;
                        //     }),


                        //     Select::make('program_id')
                        //     ->live()
                        //     ->debounce(700)
                        //     // ->required()
                        //     ->label('Choose Program')
                        //     ->relationship(
                        //         name: 'program',
                        //         titleAttribute: 'title'
                        //     )
                        //     ->hint('Program  & Budget')
                        //     ->columnSpanFull()
                        //     //->helperText(new HtmlString('Program  & Budget'))
                        //     // ->hintColor('primary')
                        //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->title} - ₱ " . number_format($record->total_budget))

                        //     //     ->live()
                        //     //     ->debounce(700)
                        //     //     ->afterStateUpdated(function(Get $get , Set $set){
                        //     //         // $program = Program::find($get('program_id'));
                        //     //         // if(!empty($program)){
                        //     //         //      set('allocated_fund', $program->total_budget);
                        //     //         // }
                        //     // subtract the allocate ddun to the total budget of
                        //     // })
                        //     ->afterStateUpdated(function (Get $get, Set $set) {
                        //         // self::updateProgramOverviewDetails($get, $set);
                        //         // self::calculateTotalMonthDurationn($get, $set);
                        //         // self::setCurrentDuration($get, $set);
                        //     })

                        //     ->hidden(function (Get $get, Set $set) {
                        //         //if project has program
                        //         if ($get('project_type')  !=  'Dependent') {

                        //             // self::resetSelectedProgram($get, $set);

                        //             return true;
                        //         } else {
                        //             return false;
                        //         }
                        //     })
                        //     ->searchable()
                        //     ->preload()
                        //     ->native(false),

                        // ]),
                        Textarea::make('program_title')
                        ->rows(3)
                        ->required()
                        ->columnSpanFull()
                        ->default('N/A'),
                        
                        Textarea::make('title')
                        ->label('Project Title')
                        ->required()
                        ->maxLength(191)
                        ->rows(3)
                        ->columnSpanFull(),
                       


                            
                        Section::make('')


                        ->columns([
                            'sm' => 3,
                            'xl' => 6,
                            '2xl' => 9,
                        ])
                        ->schema([
                            TextInput::make('project_leader')
                            ->label('Project Leader')
                            ->required()
                            ->maxLength(191)
                            ->columnSpanFull(),
                       
                        ]),

                      

                        Section::make('')


                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 9,
                            ])
                            ->schema([
                                TextInput::make('source_of_fund')
                                ->label('Source Of Fund')
                                ->required()
                                ->maxLength(191)
                                ->columnSpan(3),
                            TextInput::make('order_no')
                                ->label('Order No')
                                // ->required()
                                ->maxLength(191)
                               ->columnSpan(3),
    
    
                            DatePicker::make('date_when_fund_recieved_by_agency')
                                ->label('Date Was Fund Recieved By Implementin Agency')
                                ->date()
                               ->columnSpan(3)
    
                                ->native(function (Get $get, Set $set) {
                                    // return self::disabledDate($get, $set);
                                })
                                ->suffixIcon('heroicon-m-calendar-days'),

                            ]),
                        Section::make('')


                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 9,
                            ])
                            ->schema([
                            
                            // ->columnSpan(6),
    
    
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
                                ->columnSpan(3)
                                ->searchable()
    
                                ->native(function (Get $get, Set $set) {
                                    // return self::disabledDate($get, $set);
                                }),
    
                                TextInput::make('fund')
                                ->label(function (string $operation) {
                                    return $operation === 'edit' ? 'Update Fund' : 'Fund';
                                })
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->required()
                                ->maxValue(1000000000)
                                ->prefix('₱')
                                ->numeric()
                                ->columnSpan(3)
                                ->default(0)
                            // ->disabled()
                            // ->readOnly()
                            ,
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
                            ->schema([])



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
                ]
            )
         
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

            // Calculate years and remaining months
            $totalYears = floor($totalMonths / 12);
            $remainingMonths = $totalMonths % 12;

            $duration = '';

            if ($totalYears > 0) {
                $duration .= $totalYears . ' year';
                if ($totalYears > 1) {
                    $duration .= 's';
                }
                $duration .= ' (' . $totalMonths . ' months)';
            } else {
                $duration .= $totalMonths . ' months';
            }

            $set('duration_overview', $duration);
        }
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


           




        return redirect()->route('project.edit', ['record'=> $record->id])->with('success', 'Project successfully created! You can now manage your finance manager and staff here.');
    }

    public function render(): View
    {
        return view('livewire.projects.create-project');
    }
}
