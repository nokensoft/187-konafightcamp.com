<!-- INVENTORY -->
<div x-show="activeTab === 'inventory'">
    <div class="flex flex-wrap gap-4 justify-between items-center mb-8">
        <h2 class="text-2xl lg:text-3xl font-semibold" x-text="activeUnit === 'gym' ? 'Packages & Categories' : activeUnit === 'store' ? 'Store Catalog' : 'Kitchen Menu'"></h2>
        <button x-show="isManager" @click="openItemModal()" class="bg-red-600 text-white px-7 py-3.5 rounded-3xl flex items-center gap-2 hover:bg-red-700">
            <i class="fa-solid fa-plus"></i> Add New
        </button>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-3 bg-white rounded-3xl p-6">
            <h3 class="font-medium mb-4">Categories</h3>
            <div class="space-y-3">
                <div @click="activeCategory = null"
                     class="px-5 py-4 rounded-2xl text-sm cursor-pointer transition-colors"
                     :class="!activeCategory ? 'bg-red-50 text-red-700 font-medium' : 'bg-zinc-50 hover:bg-zinc-100'">All Items</div>
                <template x-for="cat in unitCategories" :key="cat.name">
                    <div @click="selectCategory(cat.name)"
                         class="group px-5 py-4 rounded-2xl text-sm cursor-pointer transition-colors"
                         :class="activeCategory === cat.name ? 'bg-red-50 text-red-700 font-medium' : 'bg-zinc-50 hover:bg-zinc-100'">
                        <div class="flex items-center justify-between gap-2">
                            <span x-text="cat.name"></span>
                            <i x-show="isManager" @click.stop="openCategoryModal(cat)" class="fa-solid fa-pen text-xs text-zinc-300 hover:text-red-500 cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div x-show="cat.description" class="text-xs font-normal text-zinc-400 mt-1 leading-snug" x-text="cat.description"></div>
                    </div>
                </template>
            </div>
            <button x-show="isManager" @click="openCategoryModal()" class="text-red-600 text-sm mt-6 flex items-center gap-1"><i class="fa-solid fa-plus"></i> New Category</button>
        </div>
        <div class="col-span-12 lg:col-span-9 bg-white rounded-3xl p-6 overflow-x-auto">
            <table class="w-full min-w-[560px]">
                <thead>
                    <tr class="text-xs text-zinc-400 border-b">
                        <th class="py-6 px-6 text-left">Item</th>
                        <th class="py-6 px-6 text-left">Category</th>
                        <th class="py-6 px-6 text-left">Price</th>
                        <th class="py-6 px-6 text-left">Stock</th>
                        <th class="py-6 px-6 w-28"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-if="inventoryItems.length === 0">
                        <tr><td colspan="5" class="px-6 py-12 text-center text-zinc-400">No items found</td></tr>
                    </template>
                    <template x-for="item in inventoryItems" :key="item.id">
                        <tr class="border-b last:border-none hover:bg-zinc-50">
                            <td class="px-6 py-6">
                                <span class="mr-2" x-text="item.emoji || '📦'"></span>
                                <span x-text="item.name"></span>
                            </td>
                            <td class="px-6 py-6 text-zinc-500" x-text="item.cat"></td>
                            <td class="px-6 py-6 font-medium" x-text="formatRp(item.price)"></td>
                            <td class="px-6 py-6" x-text="item.stock"></td>
                            <td class="px-6 py-6 text-center">
                                <div x-show="isManager" class="flex items-center justify-center gap-4">
                                    <i @click="openItemModal(item)" class="fa-solid fa-pen text-zinc-400 cursor-pointer hover:text-red-500" title="Edit"></i>
                                    <i @click="askDeleteItem(item)" class="fa-solid fa-trash text-zinc-400 cursor-pointer hover:text-red-500" title="Move to Trash"></i>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
