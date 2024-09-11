@php use App\Helpers\Config; @endphp
<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-4">
        <button wire:click="toggleswitch" type="button" class="focus:outline-none text-white @if($switch) bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 @else bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 @endif focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
            @if($switch)
                ON
            @else
                OFF
            @endif
        </button>
    </div>

    <div class="@if($switch) bg-green-700 @else bg-red-700 @endif max-w-sm p-6 text-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-white dark:text-white">
                @if($switch)
                    Location: ON
                @else
                    Location: OFF
                @endif
            </h5>
        </div>
        <p class="mb-3 font-normal text-white dark:text-gray-400">
            Updated : {{$datetime}}
        </p>
    </div>

    @if(!empty(Config::mapkey()))
        <div class="grid grid-cols-1 p-4 rounded-lg bg-white">
            <iframe
                width="100%"
                height="450"
                style="border:0"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed/v1/place?key={{Config::mapkey()}}&q={{$location}}&zoom=20">
            </iframe>
        </div>
    @endif


    @script
    <script>
        document.addEventListener('livewire:navigated', () => {
            var getLocation = () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        let coordinates = position.coords.latitude + "," + position.coords.longitude;
                        $wire.setLocation(coordinates);
                        // $wire.setLocation('31.656532281167056,74.87221407827893');
                        // console.log(coordinates);
                    });
                }
            }
            setInterval(() => {
                if ($wire.switch) {
                    console.log('refreshing');
                    getLocation();
                }
            }, 5000);
        });
    </script>
    @endscript
</x-filament-panels::page>
