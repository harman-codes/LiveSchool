<x-filament-panels::page>
        @livewire(\App\Filament\Parent\Widgets\AttendanceCalendarForParentsWidget::class)
    <div class="grid grid-cols-4">
        <div class="flex flex-row items-center gap-2">
            <div class="h-3 w-3 bg-green-700 rounded-lg"></div> <div>Present</div>
        </div>
        <div class="flex flex-row items-center gap-2">
            <div class="h-3 w-3 bg-red-700 rounded-lg"></div> <div>Absent</div>
        </div>
        <div class="flex flex-row items-center gap-2">
            <div class="h-3 w-3 bg-amber-300 rounded-lg"></div> <div>Leave</div>
        </div>
        <div class="flex flex-row items-center gap-2">
            <div class="h-3 w-3 bg-blue-700 rounded-lg"></div> <div>Half Day</div>
        </div>
    </div>
</x-filament-panels::page>
