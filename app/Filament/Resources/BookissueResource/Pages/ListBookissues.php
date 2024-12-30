<?php

namespace App\Filament\Resources\BookissueResource\Pages;

use App\Filament\Resources\BookissueResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\View\Components\Modal;

class ListBookissues extends ListRecords
{
    protected static string $resource = BookissueResource::class;

    protected static ?string $title = 'Issue Books';

    public function boot()
    {
        Modal::closedByClickingAway(false);
        Section::configureUsing((function (Section $section) {
            $section
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ]);
        }));
    }

    public function getModelLabel(): ?string
    {
        return 'Record';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Issue Book'),
        ];
    }
}
