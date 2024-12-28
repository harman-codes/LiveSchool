<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Widgets\CalendarWidget;
use App\Helpers\Role;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        $tabsArray = [
            'all' => Tab::make('All'),
            'admin' => Tab::make('Admin')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_admin', true)),
        ];
        foreach (Role::$rolesKeyValuePair as $key => $value) {
            $tabsArray += [
                $key => Tab::make($value)
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('role', $key))
            ];
        }
        return $tabsArray;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
