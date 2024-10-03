<x-filament-panels::page>
    @livewire(\App\Filament\Parent\Widgets\ClassTestMarksChart::class)
    {{ $this->table }}
    @livewire(\App\Filament\Parent\Widgets\PerformanceIndicatorWidget::class)
</x-filament-panels::page>
