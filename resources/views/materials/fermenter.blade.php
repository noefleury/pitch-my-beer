<h1>{{ trans_choice('fermenter', 1) |> ucfirst(...) }}</h1>

<a href="{{ route('home') }}">
    <button>{{ __('Back to home') }}</button>
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

    <!-- fermenter data -->
    <!-- todo -->


</div>
