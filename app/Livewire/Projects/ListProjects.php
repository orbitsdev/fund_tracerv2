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

                TextColumn::make('user')
                    ->formatStateUsing(function ($state) {
                        return $state->getFullName();
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    })
                    ->label('FINANCE MANAGER'),



                ViewColumn::make('')->view('tables.columns.project-total-budget')->label('DOST FUND'),
                TextColumn::make('title')->searchable()->label('PROJECT TITLE')->wrap(),
                // TextColumn::make('allocated_fund')
                //     ->money('PHP')
                //     ->numeric(
                //         decimalPlaces: 0,
                //     )

                //     ->prefix('₱ ')
                //     ->sortable(),

                TextColumn::make('start_date')
                    ->date()

                    ->label('START DATE')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('END DATE')
                    ->date()
                    ->sortable(),

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
                    ->icon('heroicon-m-pencil-square')
                    ->button()
                    ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->outlined()
                    ->label('MANAGE LIB')

                    ->url(fn (Model $record): string => route('project.line-item-budget', ['record' => $record])),

                EditAction::make('FINANCE MANAGER')
                    ->label('FINANCE MANAGER')
                    ->icon('heroicon-m-plus')
                    ->outlined()
                    ->button()
                    ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->form([
                        Select::make('user_id')
                        ->label('Account')
                        ->options(User::query()->where('role', RoleConstant::FINANCE_MANAGER)
                            ->get()
                            ->map(function ($item) {
                                return [
                                    'id' => $item->id,
                                    'name' => $item->getFullName()
                                ];
                            })
                            ->pluck('name', 'id'))
                        ->required(),


                    ]),
                    Action::make('edit')
                    ->extraAttributes(AppConstant::ACTION_STYLE)
                    ->icon('heroicon-m-pencil')
                    ->label('EDIT')
                    ->outlined()
                    ->button()
                    ->color('primary')

                    ->url(fn (Model $record): string => route('project.edit', ['record' => $record])),

                // Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('DELETE')
                ->outlined()
                ->button()
                ->extraAttributes(AppConstant::ACTION_STYLE)
                ,

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
