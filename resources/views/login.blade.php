<h1>{{ config('app.name') }} </h1>

<form method="POST" action="{{ route('authenticate') }}">
    @csrf
    <input type="text" name="login" placeholder="{{ __('Username') }}">
    <input type="password" name="password" placeholder="{{ __('Password') }}">
    <input type="submit" value="{{ __('Connect') }}">
</form>
