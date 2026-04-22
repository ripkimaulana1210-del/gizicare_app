<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="/dashboard">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- 🔥 Menu -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link href="/dashboard" :active="request()->is('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link href="/pencatatan" :active="request()->is('pencatatan*')">
                        Pencatatan
                    </x-nav-link>

                    <x-nav-link href="/edukasi" :active="request()->is('edukasi*')">
                        Edukasi
                    </x-nav-link>

                    <x-nav-link href="/diagnosis" :active="request()->is('diagnosis')">
                        Masalah Gizi
                    </x-nav-link>

                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm rounded-md text-gray-500 hover:text-gray-700">
                            {{ Auth::user()->name }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="/profile">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- 🔥 Mobile -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link href="/dashboard" :active="request()->is('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/pencatatan" :active="request()->is('pencatatan*')">
                Pencatatan
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/edukasi" :active="request()->is('edukasi*')">
                Edukasi
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/diagnosis" :active="request()->is('diagnosis')">
                Masalah Gizi
            </x-responsive-nav-link>

        </div>
    </div>

</nav>
