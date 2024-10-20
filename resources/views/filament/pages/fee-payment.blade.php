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

        {{--Select Fee Structure--}}
        <div class="ls-card">
            <div class="ls-card-body">
                <form class="max-w-sm mx-auto">
                    <label for="classtest" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Fee Period</label>
                    <select wire:model.change="selectedFeeStructure" id="classtest" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" selected>Select</option>
                        @if(!empty($this->getFeeStructure()))
                            @foreach($this->getFeeStructure() as $row)
                                <option wire:key="{{ $row->id }}" value="{{ $row->id }}">{{$row->from}} to {{$row->to}}</option>
                            @endforeach
                        @endif
                    </select>
                </form>
            </div>
        </div>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
