<?php

namespace App\Filament\Widgets;

use App\Models\CalendarEvent;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarViewOnlyWidget extends FullCalendarWidget
{

    public Model | string | null $model = CalendarEvent::class;
    protected int | string | array $columnSpan = 1;

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

    public function getFormSchema(): array
    {
        return [];
    }

    protected function headerActions(): array
    {
        return [];
    }

    protected function modalActions(): array
    {
        return [];
    }

    protected function viewAction(): Actions\ViewAction
    {
        return Actions\ViewAction::make()
            ->disabled();
    }

//    public function eventDidMount(): string
//    {
//        return <<<JS
//        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
//            el.setAttribute("x-tooltip", "tooltip");
//            el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
//        }
//    JS;
//    }

    public function fetchEvents(array $fetchInfo): array
    {
        return CalendarEvent::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (CalendarEvent $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->title)
                    ->start($event->starts_at)
                    ->end($event->ends_at)
            )
            ->toArray();
    }



}
