<!-- TRASH (recycle bin) — manager only -->
<div x-show="activeTab === 'trash'" x-cloak>
    <div class="flex flex-wrap gap-4 justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl lg:text-3xl font-semibold">Trash</h2>
            <p class="text-zinc-400 text-sm mt-1">Deleted members and items. Restore them or remove permanently.</p>
        </div>
        <button x-show="trashCount > 0" @click="askEmptyTrash()"
                class="border border-zinc-300 text-zinc-600 px-6 py-3.5 rounded-3xl flex items-center gap-2 hover:bg-zinc-50">
            <i class="fa-solid fa-trash-can"></i> Empty Trash
        </button>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px]">
                <thead class="bg-zinc-50">
                    <tr>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Item</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Type</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Deleted</th>
                        <th class="w-64"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <template x-if="trash.length === 0">
                        <tr><td colspan="4" class="px-8 py-16 text-center text-zinc-400">
                            <i class="fa-regular fa-trash-can text-4xl mb-3 block"></i>
                            Trash is empty
                        </td></tr>
                    </template>
                    <template x-for="entry in trash" :key="entry.trashId">
                        <tr class="hover:bg-zinc-50">
                            <td class="px-8 py-5 font-medium" x-text="entry.name"></td>
                            <td class="px-8 py-5">
                                <span class="px-4 py-1 text-xs rounded-3xl bg-zinc-100 text-zinc-600" x-text="entry.typeLabel"></span>
                            </td>
                            <td class="px-8 py-5 text-zinc-500" x-text="entry.deletedAt"></td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="restoreFromTrash(entry)"
                                            class="px-4 py-2 text-xs rounded-2xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 flex items-center gap-2">
                                        <i class="fa-solid fa-rotate-left"></i> Restore
                                    </button>
                                    <button @click="askPurge(entry)"
                                            class="px-4 py-2 text-xs rounded-2xl bg-red-50 text-red-600 hover:bg-red-100 flex items-center gap-2">
                                        <i class="fa-solid fa-xmark"></i> Delete Permanently
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
