<h1>{{ __('Bottlings') }}</h1>

<a href="{{ route('home') }}">
    <button>{{ __('Back to home') }}</button>
</a>

<div id="bottlings">

    <br/>

    <x-table :headers="$headers" :rows="$rows"></x-table>

</div>
