@props(['item', 'watchlisted' => false])

<li class="relative splide__slide" wire:key="{{ $item['id'] }}" x-data="{
    watchlisted: {{ $watchlisted ? 'true' : 'false' }}
}" x-init="tippy($el, {
    content: $refs.content.innerHTML,
    allowHTML: true
})">
    <div class="hidden" x-ref="content">
        <p class="prose text-sm text-white">{{ $item['overview'] }}</p>
    </div>
    <div class="relative inline-flex flex-col mx-auto">
        <div class="absolute top-1 right-2 z-20 text-xl"
            @watchlisted.window=" if({{ $item['id'] }} == $event.detail.movie_id){
                watchlisted = true;
            }">
            <button class="border-2 px-1 z-40 rounded-full hover:bg-red-600 duration-300"
                :class="watchlisted ? 'bg-red-600' : ''"
                @if (!$watchlisted) wire:click="toggleWatchlist({{ $item['id'] }})" @endif>
                <i class="ri-loader-4-line animate-spin" wire:loading.delay
                    wire:target="toggleWatchlist({{ $item['id'] }})"></i>
                <i class="ri-heart-3-line" wire:loading.delay.remove
                    wire:target="toggleWatchlist({{ $item['id'] }})"></i>
            </button>
        </div>
        <a class="flex justify-center" href="{{ route('movies.details', ['movie_id' => $item['id']]) }}">
            <img src="{{ $item['poster_path'] }}" alt="{{ $item['title'] }} Poster">
            <div class="absolute bottom-2 z-20 left-2 right-0">
                <p class="text-left">{{ $item['title'] }}</p>
                <div class="flex items-end gap-1">
                    <i class="ri-star-fill text-yellow-300"></i>
                    <h6 class="text-sm">{{ $item['vote_average'] }}</h6>
                </div>
            </div>
            <div class="bg-gradient-to-t from-black to-transparent absolute inset-0 z-10"></div>
        </a>
    </div>
</li>
