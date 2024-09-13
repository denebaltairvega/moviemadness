@props([
    'id' => 'splide',
    'type' => 'slide',
    'perPage' => 7,
    'gap' => '1rem',
    'lazyLoad' => 'false',
    'breakpoints' => '{}',
    'autoplay' => 'false',
    'arrows' => 'true',
    'pagination' => 'true',
    'interval' => 0,
])

<div wire:ignore x-data x-init="new Splide('#{{ $id }}', {
    type: '{{ $type }}',
    perPage: {{ $perPage }},
    gap: '{{ $gap }}',
    breakpoints: {{ $breakpoints }},
    arrows: {{ $arrows }},
    pagination: {{ $pagination }},
    autoplay: {{ $autoplay }},
    interval: {{ $interval }},
}).mount()">
    <section x-cloak class="splide" id="{{ $id }}">
        <div class="splide__track">
            <ul class="splide__list">
                {{ $slot }}
            </ul>
        </div>
    </section>
</div>
