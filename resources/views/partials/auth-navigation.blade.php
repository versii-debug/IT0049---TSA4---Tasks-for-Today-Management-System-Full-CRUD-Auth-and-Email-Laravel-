@auth
    <span class="nav-user">{{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-logout">Log out</button>
    </form>
@else
    <a class="nav-login" href="{{ route('login') }}" @if (request()->routeIs('login')) aria-current="page" @endif>Log in</a>
    <a href="{{ route('register') }}" @if (request()->routeIs('register')) aria-current="page" @endif>Register</a>
@endauth
