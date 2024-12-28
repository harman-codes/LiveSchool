@php use App\Helpers\SessionYears; @endphp
<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
        <x-filament::section>
            <x-slot name="heading">
                Session Year
            </x-slot>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="selectedSessionYear">
                    <option value="0">Select</option>
                    @foreach(SessionYears::years() as $key => $value)
                        <option wire:key="$key" value="{{ $key }}" @if($key == $this->currentSessionYear) class="font-bold" @endif>{{ $value }}</option>
                        @if($key == $this->currentSessionYear)
                            @break
                        @endif
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </x-filament::section>
    </div>

{{$this->table}}
</x-filament-panels::page>
