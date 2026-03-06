<h1>{{ trans_choice('beer', 2) |> ucfirst(...) }}</h1>

<a href="{{ route('home') }}">
    <button>{{ __('Back to home') }}</button>
</a>

<div id="beers">

    <br/>

    <x-table :headers="$headers" :rows="$rows" :trusted="$trusted"></x-table>

</div>
