@php use App\Helpers\DT; @endphp
<x-filament-panels::page>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
        {{--Left Side--}}
        <div class="bg-white dark:bg-gray-900 px-6 py-10 rounded-xl h-full flex flex-col justify-center gap-4 shadow-sm">
            <div>
                <form class="max-w-sm mx-auto">
                    <label for="classes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Year</label>
                    <select wire:model.change="selectedYear" id="classes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @for($i=2023; $i<=2050; $i++)
                            <option wire:key="{{ $i }}" value="{{ $i }}">{{ $i }} </option>
                        @endfor
                    </select>
                </form>
            </div>
            <div>
                <form class="max-w-sm mx-auto">
                    <label for="classes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Month</label>
                    <select wire:model.change="selectedMonth" id="classes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach(DT::$months as $month)
                            <option wire:key="{{ $month }}" value="{{ $month }}">{{ ucwords($month) }} </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div>
            @livewire(\App\Filament\Parent\Widgets\SingleStudentAttendanceChart::class)
        </div>
    </div>





    {{-------------------------------------------------------}}
{{--    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">--}}
{{--        <div class="ls-card">--}}
{{--            <div class="ls-card-body">--}}
{{--                <form class="max-w-sm mx-auto">--}}
{{--                    <label for="classes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Year</label>--}}
{{--                    <select wire:model.change="selectedYear" id="classes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                        @for($i=2023; $i<=2050; $i++)--}}
{{--                            <option wire:key="{{ $i }}" value="{{ $i }}">{{ $i }} </option>--}}
{{--                        @endfor--}}
{{--                    </select>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="ls-card">--}}
{{--            <div class="ls-card-body">--}}
{{--                <form class="max-w-sm mx-auto">--}}
{{--                    <label for="classes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Month</label>--}}
{{--                    <select wire:model.change="selectedMonth" id="classes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                        @foreach(DT::$months as $month)--}}
{{--                            <option wire:key="{{ $month }}" value="{{ $month }}">{{ ucwords($month) }} </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="grid grid-cols-1 md:grid-cols-2">--}}
{{--    @livewire(\App\Filament\Parent\Widgets\SingleStudentAttendanceChart::class)--}}
{{--    </div>--}}
    {{-------------------------------------------------------}}

    <div>
    @livewire(\App\Filament\Parent\Widgets\AttendanceCalendarForParentsWidget::class)
    </div>
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
