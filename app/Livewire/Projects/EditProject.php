<?php

namespace App\Livewire\Projects;

use Filament\Forms;
use App\Models\User;
use App\Models\Project;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use App\Enums\AppConstant;
use App\Enums\RoleConstant;
use Filament\Support\RawJs;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use App\Models\MonitoringAgency;
use Filament\Actions\EditAction;
use App\Models\ImplementingAgency;
use Filament\Actions\StaticAction;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class EditProject extends Component implements HasForms , HasActions
{   
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public Project $record;

    public function mount(): void
    {
        
        $this->fillTotalDuration($this->record);
        $this->form->fill($this->record->attributesToArray());
    }


    public static function fillTotalDuration($record)
    {   
        $startDate = $record->start_date;
        $endDate = $record->start_date;

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

            $record->duration_overview =$duration;
           
        }
    }
      
    public function  addFinanceManagerAction(): EditAction
        {
           return EditAction::make('addFinanceManager')
            ->label('Finance Manager')
            ->icon('heroicon-m-plus')
            // ->iconButton()
            ->extraAttributes(AppConstant::ACTION_STYLE)
            ->record(function (array $arguments) {
                return Project::find($arguments['record']);
            })
            ->model(Project::class)
            ->form([

                Select::make('user_id')
                    ->label('Finance Manager Account')
                    ->relationship(name: 'user', titleAttribute: 'first_name',   modifyQueryUsing: fn (Builder $query) => $query->where('role', RoleConstant::FINANCE_MANAGER),)
                    ->searchable(['first_name', 'last_name', 'email'])
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->getFullName()} - {$record->email}")
                    ->preload()


            ])
            ->successRedirectUrl(fn (Model $record): string => 
            route('project.edit', [ 'record' => $record->id,])
        );
            
            
        }
    
    
    public function   removeFinanceManagerAction(): Action
        {
            
       return Action::make('removeFinanceManager')
                    ->label('Remove Finance Manager')
                    ->icon('heroicon-m-x-mark')
                    ->color('gray')
                    ->iconButton()
                    
                    ->size(ActionSize::Small)
                    ->outlined()
                    ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->requiresConfirmation()
                    ->modalHeading('Remove Finance Manager ')
                    ->modalDescription('Are you sure you\'d like to remove project finance manager? This cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Remove it')
                    ->action(function (array $arguments) {
                        $record = Project::find($arguments['record']);

                        if ($record->user) {
                            $record->user_id = null;
                            $record->update();
                            Notification::make()
                                ->title('Finance Manager Removed')
                                ->success()
                                ->send();
                        }

                        route('project.edit', [ 'record' => $record->id,]);
                    });
                    // ->hidden(fn (Model $record) => !empty($record->user) ? false : true);
    }


    public function  viewAccountDetailsAction(): Action
        {
            
       return  Action::make('viewAccountDetails')
           ->color('gray')
           ->extraAttributes([
            'style'=> 'color: gray'
           ])
         
           ->label('View Profile')
           ->modalContent(function (array $arguments) {
              $record = Project::find($arguments['record']['id']);
        
               return view('livewire.account-details', ['record'=> $record?->user]);
           })
           ->size(ActionSize::ExtraSmall)
           ->modalWidth(MaxWidth::SevenExtraLarge)
           ->button()
           ->outlined()
           ->modalSubmitAction(false)
           ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
           ->disabledForm()
           ->slideOver();
                    // ->hidden(fn (Model $record) => !empty($record->user) ? false : true);
    }


   

    public function form(Form $form): Form
    {
        return $form
            ->schema([ Section::make('Project Details')


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


        return redirect()->route('project.index');
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


    public function updateAction(): Action
    {
        return Action::make('update')
        ->label('SUBMIT')
            ->action(fn () => $this->save());
    }

    public function render(): View
    {
        return view('livewire.projects.edit-project');
    }
}
