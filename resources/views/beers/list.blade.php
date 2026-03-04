<h1>{{ trans_choice('beer', 2) |> ucfirst(...) }}</h1>

<a href="{{ route('home') }}">
    <button>{{ __('Back to home') }}</button>
</a>

<div id="beers">

    @foreach($beers as $beer)

        <!-- beer detail -->

        <h2>{{ $beer->getUniqueIdentifier() }}</h2>

        <br/>

        <b>{{ __('name') |> ucfirst(...) }}</b>
        {{ $beer->name }}
        <br/>

        <b>{{ __('Type') }}</b>
        {{ $beer->type }}
        <br/>

        <b>{{ __('Creation') }}</b>
        {{ $beer->created_at->toDateString() }}
        <br/>

        <a href="{{route('beer', ['beer' => $beer->id])}}">{{__('See')}}</a>

    @endforeach

</div>
