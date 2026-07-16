<!-- INVENTORY -->
<div x-show="activeTab === 'inventory'">
    <div class="flex flex-wrap gap-4 justify-between items-center mb-8">
        <h2 class="text-2xl lg:text-3xl font-semibold" x-text="activeUnit === 'gym' ? 'Packages & Categories' : activeUnit === 'store' ? 'Store Catalog' : 'Kitchen Menu'"></h2>
        <button @click="openItemModal()" class="bg-red-600 text-white px-7 py-3.5 rounded-3xl flex items-center gap-2 hover:bg-red-700">
            <i class="fa-solid fa-plus"></i> Add New
        </button>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-3 bg-white rounded-3xl p-6">
            <h3 class="font-medium mb-4">Categories</h3>
            <div class="space-y-3">
                <div @click="activeCategory = null"
                     class="px-5 py-4 rounded-2xl text-sm cursor-pointer transition-colors"
                     :class="!activeCategory ? 'bg-red-50 text-red-700 font-medium' : 'bg-zinc-50 hover:bg-zinc-100'">
                    <div class="flex items-center justify-between gap-2">
                        <span>All Items</span>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full"
                              :class="!activeCategory ? 'bg-red-100 text-red-600' : 'bg-zinc-200 text-zinc-600'"
                              x-text="catalog.length"></span>
                    </div>
                </div>
                <template x-for="cat in unitCategories" :key="cat.name">
                    <div @click="selectCategory(cat.name)"
                         class="group px-5 py-4 rounded-2xl text-sm cursor-pointer transition-colors"
                         :class="activeCategory === cat.name ? 'bg-red-50 text-red-700 font-medium' : 'bg-zinc-50 hover:bg-zinc-100'">
                        <div class="flex items-center justify-between gap-2">
                            <span x-text="cat.name"></span>
                            <div class="flex items-center gap-2 shrink-0">
                                <i @click.stop="openCategoryModal(cat)" class="fa-solid fa-pen text-xs text-zinc-300 hover:text-red-500 cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full"
                                      :class="activeCategory === cat.name ? 'bg-red-100 text-red-600' : 'bg-zinc-200 text-zinc-600'"
                                      x-text="categoryItemCount(cat.name)"></span>
                            </div>
                        </div>
                        <div x-show="cat.description" class="text-xs font-normal text-zinc-400 mt-1 leading-snug" x-text="cat.description"></div>
                    </div>
                </template>
            </div>
            <button @click="openCategoryModal()" class="text-red-600 text-sm mt-6 flex items-center gap-1"><i class="fa-solid fa-plus"></i> New Category</button>
        </div>
        <div class="col-span-12 lg:col-span-9 bg-white rounded-3xl p-6">
            <!-- Filter & search toolbar -->
            <div class="flex flex-col md:flex-row md:items-center gap-3 mb-6">
                <div class="relative flex-1">
                    <input x-model="inventoryQuery" type="text" placeholder="Search items..."
                           class="w-full bg-zinc-50 border border-zinc-200 focus:border-red-300 rounded-3xl py-3 pl-11 pr-4 outline-none text-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-zinc-400"></i>
                </div>
                <select x-model="activeCategory"
                        class="bg-zinc-50 border border-zinc-200 focus:border-red-300 rounded-3xl py-3 px-5 outline-none text-sm">
                    <option :value="null">All Categories</option>
                    <template x-for="c in unitCategories" :key="c.name">
                        <option :value="c.name" x-text="c.name"></option>
                    </template>
                </select>
                <select x-model="stockFilter"
                        class="bg-zinc-50 border border-zinc-200 focus:border-red-300 rounded-3xl py-3 px-5 outline-none text-sm">
                    <option value="all">All Stock</option>
                    <option value="in">In Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                </select>
                <button x-show="hasInventoryFilters" x-cloak @click="clearInventoryFilters()"
                        class="py-3 px-5 rounded-3xl border border-zinc-200 text-zinc-500 hover:bg-zinc-50 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-xmark"></i> Reset
                </button>
            </div>

            <div class="overflow-x-auto">
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
                                <span x-text="item.name"></span>
                            </td>
                            <td class="px-6 py-6 text-zinc-500" x-text="item.cat"></td>
                            <td class="px-6 py-6 font-medium">
                                <template x-if="item.hasDiscount">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span x-text="formatRp(item.finalPrice)"></span>
                                        <span class="text-xs text-zinc-400 line-through" x-text="formatRp(item.price)"></span>
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600" x-text="discountBadge(item)"></span>
                                    </div>
                                </template>
                                <template x-if="!item.hasDiscount">
                                    <span x-text="formatRp(item.price)"></span>
                                </template>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2">
                                    <span x-text="item.stock"></span>
                                    <span class="text-xs px-2 py-0.5 rounded-full"
                                          :class="{ 'bg-emerald-50 text-emerald-600': stockStatus(item) === 'in', 'bg-amber-50 text-amber-600': stockStatus(item) === 'low', 'bg-red-50 text-red-600': stockStatus(item) === 'out' }"
                                          x-text="stockLabel(item)"></span>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <div class="flex items-center justify-center gap-4">
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
</div>
