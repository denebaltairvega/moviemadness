<?php

namespace App\Livewire\Movies;

use App\Models\WatchlistItem;
use App\Oxytoxin\ManagesMovieWatchlist;
use App\Services\TMDB\Enums\Images\BackdropSize;
use App\Services\TMDB\Enums\Images\PosterSize;
use App\Services\TMDB\Enums\Images\ProfileSize;
use App\Services\TMDB\TMDBClient;
use Livewire\Component;

class MovieDetails extends Component
{
    public $movie = [];
    public $watchlisted = [];

    public function mount($movie_id, TMDBClient $client)
    {
        $data = $client->getMovie($movie_id, [
            'append_to_response' => 'images,videos,credits,reviews,keywords,similar'
        ]);
        $this->movie = $data->toArray();
        $this->movie['videos'] = collect($this->movie['videos'])
            ->groupBy('type')
            ->sortKeysDesc()
            ->toArray();
        $this->movie['backdrop_path'] = TMDBClient::getImageUrl(BackdropSize::w1280, $this->movie['backdrop_path']);
        $this->movie['poster_path'] = TMDBClient::getImageUrl(PosterSize::w185, $this->movie['poster_path']);
        $this->movie['credits']['cast'] = collect($this->movie['credits']['cast'] ?? [])->take(10)
            ->map(function ($c) {
                $c['profile_path'] = $c['profile_path'] ?  TMDBClient::getImageUrl(ProfileSize::w185, $c['profile_path']) : 'https://www.pngitem.com/pimgs/m/264-2647677_avatar-icon-human-user-avatar-svg-hd-png.png';
                return $c;
            });
        $this->movie['credits']['crew'] = collect($this->movie['credits']['crew'] ?? [])
            ->filter(fn ($c) => in_array($c['job'], ['Writer', 'Director']))
            ->map(function ($c) {
                $c['profile_path'] = $c['profile_path'] ?  TMDBClient::getImageUrl(ProfileSize::w185, $c['profile_path']) : 'https://www.pngitem.com/pimgs/m/264-2647677_avatar-icon-human-user-avatar-svg-hd-png.png';
                return $c;
            });
        $this->movie['similar'] = $client->transformImages($data->similar);
        if (auth()->id()) {
            $this->watchlisted = WatchlistItem::whereUserId(auth()->id())->pluck('movie_id')->toArray();
        }
    }

    public function render()
    {
        return view('livewire.movies.movie-details');
    }
}
