@props([
'item',
'on_watchlist' => false
])
<button @class([ 'inline-flex items-center border px-2 py-1 gap-1 duration-200 rounded-lg'
    , 'bg-red-600 hover:bg-red-700'=> $on_watchlist,
    'bg-green-600 hover:bg-green-700' => !$on_watchlist,
    ])
    wire:click="toggleWatchlist({{ $item['id'] }})">
    <i class="ri-loader-4-line animate-spin" wire:loading.delay wire:target="toggleWatchlist({{ $item['id'] }})"></i>
    <i class="ri-bookmark-line" wire:loading.delay.remove wire:target="toggleWatchlist({{ $item['id'] }})"></i>
    @if($on_watchlist)
        <p class="text-xs md:text-sm">Remove from Watchlist</p>
    @else
        <p class="text-xs md:text-sm">Add to Watchlist</p>
    @endif
</button>