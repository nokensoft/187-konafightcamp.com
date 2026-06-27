<!-- NOTIFICATIONS (simulation) -->
<div x-show="activeTab === 'notifications'" x-cloak>
    <div class="flex flex-wrap gap-4 justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl lg:text-3xl font-semibold">Notifications</h2>
            <p class="text-zinc-400 text-sm mt-1">Recent alerts and updates across your units.</p>
        </div>
        <button x-show="unreadCount > 0" @click="markAllNotificationsRead()"
                class="border border-zinc-300 text-zinc-600 px-6 py-3.5 rounded-3xl flex items-center gap-2 hover:bg-zinc-50">
            <i class="fa-solid fa-check-double"></i> Mark all as read
        </button>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden divide-y">
        <template x-if="notifications.length === 0">
            <div class="px-8 py-16 text-center text-zinc-400">
                <i class="fa-regular fa-bell text-4xl mb-3 block"></i>
                No notifications
            </div>
        </template>
        <template x-for="n in notifications" :key="n.id">
            <div @click="markNotificationRead(n)"
                 :class="n.read ? '' : 'bg-red-50'"
                 class="flex items-start gap-4 px-6 lg:px-8 py-5 hover:bg-zinc-50 cursor-pointer transition-colors">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0" :class="n.tone">
                    <i class="fa-solid" :class="n.icon"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="font-medium" x-text="n.title"></span>
                        <span x-show="!n.read" x-cloak class="w-2 h-2 rounded-full bg-red-500 shrink-0"></span>
                    </div>
                    <p class="text-sm text-zinc-500 mt-0.5" x-text="n.body"></p>
                </div>
                <div class="text-xs text-zinc-400 shrink-0 whitespace-nowrap" x-text="n.time"></div>
            </div>
        </template>
    </div>
</div>
