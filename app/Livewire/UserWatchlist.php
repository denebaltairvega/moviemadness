<?php

namespace App\Livewire;

use App\Models\WatchlistItem;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class UserWatchlist extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.user-watchlist', [
            'watchlisted' => auth()->user()->watchlist_items()->paginate()
        ]);
    }

    public function complete(WatchlistItem $watchlistItem)
    {
        $watchlistItem->update([
            'status' => WatchlistItem::COMPLETED,
            'watched_at' => now(),
        ]);
        Notification::make()->title('Movie marked as watched.')->success()->send();
    }

    public function removeFromList($watchlist_item_id)
    {
        auth()->user()->watchlist_items()->find($watchlist_item_id)?->delete();
        Notification::make()->title('Movie removed from watchlist.')->success()->send();
    }
}
