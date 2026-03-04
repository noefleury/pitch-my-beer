<h1>{{ trans_choice('fermenter', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('materials') }}">
    <button>{{ __('Back to materials') }}</button>
</a>

<br/><br/>

<div id="fermenter">

    <!-- fermenter detail -->
    <h2>{{ $fermenter->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('name') |> ucfirst(...) }}</b>
    {{ $fermenter->name }}
    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ $fermenter->volume }} L
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $fermenter->created_at->toDateString() }}
    <br/>

    <!-- relations data -->

    @if( $currentFermentation = $relations->current_fermentation)

        <h3>Current fermentation</h3>

        <b>{{ __('volume') |> ucfirst(...) }}</b>
        {{ $relations->current_fermentation->volume }} L
        <br/>

        <b>{{ __('Creation') }}</b>
        {{ $relations->current_fermentation->created_at->toDateString() }}
        <br/>
        
    @endif


</div>
