<h1>{{ trans_choice('keg', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('materials') }}">
    <button>{{ __('Back to materials') }}</button>
</a>

<br/><br/>

<div id="keg">

    <!-- keg-tank detail -->
    <h2>{{ $keg->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('name') |> ucfirst(...) }}</b>
    {{ $keg->name }}
    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ $keg->volume }} L
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $keg->created_at->toDateString() }}
    <br/>

    <!-- keg data -->
    <!-- todo -->


</div>
