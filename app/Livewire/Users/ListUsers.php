<?php

namespace App\Livewire\Users;

use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Notifications\Notification;
class ListUsers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([


                // ->hidden(function(Model $record) {
                //     return $record->is_admin();
                // }),
                TextColumn::make('first_name')->searchable(),
                TextColumn::make('last_name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('account_type')->searchable(),
                TextColumn::make('role')->searchable()->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Admin' => 'primary',
                        'Financial Manager' => 'info',
                        default => 'gray',
                    }),
                    TextColumn::make('assigned_project')->formatStateUsing(function($state){

                        if(!empty($state)){
                            return $state->project->title;
                        }else{
                            return 'No Project Assigned';
                        }
                    })
                    ->label(' Project')
                    ->color('gray'),
            ])
            ->filters([
                //
            ])

            ->headerActions([



                CreateAction::make()
                    ->modalHeading('Create User')
                    ->label('New User')
                    ->icon('heroicon-m-users')
                    ->form([


                        Section::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([


                                TextInput::make('first_name')->required()->columnSpan(4),
                                TextInput::make('last_name')->required()->columnSpan(4),

                                TextInput::make('email')->required()->unique(ignoreRecord: true)
                                    ->columnSpan(4),
                                Select::make('role')
                                    ->required()
                                    ->label('Role')
                                    ->default('Financial Manager')
                                    ->options([
                                        'Admin' => 'Admin',
                                        'Financial Manager' => 'Financial Manager',
                                    ])
                                    ->columnSpan(4)
                                    ->searchable()
                                    ->live()
                                    ->hidden(fn (string $operation): bool => $operation === 'edit'),

                                Password::make('password')
                                    ->label(fn (string $operation) => $operation == 'create' ? 'Password' : 'New Password')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->columnSpan(4),

                                FileUpload::make('profile_photo_path')
                                    ->disk('public')
                                    ->label('Profile')
                                    ->directory('user-profile')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    // ->imageEditorMode(2)
                                    ->columnSpan(4)

                            ]),




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ->disableCreateAnother(),
            ])
            ->actions([

                Action::make('remove_assigned')
                    ->label('Remove Assigned')
                    ->requiresConfirmation()
                    ->action(function(Model $record){


                        if($record->assigned_project()->exists()){
                            $record->assigned_project()->delete();
                            Notification::make()
                            ->title('Saved successfully')
                            ->success()
                            ->send();
                        }
                        // $record->assigned_project()->delete();
                    })
                    ->hidden(function ($record) {
                        return $record->assigned_project()->doesntExist();
                    })

                // ->modalWidth(MaxWidth::SevenExtraLarge)
                ,
                EditAction::make('assigne_to_project')
                    ->modalHeading('Assigne to Project')
                    ->label("Assigned Project")
                    // ->diabledicon()
                    ->icon(function(){
                        return "";
                    })
                    ->color('primary')
                    // ->icon('heroicon-m-user-plus')
                    ->form([



                        Group::make()
                            ->relationship('assigned_project')
                            ->schema([
                                Select::make('project_id')
                                    ->relationship(
                                        name: 'project',
                                        titleAttribute: 'title',
                                         modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('assigned_project'),
                                    )
                                    ->preload()
                                    ->searchable()
                                    ,



                            ]),


                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])
                    ->hidden(function ($record) {
                        return $record->assigned_project()->exists();

                    })


                // ->modalWidth(MaxWidth::SevenExtraLarge)
                ,

                ActionGroup::make([


                    EditAction::make()
                    ->color('primary')
                    ->label('Edit User')
                        ->modalHeading('Edit User')
                        // ->icon('heroicon-m-users')
                        ->form([


                            Section::make()
                                ->columns([
                                    'sm' => 3,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                ->schema([


                                    TextInput::make('first_name')->required()->columnSpan(4),
                                    TextInput::make('last_name')->required()->columnSpan(4),

                                    TextInput::make('email')->required()->unique(ignoreRecord: true)
                                        ->columnSpan(4),
                                    Select::make('role')
                                        ->required()
                                        ->label('Role')
                                        ->default('Financial Manager')
                                        ->options([
                                            'Admin' => 'Admin',
                                            'Financial Manager' => 'Financial Manager',
                                        ])
                                        ->columnSpan(4)
                                        ->searchable()
                                        ->live()
                                        // ->hidden(fn (string $operation): bool => $operation === 'edit')
                                        ->disabled(),

                                    Password::make('password')
                                        ->label(fn (string $operation) => $operation == 'create' ? 'Password' : 'New Password')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->required(fn (string $operation): bool => $operation === 'create')
                                        ->columnSpan(4),
                                    FileUpload::make('profile_photo_path')
                                        ->disk('public')
                                        ->directory('user-profile')
                                        ->image()
                                        ->imageEditor()
                                        ->imageEditorAspectRatios([
                                            '16:9',
                                            '4:3',
                                            '1:1',
                                        ])
                                        // ->imageEditorMode(2)
                                        ->columnSpan(4)

                                ]),




                            // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                        ])
                        ->modalWidth(MaxWidth::SevenExtraLarge),
                    Tables\Actions\DeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])



             ->modifyQueryUsing(fn (Builder $query) => $query->where('id', '!=', auth()->user()->id)->latest())
            ;
    }

    public function render(): View
    {
        return view('livewire.users.list-users');
    }
}
