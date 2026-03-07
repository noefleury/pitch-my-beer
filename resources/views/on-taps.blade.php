<h1>{{ __('on taps') |> ucfirst(...) }}</h1>

<a href="{{ route('home') }}">
    <button>{{ __('Back to home') }}</button>
</a>

<div id="on-taps">

    <br/>

    <x-table :headers="$headers" :rows="$rows"></x-table>

</div>
