<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle ml-4" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        Browse <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">

                        <li class="ml-2"><a href="{{ url('/threads') }}">All threads</a></li>

                        @if (auth()->check())
                        <li class="ml-2"><a href="{{ url('/threads') }}?by={{ auth()->user()->name }}">My
                                Threads</a></li>
                        @endif

                        <li class="ml-2"><a href="{{ url('/threads') }}?popular=1">Popular threads</a></li>

                        <li class="ml-2"><a href="{{ url('/threads') }}?unanswered=1">Unanswered threads</a></li>
                    </ul>
                </li>

                <li><a href="{{ url('/threads/create') }}" class="ml-4">New Thread</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle ml-4" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        Channels <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($channels as $channel)
                        <li><a href="{{ url('/threads')}}/{{ $channel->slug }}" class="ml-2">
                                {{ $channel->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>


                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        <li class="dropdown-item">
                            <a href="{{ route('profile',Auth::user()) }}">
                                My profile
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
