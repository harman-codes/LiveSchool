@php use App\Helpers\DT; @endphp
<div>
{{--    {{ $getState() }}--}}
    <livewire:tablecolumns.attendance-component :record="$getRecord()" :key="$getRecord()->pluck('id')->join(uniqid())" :selectedDate="DT::formatDate($this->selectedDate)" :selectedClass="$this->selectedClass" />
</div>
