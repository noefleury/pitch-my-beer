<h1>{{ trans_choice('gaz_tank', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('materials') }}">
    <button>{{ __('Back to materials') }}</button>
</a>

<br/><br/>

<div id="gaz-tank">

    <!-- gaz-tank detail -->
    <h2>{{ $gazTank->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('Name') }}</b>
    {{ $gazTank->name }}
    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ \App\Helpers\Volume::getFormattedValue($gazTank->volume) }}
    <br/>

    <b>{{ __('co2') |> ucfirst(...) }}</b>
    {{ $gazTank->co2_percent }} %
    <br/>

    <b>{{ __('n2') |> ucfirst(...) }}</b>
    {{ $gazTank->n2_percent }} %
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $gazTank->created_at->toDateString() }}
    <br/>

    <!-- gaz-tank data -->
    <!-- todo -->


</div>
