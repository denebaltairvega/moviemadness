<?php

namespace App\Livewire;

use App\Models\WatchlistItem;
use App\Oxytoxin\ManagesMovieWatchlist;
use App\Services\TMDB\Enums\Images\BackdropSize;
use App\Services\TMDB\Enums\Images\PosterSize;
use App\Services\TMDB\TMDBClient;
use Livewire\Component;

class Homepage extends Component
{
    public $discover_movies = [];
    public $movies = [];
    public $genres = [];
    public $watchlisted = [];
    public $home = true;

    public function mount(TMDBClient $client)
    {
        $this->discover_movies = $client->transformImages($client->discover_movies(key: 'homepage')->results);
        ['popular' => $this->movies['popular'], 'upcoming' => $this->movies['upcoming'], 'now_playing' => $this->movies['now_playing'], 'top_rated' => $this->movies['top_rated']] = $client->getAllMovies();
        foreach ($this->movies as $key => $movie) {
            $this->movies[$key] = $client->transformImages($movie->results);
        }
        $this->genres = $client->getGenres()->toArray();
        if (auth()->id()) {
            $this->watchlisted = WatchlistItem::whereUserId(auth()->id())->pluck('movie_id')->toArray();
        }
    }

    public function render()
    {
        return view('livewire.homepage');
    }
}
