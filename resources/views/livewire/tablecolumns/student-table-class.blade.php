@php use App\Helpers\SessionYears; @endphp
<div>
    <div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
        <div class="flex ">
            <div class="flex max-w-max" style="">
                <div class="fi-ta-text-item inline-flex items-center gap-1.5  ">
                    <span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white  " style="">
                        @foreach($getRecord()->studentdetails as $value)
                            @if($value->sessionyear == SessionYears::currentSessionYear())
                                {{ $value->schoolclass->classwithsection }}
                            @endif
                        @endforeach
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
