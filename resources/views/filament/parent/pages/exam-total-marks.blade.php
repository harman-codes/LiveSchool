<x-filament-panels::page>
    @livewire(\App\Filament\Parent\Widgets\ExamTotalMarksChart::class)
    {{ $this->table }}
    @livewire(\App\Filament\Parent\Widgets\PerformanceIndicatorWidget::class)
</x-filament-panels::page>
