<?php

namespace App\Livewire;

use App\Oxytoxin\ManagesMovieWatchlist;
use Livewire\Component;

class Poster extends Component
{
    use ManagesMovieWatchlist;

    public $item;

    public function render()
    {
        return view('livewire.poster');
    }
}
