<!-- Mobile sidebar backdrop -->
<div x-show="sidebarOpen" x-cloak x-transition.opacity
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

<!-- Sidebar -->
<div class="w-72 bg-white border-r border-zinc-100 flex flex-col shadow-sm overflow-y-auto
            fixed inset-y-0 left-0 z-50 transform transition-transform duration-300
            lg:static lg:z-auto lg:translate-x-0"
     :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'lg:hidden': sidebarCollapsed }">
    <div class="p-8 border-b relative">
        <!-- Mobile: close overlay -->
        <button @click="sidebarOpen = false"
                class="lg:hidden absolute top-6 right-6 w-9 h-9 flex items-center justify-center rounded-2xl text-zinc-400 hover:bg-zinc-100"
                aria-label="Close menu">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
        <!-- Desktop: collapse sidebar -->
        <button @click="sidebarCollapsed = true"
                class="hidden lg:flex absolute top-6 right-6 w-9 h-9 items-center justify-center rounded-2xl text-zinc-400 hover:bg-zinc-100"
                aria-label="Hide sidebar">
            <i class="fa-solid fa-angles-left text-lg"></i>
        </button>
        <img src="{{ asset('logo.png') }}" alt="Kona Fight Camp" class="h-14 w-auto rounded-2xl">
        <p class="text-zinc-400 text-sm mt-3 pl-1">Multi-Unit POS</p>
    </div>

    <!-- Per-unit navigation -->
    <div class="px-6 pt-8">
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 px-3">
            <span x-text="unitInfo[activeUnit].label"></span> Navigation
        </div>
        <nav class="space-y-1 px-3">
            <template x-for="n in unitNav" :key="n.tab">
                <a @click.prevent="activeTab = n.tab; sidebarOpen = false"
                   :class="{ 'bg-zinc-100': activeTab === n.tab }"
                   class="flex items-center gap-3 px-5 py-4 rounded-3xl cursor-pointer hover:bg-zinc-100">
                    <i class="fa-solid w-5" :class="n.icon"></i>
                    <span class="font-medium" x-text="n.label"></span>
                    <span x-show="n.tab === 'trash' && trashCount > 0" x-cloak
                          class="ml-auto bg-red-100 text-red-600 text-xs font-semibold rounded-full px-2 py-0.5"
                          x-text="trashCount"></span>
                </a>
            </template>
        </nav>
    </div>

    <!-- General navigation (notifications, logs) -->
    <div class="px-6 pt-8">
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 px-3">General</div>
        <nav class="space-y-1 px-3">
            <template x-for="n in generalNav" :key="n.tab">
                <a @click.prevent="activeTab = n.tab; sidebarOpen = false"
                   :class="{ 'bg-zinc-100': activeTab === n.tab }"
                   class="flex items-center gap-3 px-5 py-4 rounded-3xl cursor-pointer hover:bg-zinc-100">
                    <i class="fa-solid w-5" :class="n.icon"></i>
                    <span class="font-medium" x-text="n.label"></span>
                    <span x-show="n.tab === 'notifications' && unreadCount > 0" x-cloak
                          class="ml-auto bg-red-100 text-red-600 text-xs font-semibold rounded-full px-2 py-0.5"
                          x-text="unreadCount"></span>
                </a>
            </template>
        </nav>
    </div>

    <!-- Signed-in user -->
    <div class="mt-auto p-6 border-t">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-zinc-900 text-white rounded-2xl flex items-center justify-center text-sm font-medium">
                {{ strtoupper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-medium text-sm truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-emerald-600 capitalize">{{ auth()->user()->role }} • On Duty</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-9 h-9 flex items-center justify-center rounded-2xl text-zinc-400 hover:bg-zinc-100 hover:text-red-600"
                        title="Log out" aria-label="Log out">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
        <a href="{{ route('profile.edit') }}" class="mt-3 inline-flex items-center gap-2 text-xs text-zinc-400 hover:text-zinc-600">
            <i class="fa-regular fa-user"></i> Profile settings
        </a>
    </div>
</div>
