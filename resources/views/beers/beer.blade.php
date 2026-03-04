@php use App\Enums\FermenterType; @endphp
<h1>{{ trans_choice('beer', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('beers') }}">
    <button>{{ __('Back to beers') }}</button>
</a>

<div id="beer">

    <!-- beer detail -->

    <h2>{{ $beer->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('name') |> ucfirst(...) }}</b>
    {{ $beer->name }}
    <br/>

    <b>{{ __('Type') }}</b>
    {{ $beer->type }}
    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ $beer->volume }} L
    <br/>

    <b>{{ __('status') |> ucfirst(...) }}</b>
    {{ $beer->status }}
    <br/>

    <b>{{ __('homemade') |> ucfirst(...) }}</b>
    {{ $beer->is_homemade ? __('Yes') : __('No') }}
    <br/>

    <b>{{ __('Creation') }}</b>
    {{ $beer->created_at->toDateString() }}
    <br/>

    <!-- relations data -->

    @if($beer->is_homemade)

        <h3>{{ __('Fermentation') }}</h3>

        <b>{{ __('Type') }}</b>
        {{ $relations->fermentation->fermenter_type }}
        <br/>

        <b>{{ __('volume') |> ucfirst(...) }}</b>
        {{ $relations->fermentation->volume }} L
        <br/>

        <b>{{ __('Creation') }}</b>
        {{ $relations->fermentation->created_at->toDateString() }}
        <br/>

        @if($relations->fermentation->fermenter_type === FermenterType::Fermenter)
            <a href="{{route('fermenter', ['fermenter' => $relations->fermentation->fermenter_id])}}">{{__('See')}}</a>
        @elseif($relations->fermentation->fermenter_type === FermenterType::Keg)
            <a href="{{route('keg', ['keg' => $relations->fermentation->fermenter_id])}}">{{__('See')}}</a>
        @endif
        <br/>

    @endif

    @if($beer->keggings->isNotEmpty())

        <h3>{{ __('Keggings') }}</h3>

        @foreach($beer->keggings as $kegging)

            <b>{{ __('volume') |> ucfirst(...) }}</b>
            {{ $kegging->volume }} L
            <br/>

            <b>{{ __('Creation') }}</b>
            {{ $kegging->created_at->toDateString() }}
            <br/>

            <a href="{{route('keg', ['keg' => $kegging->id])}}">{{__('See')}}</a>
            <br/>

        @endforeach

    @endif

    @if($beer->bottlings->isNotEmpty())

        <h3>{{ __('Bottlings') }}</h3>

        @foreach($beer->bottlings as $bottling)

            <b>{{ __('volume') |> ucfirst(...) }}</b>
            {{ $bottling->bottle->volume }} mL
            <br/>

            <b>{{ __('Creation') }}</b>
            {{ $bottling->created_at->toDateString() }}
            <br/>

            <a href="{{route('bottle', ['bottle' => $bottling->bottle_id])}}">{{__('See')}}</a>
            <br/>

        @endforeach

    @endif

</div>
