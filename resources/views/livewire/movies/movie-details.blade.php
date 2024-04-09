<div class="md:px-16 px-4 mt-8" x-data>
    <div class="mt-12 flex justify-between items-end">
        <div>
            <div class="flex items-center gap-4">
                <h2 class="text-4xl font-semibold">{{ $movie['title'] }}</h2>
                <p class="border rounded-full px-2">{{ xformatted_runtime($movie['runtime']) }}</p>
            </div>
            <blockquote class="italic prose-p mt-4">"{{ $movie['tagline'] != '' ? $movie['tagline'] : '--------' }}"
            </blockquote>
        </div>
        <div class="text-sm text-right">
            <div class="text-sm mt-2">
                @foreach ($movie['genres'] as $genre)
                    @if ($loop->iteration != 1)
                        <i class="ri-git-commit-fill"></i>
                    @endif
                    <span>{{ $genre['name'] }}</span>
                @endforeach
            </div>
            <p>{{ date_create($movie['release_date'])?->format('F d, Y') }}</p>
        </div>
    </div>
    <div class="mt-4" wire:ignore x-data="{ player: null }">
        @if (count($movie['videos']))
            <div x-init="player = YouTubePlayer('player', {
                playerVars: {
                    modestbranding: true,
                }
            });
            player.loadVideoById('{{ collect(collect($movie['videos'])->first())->first()['key'] }}');">
                <div class="">
                    <div class="w-full h-[70vh]" id="player"></div>
                </div>
            </div>
        @else
            <img class="w-full h-[40rem] select-none object-cover object-center" src="{{ $movie['backdrop_path'] }}"
                alt="{{ $movie['title'] }} Backdrop">
        @endif
        <div class="mt-8">
            <div class="flex items-stretch overflow-x-auto overflow-y-hidden pb-4 gap-4">
                @foreach ($movie['videos'] as $type => $video_collection)
                    @if ($loop->iteration != 1)
                        <div class="w-1 flex-shrink-0 mb-6 bg-white"></div>
                    @endif
                    <div class="flex-shrink-0">
                        <div class="flex gap-4">
                            @foreach ($video_collection as $video)
                                <button class="w-48 aspect-video focus:outline-none"
                                    @click="player?.stopVideo().then(() => player.loadVideoById('{{ $video['key'] }}'))">
                                    <img class="block object-cover object-center w-full hover:scale-105 duration-200"
                                        src="{{ $video['thumbnail'] }}" alt="{{ $video['name'] }} Thumbnail" />
                                </button>
                            @endforeach
                        </div>
                        <h3>{{ str($type)->plural(count($video_collection))->upper() }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="mt-8">
        <div class="flex justify-between items-end">
            <div class="flex gap-4 items-center">
                <h4 class="text-2xl font-semibold">OVERVIEW</h4>
                <div class="flex items-end gap-1">
                    <i class="ri-star-fill text-yellow-300"></i>
                    <h6 class="text-sm">{{ $movie['vote_average'] }}</h6>
                </div>
                <div class="flex items-end gap-1">
                    <i class="ri-user-star-fill text-yellow-300"></i>
                    <h6 class="text-sm">{{ $movie['vote_count'] }}</h6>
                </div>
            </div>
            <button
                class="inline-flex items-center border px-2 py-1 gap-1 hover:bg-white duration-200 hover:text-slate-700 rounded-lg"
                wire:click="toggleWatchlist({{ $movie['id'] }})">
                <i class="ri-loader-4-line animate-spin" wire:loading.delay
                    wire:target="toggleWatchlist({{ $movie['id'] }})"></i>
                <i class="ri-bookmark-line" wire:loading.delay.remove
                    wire:target="toggleWatchlist({{ $movie['id'] }})"></i>
                <p class="text-xs md:text-sm">Add to Watchlist</p>
            </button>
        </div>
        <div class="flex flex-col md:flex-row mt-8 justify-between items-start">
            <div class="md:w-3/4">
                <p class="prose text-white">
                    {{ $movie['overview'] }}
                </p>
                <div class="mt-16">
                    <h4 class="text-xl font-semibold">CAST</h4>
                    <div class="pr-8 mt-2">
                        @if (filled($movie['credits']['cast']))
                            <x-splide id="cast"
                                breakpoints="{
                        480: {
                            perPage: 2,
                            pagination: false,
                        },
                        900: {
                            perPage: 4,
                            pagination: false,
                        },
                    }">
                                @foreach ($movie['credits']['cast'] as $cast)
                                    <li class="relative splide__slide text-sm flex-shrink-0">
                                        <a href="#">
                                            <div class="h-full bg-white flex items-center">
                                                <img src="{{ $cast['profile_path'] }}"
                                                    alt="{{ $cast['name'] }} Profile">
                                            </div>
                                            <div
                                                class="absolute opacity-0 hover:opacity-100 p-2 flex flex-col justify-end z-20 bg-black bg-opacity-70 duration-200 inset-0">
                                                <p class="text-base">{{ $cast['name'] }}</p>
                                                <p>as {{ $cast['character'] }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </x-splide>
                        @else
                            <p>No cast found.</p>
                        @endif
                    </div>
                </div>
                <div class="mt-16">
                    <h4 class="text-xl font-semibold">CREW</h4>
                    <div class="pr-8 mt-2">
                        @if (filled($movie['credits']['crew']))
                            <x-splide id="crew"
                                breakpoints="{
                        480: {
                            perPage: 2,
                            pagination: false,
                        }
                    }">
                                @foreach ($movie['credits']['crew'] as $crew)
                                    <li class="relative text-sm splide__slide">
                                        <a href="#">
                                            <div class="h-full bg-white flex items-center">
                                                <img src="{{ $crew['profile_path'] }}"
                                                    alt="{{ $crew['name'] }} Profile">
                                            </div>
                                            <div
                                                class="absolute opacity-0 hover:opacity-100 p-2 flex flex-col justify-end z-20 bg-black bg-opacity-70 duration-200 inset-0">
                                                <p class="text-base">{{ $crew['name'] }}</p>
                                                <p>{{ $crew['job'] }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </x-splide>
                        @else
                            <p>No crew found.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="md:w-1/4 mt-16 md:mt-0 gap-2 flex flex-col border-2 p-8">
                <div class="flex justify-between">
                    <p>Status</p>
                    <p>{{ $movie['status'] }}</p>
                </div>
                <div class="flex justify-between">
                    <p>Budget</p>
                    <p>{{ xformatted_dollar($movie['budget']) }}</p>
                </div>
                <div class="flex justify-between">
                    <p>Revenue</p>
                    <p>{{ $movie['revenue'] ? xformatted_dollar($movie['revenue'], 0) : 'unknown' }}</p>
                </div>
                <div class="mt-2">
                    <p>Keywords</p>
                    <div class="flex mt-2 flex-wrap gap-2">
                        @forelse ($movie['keywords']['keywords'] ?? [] as $keyword)
                            <p class="p-1 rounded text-sm text-slate-900 bg-gray-300">{{ $keyword['name'] }}</p>
                        @empty
                            <p>No keywords found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-cloak>
        <h4 class="text-2xl mt-16 font-semibold">REVIEWS</h4>
        <div class="flex flex-col gap-8 mt-8">
            @forelse ($movie['reviews']['results'] ?? [] as $review)
                <div class="flex items-start gap-4" x-data="{
                    more: false,
                }" x-init="setProgressValue($refs.fill, {{ $review['author_details']['rating'] ?? 0 }}, 10)">
                    <div class="relative w-max">
                        <svg class="progress-bar" viewBox="0 0 100 100">
                            <circle class="progress-bar__background" cx="50" cy="50" r="45">
                            </circle>
                            <circle class="progress-bar__fill" x-ref="fill" cx="50" cy="50" r="45">
                            </circle>
                        </svg>
                        <p
                            class="absolute text-2xl font-semibold left-1/2 -translate-x-1/2 -translate-y-1/2 top-1/2 text-black">
                            {{ number_format($review['author_details']['rating'], 1) }}
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-semibold text-lg">{{ $review['author'] }}</h3>
                        <p class="prose mt-2 text-white italic whitespace-pre-line" x-show="more" x-collapse.min.100px>
                            {{ $review['content'] }}</p>
                        <button class="self-end p-1 border mt-2 hover:bg-white hover:text-black" @click="more = !more"
                            x-text="more ? 'Read less...' : 'Read more...'"></button>
                    </div>
                </div>
            @empty
                <p>No reviews found.</p>
            @endforelse
        </div>
    </div>
    <div>
        <h4 class="text-2xl mt-16 font-semibold">SIMILAR MOVIES</h4>
        <div class="mt-2">
            @if (filled($movie['similar']))
                <x-splide id="similar"
                    breakpoints="{
                480: {
                    perPage: 2,
                    pagination: false,
                },
                900: {
                    perPage: 4,
                    pagination: false,
                },
            }">
                    @foreach ($movie['similar'] as $similar)
                        <livewire:poster :item="$similar" :on_watchlist="collect($watchlisted)->contains($similar['id'])" />
                    @endforeach
                </x-splide>
            @else
                <p>No movies found.</p>
            @endif
        </div>
    </div>
    <div class="mt-40"></div>
</div>
