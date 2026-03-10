@php use App\Enums\FermenterType;use App\Helpers\Volume; @endphp
<h1>{{ trans_choice('beer', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('beers') }}">
    <button>{{ __('Back to beers') }}</button>
</a>

<div id="beer">

    <!-- beer detail -->

    <h2>{{ $beer->getUniqueIdentifier() }}</h2>

    <br/>

    <b>{{ __('Name') }}</b>
    {{ $beer->name }}
    <br/>

    <b>{{ __('Type') }}</b>
    {{ $beer->type }}
    <br/>

    <b>{{ __('volume') |> ucfirst(...) }}</b>
    {{ Volume::getFormattedValue($beer->volume) }}
    <br/>

    <b>{{ __('ABV') }}</b>
    {{ filled($beer->abv) ? round($beer->abv, 2).' %' : __('N/A') }}
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
        {{ Volume::getFormattedValue($relations->fermentation->volume) }}
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

        <span>{{ $beer->keggings->first()->created_at->toDateString() }}</span>
        <br/><br/>

        <x-table :headers="$keggingsHeaders" :rows="$keggingsRows"></x-table>

    @endif

    @if($beer->bottlings->isNotEmpty())

        <h3>{{ __('Bottlings') }}</h3>

        <span>{{ $beer->bottlings->first()->created_at->toDateString() }}</span>
        <br/><br/>

        <x-table :headers="$bottlingsHeaders" :rows="$bottlingsRows"></x-table>

    @endif

    @if($beer->comments->isNotEmpty())

        <h3>{{ __('Comments') }}</h3>

        @foreach($beer->comments as $comment)

            <b>{{ $comment->created_at->toDateString() }}</b>

            <br/>

            {{ $comment->value }}

            <br/><br/>

        @endforeach

    @endif

</div>
