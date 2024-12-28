<x-filament-panels::page>
    <div class="ls-cards-holder">
        <div class="ls-card">
            <div class="ls-card-body">
                <form class="max-w-sm mx-auto">
                    <label for="classes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Exam</label>
                    <select wire:model.change="selectedExam" id="classes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" selected>Select</option>
                        @if($this->getAllExams())
                            @foreach($this->getAllExams() as $examData)
                                <option wire:key="{{ $examData->id }}" value="{{ $examData->id }}">{{ $examData->examname }} </option>
                            @endforeach
                        @endif
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
        <table class="fi-ta-table w-full text-sm text-left rtl:text-right text-gray-800 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Exam
                </th>
                <th scope="col" class="px-6 py-3">
                    Max Marks
                </th>
                <th scope="col" class="px-6 py-3">
                    Marks Obtd
                </th>
                <th scope="col" class="px-6 py-3">
                    %
                </th>
            </tr>
            </thead>
            <tbody>
                @if(!empty($this->getSubjectsAndMarksFromSelectedExam()))
                    @foreach($this->getSubjectsAndMarksFromSelectedExam()->maxmarks as $subject=>$marks)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap dark:text-white">
                                {{ $subject }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $marks }}
                            </td>
                            <td class="px-6 py-4">
                                @if(!empty($this->getMarksObtained()))
                                    @if(array_key_exists($subject, (array)$this->getMarksObtained()?->marksobtained))
                                        {{$this->getMarksObtained()?->marksobtained[$subject]}}
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if(!empty($this->getMarksObtained()))
                                    @if(array_key_exists($subject, (array)$this->getMarksObtained()?->marksobtained))
                                        {{round((int)$this->getMarksObtained()?->marksobtained[$subject]/(int)$marks*100,2)}}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap dark:text-white">
                            Total
                        </td>
                        <td class="px-6 py-4">
                            {{$this->getSubjectsAndMarksFromSelectedExam()->totalmarks}}
                        </td>
                        <td class="px-6 py-4">
                            @if(!empty($this->getMarksObtained()))
                                {{$this->getMarksObtained()?->totalmarksobtained}}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(!empty($this->getMarksObtained()))
                                {{round((int)$this->getMarksObtained()?->totalmarksobtained/(int)$this->getSubjectsAndMarksFromSelectedExam()?->totalmarks*100,2)}}
                            @endif
                        </td>
                    </tr>
                @else
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap dark:text-white">
                            N/A
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap dark:text-white">
                            N/A
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap dark:text-white">
                            N/A
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap dark:text-white">
                            N/A
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

{{--    <div>--}}
{{--        @if(!empty($this->getMarksObtained()))--}}
{{--            @if(array_key_exists('dfdf', (array)$this->getMarksObtained()?->marksobtained))--}}
{{--            {{$this->getMarksObtained()?->marksobtained['dfdf']}}--}}
{{--            @endif--}}
{{--            {{$this->getMarksObtained()?->totalmarksobtained}}--}}
{{--        @endif--}}
{{--    </div>--}}
</x-filament-panels::page>
