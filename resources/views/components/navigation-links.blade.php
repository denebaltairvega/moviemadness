<ul class="flex gap-8 items-center">
    <a href="{{ route('home') }}" @class([
        'border-b border-white px-4',
        'border border-amber-600 text-amber-600' =>
            \Route::currentRouteName() == 'home',
    ])>
        <li>Home</li>
    </a>
    <a href="{{ route('movies.discover') }}"@class([
        'border-b border-white px-4',
        'border border-amber-600 text-amber-600' =>
            \Route::currentRouteName() == 'movies.discover',
    ])>
        <li>Discover</li>
    </a>
    <a href="{{ route('about') }}"@class([
        'border-b border-white px-4',
        'border border-amber-600 text-amber-600' =>
            \Route::currentRouteName() == 'about',
    ])>
        <li>About</li>
    </a>
</ul>
