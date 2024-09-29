@php use App\Helpers\Config; @endphp
<x-filament-panels::page>
<div class="ls-cards-holder">
    <div class="ls-card">
        <div class="ls-card-body">
            <form class="max-w-sm mx-auto">
                <label for="vehicle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select</label>
                <select wire:model.change="selectedVan" id="vehicle" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="0" selected>Vehicle No</option>
                    @if(!empty($this->getVanNumbers() ))
                        @foreach($this->getVanNumbers() as $vanNumber)
                            <option wire:key="{{ $vanNumber->id }}" value="{{ $vanNumber->id }}">{{ $vanNumber->van }} </option>
                        @endforeach
                    @endif
                </select>
            </form>
        </div>
    </div>

    <div class="ls-card">
        <div class="ls-card-body">
            <p>Driver : {{$driverName}}</p>
            <p>Vehicle No : {{$vehicleNumber}}</p>
            <p>Location : @if(!empty($selectedVan)) @if($locationStatus) ON @else OFF @endif @else @endif</p>
            <p>Updated : @if(!empty($selectedVan)) @if(!empty($dateTime)) {{$dateTime}} @else @endif @else @endif</p>
        </div>
    </div>
</div>

    @php
    $location = !empty($location) ? $location : 'india';
    @endphp

    @if(!empty(Config::mapkey()))
            <div class="grid grid-cols-1 p-4 rounded-lg bg-white">
                <iframe
                    width="100%"
                    height="600"
                    style="border:0"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed/v1/place?key={{Config::mapkey()}}&q={{$location}}&zoom=20">
                </iframe>
            </div>
    @else
        <div class="bg-white p-4 flex justify-center items-center rounded-lg shadow-sm dark:bg-gray-800 dark:text-white">
            Please enter Google Map key in .env file to get the location on map.
        </div>
    @endif

    @script
    <script>
        document.addEventListener('livewire:navigated', () => {
           setInterval(function(){
               $wire.$refresh();
           },1000*30);
        });
    </script>
    @endscript




</x-filament-panels::page>
