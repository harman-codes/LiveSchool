<?php

namespace App\Filament\Pages;

use App\Helpers\Role;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Availability extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    protected static string $view = 'filament.pages.availability';

    protected static ?string $navigationGroup = 'Users';

    protected static ?int $navigationSort = 2;

    public $selectedId = null;

    public function setIdToMyID()
    {
        $this->selectedId = auth()->user()->id;
    }

    public function setIdToNull()
    {
        $this->selectedId = null;
    }

    public function mount()
    {
        $this->selectedId = auth()->user()->id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                if (!empty($this->selectedId)) {
                    return User::query()->where('id', $this->selectedId);
                } else {
                    return User::query();
                }
            })
            ->columns([
                TextColumn::make('name')
                ->sortable(),
                ToggleColumn::make('is_available')
                    ->label('Availability')
                    ->onColor('success')
                    ->offColor('danger')
                    ->disabled(fn($record): bool => $record->id !== auth()->user()->id)
                    ->alignCenter(),
                IconColumn::make('is_available_icon')
                    ->boolean()
                    ->label('Availability Status')
                    ->alignCenter(),
            ]);
    }


}
