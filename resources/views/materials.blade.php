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
                <b>{{ __('name') |> ucfirst(...) }}</b>
                <span>{{ $fermenter->name }}</span>
                <b>{{ __('volume') |> ucfirst(...)  }}</b>
                <span>{{ $fermenter->volume }} L</span>
                <br/>
            @endforeach
        </div>
    </div>

    <!-- gaz tanks -->
    <div>
        <h2>{{ ucfirst(trans_choice('gaz_tank', 2)) }}</h2>
        <div>
            @foreach($materialsByType['gaz_tanks'] as $gazTank)
                <b>{{ __('name') |> ucfirst(...) }}</b>
                <span>{{ $gazTank->name }}</span>
                <b>{{ __('co2') |> ucfirst(...)  }}</b>
                <span>{{ $gazTank->co2_percent }} %</span>
                <b>{{ __('n2') |> ucfirst(...)  }}</b>
                <span>{{ $gazTank->n2_percent }} %</span>
                <br/>
            @endforeach
        </div>
    </div>

    <!-- kegs -->
    <div>
        <h2>{{ ucfirst(trans_choice('keg', 2)) }}</h2>
        <div>
            @foreach($materialsByType['kegs'] as $keg)
                <b>{{ __('name') |> ucfirst(...) }}</b>
                <span>{{ $keg->name }}</span>
                <b>{{ __('volume') |> ucfirst(...)  }}</b>
                <span>{{ $keg->volume }} L</span>
                <br/>
            @endforeach
        </div>
    </div>

    <!-- taps -->
    <div>
        <h2>{{ ucfirst(trans_choice('tap', 2)) }}</h2>
        <div>
            @foreach($materialsByType['taps'] as $tap)
                <b>{{ __('name') |> ucfirst(...) }}</b>
                <span>{{ $tap->name }}</span>
                <b>{{ __('type') |> ucfirst(...)  }}</b>
                <span>{{ $tap->type }}</span>
                <br/>
            @endforeach
        </div>
    </div>

</div>
