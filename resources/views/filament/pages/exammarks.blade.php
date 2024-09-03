@php use Carbon\Carbon; @endphp
<x-filament-panels::page>
    <div class="ls-cards-holder">
        <div class="ls-card">
            <div class="ls-card-body">
                <form class="max-w-sm mx-auto">
                    <label for="classes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Class</label>
                    <select wire:model.change="selectedClass" id="classes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" selected>All Classes</option>
                        @foreach($this->getAllClasses() as $class)
                            <option wire:key="{{ $class->id }}" value="{{ $class->id }}">{{ $class->classwithsection }} </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        {{--Select Exam--}}
        <div class="ls-card">
            <div class="ls-card-body">
                <form class="max-w-sm mx-auto">
                    <label for="classtest" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Exam</label>
                    <select wire:model.change="selectedExam" id="classtest" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" selected>Select</option>
                        @if(!empty($this->getExams()))
                            @foreach($this->getExams() as $exam)
                                <option wire:key="{{ $exam->id }}" value="{{ $exam->id }}">{{ $exam->examname }} ({{Carbon::parse($exam->fromdate)->format('d-m-Y')}} | {{Carbon::parse($exam->todate)->format('d-m-Y')}})</option>
                            @endforeach
                        @endif
                    </select>
                </form>
            </div>
        </div>
    </div>
{{$this->table}}
</x-filament-panels::page>
