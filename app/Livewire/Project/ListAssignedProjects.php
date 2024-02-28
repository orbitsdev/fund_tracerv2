<?php

namespace App\Livewire\Project;

use Filament\Tables;
use App\Models\Project;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListAssignedProjects extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Project::query())
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('project_type')->searchable(),
                TextColumn::make('implementing_agency')->searchable(),
                TextColumn::make('monitoring_agency')->searchable(),
                TextColumn::make('project_leader')->searchable(),
                TextColumn::make('allocated_fund')->searchable(),
                TextColumn::make('start_date')->date(),
                TextColumn::make('end_date')->date(),

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
                $query->where('assigned_projectable_id', Auth::user()->id)->where('assigned_projectable_type', get_class(Auth::user()));
            })->latest())
            ;
    }

    public function render(): View
    {
        return view('livewire.project.list-assigned-projects');
    }
}
