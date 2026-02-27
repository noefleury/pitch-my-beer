<h1>{{ trans_choice('tap', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('materials') }}">
    <button>{{ __('Back to materials') }}</button>
</a>

<br/><br/>

<div id="tap">

    <!-- tap detail -->
    <h2>{{ $tap->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('name') |> ucfirst(...) }}</b>
    {{ $tap->name }}
    <br/>

    <b>{{ __('type') |> ucfirst(...) }}</b>
    {{ $tap->type }}
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $tap->created_at->toDateString() }}
    <br/>

    <!-- tap data -->
    <!-- todo -->


</div>
