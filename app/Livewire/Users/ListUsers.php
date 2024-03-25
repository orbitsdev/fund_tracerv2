<?php

namespace App\Livewire\Users;

use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;

use App\Enums\RoleConstant;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
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
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Tables\Grouping\Group as TGroup;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListUsers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    public function userForm(): array
    {
        return [
            Section::make('Personal Details')
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 9,
                ])
                ->schema([

                    TextInput::make('first_name')->required()->columnSpan(3),
                    TextInput::make('last_name')->required()->columnSpan(3),
                    Radio::make('gender')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                        ])
                        ->required()
                        ->inline()
                        ->columnSpan(3),



                ]),


                Section::make('Account Details')
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 9,
                ])
                ->schema([

                    Select::make('role')
                        ->required()
                        ->label('Account Type')
                        ->default(RoleConstant::FINANCE_MANAGER)
                        ->options(RoleConstant::ROLES)
                        ->columnSpan(3)
                        ->searchable()
                        ->live()
                        ->hidden(fn (string $operation): bool => $operation === 'edit'),

                    TextInput::make('email')->required()->unique(ignoreRecord: true)
                        ->columnSpan(3),


                    Password::make('password')
                        ->label(fn (string $operation) => $operation == 'create' ? 'Password' : 'New Password')
                        ->password()
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->columnSpan(3),

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
                        ->columnSpanFull()
                ]),

        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([


                // ->hidden(function(Model $record) {
                //     return $record->is_admin();
                // }),
                TextColumn::make('first_name')->formatStateUsing(function(Model $record) {
                    return $record->getFullName();
                })
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query
                        ->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                }),
                TextColumn::make('last_name')->searchable(),
                TextColumn::make('gender')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('account_type')->searchable(),
                TextColumn::make('role')->searchable()->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Admin' => 'trust',
                        'Financial Manager' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('assigned_project')->formatStateUsing(function ($state) {

                    if (!empty($state)) {
                        return $state->project->title;
                    } else {
                        return 'No Project Assigned';
                    }
                })
                    ->label(' Project')
                    ->color('gray'),
            ])
            ->filters([
                SelectFilter::make('role')
                ->label('Account Type')
                    ->options(RoleConstant::ROLES)
            ],
            layout: FiltersLayout::AboveContent
            )

            ->headerActions([



                CreateAction::make()
                ->color('trust')
                    ->modalHeading('Create Account')
                    ->label('New Account')
                    ->icon('heroicon-m-users')
                    ->form($this->userForm())
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ->disableCreateAnother(),
            ])
            ->actions([

                // Action::make('remove_assigned')
                //     ->label('Remove Assigned')
                //     ->button()
                //     ->outlined()
                //     ->requiresConfirmation()
                //     ->action(function (Model $record) {


                //         if ($record->assigned_project()->exists()) {
                //             $record->assigned_project()->delete();
                //             Notification::make()
                //                 ->title('Saved successfully')
                //                 ->success()
                //                 ->send();
                //         }
                //         // $record->assigned_project()->delete();
                //     })
                //     ->hidden(function ($record) {
                //         return $record->assigned_project()->doesntExist();
                //     })

                // // ->modalWidth(MaxWidth::SevenExtraLarge)
                // ,
                // EditAction::make('assigne_to_project')
                //     ->modalHeading('Assigne to Project')
                //     ->label("Assigned Project")
                //     // ->diabledicon()
                //     ->icon(function () {
                //         return "";
                //     })
                //     ->color('trust')
                //     // ->icon('heroicon-m-user-plus')
                //     ->form([



                //         Group::make()
                //             ->relationship('assigned_project')
                //             ->schema([
                //                 Select::make('project_id')
                //                     ->relationship(
                //                         name: 'project',
                //                         titleAttribute: 'title',
                //                         modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('assigned_project'),
                //                     )
                //                     ->preload()
                //                     ->searchable(),



                //             ]),


                //         // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                //     ])
                //     ->hidden(function ($record) {
                //         return $record->assigned_project()->exists();
                //     })


                // // ->modalWidth(MaxWidth::SevenExtraLarge)
                // ,


                EditAction::make()
                ->button()
                ->outlined()
                ->color('trust')
                ->label('Edit')
                ->modalHeading('Edit User')
                // ->icon('heroicon-m-users')
                ->form($this->userForm())
                ->modalWidth(MaxWidth::SevenExtraLarge),
            Tables\Actions\DeleteAction::make()
            ->button()
                ->outlined()
            ,
                // ActionGroup::make([


                // ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])

            ->groups([
                TGroup::make('role')
                ->label('Account Type')
                ->titlePrefixedWithLabel(false),
            ])



            ->modifyQueryUsing(fn (Builder $query) => $query->where('id', '!=', auth()->user()->id)->latest());
    }

    public function render(): View
    {
        return view('livewire.users.list-users');
    }
}
