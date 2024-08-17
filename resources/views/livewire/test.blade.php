@php use App\Helpers\SessionYears; @endphp
<div>
    {{--    [
    {"id":1,"student_id":1,"sessionyear":"2024-25","schoolclass_id":1,"rollno":123,"created_at":"2024-08-16T13:52:43.000000Z","updated_at":"2024-08-16T13:52:43.000000Z","schoolclass":{"id":1,"name":"1st","section":"A","classwithsection":"1st (A)","sort":null,"created_at":null,"updated_at":null}},--}}

    {{--    {"id":3,"student_id":1,"sessionyear":"2025-26","schoolclass_id":3,"rollno":55,"created_at":null,"updated_at":null,"schoolclass":{"id":3,"name":"1st","section":"C","classwithsection":"1st (C)","sort":null,"created_at":null,"updated_at":null}}
    ]--}}


    {{--    {{ $getRecord()->studentdetails }}--}}
    <div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
        <!--[if BLOCK]><![endif]-->        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

        <div class="flex ">
            <div class="flex max-w-max" style="">
                <div class="fi-ta-text-item inline-flex items-center gap-1.5  ">
                    <span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white  " style="">
                        @foreach($getRecord()->studentdetails as $value)
                            @if($value->sessionyear == SessionYears::currentSessionYear())
                                {{ $value->rollno }}
                            @endif
                        @endforeach
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
