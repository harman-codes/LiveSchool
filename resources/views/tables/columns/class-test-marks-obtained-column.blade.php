<div>
{{--    {{ $getState() }}--}}
{{--    <input type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white/5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
    <livewire:tablecolumns.class-test-marks-obtained :record="$getRecord()" :key="$getRecord()->pluck('id')->join(uniqid())" :classtestid="$this->selectedClassTest" />
</div>
