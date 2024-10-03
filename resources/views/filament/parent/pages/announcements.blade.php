<x-filament-panels::page>
    @assets
    <link rel="stylesheet" href="{{asset('/swiper/swiper-bundle.min.css')}}" />
    <script src="{{asset('/swiper/swiper-bundle.min.js')}}"></script>
    @endassets
    <style>
        /*.swiper {*/
        /*    width: 100%;*/
        /*    height: 100%;*/
        /*}*/

        /*.swiper-wrapper{*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*}*/

        /*.swiper-slide {*/
        /*    text-align: center;*/
        /*    font-size: 18px;*/
        /*    background: #fff;*/
        /*    display: flex;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*}*/
        /*.swiper-slide img {*/
        /*    display: block;*/
        /*    width: 100%;*/
        /*    height: 100%;*/
        /*    object-fit: contain;*/
        /*}*/
    </style>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
   @if(!empty($this->getAllAnnouncements()))
       @foreach($this->getAllAnnouncements() as $announcement)
           @if($announcement->is_published)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 self-baseline">
                    <div class="p-5">
{{--                        <a href="#">--}}
                            <div class="mb-2 text-lg font-bold tracking-tight text-gray-700 dark:text-white truncate">{{$announcement->title}}</div>
{{--                        </a>--}}

                        <div class="mb-3 font-normal text-gray-700 dark:text-gray-400 line-clamp-5 text-justify">{!! $announcement->description !!}</div>
                    </div>
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach($announcement->pics as $pic)
                                <div class="swiper-slide rounded-b-lg"><img src="{{asset('/storage/'.$pic)}}" alt=""></div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <div class="m-4 flex justify-center">
                        <x-filament::modal :close-by-clicking-away="false">
                            <x-slot name="trigger">
                                    <span class="text-blue-600 hover:text-blue-900 dark:text-gray-400 dark:hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    </span>
                            </x-slot>

                            <x-slot name="heading">
                                <div class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{$announcement->title}}</div>
                            </x-slot>

                            <x-slot name="description">
                                <div class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-justify">{!! $announcement->description !!}</div>
                            </x-slot>
                        </x-filament::modal>
                    </div>
                </div>
           @endif
       @endforeach
   @endif
    </div>


{{--       <x-filament::modal :close-by-clicking-away="false">--}}
{{--           <x-slot name="trigger">--}}
{{--               <x-filament::link>--}}
{{--                   Open modal--}}
{{--               </x-filament::link>--}}
{{--           </x-slot>--}}

{{--           <x-slot name="heading">--}}
{{--               Modal heading--}}
{{--           </x-slot>--}}

{{--           <x-slot name="description">--}}
{{--               Modal description--}}
{{--           </x-slot>--}}
{{--           <x-slot name="footer">--}}
{{--                Modal footer content --}}
{{--           </x-slot>--}}
{{--       </x-filament::modal>--}}





{{--    <div class="swiper mySwiper">--}}
{{--        <div class="swiper-wrapper">--}}
{{--            <div class="swiper-slide"><img src="https://picsum.photos/500/300?random=1" alt=""></div>--}}
{{--            <div class="swiper-slide"><img src="https://picsum.photos/500/300?random=2" alt=""></div>--}}
{{--            <div class="swiper-slide"><img src="https://picsum.photos/500/300?random=3" alt=""></div>--}}
{{--            <div class="swiper-slide"><img src="https://picsum.photos/500/300?random=4" alt=""></div>--}}
{{--        </div>--}}
{{--        <div class="swiper-button-next"></div>--}}
{{--        <div class="swiper-button-prev"></div>--}}
{{--        <div class="swiper-pagination"></div>--}}
{{--    </div>--}}




    @script
    <script>
        document.addEventListener('livewire:navigated', () => {
            var swiper = new Swiper(".mySwiper", {
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        })
    </script>
    @endscript
</x-filament-panels::page>
