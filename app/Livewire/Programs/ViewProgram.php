<?php

namespace App\Livewire\Programs;

use App\Models\Program;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class ViewProgram extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    public Program $record;


    public function programInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([

                Fieldset::make('Program Details')


                    ->schema([

                        TextEntry::make('title')
                            ->label('Program Title')



                            ->columnSpanFull(),
                        TextEntry::make('program_leader')


                            ->label('Program Leader')


                            ->columnSpanFull(),
                        TextEntry::make('start_date')
                            ->label('Program Start')
                            ->date(),


                        TextEntry::make('end_date')
                            ->label('Program End')
                            ->date(),
                        TextEntry::make('total_budget')
                            ->money('PHP')
                            ->label('Program Budget')
                            ->size(TextEntry\TextEntrySize::Large),

                        TextEntry::make('total_usage')
                            ->money('PHP')
                            ->label('Program Budget')
                            ->size(TextEntry\TextEntrySize::Large),
                    ]),


                Fieldset::make('Duration')
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 9,
                    ])
                    ->schema([
                        ViewEntry::make('Total Duration')
                        ->view('infolists.components.project-duration')
                        ->columnSpanFull(),
                    ]),


                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Summary Budget')
                            ->schema([
                                // ViewEntry::make('')
                                //     ->view('infolists.components.program-summary-budget')
                                //     ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('PCAARRD IC')
                            ->schema([

                                // ViewEntry::make('')
                                //     ->view('infolists.components.summary-pcaardic')
                                //     ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Files')
                            ->schema([
                                // ViewEntry::make('')
                                // ->view('infolists.components.files')
                                // ->columnSpanFull(),
                            ]),


                    ])
                    ->activeTab(2)
                    ->columnSpanFull(),

            ]);
    }
    public function render()
    {
        return view('livewire.programs.view-program');
    }
}
