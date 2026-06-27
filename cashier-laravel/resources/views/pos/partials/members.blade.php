<!-- MEMBERS -->
<div x-show="activeTab === 'members'">
    <div class="flex flex-wrap gap-4 justify-between items-center mb-8">
        <h2 class="text-2xl lg:text-3xl font-semibold">Gym Memberships</h2>
        <button x-show="isManager" @click="openMemberModal()" class="bg-red-600 text-white px-6 py-3.5 rounded-3xl flex items-center gap-2 hover:bg-red-700">
            <i class="fa-solid fa-plus"></i> New Member
        </button>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px]">
                <thead class="bg-zinc-50">
                    <tr>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">ID</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Name</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Gender</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Package</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Type</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Registered</th>
                        <th class="text-left py-5 px-8 text-xs font-medium text-zinc-500">Expires</th>
                        <th class="w-32"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <template x-if="filteredMembers.length === 0">
                        <tr><td colspan="8" class="px-8 py-12 text-center text-zinc-400">No members found</td></tr>
                    </template>
                    <template x-for="m in filteredMembers" :key="m.id">
                        <tr class="hover:bg-zinc-50">
                            <td class="px-8 py-5 font-medium" x-text="m.id"></td>
                            <td class="px-8 py-5" x-text="m.name"></td>
                            <td class="px-8 py-5 text-zinc-500" x-text="m.gender || '—'"></td>
                            <td class="px-8 py-5" x-text="m.package"></td>
                            <td class="px-8 py-5">
                                <span class="px-4 py-1 text-xs rounded-3xl" :class="m.type === 'Tourist' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700'" x-text="m.type"></span>
                            </td>
                            <td class="px-8 py-5 text-zinc-500" x-text="m.registrationDate || '—'"></td>
                            <td class="px-8 py-5 text-zinc-500" x-text="m.expiry"></td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="viewMember(m)" class="w-9 h-9 flex items-center justify-center rounded-2xl text-zinc-400 hover:bg-zinc-100 hover:text-red-600" title="View details" aria-label="View member">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button x-show="isManager" @click="askDeleteMember(m)" class="w-9 h-9 flex items-center justify-center rounded-2xl text-zinc-400 hover:bg-zinc-100 hover:text-red-600" title="Move to Trash" aria-label="Delete member">
                                        <i class="fa-solid fa-trash"></i>
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
