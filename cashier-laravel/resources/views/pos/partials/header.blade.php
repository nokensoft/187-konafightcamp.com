<header class="bg-white border-b flex items-center gap-3 px-4 py-3 lg:px-8 lg:py-0 lg:h-16 justify-between flex-wrap lg:flex-nowrap">
    <div class="flex items-center gap-3 lg:gap-8 min-w-0 flex-wrap">
        <button @click="sidebarOpen = true"
                class="lg:hidden shrink-0 -ml-1 w-10 h-10 flex items-center justify-center rounded-2xl text-zinc-600 hover:bg-zinc-100 text-xl"
                aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="hidden lg:flex shrink-0 -ml-1 w-10 h-10 items-center justify-center rounded-2xl text-zinc-600 hover:bg-zinc-100 text-xl"
                :aria-label="sidebarCollapsed ? 'Show sidebar' : 'Hide sidebar'">
            <i class="fa-solid fa-bars"></i>
        </button>

        <h1 class="text-xl lg:text-2xl font-semibold tracking-tight truncate" x-text="pageTitle"></h1>

        <div class="flex bg-zinc-100 rounded-3xl p-1 text-sm font-medium">
            <template x-for="u in unitKeys" :key="u">
                <button @click="activeUnit = u"
                        class="px-3 sm:px-6 py-2 rounded-3xl transition-all flex items-center gap-2"
                        :class="activeUnit === u ? 'bg-white shadow text-red-600' : 'text-zinc-500 hover:text-zinc-700'">
                    <i class="fa-solid" :class="unitInfo[u].icon"></i>
                    <span class="hidden sm:inline" x-text="unitInfo[u].label"></span>
                </button>
            </template>
        </div>
    </div>

    <div class="flex items-center gap-4 lg:gap-6 w-full lg:w-auto">
        <div class="relative flex-1 lg:w-80 lg:flex-none">
            <input x-model="searchQuery"
                   type="text"
                   placeholder="Quick search members or products..."
                   class="w-full bg-zinc-100 border border-transparent focus:border-red-200 rounded-3xl py-2.5 lg:py-3 pl-11 lg:pl-12 outline-none text-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-4 lg:left-5 top-3 lg:top-3.5 text-zinc-400"></i>
        </div>

        <div class="flex items-center gap-5 text-zinc-400 shrink-0">
            <button @click="activeTab = 'notifications'"
                    class="relative hover:text-zinc-600"
                    aria-label="Notifications"
                    :title="unreadCount > 0 ? unreadCount + ' unread' : 'Notifications'">
                <i class="fa-solid fa-bell text-xl"></i>
                <span x-show="unreadCount > 0" x-cloak
                      class="absolute -top-1.5 -right-1.5 bg-red-600 text-white text-[10px] font-semibold rounded-full min-w-[18px] h-[18px] px-1 flex items-center justify-center"
                      x-text="unreadCount"></span>
            </button>
            <div class="hidden xl:block text-right text-sm"
                 x-data="{ time: '' }"
                 x-init="time = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
                         setInterval(() => time = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' }), 1000)">
                <div class="font-medium text-zinc-700">{{ now()->format('d F Y') }}</div>
                <div class="text-emerald-500 text-xs" x-text="time"></div>
            </div>
        </div>
    </div>
</header>
