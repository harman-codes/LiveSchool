@php use Illuminate\Support\Carbon; @endphp
<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            {{--        <h6 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Select Class</h6>--}}
            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                <form class="max-w-sm mx-auto">
                    <label for="classes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Class</label>
                    <select wire:model.live="selectedClass" id="classes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" selected>All Classes</option>
                        @foreach($this->getAllClasses() as $class)
                            <option wire:key="{{ $class->classwithsection }}" value="{{ $class->classwithsection }}">{{ $class->classwithsection }} </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        {{--Select Class Test--}}
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            {{--        <h6 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Select Class</h6>--}}
            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                <form class="max-w-sm mx-auto">
                    <label for="classtest" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Test</label>
                    <select wire:model.live="selectedClassTest" id="classtest" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" selected>Select</option>
                        @if(!empty($this->getClassTests()))
                            @foreach($this->getClassTests() as $classTest)
                                <option wire:key="{{ $classTest->id }}" value="{{ $classTest->id }}">{{ $classTest->testname }} ({{Carbon::parse($classTest->date)->format('d-m-Y')}})</option>
                            @endforeach
                        @endif
                    </select>
                </form>
            </div>
        </div>
    </div>
    {{ $this->table }}
</x-filament-panels::page>
