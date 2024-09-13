<?php

namespace App\Livewire;

use App\Oxytoxin\ManagesMovieWatchlist;
use Livewire\Component;

class HeroEntry extends Component
{
    use ManagesMovieWatchlist;

    public $item;
    
    public function render()
    {
        return view('livewire.hero-entry');
    }
}
