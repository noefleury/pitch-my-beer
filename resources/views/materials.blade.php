@php use App\Helpers\Volume; @endphp

<h1>{{ trans_choice('material', 2) |> ucfirst(...) }}</h1>

<a href="{{ route('home') }}">
    <button>{{ __('Back to home') }}</button>
</a>

<div id="materials">

    <!-- fermenters -->
    <div>
        <h2>{{ ucfirst(trans_choice('fermenter', 2)) }}</h2>
        <div>
            @foreach($materialsByType['fermenters'] as $fermenter)
                <b>{{ __('Name') }}</b>
                <span>{{ $fermenter->name }}</span>
                <b>{{ __('volume') |> ucfirst(...)  }}</b>
                <span>{{ Volume::getFormattedValue($fermenter->volume) }}</span>
                <a href="{{route('fermenter', ['fermenter' => $fermenter->id])}}">{{__('See')}}</a>
                <br/>
            @endforeach
        </div>
    </div>

    <!-- gaz tanks -->
    <div>
        <h2>{{ ucfirst(trans_choice('gaz_tank', 2)) }}</h2>
        <div>
            @foreach($materialsByType['gaz_tanks'] as $gazTank)
                <b>{{ __('Name') }}</b>
                <span>{{ $gazTank->name }}</span>
                <b>{{ __('co2') |> ucfirst(...)  }}</b>
                <span>{{ $gazTank->co2_percent }} %</span>
                <b>{{ __('n2') |> ucfirst(...)  }}</b>
                <span>{{ $gazTank->n2_percent }} %</span>
                <a href="{{route('gaz-tank', ['gazTank' => $gazTank->id])}}">{{__('See')}}</a>
                <br/>
            @endforeach
        </div>
    </div>

    <!-- kegs -->
    <div>
        <h2>{{ ucfirst(trans_choice('keg', 2)) }}</h2>
        <div>
            @foreach($materialsByType['kegs'] as $keg)
                <b>{{ __('Name') }}</b>
                <span>{{ $keg->name }}</span>
                <b>{{ __('volume') |> ucfirst(...)  }}</b>
                <span>{{ Volume::getFormattedValue($keg->volume) }}</span>
                <a href="{{route('keg', ['keg' => $keg->id])}}">{{__('See')}}</a>
                <br/>
            @endforeach
        </div>
    </div>

    <!-- taps -->
    <div>
        <h2>{{ ucfirst(trans_choice('tap', 2)) }}</h2>
        <div>
            @foreach($materialsByType['taps'] as $tap)
                <b>{{ __('Name') }}</b>
                <span>{{ $tap->name }}</span>
                <b>{{ __('Type') }}</b>
                <span>{{ $tap->type }}</span>
                <a href="{{route('tap', ['tap' => $tap->id])}}">{{__('See')}}</a>
                <br/>
            @endforeach
        </div>
    </div>

    <!-- bottles -->
    <div>
        <h2>{{ ucfirst(trans_choice('bottle', 2)) }}</h2>
        <div>
            @foreach($materialsByType['bottles'] as $bottle)
                <b>{{ __('volume') |> ucfirst(...) }}</b>
                <span>{{ Volume::getFormattedValue($bottle->volume / 1000) }}</span>
                <a href="{{route('bottle', ['bottle' => $bottle->id])}}">{{__('See')}}</a>
                <br/>
            @endforeach
        </div>
    </div>

</div>
