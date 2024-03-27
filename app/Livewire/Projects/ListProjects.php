<?php

namespace App\Livewire\Projects;

use App\Models\User;
use Filament\Tables;
use App\Models\Project;
use Livewire\Component;
use App\Enums\AppConstant;
use Filament\Tables\Table;
use App\Enums\RoleConstant;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListProjects extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Project::query())
            ->columns([





                ViewColumn::make('')->view('tables.columns.project-total-budget')->label('DOST FUND'),
                TextColumn::make('title')->searchable()->label('PROJECT TITLE')->wrap(),
                TextColumn::make('user')
                    ->formatStateUsing(function ($state) {
                        if (!empty($state)) {

                            return $state->getFullName();
                        } else {
                            return 'NONE';
                        }
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    })
                    ->label('FINANCE MANAGER'),
                // TextColumn::make('allocated_fund')
                //     ->money('PHP')
                //     ->numeric(
                //         decimalPlaces: 0,
                //     )

                //     ->prefix('₱ ')
                //     ->sortable(),

                // TextColumn::make('start_date')
                //     ->date()

                //     ->label('START DATE')
                //     ->sortable(),
                // TextColumn::make('end_date')
                //     ->label('END DATE')
                //     ->date()
                //     ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([

                CreateAction::make('create')
                    ->icon('heroicon-m-plus')
                    ->label('Create')
                    ->url(fn (): string => route('project.create'))

                // CreateAction::make('create')->form([
                // ])

            ])
            ->actions([
                Action::make('view')
                    ->icon('heroicon-m-cursor-arrow-rays')
                    ->button()
                    ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->outlined()
                    ->label('MANAGE LIB')

                    ->url(fn (Model $record): string => route('project.line-item-budget', ['record' => $record])),

                // EditAction::make('FINANCE MANAGER')
                //     ->label('ADD FINANCE MANAGER')
                //     ->icon('heroicon-m-plus')
                //     ->outlined()
                //     ->button()
                //     ->extraAttributes(AppConstant::ACTION_STYLE)
                //     ->form([

                //         Select::make('user_id')
                //             ->label('Finance Manager Account')
                //             ->relationship(name: 'user', titleAttribute: 'first_name',   modifyQueryUsing: fn (Builder $query) => $query->where('role', RoleConstant::FINANCE_MANAGER),)
                //             ->searchable(['first_name', 'last_name', 'email'])
                //             ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->getFullName()} - {$record->email}")
                //             ->preload()


                //     ])
                //     ->hidden(fn (Model $record) => empty($record->user) ? false : true),
                // Action::make('REMOVE FINANCE MANAGER')
                //     ->label('REMOVE FINANCE MANAGER')
                //     ->icon('heroicon-m-x-mark')
                //     ->color('gray')
                //     ->outlined()

                //     ->button()
                //     ->extraAttributes(AppConstant::ACTION_STYLE)
                //     ->requiresConfirmation()
                //     ->modalHeading('Remove Finance Manager ')
                //     ->modalDescription('Are you sure you\'d like to remove project finance manager? This cannot be undone.')
                //     ->modalSubmitActionLabel('Yes, Remove it')
                //     ->action(function (Model $record) {


                //         if ($record->user) {
                //             $record->user_id = null;
                //             $record->update();
                //             Notification::make()
                //                 ->title('Finance Manager Removed')
                //                 ->success()
                //                 ->send();
                //         }
                //     })
                //     ->hidden(fn (Model $record) => !empty($record->user) ? false : true),

                Action::make('edit')
                    ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->icon('heroicon-m-pencil')
                    ->label('EDIT')
                    ->outlined()
                    ->button()
                    ->color('gray')


                    ->url(fn (Model $record): string => route('project.edit', ['record' => $record])),

                // Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('DELETE')
                    ->outlined()
                    ->color('gray')
                    ->button()
                    ->extraAttributes(AppConstant::ACTION_STYLE),

                // Action::make('monitor')

                // ->label('Monitor Lib')
                // ->url(fn (Model $record): string => route('project.line-item-budget', ['record'=> $record]))
                // ->button()
                // ->color('gray')
                // ->outlined()
                // ,




            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                    ->label('Actions'),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->latest());;
    }

    public function render(): View
    {
        return view('livewire.projects.list-projects');
    }
}
