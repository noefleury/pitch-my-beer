<h1>{{ config('app.name') }}</h1>

<a href="{{ route('materials') }}">{{ trans_choice('material', 2) }}</a>
<a href="{{ route('beers') }}">{{ trans_choice('beer', 2) }}</a>
<a href="{{ route('on-taps') }}">{{ __('on taps') }}</a>
<a href="#">todo</a>
