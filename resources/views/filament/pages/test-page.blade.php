<x-filament-panels::page>
    @foreach($this->getsubjects() as $subject)
        {{$subject->id}}
        <br>
        {{$subject->name}}
        <hr>
    @endforeach
</x-filament-panels::page>
