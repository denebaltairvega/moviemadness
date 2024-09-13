<?php

namespace App\Livewire\Movies;

use App\Models\WatchlistItem;
use App\Oxytoxin\ManagesMovieWatchlist;
use App\Services\TMDB\TMDBClient;
use App\Services\TMDB\Traits\PaginatesMovieResults;
use Illuminate\Http\Response;
use Livewire\Component;

class SearchMovies extends Component
{
    use PaginatesMovieResults;

    public $search = '';
    public $movies = [];
    public $watchlisted = [];

    protected $queryString = [
        "current_page" => ['except' => 1],
        "search" => ['except' => ''],
    ];

    public function mount()
    {
        if (auth()->id()) {
            $this->watchlisted = WatchlistItem::whereUserId(auth()->id())->pluck('movie_id')->toArray();
        }
    }

    public function render(TMDBClient $client)
    {
        $movies = [];
        $query['page'] = $this->current_page;
        if ($this->search) {
            $query['query'] = $this->search;
            try {
                $movies = retry(3, function () use ($client, $query) {
                    $data = $client->search_movies($query);
                    $this->current_page = $data->page;
                    $this->total_pages = $data->total_pages;
                    $this->total_results = $data->total_results;
                    return $client->transformImages($data->results);
                });
            } catch (\Throwable $th) {
                abort(Response::HTTP_NOT_FOUND);
            }
        }
        $this->movies = $movies;

        return view('livewire.movies.search-movies');
    }

    public function searchMovies()
    {
        $this->current_page = 1;
    }
}
