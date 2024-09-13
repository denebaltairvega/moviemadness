@props([
'items' => [],
'watchlisted' => [],
])

<div x-cloak class="w-full relative" x-data="{ showTrailer: false, player: null }">
    <div class="fixed grid place-items-center inset-0 bg-gray-900 bg-opacity-70 z-30" x-cloak x-transition.opacity
        x-show="showTrailer" x-init="player = YouTubePlayer('trailer', {
            playerVars: {
                modestbranding: true,
            }
        });">
        <div @click.away="player?.stopVideo().then(() => showTrailer = false)" class="md:w-2/3 w-full px-4">
            <div class="w-full md:h-[70vh]" id="trailer">
            </div>
        </div>
    </div>
    <x-splide id="discover" type="loop" perPage="1" arrows="false" autoplay="true" interval="5000">
        @foreach ($items as $item)
        <li wire:key=" {{ $item['id'] }}" class="splide__slide cursor-grab">
            <livewire:hero-entry :on_watchlist="collect($watchlisted)->contains($item['id'])" :item="$item" />
        </li>
        @endforeach
    </x-splide>
</div>