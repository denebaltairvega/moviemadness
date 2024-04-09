<?php

namespace App\Livewire\Movies;

use App\Models\WatchlistItem;
use App\Services\TMDB\TMDBClient;
use App\Services\TMDB\Traits\PaginatesMovieResults;
use Illuminate\Http\Response;
use Livewire\Component;

class DiscoverMovies extends Component
{
    use PaginatesMovieResults;

    public $genres = [];
    public $movies = [];
    public $include_genres = [];
    public $min_rating = 7.11;
    public $loaded = false;
    public $watchlisted = [];

    protected $queryString = [
        "current_page" => ['except' => 1],
    ];

    public function mount(TMDBClient $client)
    {
        $this->genres = $client->getGenres()->toArray();

        if (request('genre')) {
            $this->include_genres[] = request('genre');
        }

        if (request('page')) {
            $this->current_page = request('page');
        }

        if (auth()->id()) {
            $this->watchlisted = WatchlistItem::whereUserId(auth()->id())->pluck('movie_id')->toArray();
        }
    }

    public function render(TMDBClient $client)
    {
        $movies = [];

        if ($this->loaded) {
            $query = [];
            $query['with_genres'] = implode('|', $this->include_genres);
            $query['vote_average.gte'] = $this->min_rating;
            $query['sort_by'] = 'popularity.desc';
            $query['include_adult'] = false;
            $query['page'] = $this->current_page;
            try {
                $movies = retry(3, function () use ($client, $query) {
                    $data = $client->discover_movies($query);
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
        return view('livewire.movies.discover-movies');
    }


    public function discover()
    {
        $this->loaded = true;
    }

    public function toggleGenre(string $genre_id)
    {
        $include_genres = collect($this->include_genres);
        if ($include_genres->contains($genre_id)) {
            $include_genres = $include_genres->reject(function ($item) use ($genre_id) {
                return $item === $genre_id;
            });
        } else {
            $include_genres->push($genre_id);
        }

        $this->include_genres = $include_genres->toArray();
        $this->current_page = 1;
    }
}
