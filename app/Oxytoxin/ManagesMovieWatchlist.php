<?php

namespace App\Oxytoxin;

use App\Models\WatchlistItem;
use App\Services\TMDB\Enums\Images\PosterSize;
use App\Services\TMDB\TMDBClient;
use Filament\Notifications\Notification;

trait ManagesMovieWatchlist
{
    public $on_watchlist = false;

    public function toggleWatchlist($movie_id, TMDBClient $client)
    {
        if (!auth()->user()) {
            return redirect()->route('login');
        }
        $movie = $client->getMovie($movie_id);
        $watchlistItem = WatchlistItem::firstWhere('movie_id', $movie->id);
        if ($watchlistItem) {
            $watchlistItem->delete();
            $this->on_watchlist = false;
            Notification::make()->title('Movie removed from watchlist!')->success()->send();
        } else {
            WatchlistItem::query()->create([
                'user_id' => auth()->id(),
                'movie_id' => $movie->id,
                'other_details' => [
                    'movie_poster_path' => $client->getImageUrl(PosterSize::w185, $movie->poster_path),
                    'movie_title' => $movie->title,
                    'movie_overview' => $movie->overview,
                ]
            ]);
            $this->on_watchlist = true;
            Notification::make()->title('Movie added to watchlist!')->success()->send();
        }
    }
}
