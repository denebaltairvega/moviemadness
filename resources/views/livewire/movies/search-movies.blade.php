<div class="md:px-16 px-4">
    <h1 class="text-center text-4xl my-16">SEARCH MOVIES</h1>
    <div class="md:px-20">
        <div class="mt-16">
            <div>
                <form class="flex gap-2" wire:submit="searchMovies">
                    <div class="relative flex-1">
                        <i class="ri-search-line text-black text-3xl top-1/2 -translate-y-1/2 left-3 absolute"></i>
                        <input class="w-full text-2xl text-black pl-16" type="text" placeholder="Enter keywords..." wire:model="search" required>
                    </div>
                    <button class="text-center py-2 hover:bg-gray-400 hover:text-slate-700 px-12 text-lg border-2 border-white duration-500 flex-shrink-0" type="submit">
                        SEARCH
                        <i class="ri-loader-4-line animate-spin" wire:loading.delay
                        wire:target="searchMovies"></i>
                    </button>
                </form>
                <div class="min-h-[10rem] text-center">
                    @if ($search)
                        <div wire:loading.delay.remove wire:target="render,search">
                            @if ($movies)
                                <div class="posters-container">
                                    @foreach ($movies as $movie)
                                        <livewire:poster wire:key="movie-{{ $movie['id'] }}" :item="$movie" :on_watchlist="collect($watchlisted)->contains($movie['id'])" />
                                    @endforeach
                                </div>
                                <div @class([
                                    'flex mt-16',
                                    'justify-between' => $current_page > 1,
                                    'justify-end' => $current_page <= 1,
                                ])>
                                    @if ($current_page > 1)
                                        <button class="text-center py-2 hover:bg-gray-400 hover:text-slate-700 px-12 text-lg border-2 border-white duration-500 flex-shrink-0" wire:click="previousPage">Previous</button>
                                    @endif
                                    @if ($current_page < $total_pages)
                                        <button class="text-center py-2 hover:bg-gray-400 hover:text-slate-700 px-12 text-lg border-2 border-white duration-500 flex-shrink-0" wire:click="nextPage">Next</button>
                                    @endif
                                </div>
                            @else
                                <p class="text-center p-16">No results found for '{{ $search }}'.</p>
                            @endif
                        </div>
                        <div wire:loading.delay class="mt-16" wire:target="render,search">
                            <i class="ri-loader-4-line animate-spin inline-flex text-9xl"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
