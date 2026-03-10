<h1>{{ trans_choice('keg', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('materials') }}">
    <button>{{ __('Back to materials') }}</button>
</a>

<br/><br/>

<div id="keg">

    <!-- keg-tank detail -->
    <h2>{{ $keg->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('Name') }}</b>
    {{ $keg->name }}
    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ \App\Helpers\Volume::getFormattedValue($keg->volume) }}
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $keg->created_at->toDateString() }}
    <br/>

    <!-- keg data -->
    <!-- todo -->


</div>
