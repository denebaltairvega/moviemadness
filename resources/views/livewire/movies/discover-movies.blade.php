<div class="px-4 md:px-16">
    <h1 class="my-16 text-center text-4xl">DISCOVER MOVIES</h1>
    <div class="mt-8 grid grid-cols-2 gap-2 md:grid-cols-6 md:px-20">
        @foreach ($genres as $genre)
            <button wire:key="{{ $genre['id'] }}" @class([
                'text-center flex gap-2 items-center justify-center hover:bg-gray-400 hover:text-slate-700 w-full border-2 border-white duration-500 p-2 md:p-1',
                'bg-green-600 text-white' => in_array($genre['id'], $include_genres),
            ]) wire:click="toggleGenre('{{ $genre['id'] }}')">
                <i class="ri-loader-4-line animate-spin" wire:loading.delay wire:target="toggleGenre('{{ $genre['id'] }}')"></i><span>{{ $genre['name'] }}</span>
            </button>
        @endforeach
    </div>
    <div class="md:px-20">
        <div class="mt-8">
            <div>
                <div>
                    <div class="flex gap-4">
                        <p>Minimum Rating: </p>
                        <span>{{ $min_rating }}</span>
                    </div>
                    <input class="w-full"
                           type="range"
                           wire:model.live="min_rating"
                           step="0.1"
                           min="0"
                           max="10">
                </div>
            </div>
            <div class="mt-16">
                <div>
                    <div class="min-h-[10rem] text-center" wire:init="discover">
                        <div wire:loading.delay.remove wire:target="discover,toggleGenre,min_rating,nextPage,previousPage">
                            @if ($movies)
                                <div class="posters-container">
                                    @foreach ($movies as $movie)
                                        <livewire:poster :key="$movie['id']" :item="$movie" :on_watchlist="collect($watchlisted)->contains($movie['id'])" />
                                    @endforeach
                                </div>
                                <div @class([
                                    'flex mt-16',
                                    'justify-between' => $current_page > 1,
                                    'justify-end' => $current_page <= 1,
                                ])>
                                    @if ($current_page > 1)
                                        <button class="flex-shrink-0 border-2 border-white px-12 py-2 text-center text-lg duration-500 hover:bg-gray-400 hover:text-slate-700" wire:click="previousPage">Previous</button>
                                    @endif
                                    @if ($current_page < $total_pages)
                                        <button class="flex-shrink-0 border-2 border-white px-12 py-2 text-center text-lg duration-500 hover:bg-gray-400 hover:text-slate-700" wire:click="nextPage">Next</button>
                                    @endif
                                </div>
                            @else
                                <p class="p-16 text-center">No results found.</p>
                            @endif
                        </div>
                        <div wire:loading.delay>
                            <i class="ri-loader-4-line inline-flex animate-spin text-9xl"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
