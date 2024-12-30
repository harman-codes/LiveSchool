<x-filament-panels::page>
    @assets
    <link rel="stylesheet" href="{{asset('/swiper/swiper-bundle.min.css')}}"/>
    <script src="{{asset('/swiper/swiper-bundle.min.js')}}"></script>
    @endassets
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if(!empty($this->getAllAnnouncements()))
            @foreach($this->getAllAnnouncements() as $announcement)
                {{--                @if($announcement->is_published)--}}
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="line-clamp-2">
                            {{$announcement->title}}
                        </div>
                    </x-slot>

                    <div class="line-clamp-5">
                        {!! $announcement->description !!}
                    </div>
                    {{--Photographs section--}}
                    <div class="swiper mySwiper mt-6">
                        <div class="swiper-wrapper">
                            @foreach($announcement->pics as $pic)
                                <div class="swiper-slide rounded-b-lg"><img src="{{asset('/storage/'.$pic)}}" alt=""></div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                    {{--modal--}}
                    <div class="mt-6 text-center">
                        <x-filament::modal :close-by-clicking-away="false">
                            <x-slot name="trigger">
                                <x-filament::button>View</x-filament::button>
                            </x-slot>
                            <x-slot name="heading">
                                {{--Empty heading element just to show close button at top--}}
                            </x-slot>

                            {{--modal content (in Section component)--}}
                            <x-filament::section>
                                <x-slot name="heading">
                                    <div class="text-left">
                                        {{$announcement->title}}
                                    </div>
                                </x-slot>
                                <div class="text-left">
                                    {!! $announcement->description !!}
                                </div>
                                {{--Photographs section in modal--}}
                                <div class="swiper mySwiper mt-6">
                                    <div class="swiper-wrapper">
                                        @foreach($announcement->pics as $pic)
                                            <div class="swiper-slide rounded-b-lg"><img
                                                    src="{{asset('/storage/'.$pic)}}" alt=""></div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </x-filament::section>
                        </x-filament::modal>
                    </div>
                </x-filament::section>
                {{--                @endif--}}
            @endforeach
        @endif
    </div>

    @if(!empty($this->getAllAnnouncements()))
        <x-filament::pagination
            :paginator="$this->getAllAnnouncements()"
        />
    @endif

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
