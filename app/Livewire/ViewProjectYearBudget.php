<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\ProjectYear;
use Filament\Support\RawJs;
use App\Models\SelectedMOOE;
use App\Models\SPSBreakdown;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\TextInput;

use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Actions\Action as FAction;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Illuminate\Support\Facades\Storage;
class ViewProjectYearBudget extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;




    public function addPSBreakDownAction(): Action
    {
        return CreateAction::make('addPSBreakDown')
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

                TextInput::make('description')->required()
                ->columnSpan(2)

                ,
                TextInput::make('amount')
                ->columnSpan(2)

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

                     TableRepeater::make('break_down_files')
                                ->withoutHeader()
                                ->emptyLabel('No Attachment Files')
                                ->columnSpanFull()
                                ->emptyLabel('None')
                                    ->relationship('files')
                                    ->label('Documents')

                                    ->columnWidths([
                                        // 'fourth_layer_id' => '200px',
                                        'file' => '200px',
                                    ])
                                    ->schema([
                                        TextInput::make('file_name')
                                            ->label('File Name')
                                            ->maxLength(191)
                                            ->required()
                                            ->columnSpanFull()
                                            ,
                                        FileUpload::make('file')
                                            ->required()

                                            // ->columnSpanFull()
                                            // ->image()
                                            ->preserveFilenames()
                                            ->maxSize(200000)
                                            ->label('File')
                                            ->disk('public')
                                            ->directory('program-files')
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


            ])
            ->mutateFormDataUsing(function (array $data, array $arguments): array {
                $data['selected_p_s_id'] = auth()->id();

                return $data;
            })
            ->disableCreateAnother()
             ->model(SPSBreakdown::class)
            ->modalHeading('Add/Edit BreakDown')
            ->modalWidth(MaxWidth::SixExtraLarge)

            ;
        // ->action(fn () => dd('addPersonalService'));
    }


    public ProjectYear $record;
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
        $total_mooe = SelectedMOOE::where('project_year_id', $this->record->id)->sum('amount');
        $total_co = SelectedCO::where('project_year_id', $this->record->id)->sum('amount');


        return view('livewire.view-project-year-budget',compact(
            'total_ps',
            'total_mooe',
            'total_co',
            'personal_services',
            'mooes',
            'cos'
        ));
    }
}
