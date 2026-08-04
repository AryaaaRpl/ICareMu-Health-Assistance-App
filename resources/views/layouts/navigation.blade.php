<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(in_array(auth()->user()->role, ['guru_ismuba', 'admin_uks', 'super_admin', 'petugas_uks', 'admin_super', 'siswa']))
                        <x-nav-link :href="route('ismuba.index')" :active="request()->routeIs('ismuba.*')">
                            {{ __('Edukasi & ISMUBA') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings & Notifications Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <!-- Notification Bell Dropdown -->
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-full focus:outline-none transition">
                        <!-- Bell SVG Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>

                        <!-- Red Dot Badge -->
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-600 text-[10px] font-bold text-white shadow-sm ring-2 ring-white">
                                {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="notifOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden"
                         style="display: none;">
                        
                        <!-- Dropdown Header -->
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-800 text-sm">Notifikasi</span>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="px-2 py-0.5 text-[10px] font-extrabold bg-rose-100 text-rose-700 rounded-full">
                                        {{ auth()->user()->unreadNotifications->count() }} Baru
                                    </span>
                                @endif
                            </div>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">
                                        Tandai semua dibaca
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Notification List -->
                        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                            @forelse(auth()->user()->notifications->take(10) as $notification)
                                @php
                                    $data = $notification->data;
                                    $type = $data['type'] ?? 'info';
                                    $isUnread = is_null($notification->read_at);
                                @endphp
                                <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-slate-50 transition {{ $isUnread ? 'bg-indigo-50/40' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <!-- Icon based on notification type -->
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $type === 'menstrual' ? 'bg-pink-100 text-pink-600' : ($type === 'ai' ? 'bg-purple-100 text-purple-600' : 'bg-indigo-100 text-indigo-600') }}">
                                            @if($type === 'menstrual')
                                                🌸
                                            @elseif($type === 'ai')
                                                🤖
                                            @else
                                                🔔
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-slate-800 truncate">{{ $data['title'] ?? 'Notifikasi' }}</p>
                                            <p class="text-xs text-slate-600 mt-0.5 line-clamp-2">{{ $data['message'] ?? '' }}</p>
                                            <span class="text-[10px] text-slate-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($isUnread)
                                            <span class="w-2 h-2 rounded-full bg-rose-500 mt-1 shrink-0"></span>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="p-6 text-center text-slate-400 space-y-1">
                                    <div class="text-2xl">🔕</div>
                                    <p class="text-xs font-medium">Belum ada notifikasi baru</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(in_array(auth()->user()->role, ['guru_ismuba', 'admin_uks', 'super_admin', 'petugas_uks', 'admin_super', 'siswa']))
                <x-responsive-nav-link :href="route('ismuba.index')" :active="request()->routeIs('ismuba.*')">
                    {{ __('Edukasi & ISMUBA') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
