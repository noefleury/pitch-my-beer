<h1>{{ trans_choice('bottle', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('materials') }}">
    <button>{{ __('Back to materials') }}</button>
</a>

<br/><br/>

<div id="bottle">

    <!-- bottle detail -->
    <h2>{{ $bottle->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ $bottle->volume }} mL
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $bottle->created_at->toDateString() }}
    <br/>

    <!-- bottle data -->
    <!-- todo -->


</div>
