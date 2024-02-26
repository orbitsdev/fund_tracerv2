<?php

namespace App\Livewire\FinancialManagerProjects;

use Filament\Tables;
use App\Models\Project;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListFinancialManager extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Project::query())
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('implementing_agency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monitoring_agency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_leader')
                    ->searchable(),
                Tables\Columns\TextColumn::make('allocated_fund')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_usage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('assigned_project', function($query){
                $query->where('assigned_projectable_id', Auth::user()->id);
            }))
            ;
    }

    public function render(): View
    {

        $projects = Project::whereHas('assigned_project', function($query) {
            return $query->where('assigned_projectable_id', Auth::user()->id);

        });
        return view('livewire.financial-manager-projects.list-financial-manager', compact('projects'));
    }
}
