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


    public function testAction(): Action
    {
        return Action::make('print')
        ->modalContentFooter(view('filament.pages.actions.advance'))
        ;
    }

    public function redirectToPrintPageAction(): Action
    {
        return Action::make('print')
            ->label('Print')
            ->color('gray')
            // ->button()
            ->icon('heroicon-m-printer')
            ->outlined()
            ->size(ActionSize::ExtraSmall)
            // ->iconButton()
            ->extraAttributes([

                'style' => 'outline: none;
                 box-shadow: none ;
                  font-weight: normal;
                  color: #9ca3af;
                  font-size: 10px;
                  ',

            ])
            ->url(fn (array $arguments): string => route('report.breakdown.redirectoPrintPage', ['record'=> $arguments['record'], 'type'=> $arguments['type']]))
             ->openUrlInNewTab()

            ;
    }

    public function downloadGroupAction(): Action
    {
        return Action::make('downloadGroup')
            ->label('Download')
            ->color('gray')
            // ->button()
            ->icon('heroicon-m-arrow-down-tray')
            ->outlined()
            ->size(ActionSize::ExtraSmall)
            // ->iconButton()
            ->extraAttributes([

                'style' => 'outline: none;
                 box-shadow: none ;
                  font-weight: normal;
                  color: #9ca3af;
                  font-size: 10px;
                  ',

            ])
            ->url(fn (array $arguments): string => route('report.group.redirecttoPrintPage', ['record'=> $arguments['record'], 'type'=> $arguments['type'], 'year'=> $arguments['year']]))
             ->openUrlInNewTab()

            ;
    }
    public function downloadBreakdownAction(): Action
    {
        return Action::make('downloadBreakDown')
            ->label('Download')
            ->color('gray')
            // ->button()
            ->icon('heroicon-m-arrow-down-tray')
            ->outlined()
            ->size(ActionSize::ExtraSmall)
            // ->iconButton()
            ->extraAttributes([

                'style' => 'outline: none;
                 box-shadow: none ;
                  font-weight: normal;
                  color: #9ca3af;
                  font-size: 10px;
                  ',

            ])
            ->url(fn (array $arguments): string => route('report.breakdown.download', ['record'=> $arguments['record'], 'type'=> $arguments['type']]))
             ->openUrlInNewTab()

            ;
    }
    public function viewAttachmentAction(): Action
    {
        return Action::make('ViewAttachment')
            ->label(function (array $arguments) {
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
            ->modalHeading(function (array $arguments) {
                $breakdown = BreakDown::find($arguments['record']);
                return $breakdown->description . ' Attachment' ?? 'Attachment';
            })

            ->modalSubmitAction(false)
            ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
            ->disabledForm()
            ->size(ActionSize::ExtraSmall)
            ->button()
            ->icon('heroicon-m-paper-clip')
            ->outlined()
            // ->iconButton()
            ->extraAttributes([
                // #9ca3af

                'style' => 'outline: none;
                 box-shadow: none ;
                 font-size: 10px;
                 color: #9ca3af;

             ',
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
                // color: #9ca3af   color: #9ca3af;;
                'style' => 'outline: none;
                 box-shadow: none ;
                  font-weight: normal;
                  color: #9ca3af;
                  font-size: 10px;
                  ',
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
                            ->columnSpanFull()->readonly()->disabled(),
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
                                function (Get $get) {
                                    return function (string $attribute, $value, Closure $fail) use ($get) {

                                        $selected_ps = SelectedPS::find((int)$this->selectedps ?? null);

                                        if ($selected_ps) {
                                            $current_budget = $selected_ps->amount;
                                            $current_breakdown = $selected_ps->breakdowns->sum('amount');
                                            $new_amount = (float) str_replace(',', '', $get('amount'));
                                            $over_all_total = $new_amount + $current_breakdown;
                                            $remaining_budget = $current_budget - $current_breakdown;

                                            if ($over_all_total > $current_budget) {
                                                $fail("Attention: Your proposed expense exceeds the allocated budget. The remaining budget is {$remaining_budget}, but including this new expense would bring the total to {$over_all_total}. Please be mindful of your spending limits.");
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
            ->modalHeading(function (array $arguments) {
                $model = SelectedPS::find($arguments['record']);

                return 'Add Breakdown ' .  $model->p_s_expense->title ?? '';
            })
            ->modalWidth(MaxWidth::SevenExtraLarge);
        // ->action(fn () => dd('addPersonalService'));
    }




    public function addMOOEBreakDownAction(): Action
    {
        return CreateAction::make('addMOOEBreakDown')

            ->beforeFormFilled(function (array $arguments) {
                $this->selectedps = $arguments['record'];

                // Runs before the form fields are populated with their default values.
            })
            ->fillForm(function (array $arguments) {
                $model = SelectedMOOE::find($arguments['record']);
                $remaining_budget = null;

                if ($model) {
                    $current_budget = $model->amount;
                    $current_breakdown = $model->breakdowns->sum('amount');
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
                box-shadow: none ;
                 font-weight: normal;
                 color: #9ca3af;
                 font-size: 10px;
                 ',
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
                            ->columnSpanFull()->readonly()->disabled(),
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

                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->prefix('₱')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(4)
                            ->required()
                            ->rules([
                                function (Get $get) {
                                    return function (string $attribute, $value, Closure $fail) use ($get) {

                                        $model = SelectedMOOE::find((int)$this->selectedps ?? null);

                                        if ($model) {
                                            $current_budget = $model->amount;
                                            $current_breakdown = $model->breakdowns->sum('amount');
                                            $new_amount = (float) str_replace(',', '', $get('amount'));
                                            $over_all_total = $new_amount + $current_breakdown;
                                            $remaining_budget = $current_budget - $current_breakdown;

                                            if ($over_all_total > $current_budget) {
                                                $fail("Attention: Your proposed expense exceeds the allocated budget. The remaining budget is {$remaining_budget}, but including this new expense would bring the total to {$over_all_total}. Please be mindful of your spending limits.");
                                            }
                                        } else {
                                            $fail("Selected Personal Serivce not found");
                                        }

                                        // if ($get('other_field') === 'foo' && $value !== 'bar') {
                                        // }
                                    };
                                },
                            ]),



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
            ->modalHeading(function (array $arguments) {
                $model = SelectedMOOE::find($arguments['record']);
                return 'Add Breakdown ' . $model->m_o_o_e_expense->title ?? '';
            })
            ->modalWidth(MaxWidth::SevenExtraLarge);
        // ->action(fn () => dd('addPersonalService'));
    }
    public function addCOBreakDownAction(): Action
    {
        return CreateAction::make('addCOBreakDown')
            ->extraAttributes([
                'style' => 'outline: none;
            box-shadow: none ;
             font-weight: normal;
             color: #9ca3af;
             font-size: 10px;
             ',
            ])
            ->beforeFormFilled(function (array $arguments) {
                $this->selectedps = $arguments['record'];

                // Runs before the form fields are populated with their default values.
            })
            ->fillForm(function (array $arguments) {
                $model = SelectedCO::find($arguments['record']);
                $remaining_budget = null;

                if ($model) {
                    $current_budget = $model->amount;
                    $current_breakdown = $model->breakdowns->sum('amount');
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


            ->form([
                Section::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                        TextInput::make('remaining')->required()
                            ->columnSpanFull()->readonly()->disabled(),
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

                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->prefix('₱')
                            ->numeric()

                            ->default(0)
                            ->columnSpan(4)
                            ->required()

                            ->rules([
                                function (Get $get) {
                                    return function (string $attribute, $value, Closure $fail) use ($get) {

                                        $model = SelectedCO::find((int)$this->selectedps ?? null);

                                        if ($model) {
                                            $current_budget = $model->amount;
                                            $current_breakdown = $model->breakdowns->sum('amount');
                                            $new_amount = (float) str_replace(',', '', $get('amount'));
                                            $over_all_total = $new_amount + $current_breakdown;
                                            $remaining_budget = $current_budget - $current_breakdown;

                                            if ($over_all_total > $current_budget) {
                                                $fail("Attention: Your proposed expense exceeds the allocated budget. The remaining budget is {$remaining_budget}, but including this new expense would bring the total to {$over_all_total}. Please be mindful of your spending limits.");
                                            }
                                        } else {
                                            $fail("Selected Personal Serivce not found");
                                        }

                                        // if ($get('other_field') === 'foo' && $value !== 'bar') {
                                        // }
                                    };
                                },
                            ]),



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
            ->modalHeading(function (array $arguments) {
                $model = SelectedCO::find($arguments['record']);
                return 'Add Breakdown ' . $model->description ?? '';
            })
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

                // Initialize variables
                $remaining_budget = 0;
                $description = '';
                $amount = 0;
                $break_down_files = [];

                if ($model) {
                    if (
                        $model->breakdownable instanceof \App\Models\SelectedPS ||
                        $model->breakdownable instanceof \App\Models\SelectedMOOE ||
                        $model->breakdownable instanceof \App\Models\SelectedCO
                    ) {
                        $parent_model = $model->breakdownable;
                        $current_breakdown = $parent_model->breakdowns->sum('amount');
                        $current_budget = $parent_model->amount;
                        $remaining_budget = $current_budget - $current_breakdown;

                        // Extract common data
                        $description = $model->description;
                        $amount = $model->amount;
                        $break_down_files = $model->files->map(function ($file) {
                            return $file->toArray();
                        })->toArray();
                    } else {
                        // Handle the case where breakdown is not associated with a SelectedPS, SelectedMOOE, or SelectedCO
                        // You may want to throw an exception or handle this differently based on your application's logic
                        // For now, we'll set a message indicating that the breakdown is not associated with a specific budget type
                        $description = 'Breakdown is not associated with any specific budget type.';
                    }
                } else {
                    // Handle the case where the BreakDown record is not found
                    // For now, we'll set a message indicating that the record was not found
                    $description = 'BreakDown record not found.';
                }

                // Prepare the filled data
                $filled_data = [
                    'remaining' => $remaining_budget,
                    'description' => $description,
                    'amount' => $amount,
                    'break_down_files' => $break_down_files,
                ];

                // Return the filled data
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

                            ->columnSpanFull()->readonly()->disabled(),
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
                                    function (Get $get) {
                                        return function (string $attribute, $value, Closure $fail) use ($get) {
                                            $model = BreakDown::find((int)$this->selectedps ?? null);

                                            if (!$model) {
                                                $fail("BreakDown record not found.");
                                                return;
                                            }




                                            $parent_model = $model->breakdownable;
                                            $current_budget = $parent_model->amount;

                                            $current_breakdown = $parent_model->breakdowns->sum('amount');


                                            $new_amount = (float) str_replace(',', '', $get('amount'));


                                            $remaining_budget = $current_budget - $current_breakdown;


                                            $old_amount = $model->amount;

                                            if ($new_amount > $old_amount) {
                                                $updated_amount  = $new_amount - $old_amount;
                                                if ($updated_amount > $remaining_budget) {
                                                    $fail("Attention: Your proposed expense exceeds the remaining budget. The remaining budget is {$remaining_budget}. Please adjust the new amount accordingly.");
                                                    return;
                                                }
                                            }
                                        };
                                    }
                                ]),



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

            ->modalWidth(MaxWidth::SevenExtraLarge)
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

        $total_ps_breakdown = SelectedPS::where('project_year_id', $this->record->id)->with('breakdowns')->get()->flatMap->breakdowns->sum('amount');
        $remaining_budget_ps = $total_ps - $total_ps_breakdown;
        $percentage_used_ps = $total_ps != 0 ? ($total_ps_breakdown / $total_ps) * 100 : 0;
        $remaining_percentage_ps = 100 - $percentage_used_ps;


        $total_mooe = SelectedMOOE::where('project_year_id', $this->record->id)->sum('amount');
        $total_mooe_breakdown = SelectedMOOE::where('project_year_id', $this->record->id)->with('breakdowns')->get()->flatMap->breakdowns->sum('amount');
        $remaining_budget_mooe = $total_mooe - $total_mooe_breakdown;
        $percentage_used_mooe = $total_mooe != 0 ? ($total_mooe_breakdown / $total_mooe) * 100 : 0;
        $remaining_percentage_mooe = 100 - $percentage_used_mooe;


        $total_co = SelectedCO::where('project_year_id', $this->record->id)->sum('amount');
        $total_co_breakdown = SelectedCO::where('project_year_id', $this->record->id)->with('breakdowns')->get()->flatMap->breakdowns->sum('amount');
        $remaining_budget_co = $total_co - $total_co_breakdown;
        $percentage_used_co = $total_co != 0 ? ($total_co_breakdown / $total_co) * 100 : 0;
        $remaining_percentage_co = 100 - $percentage_used_co;



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
            // PS
            'total_ps_breakdown',
            'remaining_budget_ps',
             'percentage_used_ps',
            'remaining_percentage_ps',
            //MOOE
            'total_mooe_breakdown',
            'remaining_budget_mooe',
            'percentage_used_mooe',
            'remaining_percentage_mooe',
            //CO
            'total_co_breakdown',
            'remaining_budget_co',
            'percentage_used_co',
            'remaining_percentage_co',


            'total_months'
        ));
    }
}
