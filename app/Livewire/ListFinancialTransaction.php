<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Contracts\View\View;
use App\Models\FinancialTransaction;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class ListFinancialTransaction extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    public function myform(){
     return [
        Section::make('')
        ->columns([
            'sm' => 3,
            'xl' => 6,
            '2xl' => 9,
        ])
        ->schema([

            TextInput::make('dv_number')
                ->required()
                ->live()
                ->columnSpan(3)
                ->debounce(700),
            Select::make('cost_type')
                ->columnSpan(3)
                ->options([
                    'Direct Cost' => 'Direct Cost',
                    'Indirect Cost SKSU' => 'Indirect Cost SKSU',
                    'Indirect Cost DOST' => 'Indirect Cost DOST',
                ]),
            TextInput::make('selected_dropdown')
                ->live()
                ->required()

                ->columnSpan(3)
                ->debounce(700),






        ]),

    Section::make('')
        ->columns([
            'sm' => 3,
            'xl' => 6,
            '2xl' => 9,
        ])
        ->schema([
            TextInput::make('amount')
                ->required()

                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')

                // ->mask(RawJs::make('$money($input)'))
                // ->stripCharacters(',')
                ->prefix('₱')
                ->numeric()
                ->required()

                // ->maxValue(9999999999)
                ->default(0)
                ->columnSpan(3)
                ->required(),

            TextInput::make('ada_number')
                ->live()
                ->columnSpan(3)
                ->required()

                ->debounce(700)
                ->label('Check/Ada Number'),
            Select::make('user_id')
            ->label('Payee Member')
                ->required()
                ->options(User::where('role', 'Payee')->get()->map(function($item){
                    return [
                        'id' => $item->id,
                        'name' => $item->getFullName(),
                    ];
                })->pluck('name','id'))
                ->columnSpan(3)
            ]),
            Section::make('')
            ->columns([
                'sm' => 3,
                'xl' => 6,
                '2xl' => 9,
            ])
            ->schema([
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
                    fn (Action $action) => $action->requiresConfirmation(),
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

        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(FinancialTransaction::query())
            ->columns([


                Tables\Columns\TextColumn::make('dv_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('selected_dropdown')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ada_number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.first_name')->formatStateUsing(function ($state) {
                    return $state;
                })
                    ->searchable(),

                    ViewColumn::make('file')->view('tables.columns.attachment-link')->label('Attachments')

            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()
                    ->modalWidth(MaxWidth::SixExtraLarge)
                    ->form($this->myForm())
            ])
            ->actions([

                ActionGroup::make([
                    // Action::make('view')
                    //     ->icon('heroicon-m-eye')
                    //     ->color('primary')
                    //     ->label('View')
                    //     ->url(fn (Model $record): string => route('project.view', ['record' => $record])),



                    Tables\Actions\EditAction::make()

                    ->label('Edit')->form($this->myForm())
                    ->modalWidth(MaxWidth::SixExtraLarge)
                    ,
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                    ->label('Actions'),
            ]);
    }

    public function render(): View
    {
        return view('livewire.list-financial-transaction');
    }
}
