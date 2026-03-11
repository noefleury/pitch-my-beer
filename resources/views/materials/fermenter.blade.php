<h1>{{ trans_choice('fermenter', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('materials') }}">
    <button>{{ __('Back to materials') }}</button>
</a>

<br/><br/>

<div id="fermenter">

    <!-- fermenter detail -->
    <h2>{{ $fermenter->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('Name') }}</b>
    {{ $fermenter->name }}
    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ \App\Helpers\Volume::getFormattedValue($fermenter->volume) }}
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $fermenter->created_at->toDateString() }}
    <br/>

    <!-- relations data -->

    @if($currentFermentation = $relations->fermentation)

        <h3>{{ __('Current fermentation') }}</h3>

        <b>{{ __('volume') |> ucfirst(...) }}</b>
        {{ \App\Helpers\Volume::getFormattedValue($currentFermentation->volume) }}
        <br/>

        <b>{{ __('Creation') }}</b>
        {{ $currentFermentation->created_at->toDateString() }}
        <br/>

    @endif


</div>
