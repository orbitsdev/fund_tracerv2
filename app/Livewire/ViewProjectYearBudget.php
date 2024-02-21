<?php

namespace App\Livewire;

use Closure;
use App\Models\Test;
use Filament\Forms\Get;
use Livewire\Component;
use App\Models\Breakdown;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\ProjectYear;
use Filament\Support\RawJs;
use App\Models\SelectedMOOE;
use App\Models\SPSBreakdown;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;

use Filament\Actions\StaticAction;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Section;

use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Actions\Action as FAction;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class ViewProjectYearBudget extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;






    public ?array $data = [];

    public ?String $selectedps;

    public ProjectYear $record;

    public function viewAttachmentAction(): Action
    {
        return Action::make('ViewAttachment')
        ->label(function(array $arguments) {
            $breakdown = BreakDown::find($arguments['record']);
            $count = $breakdown ? $breakdown->files()->count() : 0;
            $label = 'Attachment' . ($count > 0 ? '(' . $count . ')' : '');
            return $label;
            
        })
        ->color('info')
        // ->action(function (array $arguments) {
        //     return  $record = BreakDown::find($arguments['record']);
        // })
    ->modalContent(fn (array $arguments): View => view(
        'livewire.attachment-view',
        ['record' => BreakDown::find($arguments['record'])],
    ))
    ->modalSubmitAction(false)
    ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
    ->disabledForm()
        ->size(ActionSize::ExtraSmall)
       ->button()
        ->icon('heroicon-m-paper-clip')
        ->outlined()
        // ->iconButton()
        ->extraAttributes([
            'style' => 'outline: none;
             box-shadow: none ; ',
        ]);
    }

    public function addPSBreakDownAction(): Action
    {
        return CreateAction::make('addPSBreakDown')
        ->beforeFormFilled(function (array $arguments) {
            $this->selectedps = $arguments['record'];
           
            // Runs before the form fields are populated with their default values.
        })
       
        ->fillForm(function (array $arguments) {
            $selected_ps = SelectedPS::find($arguments['record']);
            $remaining_budget = null;
            
            if ($selected_ps) {
                $current_budget = $selected_ps->amount;
                $current_breakdown = $selected_ps->breakdowns->sum('amount');
                $remaining_budget = $current_budget - $current_breakdown;
            }
            
            return [
                'remaining' => number_format($remaining_budget),
            ];
        })
            ->label('Add Breakdown')
            ->size(ActionSize::ExtraSmall)
            ->button()
            ->icon('heroicon-m-plus')
            ->outlined()
            // ->iconButton()
            ->extraAttributes([
                'style' => 'outline: none;
                 box-shadow: none ; color:#9ca3af; font-weight: normal;',
            ])

            ->form([
                
                Section::make()
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([
                    TextInput::make('remaining')->required()
                    ->columnSpanFull()->readonly()->disabled()
                    
                    ,
                ]),
                Section::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                      
                        TextInput::make('description')->required()
                            ->columnSpan(4),
                        TextInput::make('amount')
                            ->columnSpan(4)
                            ->formatStateUsing(function ($get) {
                            })
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')

                            // ->rules([   fn (Get $get, array $arguments): Closure => function (string $attribute, $value, Closure $fail, ) use ($get, $arguments) {

                            //             $selected_ps = SelectedPS::find($arguments['record']);
                            //             $current_budget = $selected_ps->amount;
                            //             $current_breakdown = $selected_ps->breakdown->sum('amount');
                            //             $new_amount =  (float) str_replace(',', '', $get('amount'));
                            //             $over_all_total = $new_amount + $current_breakdown;
                            //             $remaining_budget = $current_budget - $current_breakdown;

                            //             if($over_all_total > $current_budget) {
                            //                 $fail("The remaining budgget is only {$remaining_budget} and the total breakdown plus new amount {$over_all_total} which exceed to the total buget");
                            //             }


                            //         // if ($get('other_field') === 'foo' && $value !== 'bar') {
                            //         //     $fail("The {$attribute} is invalid.");
                            //         // }
                            //     },
                            // ])
                            ->rules([
                                function (Get $get){
                                    return function (string $attribute, $value, Closure $fail) use ($get) {

                                        $selected_ps = SelectedPS::find((int)$this->selectedps ?? null);

                                        if ($selected_ps) {
                                            $current_budget = $selected_ps->amount;
                                            $current_breakdown = $selected_ps->breakdowns->sum('amount');
                                            $new_amount = (float) str_replace(',', '', $get('amount'));
                                            $over_all_total = $new_amount + $current_breakdown;
                                            $remaining_budget = $current_budget - $current_breakdown;
                                        
                                            if ($over_all_total > $current_budget) {
                                                $fail("The remaining budget is only {$remaining_budget} and the overall total is {$over_all_total}");
                                            }
                                        } else {
                                            $fail("Selected Personal Serivce not found");
                                        }
                                        
                                        // if ($get('other_field') === 'foo' && $value !== 'bar') {
                                        // }
                                    };
                                },
                            ])
                            ->live()
                            // ->formatStateUsing(function($state){
                            //     return $state->title;
                            // })


                            ->prefix('₱')
                            ->numeric()
                            // ->maxValue(9999999999)
                            ->default(0)
                            ->columnSpan(4)
                            ->required(),



                        TableRepeater::make('ps_break_down_files')
                            ->withoutHeader()
                            ->emptyLabel('No Attachment Files')
                            ->columnSpanFull()
                            ->emptyLabel('None')
                            ->relationship('files')
                            ->label('Attachments')

                            ->columnWidths([
                                // 'fourth_layer_id' => '200px',
                                'file' => '300px',
                            ])
                            ->schema([
                                TextInput::make('file_name')
                                    ->label('File Description')
                                    ->maxLength(191)
                                    ->required()

                                    ->columnSpanFull(),
                                FileUpload::make('file')
                                    ->required()


                                    // ->columnSpanFull()
                                    // ->image()
                                    ->preserveFilenames()
                                    ->maxSize(200000)
                                    ->label('File')
                                    ->disk('public')
                                    ->directory('breakdown-files')
                            ])
                            ->deleteAction(
                                fn (FAction $action) => $action->requiresConfirmation(),
                            )
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data, Get $get): array {


                                // $data['user_id'] = auth()->id();

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                // $filePath = storage_path('app/public/' . $data['file']);


                                $filePath = storage_path('app/public/' . $data['file']);

                                $fileInfo = [
                                    'file' => $data['file'],
                                    'file_name' => $data['file_name'],
                                    'file_type' => mime_content_type($filePath),
                                    'file_size' => call_user_func(function ($bytes) {
                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                        $i = 0;

                                        while ($bytes >= 1024 && $i < count($units) - 1) {
                                            $bytes /= 1024;
                                            $i++;
                                        }

                                        return round($bytes, 2) . ' ' . $units[$i];
                                    }, filesize($filePath)),
                                ];
                                return $fileInfo;
                                // $data['user_id'] = auth()->id();

                                // return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data, $get): array {


                                $filePath = storage_path('app/public/' . $data['file']);

                                $fileInfo = [
                                    'file' => $data['file'],
                                    'file_name' => $data['file_name'],
                                    'file_type' => mime_content_type($filePath),
                                    'file_size' => call_user_func(function ($bytes) {
                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                        $i = 0;

                                        while ($bytes >= 1024 && $i < count($units) - 1) {
                                            $bytes /= 1024;
                                            $i++;
                                        }

                                        return round($bytes, 2) . ' ' . $units[$i];
                                    }, filesize($filePath)),
                                ];

                                // dd($fileInfo);
                                // dd($data);

                                return $fileInfo;
                            })
                            // ->collapsed()
                            // ->collapsible()
                            ->reorderable(true)
                            ->columnSpanFull()
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Add File'),
                    ]),




            ])
            ->mutateFormDataUsing(function (array $data, array $arguments, Get $get): array {

                // dd($get('ps_break_down_files'));
                $model = SelectedPS::find($arguments['record']);
                $data['breakdownable_id'] = $model->id;
                $data['breakdownable_type'] = get_class($model);
                  unset($data['remaining']);
                unset($data['remaining']);


                return $data;
            })
            ->disableCreateAnother()
            ->model(Breakdown::class)
            ->modalHeading('Add BreakDown')
            ->modalWidth(MaxWidth::SevenExtraLarge);
        // ->action(fn () => dd('addPersonalService'));
    }




    public function addMOOEBreakDownAction(): Action
    {
        return CreateAction::make('addMOOEBreakDown')
            ->label('Add Breakdown')
            ->size(ActionSize::ExtraSmall)

            ->button()
            ->icon('heroicon-m-plus')
            ->outlined()
            // ->iconButton()
            ->extraAttributes([
                'style' => 'outline: none;
                box-shadow: none ',
            ])

            ->form([
             

                Section::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                        TextInput::make('description')->required()
                            ->columnSpan(4),
                        TextInput::make('amount')
                            ->columnSpan(4)

                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')

                            // ->mask(RawJs::make('$money($input)'))
                            // ->stripCharacters(',')
                            ->prefix('₱')
                            ->numeric()
                            // ->maxValue(9999999999)
                            ->default(0)
                            ->columnSpan(4)
                            ->required(),



                        TableRepeater::make('break_down_files')
                            ->withoutHeader()
                            ->emptyLabel('No Attachment Files')
                            ->columnSpanFull()
                            ->emptyLabel('None')
                            ->relationship('files')
                            ->label('Attachments')

                            ->columnWidths([
                                // 'fourth_layer_id' => '200px',
                                'file' => '300px',
                            ])
                            ->schema([
                                TextInput::make('file_name')
                                    ->label('File Description')
                                    ->maxLength(191)
                                    ->required()
                                    ->columnSpanFull(),
                                FileUpload::make('file')
                                    ->required()


                                    // ->columnSpanFull()
                                    // ->image()
                                    ->preserveFilenames()
                                    ->maxSize(200000)
                                    ->label('File')
                                    ->disk('public')
                                    ->directory('breakdown-files')
                            ])
                            ->deleteAction(
                                fn (FAction $action) => $action->requiresConfirmation(),
                            )
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                // $data['user_id'] = auth()->id();

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                // $filePath = storage_path('app/public/' . $data['file']);


                                $filePath = storage_path('app/public/' . $data['file']);

                                $fileInfo = [
                                    'file' => $data['file'],
                                    'file_name' => $data['file_name'],
                                    'file_type' => mime_content_type($filePath),
                                    'file_size' => call_user_func(function ($bytes) {
                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                        $i = 0;

                                        while ($bytes >= 1024 && $i < count($units) - 1) {
                                            $bytes /= 1024;
                                            $i++;
                                        }

                                        return round($bytes, 2) . ' ' . $units[$i];
                                    }, filesize($filePath)),
                                ];
                                return $fileInfo;
                                // $data['user_id'] = auth()->id();

                                // return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {


                                $filePath = storage_path('app/public/' . $data['file']);

                                $fileInfo = [
                                    'file' => $data['file'],
                                    'file_name' => $data['file_name'],
                                    'file_type' => mime_content_type($filePath),
                                    'file_size' => call_user_func(function ($bytes) {
                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                        $i = 0;

                                        while ($bytes >= 1024 && $i < count($units) - 1) {
                                            $bytes /= 1024;
                                            $i++;
                                        }

                                        return round($bytes, 2) . ' ' . $units[$i];
                                    }, filesize($filePath)),
                                ];

                                // dd($fileInfo);
                                // dd($data);

                                return $fileInfo;
                            })
                            // ->collapsed()
                            // ->collapsible()
                            ->reorderable(true)
                            ->columnSpanFull()
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Add File'),
                    ]),




            ])
            ->mutateFormDataUsing(function (array $data, array $arguments): array {


                $model = SelectedMOOE::find($arguments['record']);
                $data['breakdownable_id'] = $model->id;
                $data['breakdownable_type'] = get_class($model);


                return $data;
            })
            ->disableCreateAnother()
            ->model(Breakdown::class)
            ->modalHeading('Add BreakDown')
            ->modalWidth(MaxWidth::SevenExtraLarge);
        // ->action(fn () => dd('addPersonalService'));
    }
    public function addCOBreakDownAction(): Action
    {
        return CreateAction::make('addCOBreakDown')
            ->label('Add Breakdown')
            ->size(ActionSize::ExtraSmall)
           
            ->button()
            ->icon('heroicon-m-plus')
            ->outlined()
            // ->iconButton()
            ->extraAttributes([
                'style' => 'outline: none;
                box-shadow: none ',
            ])

            ->form([
             

                Section::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                     
                        TextInput::make('description')->required()
                            ->columnSpan(4),
                        TextInput::make('amount')
                            ->columnSpan(4)

                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')

                            // ->mask(RawJs::make('$money($input)'))
                            // ->stripCharacters(',')
                            ->prefix('₱')
                            ->numeric()
                            // ->maxValue(9999999999)
                            ->default(0)
                            ->columnSpan(4)
                            ->required(),



                        TableRepeater::make('break_down_files')
                            ->withoutHeader()
                            ->emptyLabel('No Attachment Files')
                            ->columnSpanFull()
                            ->emptyLabel('None')
                            ->relationship('files')
                            ->label('Attachments')

                            ->columnWidths([
                                // 'fourth_layer_id' => '200px',
                                'file' => '300px',
                            ])
                            ->schema([
                                TextInput::make('file_name')
                                    ->label('File Description')
                                    ->maxLength(191)
                                    ->required()
                                    ->columnSpanFull(),
                                FileUpload::make('file')
                                    ->required()

                                    // ->columnSpanFull()
                                    // ->image()
                                    ->preserveFilenames()
                                    ->maxSize(200000)
                                    ->label('File')
                                    ->disk('public')
                                    ->directory('breakdown-files')
                            ])
                            ->deleteAction(
                                fn (FAction $action) => $action->requiresConfirmation(),
                            )
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                // $data['user_id'] = auth()->id();

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                // $filePath = storage_path('app/public/' . $data['file']);


                                $filePath = storage_path('app/public/' . $data['file']);

                                $fileInfo = [
                                    'file' => $data['file'],
                                    'file_name' => $data['file_name'],
                                    'file_type' => mime_content_type($filePath),
                                    'file_size' => call_user_func(function ($bytes) {
                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                        $i = 0;

                                        while ($bytes >= 1024 && $i < count($units) - 1) {
                                            $bytes /= 1024;
                                            $i++;
                                        }

                                        return round($bytes, 2) . ' ' . $units[$i];
                                    }, filesize($filePath)),
                                ];
                                return $fileInfo;
                                // $data['user_id'] = auth()->id();

                                // return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {


                                $filePath = storage_path('app/public/' . $data['file']);

                                $fileInfo = [
                                    'file' => $data['file'],
                                    'file_name' => $data['file_name'],
                                    'file_type' => mime_content_type($filePath),
                                    'file_size' => call_user_func(function ($bytes) {
                                        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                        $i = 0;

                                        while ($bytes >= 1024 && $i < count($units) - 1) {
                                            $bytes /= 1024;
                                            $i++;
                                        }

                                        return round($bytes, 2) . ' ' . $units[$i];
                                    }, filesize($filePath)),
                                ];

                                // dd($fileInfo);
                                // dd($data);

                                return $fileInfo;
                            })
                            // ->collapsed()
                            // ->collapsible()
                            ->reorderable(true)
                            ->columnSpanFull()
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Add File'),
                    ]),




            ])
            ->mutateFormDataUsing(function (array $data, array $arguments): array {


                $model = SelectedCO::find($arguments['record']);
                $data['breakdownable_id'] = $model->id;
                $data['breakdownable_type'] = get_class($model);


                return $data;
            })
            ->disableCreateAnother()
            ->model(Breakdown::class)
            ->modalHeading('Add BreakDown')
            ->modalWidth(MaxWidth::SevenExtraLarge);
        // ->action(fn () => dd('addPersonalService'));
    }


    public function editBreakDownAction(): Action
    {
        return EditAction::make('editBreakDown')
            ->size(ActionSize::Small)
            ->icon('heroicon-m-pencil-square')
            ->record(function (array $arguments) {
                return BreakDown::find($arguments['record']);
            })
            ->mutateFormDataUsing(function (array $data): array {
                unset($data['remaining']);
         
                return $data;
            })
            ->iconButton()
           
            ->fillForm(function (array $arguments) {
                $model = BreakDown::find($arguments['record']);
                $this->selectedps = $arguments['record'];

                if ($model->breakdownable instanceof \App\Models\SelectedPS) {
                    $parent_model = $model->breakdownable;
                    $current_breakdown = $parent_model->breakdowns->sum('amount');
                    $current_budget = $parent_model->amount;
                    $remaining_budget = $current_budget - $current_breakdown;
                  
                    // $breakdown is associated with a SelectedPS model
                    // Your code here
                }

                $filled_data = [
                    'remaining'=> $remaining_budget,
                    'description' => $model->description,
                    'amount' => $model->amount,
                    'break_down_files' => $model->files->map(function ($file) {
                        return $file->toArray();
                    })->toArray(),
                ];

                // dd($filled_data);

                // Return the data
                return $filled_data;
            })
            ->color('info')
            ->form([
             
                Section::make()
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([
                    TextInput::make('remaining')->required()
                    ->columnSpanFull()->readonly()->disabled()
                   
                    
                    ,
                ]),
                Section::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema(
                        [
                            TextInput::make('description')->required()
                                ->columnSpan(4),
                            TextInput::make('amount')
                                ->columnSpan(4)

                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')

                                // ->mask(RawJs::make('$money($input)'))
                                // ->stripCharacters(',')
                                ->prefix('₱')
                                ->numeric()
                                // ->maxValue(9999999999)
                                ->default(0)
                                ->columnSpan(4)
                                ->required()
                                ->rules([
                                    function (Get $get){
                                        return function (string $attribute, $value, Closure $fail) use ($get, ) {
                                            $model = BreakDown::find((int)$this->selectedps ?? null);

                                            if ($model) {
                                                if ($model->breakdownable instanceof \App\Models\SelectedPS) {
                                                    $parent_model = $model->breakdownable;
                                                    $current_breakdown = $parent_model->breakdowns->sum('amount');
                                                    $new_amount = (float) str_replace(',', '', $get('amount'));
                                                    $over_all_total = $new_amount + $current_breakdown;
                                                    $current_budget = $parent_model->amount;
                                                    $remaining_budget = $current_budget - $current_breakdown;
                                                    
                                                    if ($over_all_total > $current_budget) {
                                                        $fail("The remaining budget is only {$remaining_budget} and the overall total is {$over_all_total}");
                                                    }
                                                } else {
                                                    // Handle the case where breakdown is not associated with a SelectedPS
                                                    $fail("The breakdown is not associated with any specific budget.");
                                                }
                                            } else {
                                                // Handle the case where the BreakDown record is not found
                                                $fail("BreakDown record not found.");
                                            }
                                           
                    
                                            
                                            // if ($get('other_field') === 'foo' && $value !== 'bar') {
                                            // }
                                        };
                                    },
                                ])
                                ,



                            TableRepeater::make('break_down_files')
                                ->withoutHeader()
                                ->emptyLabel('No Attachment Files')
                                ->columnSpanFull()
                                ->emptyLabel('None')
                                ->relationship('files')
                                ->label('Attachments')

                                ->columnWidths([
                                    // 'fourth_layer_id' => '200px',
                                    'file' => '300px',
                                ])
                                ->schema([
                                    TextInput::make('file_name')
                                        ->label('File Description')
                                        ->maxLength(191)
                                        ->required()
                                        ->columnSpanFull(),
                                    FileUpload::make('file')
                                        ->required()

                                        // ->columnSpanFull()
                                        // ->image()
                                        ->preserveFilenames()
                                        ->maxSize(200000)
                                        ->label('File')
                                        ->disk('public')
                                        ->directory('breakdown-files')
                                ])
                                ->deleteAction(
                                    fn (FAction $action) => $action->requiresConfirmation(),
                                )
                                ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                    // $data['user_id'] = auth()->id();

                                    return $data;
                                })
                                ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                    // $filePath = storage_path('app/public/' . $data['file']);


                                    $filePath = storage_path('app/public/' . $data['file']);

                                    $fileInfo = [
                                        'file' => $data['file'],
                                        'file_name' => $data['file_name'],
                                        'file_type' => mime_content_type($filePath),
                                        'file_size' => call_user_func(function ($bytes) {
                                            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                            $i = 0;

                                            while ($bytes >= 1024 && $i < count($units) - 1) {
                                                $bytes /= 1024;
                                                $i++;
                                            }

                                            return round($bytes, 2) . ' ' . $units[$i];
                                        }, filesize($filePath)),
                                    ];
                                    return $fileInfo;
                                    // $data['user_id'] = auth()->id();

                                    // return $data;
                                })
                                ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {


                                    $filePath = storage_path('app/public/' . $data['file']);

                                    $fileInfo = [
                                        'file' => $data['file'],
                                        'file_name' => $data['file_name'],
                                        'file_type' => mime_content_type($filePath),
                                        'file_size' => call_user_func(function ($bytes) {
                                            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                            $i = 0;

                                            while ($bytes >= 1024 && $i < count($units) - 1) {
                                                $bytes /= 1024;
                                                $i++;
                                            }

                                            return round($bytes, 2) . ' ' . $units[$i];
                                        }, filesize($filePath)),
                                    ];

                                    // dd($fileInfo);
                                    // dd($data);

                                    return $fileInfo;
                                })
                                // ->collapsed()
                                // ->collapsible()
                                ->reorderable(true)
                                ->columnSpanFull()
                                ->columns(2)
                                ->defaultItems(0)
                                ->addActionLabel('Add File'),
                        ],
                    ),
            ])
            // ->action(function (array $data, array $arguments) {
            //     $model = BreakDown::find($arguments['record']);


            //     // $final_data = [
            //     //     // 'project_year_id' => $this->record->id,
            //     //     'cost_type' => $data['cost_type'],
            //     //     'p_s_group_id' => $data['p_s_group_id'],
            //     //     'p_s_expense_id' => $data['p_s_expense_id'],
            //     //     'amount' => $amount,
            //     // ];

            //     $model->update($data);
            //     Notification::make()
            //     ->title('Update successfully')
            //     ->success()
            //     ->send();
            //     // dd($model);
            // })

            ->model(Breakdown::class)
            ->modalHeading('Add BreakDown');
    }
    public function deleteBreakDownAction(): Action
    {
        return Action::make('deleteBreakDown')
            ->size(ActionSize::Small)
            ->iconButton()
            ->icon('heroicon-m-x-mark')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $ps = BreakDown::find($arguments['record']);
                $ps?->delete();

                Notification::make()
                    ->title('Delete successfully')
                    ->success()
                    ->send();
            });
    }

    public function deleteMOOEBreakDownAction(): Action
    {
        return Action::make('deleteMOOEBreakDown')
            ->size(ActionSize::ExtraSmall)
            ->iconButton()
            ->icon('heroicon-m-x-mark')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $ps = BreakDown::find($arguments['record']);
                $ps?->delete();

                Notification::make()
                    ->title('Delete successfully')
                    ->success()
                    ->send();
            });
    }

    public function deleteCOBreakDownAction(): Action
    {
        return Action::make('deletePSBreakDown')
            ->size(ActionSize::ExtraSmall)
            ->iconButton()
            ->icon('heroicon-m-x-mark')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $ps = BreakDown::find($arguments['record']);
                $ps?->delete();

                Notification::make()
                    ->title('Delete successfully')
                    ->success()
                    ->send();
            });
    }



    public function mount()
    {
    }

    public function render()


    {

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

        #total

        $total_ps = SelectedPS::where('project_year_id', $this->record->id)->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_ps_breakdown = SelectedPS::where('project_year_id', $this->record->id) ->with('breakdowns')->get()->flatMap->breakdowns->sum('amount');
        $remaining_budget_ps = $total_ps - $total_ps_breakdown;
        $percentage_used_ps = ($total_ps_breakdown / $total_ps) * 100;
        $remaining_percentage_ps = 100 - $percentage_used_ps;


        // $total_ps_breakdown = SelectedPS::where('project_year_id', $this->record->id)->with('breakdon')->get()->sum('p_s_expense.amount');
        $total_mooe = SelectedMOOE::where('project_year_id', $this->record->id)->sum('amount');
        $total_mooe_breakdown = SelectedMOOE::where('project_year_id', $this->record->id) ->with('breakdowns')->get()->flatMap->breakdowns->sum('amount');
        $remaining_budget_mooe = $total_mooe - $total_mooe_breakdown;
        $percentage_used_mooe = ($total_mooe_breakdown / $total_mooe) * 100;
        $remaining_percentage_mooe = 100 - $percentage_used_mooe;
        $total_co = SelectedCO::where('project_year_id', $this->record->id)->sum('amount');
        $total_budget = ($total_ps + $total_mooe + $total_co);



        $startDate = \Carbon\Carbon::parse($this->record->project->start_date);
        $endDate = \Carbon\Carbon::parse($this->record->project->end_date);

        $total_months = $endDate->diffInMonths($startDate);

        return view('livewire.view-project-year-budget', compact(
            'total_ps',
            'total_mooe',
            'total_co',
            'personal_services',
            'mooes',
            'cos',
            'total_budget',
            'total_ps_breakdown',
            'remaining_budget_ps',
            'percentage_used_ps',
            'remaining_percentage_ps',
            'total_months'
        ));
    }
}
