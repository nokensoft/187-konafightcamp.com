<!-- USER LOGS (simulation) -->
<div x-show="activeTab === 'userLogs'" x-cloak>
    <div class="flex flex-wrap gap-4 justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl lg:text-3xl font-semibold">User Logs</h2>
            <p class="text-zinc-400 text-sm mt-1">Recent staff activity and system events.</p>
        </div>
        <div class="relative w-full sm:w-72">
            <input x-model="logSearch"
                   type="text"
                   placeholder="Search logs..."
                   class="w-full bg-zinc-100 border border-transparent focus:border-red-200 rounded-3xl py-2.5 pl-11 pr-4 outline-none text-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3 text-zinc-400"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px]">
                <thead class="bg-zinc-50">
                    <tr>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">User</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Action</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Details</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Time</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <template x-if="filteredLogs.length === 0">
                        <tr><td colspan="5" class="px-8 py-16 text-center text-zinc-400">
                            <i class="fa-regular fa-clock text-4xl mb-3 block"></i>
                            No logs found
                        </td></tr>
                    </template>
                    <template x-for="log in filteredLogs" :key="log.id">
                        <tr class="hover:bg-zinc-50">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-zinc-900 text-white rounded-2xl flex items-center justify-center text-xs font-medium shrink-0"
                                         x-text="log.user.slice(0, 2).toUpperCase()"></div>
                                    <div>
                                        <div class="font-medium" x-text="log.user"></div>
                                        <div class="text-xs text-zinc-400 capitalize" x-text="log.role"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-4 py-1 text-xs rounded-3xl" :class="log.tone" x-text="log.action"></span>
                            </td>
                            <td class="px-8 py-5 text-zinc-600" x-text="log.details"></td>
                            <td class="px-8 py-5 text-zinc-500 whitespace-nowrap" x-text="log.time"></td>
                            <td class="px-8 py-5 text-zinc-400 font-mono text-sm" x-text="log.ip"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
