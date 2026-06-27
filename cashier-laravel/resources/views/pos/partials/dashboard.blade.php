<!-- DASHBOARD -->
<div x-show="activeTab === 'dashboard'" class="space-y-6">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
            <div class="bg-white rounded-3xl p-7 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-zinc-500 text-sm">Total Revenue</p>
                        <p class="text-3xl font-semibold mt-3" x-text="formatRp(totalRevenue)"></p>
                    </div>
                    <div class="text-emerald-500">
                        <i class="fa-solid fa-arrow-trend-up text-4xl"></i>
                    </div>
                </div>
                <p class="text-xs text-emerald-600 mt-6">↑ 24% from yesterday</p>
            </div>

            <div class="bg-white rounded-3xl p-7 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-zinc-500 text-sm" x-text="activeUnit === 'gym' ? 'Active Members' : 'Total Items'"></p>
                        <p class="text-4xl font-semibold mt-3" x-text="activeUnit === 'gym' ? members.length : itemCount(activeUnit)"></p>
                    </div>
                    <div class="text-blue-500">
                        <i class="fa-solid text-4xl" :class="activeUnit === 'gym' ? 'fa-user-plus' : 'fa-box'"></i>
                    </div>
                </div>
                <p class="text-xs text-zinc-400 mt-6" x-text="activeUnit === 'gym' ? 'Across all gym packages' : (unitInfo[activeUnit].label + ' catalog')"></p>
            </div>

            <div class="bg-white rounded-3xl p-7 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-zinc-500 text-sm">Transactions</p>
                        <p class="text-4xl font-semibold mt-3" x-text="unitTransactions.length"></p>
                    </div>
                    <div class="text-amber-500">
                        <i class="fa-solid fa-receipt text-4xl"></i>
                    </div>
                </div>
                <p class="text-xs text-zinc-400 mt-6">Today's activity</p>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 bg-white rounded-3xl p-7 shadow-sm">
            <h3 class="font-semibold mb-5">Recent Activity</h3>
            <div class="space-y-5 text-sm">
                <template x-if="unitTransactions.length === 0">
                    <div class="text-zinc-300 text-sm py-6 text-center">No activity yet</div>
                </template>
                <template x-for="t in unitTransactions" :key="t.id">
                    <div class="flex justify-between">
                        <div>
                            <span class="font-medium" x-text="t.id"></span>
                            <span class="text-xs text-zinc-400 ml-2" x-text="t.unit"></span>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold" x-text="formatRp(t.amount)"></div>
                            <div class="text-xs text-zinc-400" x-text="t.time"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Active unit overview -->
    <div>
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 px-1">
            <span x-text="unitInfo[activeUnit].label"></span> Overview
        </div>
        <div @click="activeTab = 'inventory'" class="bg-white rounded-3xl p-7 shadow-sm cursor-pointer hover:shadow-md transition max-w-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl">
                    <i class="fa-solid" :class="unitInfo[activeUnit].icon"></i>
                </div>
                <div>
                    <div class="font-semibold text-lg" x-text="unitInfo[activeUnit].label"></div>
                    <div class="text-xs text-zinc-400" x-text="unitInfo[activeUnit].tag"></div>
                </div>
            </div>
            <div class="flex gap-8 mt-6 text-sm">
                <div>
                    <div class="text-2xl font-semibold" x-text="itemCount(activeUnit)"></div>
                    <div class="text-zinc-400 text-xs">Items</div>
                </div>
                <div>
                    <div class="text-2xl font-semibold" x-text="catCount(activeUnit)"></div>
                    <div class="text-zinc-400 text-xs">Categories</div>
                </div>
            </div>
        </div>
    </div>
</div>
