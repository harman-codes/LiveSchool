<x-filament-panels::page>
    <x-filament::tabs x-data="{ activeTab: 'tab1' }">
        <x-filament::tabs.item
            alpine-active="activeTab === 'tab1'"
            x-on:click="activeTab = 'tab1'; $wire.call('setIdToMyID')"
        >
            My Availability
        </x-filament::tabs.item>

        <x-filament::tabs.item
            alpine-active="activeTab === 'tab2'"
            x-on:click="activeTab = 'tab2'; $wire.call('setIdToNull')"
        >
            All
        </x-filament::tabs.item>
    </x-filament::tabs>

    {{$this->table}}
</x-filament-panels::page>
