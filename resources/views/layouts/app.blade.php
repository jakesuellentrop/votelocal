@extends('layouts.base', ['background' => $background ?? ''])

@section('content')
    <header class="relative z-50 text-gray-600">
        @component('partials/main-menu')
            <a
                class="
                    flex items-center px-6 py-2 outline-none hover:bg-gray-200 focus:bg-gray-200 {{ Request::is('*archive') ? 'text-red-500' : '' }}
                    sm:px-2 sm:py-0 sm:hover:text-red-500 sm:focus:text-red-500 sm:hover:bg-transparent sm:focus:bg-transparent
                "
                href="{{ route('resources') }}"
            >
                <x-icon-diagonal-arrow-right-up width="20" class="text-current inline-block mr-2" />
                @lang('resources.page_title')
            </a>
            <a
                class="
                    flex items-center px-6 py-2 outline-none hover:bg-gray-200 focus:bg-gray-200 {{ Request::is('*archive') ? 'text-red-500' : '' }}
                    sm:px-2 sm:py-0 sm:hover:text-red-500 sm:focus:text-red-500 sm:hover:bg-transparent sm:focus:bg-transparent
                "
                href="{{ route('archive') }}"
            >
                <x-icon-archive width="20" class="text-current inline-block mr-2" />
                Message Archive
            </a>
            @if (Auth::guard('subscriber')->check())
                <a
                    class="
                        flex items-center px-6 py-2 outline-none hover:bg-gray-200 focus:bg-gray-200 {{ Request::is('*archive') ? 'text-red-500' : '' }}
                        sm:px-2 sm:py-0 sm:hover:text-red-500 sm:focus:text-red-500 sm:hover:bg-transparent sm:focus:bg-transparent
                    "
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    href="#"
                >
                    @lang('subscriber.logout')
                </a>
            @endif
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            @foreach(config('votelocal.locales') as $name => $locale)
                @php
                    $current = App::getLocale();
                    $segments = Request::segments();
                    if ($current === 'en') {
                        array_unshift($segments, $locale);
                    } else {
                        $segments[0] = $locale !== 'en' ? $locale : '' ;
                    }
                    if ($current === $locale) {
                        continue;
                    }
                @endphp
                <a
                    class="
                        flex items-center px-6 py-2 outline-0 hover:bg-gray-200 focus:bg-gray-200
                        sm:px-2 sm:py-0 sm:hover:text-red-500 sm:focus:text-red-500 sm:hover:bg-transparent sm:focus:bg-transparent
                    "
                    href="{{ url(implode('/', $segments)) }}"
                >
                    @svg($locale, 'text-current inline-block mr-2', ['width' => 20])
                    <span class="sm:hidden">{{ $name }}</span>
                </a>
            @endforeach
        @endcomponent
    </header>
    <main>
        @include('partials.flash')
        @yield('content')
    </main>
@overwrite
