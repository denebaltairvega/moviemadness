<div class="md:px-16 px-4">
    <h1 class="text-center text-4xl my-16">DISCOVER MOVIES</h1>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-2 md:px-20 mt-8">
        @foreach ($genres as $genre)
            <button @class([
                'text-center flex gap-2 items-center justify-center hover:bg-gray-400 hover:text-slate-700 w-full border-2 border-white duration-500 p-2 md:p-1',
                'bg-green-600 text-white' => in_array($genre['id'], $include_genres),
            ]) wire:click="toggleGenre('{{ $genre['id'] }}')">
                <i class="ri-loader-4-line animate-spin" wire:loading.delay
                    wire:target="toggleGenre('{{ $genre['id'] }}')"></i><span>{{ $genre['name'] }}</span>
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
                    <input class="w-full" type="range" wire:model.blur="min_rating" step="0.1" min="0"
                        max="10">
                </div>
            </div>
            <div class="mt-16">
                <div>
                    <div class="min-h-[10rem] text-center" wire:init="discover">
                        <div wire:loading.delay.remove wire:target="discover,toggleGenre,render">
                            @if ($movies)
                                <div class="posters-container">
                                    @foreach ($movies as $movie)
                                        <livewire:poster :item="$movie" :on_watchlist="collect($watchlisted)->contains($movie['id'])" />
                                    @endforeach
                                </div>
                                <div @class([
                                    'flex mt-16',
                                    'justify-between' => $current_page > 1,
                                    'justify-end' => $current_page <= 1,
                                ])>
                                    @if ($current_page > 1)
                                        <button
                                            class="text-center py-2 hover:bg-gray-400 hover:text-slate-700 px-12 text-lg border-2 border-white duration-500 flex-shrink-0"
                                            wire:click="previousPage">Previous</button>
                                    @endif
                                    @if ($current_page < $total_pages)
                                        <button
                                            class="text-center py-2 hover:bg-gray-400 hover:text-slate-700 px-12 text-lg border-2 border-white duration-500 flex-shrink-0"
                                            wire:click="nextPage">Next</button>
                                    @endif
                                </div>
                            @else
                                <p class="text-center p-16">No results found.</p>
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
</div>
