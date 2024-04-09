<?php

namespace App\Livewire\Movies;

use App\Services\TMDB\TMDBClient;
use App\Services\TMDB\Traits\PaginatesMovieResults;
use Illuminate\Http\Response;
use Livewire\Component;

class MoviesByType extends Component
{
    use PaginatesMovieResults;

    public $type;
    public $movies = [];
    public $loaded = false;

    protected $queryString = [
        "current_page" => ['except' => 1],
    ];

    public function mount($type)
    {
        $this->type = $type;
    }


    public function render(TMDBClient $client)
    {
        $movies = [];
        $query['page'] = $this->current_page;
        if ($this->loaded) {
            try {
                $movies = retry(3, function () use ($client, $query) {
                    $data = $client->getMovies($this->type, $query);
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
        return view('livewire.movies.movies-by-type');
    }

    public function load()
    {
        $this->loaded = true;
    }
}
