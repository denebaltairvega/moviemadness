<div class="md:px-16 px-4">
    <h1 class="text-center text-4xl my-16">{{ str($type)->replace('_', ' ')->upper() }} MOVIES</h1>
    <div class="md:px-20">
        <div class="mt-16">
            <div>
                <div class="min-h-[10rem] text-center" wire:init="load">
                    <div wire:loading.delay.remove>
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
                        @endif
                    </div>
                    <div wire:loading.delay>
                        <i class="ri-loader-4-line animate-spin inline-flex text-9xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
