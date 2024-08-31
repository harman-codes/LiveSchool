<div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-1 m-2 md:m-1">
        <button wire:click="markAttendance('P')" type="button" class="@if($attendanceOption=='P') bg-green-700 text-white dark:bg-green-600 dark:text-white @else text-green-700 dark:text-green-500 @endif border border-green-700 px-5 py-2.5 text-center text-sm font-medium hover:bg-green-800 hover:text-white focus:outline-none focus:ring-green-300 dark:border-green-500 dark:hover:bg-green-700 dark:hover:text-white dark:focus:ring-green-800">P</button>

        <button wire:click="markAttendance('A')" type="button" class="@if($attendanceOption=='A') bg-red-700 text-white dark:bg-red-600 dark:text-white @else text-red-700 dark:text-red-500 @endif border border-red-700 px-5 py-2.5 text-center text-sm font-medium hover:bg-red-800 hover:text-white focus:outline-none focus:ring-red-300 dark:border-red-500 dark:hover:bg-red-700 dark:hover:text-white dark:focus:ring-red-900">A</button>

        <button wire:click="markAttendance('L')" type="button" class="@if($attendanceOption=='L') bg-orange-400 text-white dark:bg-orange-600 dark:text-white @else text-orange-400 dark:text-orange-300 @endif border border-orange-400 px-5 py-2.5 text-center text-sm font-medium hover:bg-orange-500 hover:text-white focus:outline-none focus:ring-orange-300 dark:border-orange-600 dark:hover:bg-orange-700 dark:hover:text-white dark:focus:ring-orange-900">L</button>

        <button wire:click="markAttendance('H')" type="button" class="@if($attendanceOption=='H') bg-blue-700 text-white dark:bg-blue-600 dark:text-white @else text-blue-700 dark:text-blue-400 @endif border border-blue-700 px-5 py-2.5 text-center text-sm font-medium hover:bg-blue-800 hover:text-white focus:outline-none focus:ring-blue-300 dark:border-blue-400 dark:hover:bg-blue-700 dark:hover:text-white dark:focus:ring-blue-900">H</button>
    </div>
{{--    <div>{{$attendanceOption}}</div>--}}
</div>
