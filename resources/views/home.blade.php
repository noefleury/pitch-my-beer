<h1>{{ config('app.name') }}</h1>

<nav>

    <a href="{{ route('materials') }}" class="link">
        <span class="btn-link">{{ trans_choice('material', 2) |> ucfirst(...) }}</span>
    </a>
    <a href="{{ route('beers') }}" class="link">
        <span class="btn-link">{{ trans_choice('beer', 2)  |> ucfirst(...) }}</span>
    </a>
    <a href="{{ route('on-taps') }}" class="link">
        <span class="btn-link">{{ __('on taps') |> ucfirst(...) }}</span>
    </a>
    <a href="{{ route('bottlings') }}" class="link">
        <span class="btn-link">{{ __('Bottlings') }}</span>
    </a>

</nav>

<style>

    nav {
        display: grid;
        column-gap: 25px;
        row-gap: 50px;
        text-align: center;
        grid-template-columns: auto auto;
        @media screen and (max-width: 1500px) {
            row-gap: 15px;
            grid-template-columns: auto;
        }
    }

    a {
        text-decoration: none;
        color: unset;
    }

    .btn-link {
        display: block;
        border: 1px solid gray;
        border-radius: 5px;
        padding: 5px;
        font-size: x-large;
        cursor: pointer;

        &:hover {
            background-color: #e3e3e3;
        }
    }

</style>
