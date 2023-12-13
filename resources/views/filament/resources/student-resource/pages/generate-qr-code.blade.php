<x-filament-panels::page>
    {!! QrCode::size(100)->generate($this->getRecord()->email) !!}
</x-filament-panels::page>
