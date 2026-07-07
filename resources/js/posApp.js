import qrcode from 'qrcode-generator';
import html2canvas from 'html2canvas';

/**
 * Kona Fight Camp POS — Alpine component.
 *
 * Ported from the static prototype (cashier/index.html). Phase 1 keeps all
 * data in memory; initial catalog data + the current user's role are injected
 * from Blade via @js(...). The relational DB + CRUD layer comes in a later phase.
 *
 * @param {object} initial  { gym, store, kitchen } data from the controller
 * @param {string} role     'manager' | 'cashier'
 */
export default (initial = {}, role = 'cashier') => ({
    // ---- navigation / ui state ----
    activeTab: 'dashboard',
    activeUnit: 'gym',
    searchQuery: '',
    logSearch: '',
    activeCategory: null,
    sidebarOpen: false,
    sidebarCollapsed: false,
    loading: true,
    role: role,
    globalTabs: ['notifications', 'userLogs'],

    // ---- static unit meta (icons/labels for sidebar & overview) ----
    unitKeys: ['gym', 'store', 'kitchen'],
    unitInfo: {
        gym:     { label: 'Gym',     tag: 'Membership', icon: 'fa-dumbbell' },
        store:   { label: 'Store',   tag: 'Equipment',  icon: 'fa-bag-shopping' },
        kitchen: { label: 'Kitchen', tag: 'F&B',        icon: 'fa-utensils' },
    },

    // ---- per-unit sidebar navigation ----
    navConfig: {
        gym: [
            { tab: 'dashboard', label: 'Dashboard',    icon: 'fa-house' },
            { tab: 'pos',       label: 'POS Terminal', icon: 'fa-cash-register' },
            { tab: 'members',   label: 'Members',      icon: 'fa-users' },
            { tab: 'inventory', label: 'Packages',     icon: 'fa-layer-group' },
        ],
        store: [
            { tab: 'dashboard', label: 'Dashboard',    icon: 'fa-house' },
            { tab: 'pos',       label: 'POS Terminal', icon: 'fa-cash-register' },
            { tab: 'inventory', label: 'Products',     icon: 'fa-boxes-stacked' },
        ],
        kitchen: [
            { tab: 'dashboard', label: 'Dashboard',    icon: 'fa-house' },
            { tab: 'pos',       label: 'POS Terminal', icon: 'fa-cash-register' },
            { tab: 'inventory', label: 'Menu',         icon: 'fa-utensils' },
        ],
    },

    // ---- data injected from the server ----
    units: {
        gym: (initial && initial.gym) || null,
        store: (initial && initial.store) || null,
        kitchen: (initial && initial.kitchen) || null,
    },

    // ---- cart & transactions ----
    cart: [],
    transactions: [
        { id: 'TRX001', unit: 'Gym',     amount: 450000, status: 'Completed', time: '10:32' },
        { id: 'TRX002', unit: 'Store',   amount: 125000, status: 'Completed', time: '10:15' },
        { id: 'TRX003', unit: 'Kitchen', amount: 89000,  status: 'Completed', time: '09:54' },
    ],

    // ---- notifications (simulation) ----
    notifications: [
        { id: 1, title: 'Low stock alert',        body: 'Protein Bar is down to 4 units in Store.',       time: '5m ago',    read: false, icon: 'fa-triangle-exclamation', tone: 'bg-amber-50 text-amber-600' },
        { id: 2, title: 'New membership sold',     body: 'Andi Pratama purchased a 3 Months gym package.', time: '32m ago',   read: false, icon: 'fa-user-plus',            tone: 'bg-emerald-50 text-emerald-600' },
        { id: 3, title: 'Daily target reached',    body: 'Gym revenue passed Rp 5.000.000 today.',          time: '1h ago',    read: false, icon: 'fa-arrow-trend-up',        tone: 'bg-blue-50 text-blue-600' },
        { id: 4, title: 'Kitchen order completed', body: 'Order TRX003 was served and closed.',             time: '3h ago',    read: true,  icon: 'fa-utensils',             tone: 'bg-zinc-100 text-zinc-500' },
        { id: 5, title: 'Shift started',           body: 'Cashier signed in at the front desk.',            time: 'Yesterday', read: true,  icon: 'fa-right-to-bracket',      tone: 'bg-zinc-100 text-zinc-500' },
    ],

    // ---- user activity logs (simulation) ----
    userLogs: [
        { id: 1, user: 'Manager', role: 'manager', action: 'Login',    tone: 'bg-emerald-100 text-emerald-700', details: 'Signed in to the dashboard',        time: '27 Jun 2026 08:02', ip: '192.168.1.10' },
        { id: 2, user: 'Cashier', role: 'cashier', action: 'Checkout', tone: 'bg-blue-100 text-blue-700',       details: 'Completed transaction TRX001 (Gym)', time: '27 Jun 2026 08:15', ip: '192.168.1.24' },
        { id: 3, user: 'Manager', role: 'manager', action: 'Update',   tone: 'bg-amber-100 text-amber-700',     details: 'Edited package "3 Months" price',    time: '27 Jun 2026 08:20', ip: '192.168.1.10' },
        { id: 4, user: 'Cashier', role: 'cashier', action: 'Create',   tone: 'bg-indigo-100 text-indigo-700',   details: 'Added new member Andi Pratama',      time: '27 Jun 2026 08:31', ip: '192.168.1.24' },
        { id: 5, user: 'Manager', role: 'manager', action: 'Delete',   tone: 'bg-red-100 text-red-700',         details: 'Moved product "Old Towel" to Trash', time: '27 Jun 2026 09:05', ip: '192.168.1.10' },
        { id: 6, user: 'Cashier', role: 'cashier', action: 'Logout',   tone: 'bg-zinc-100 text-zinc-600',       details: 'Signed out',                         time: '26 Jun 2026 17:40', ip: '192.168.1.24' },
    ],

    // ---- recycle bin (Trash) ----
    trash: [],

    // ---- modal state ----
    memberModal:   { open: false, saving: false, errors: [], name: '', email: '', password: '', password_confirmation: '', phone: '', dateOfBirth: '', gender: 'Male', type: 'Local', package: '', idNumber: '', idPhoto: null, idPhotoPreview: '', idPhotoDragging: false, address: '', emergencyContactName: '', emergencyContactPhone: '', notes: '' },
    memberView:    { open: false, member: null },
    itemModal:     { open: false, editingId: null, name: '', price: '', cat: '', stock: '' },
    categoryModal: { open: false, editingName: null, name: '', description: '' },
    confirmModal:  { open: false, title: '', message: '', kind: null, ref: null },
    checkoutModal: { open: false },
    receipt: { ref: '', unit: '', date: '', time: '', items: [], subtotal: 0, tax: 0, total: 0 },
    receiptQrUrl: '',
    toast: { show: false, message: '' },
    _toastTimer: null,

    // ---- lifecycle ----
    init() {
        this.normalizeCategories();
        this.loading = false;
        this.$watch('activeUnit', () => {
            this.activeCategory = null;
            if (!this.unitNav.some(n => n.tab === this.activeTab) && !this.globalTabs.includes(this.activeTab)) this.activeTab = 'dashboard';
        });
    },

    // normalize categories to objects { name, description } (supports legacy string arrays)
    normalizeCategories() {
        this.unitKeys.forEach(u => {
            const unit = this.units[u];
            if (unit && Array.isArray(unit.categories)) {
                unit.categories = unit.categories.map(c =>
                    typeof c === 'string'
                        ? { name: c, description: '' }
                        : { name: c.name, description: c.description || '' }
                );
            }
        });
    },

    // ---- role ----
    get isManager() { return this.role === 'manager'; },

    // ---- computed: navigation ----
    get unitNav() {
        const nav = [...(this.navConfig[this.activeUnit] || [])];
        if (this.isManager) nav.push({ tab: 'trash', label: 'Trash', icon: 'fa-trash-can' });
        return nav;
    },

    // ---- computed: general (non-unit) navigation ----
    get generalNav() {
        const nav = [{ tab: 'notifications', label: 'Notifications', icon: 'fa-bell' }];
        if (this.isManager) nav.push({ tab: 'userLogs', label: 'User Logs', icon: 'fa-clock-rotate-left' });
        return nav;
    },

    // ---- computed: current unit data ----
    get currentUnit() { return this.units[this.activeUnit] || { catalog: [], categories: [], members: [] }; },
    get catalog() { return this.currentUnit.catalog || []; },
    get unitCategories() { return this.currentUnit.categories || []; },
    get members() { return (this.units.gym && this.units.gym.members) || []; },
    get itemNoun() { return this.activeUnit === 'store' ? 'Product' : this.activeUnit === 'kitchen' ? 'Menu Item' : 'Package'; },
    get pageTitle() {
        if (this.activeTab === 'inventory') {
            const nav = (this.navConfig[this.activeUnit] || []).find(n => n.tab === 'inventory');
            return nav ? nav.label : 'Inventory';
        }
        return { dashboard: 'Dashboard', pos: 'Point of Sale', members: 'Members', trash: 'Trash', notifications: 'Notifications', userLogs: 'User Logs' }[this.activeTab] || 'Kona Fight Camp';
    },
    get membershipPackages() {
        const names = ((this.units.gym && this.units.gym.catalog) || []).map(i => i.name);
        return names.length ? names : ['1 Month', '3 Months', '12 Months'];
    },

    // ---- computed: filtering ----
    matches(text) {
        const q = this.searchQuery.toLowerCase().trim();
        if (!q) return true;
        return (text || '').toLowerCase().includes(q);
    },
    get posItems() { return this.catalog.filter(i => this.matches(i.name + ' ' + i.cat)); },
    get inventoryItems() {
        return this.catalog
            .filter(i => !this.activeCategory || i.cat === this.activeCategory)
            .filter(i => this.matches(i.name + ' ' + i.cat));
    },
    get filteredMembers() {
        return this.members.filter(m => this.matches(`${m.id} ${m.name} ${m.package} ${m.type}`));
    },

    // ---- computed: dashboard stats ----
    get unitTransactions() {
        const label = this.unitInfo[this.activeUnit].label;
        return this.transactions.filter(t => t.unit === label);
    },
    get totalRevenue() { return this.unitTransactions.reduce((s, t) => s + (t.amount || 0), 0); },
    itemCount(u) { return ((this.units[u] || {}).catalog || []).length; },
    catCount(u) { return ((this.units[u] || {}).categories || []).length; },

    // ---- computed: cart totals ----
    get subtotal() { return this.cart.reduce((s, i) => s + i.price * i.qty, 0); },
    get tax() { return Math.round(this.subtotal * 0.11); },
    get total() { return this.subtotal + this.tax; },
    get cartCount() { return this.cart.reduce((s, i) => s + i.qty, 0); },

    // ---- cart actions ----
    addToCart(item) {
        const existing = this.cart.find(i => i.id === item.id);
        if (existing) existing.qty++;
        else this.cart.push({ id: item.id, name: item.name, price: item.price, cat: item.cat, qty: 1 });
        this.showToast(item.name + ' added to cart');
    },
    cartQty(idx, delta) {
        this.cart[idx].qty += delta;
        if (this.cart[idx].qty < 1) this.cart.splice(idx, 1);
    },
    removeCartItem(idx) { this.cart.splice(idx, 1); },
    clearCart() { this.cart = []; },
    showToast(message) {
        this.toast.message = message;
        this.toast.show = true;
        if (this._toastTimer) clearTimeout(this._toastTimer);
        this._toastTimer = setTimeout(() => { this.toast.show = false; }, 2800);
    },
    goToCart() {
        this.toast.show = false;
        const el = document.getElementById('cartCard');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    },
    checkout() {
        if (this.cart.length === 0) return;
        const subtotal = this.subtotal;
        const tax = this.tax;
        const total = this.total;
        const ref = 'TRX' + String(this.transactions.length + 1).padStart(3, '0');
        const now = new Date();
        const time = now.toTimeString().slice(0, 5);
        this.transactions.unshift({
            id: ref,
            unit: this.unitInfo[this.activeUnit].label,
            amount: total,
            status: 'Completed',
            time: time,
        });
        this.receipt = {
            ref: ref,
            unit: this.unitInfo[this.activeUnit].label,
            date: now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }),
            time: time,
            items: this.cart.map(i => ({ name: i.name, qty: i.qty, price: i.price, lineTotal: i.price * i.qty })),
            subtotal: subtotal,
            tax: tax,
            total: total,
        };
        this.receiptQrUrl = '';
        this.toast.show = false;
        this.checkoutModal.open = true;
        this.clearCart();
        this.renderReceiptQR();
    },

    // ---- receipt: QR code + image download ----
    receiptText() {
        const r = this.receipt;
        const lines = [
            'KONA FIGHT CAMP',
            'Ref: ' + r.ref,
            'Unit: ' + r.unit,
            'Date: ' + r.date + ' ' + r.time,
            '----------------------------',
        ];
        r.items.forEach(i => lines.push(i.name + ' x' + i.qty + ' = ' + this.formatRp(i.lineTotal)));
        lines.push('----------------------------');
        lines.push('Subtotal: ' + this.formatRp(r.subtotal));
        lines.push('Tax 11%: ' + this.formatRp(r.tax));
        lines.push('TOTAL: ' + this.formatRp(r.total));
        lines.push('Thank you!');
        return lines.join('\n');
    },
    renderReceiptQR() {
        if (!this.receipt.ref) { this.receiptQrUrl = ''; return; }
        try {
            const qr = qrcode(0, 'M');
            qr.addData(this.receiptText());
            qr.make();
            this.receiptQrUrl = qr.createDataURL(6, 12);
        } catch (e) {
            console.error('QR generation failed:', e);
            this.receiptQrUrl = '';
        }
    },
    async downloadReceipt() {
        const el = document.getElementById('receiptContent');
        if (!el) return;
        try {
            const canvas = await html2canvas(el, { backgroundColor: '#ffffff', scale: 2 });
            const link = document.createElement('a');
            link.download = 'receipt-' + (this.receipt.ref || 'kfc') + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        } catch (e) {
            console.error('Receipt download failed:', e);
            alert('Failed to generate receipt image.');
        }
    },

    // ---- member actions ----
    openMemberModal() {
        this.memberModal = {
            open: true,
            saving: false,
            errors: [],
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            phone: '',
            dateOfBirth: '',
            gender: 'Male',
            type: 'Local',
            package: '',
            idNumber: '',
            idPhoto: null,
            idPhotoPreview: '',
            idPhotoDragging: false,
            address: '',
            emergencyContactName: '',
            emergencyContactPhone: '',
            notes: '',
        };
    },

    handleIdPhotoFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        this.memberModal.idPhoto = file;
        const reader = new FileReader();
        reader.onload = (e) => { this.memberModal.idPhotoPreview = e.target.result; };
        reader.readAsDataURL(file);
    },

    clearIdPhoto() {
        this.memberModal.idPhoto = null;
        this.memberModal.idPhotoPreview = '';
        const input = document.getElementById('idPhotoInput');
        if (input) input.value = '';
    },
    viewMember(m) { this.memberView = { open: true, member: m }; },

    // Persist the member on the server (creates a login account + gym profile),
    // then insert the returned record into the in-memory list.
    async saveMember() {
        if (!this.units.gym || this.memberModal.saving) return;
        this.memberModal.saving = true;
        this.memberModal.errors = [];

        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        const fd = new FormData();
        fd.append('name',                     (this.memberModal.name || '').trim());
        fd.append('email',                    (this.memberModal.email || '').trim().toLowerCase());
        fd.append('password',                 this.memberModal.password);
        fd.append('password_confirmation',    this.memberModal.password_confirmation);
        fd.append('phone',                    (this.memberModal.phone || '').trim());
        fd.append('date_of_birth',            this.memberModal.dateOfBirth || '');
        fd.append('gender',                   this.memberModal.gender);
        fd.append('membership_type',          this.memberModal.type);
        fd.append('membership_package',       this.memberModal.package || '');
        fd.append('id_number',                (this.memberModal.idNumber || '').trim());
        fd.append('address',                  (this.memberModal.address || '').trim());
        fd.append('emergency_contact_name',   (this.memberModal.emergencyContactName || '').trim());
        fd.append('emergency_contact_phone',  (this.memberModal.emergencyContactPhone || '').trim());
        fd.append('notes',                    (this.memberModal.notes || '').trim());
        if (this.memberModal.idPhoto) fd.append('id_photo', this.memberModal.idPhoto);

        try {
            const res = await fetch('/members', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                },
                body: fd,
            });

            if (res.status === 422) {
                const data = await res.json();
                this.memberModal.errors = Object.values(data.errors || {}).flat();
                return;
            }
            if (!res.ok) {
                this.memberModal.errors = ['Something went wrong. Please try again.'];
                return;
            }

            const data = await res.json();
            if (data.member) this.units.gym.members.unshift(data.member);
            this.memberModal.open = false;
            this.showToast((data.member?.name || 'Member') + ' added');
        } catch (e) {
            console.error('Save member failed:', e);
            this.memberModal.errors = ['Network error. Please try again.'];
        } finally {
            this.memberModal.saving = false;
        }
    },
    askDeleteMember(m) {
        this.confirmModal = {
            open: true,
            title: 'Delete Member',
            message: `Move ${m.name} (${m.id}) to Trash?`,
            kind: 'member',
            ref: m.id,
        };
    },

    // ---- item actions ----
    openItemModal(item = null) {
        if (item) {
            this.itemModal = { open: true, editingId: item.id, name: item.name, price: item.price, cat: item.cat, stock: item.stock };
        } else {
            this.itemModal = { open: true, editingId: null, name: '', price: '', cat: (this.unitCategories[0] && this.unitCategories[0].name) || 'General', stock: '' };
        }
    },
    saveItem() {
        const name = (this.itemModal.name || '').trim();
        if (!name) return;
        const list = this.catalog;
        if (this.itemModal.editingId) {
            const it = list.find(i => i.id === this.itemModal.editingId);
            if (it) {
                it.name = name;
                it.price = Number(this.itemModal.price) || 0;
                it.cat = this.itemModal.cat || 'General';
                it.stock = Number(this.itemModal.stock) || 0;
            }
        } else {
            list.unshift({
                id: Date.now(),
                name: name,
                cat: this.itemModal.cat || 'General',
                price: Number(this.itemModal.price) || 0,
                stock: Number(this.itemModal.stock) || 0,
                emoji: '🆕',
            });
        }
        this.itemModal.open = false;
    },
    askDeleteItem(item) {
        this.confirmModal = {
            open: true,
            title: 'Delete ' + this.itemNoun,
            message: `Move "${item.name}" to Trash?`,
            kind: 'item',
            ref: item.id,
        };
    },

    // ---- unified delete confirmation (soft-delete to Trash) ----
    confirmDelete() {
        if (this.confirmModal.kind === 'member') this._trashMember(this.confirmModal.ref);
        else if (this.confirmModal.kind === 'item') this._trashItem(this.confirmModal.ref);
        this.confirmModal.open = false;
    },
    _trashMember(id) {
        if (!this.units.gym) return;
        const m = (this.units.gym.members || []).find(x => x.id === id);
        if (!m) return;
        this.units.gym.members = this.units.gym.members.filter(x => x.id !== id);
        this.trash.unshift({
            trashId: this._trashId(),
            type: 'member',
            typeLabel: 'Member',
            unit: 'gym',
            name: `${m.name} (${m.id})`,
            data: m,
            deletedAt: this._stamp(),
        });
    },
    _trashItem(id) {
        const unitKey = this.activeUnit;
        const unit = this.units[unitKey];
        if (!unit) return;
        const it = (unit.catalog || []).find(x => x.id === id);
        if (!it) return;
        unit.catalog = unit.catalog.filter(x => x.id !== id);
        this.trash.unshift({
            trashId: this._trashId(),
            type: 'item',
            typeLabel: this.unitInfo[unitKey].label + ' ' + (unitKey === 'store' ? 'Product' : unitKey === 'kitchen' ? 'Menu Item' : 'Package'),
            unit: unitKey,
            name: it.name,
            data: it,
            deletedAt: this._stamp(),
        });
    },

    // ---- trash (recycle bin) actions ----
    get trashCount() { return this.trash.length; },
    restoreFromTrash(entry) {
        if (entry.type === 'member') {
            if (!this.units.gym) return;
            if (!this.units.gym.members) this.units.gym.members = [];
            this.units.gym.members.unshift(entry.data);
        } else if (entry.type === 'item') {
            const unit = this.units[entry.unit];
            if (!unit) return;
            if (!unit.catalog) unit.catalog = [];
            unit.catalog.unshift(entry.data);
        }
        this.trash = this.trash.filter(t => t.trashId !== entry.trashId);
        this.showToast(entry.name + ' restored');
    },
    purgeFromTrash(entry) {
        this.trash = this.trash.filter(t => t.trashId !== entry.trashId);
    },
    emptyTrash() { this.trash = []; },

    // ---- notifications (simulation) ----
    get unreadCount() { return this.notifications.filter(n => !n.read).length; },
    markAllNotificationsRead() { this.notifications.forEach(n => { n.read = true; }); },
    markNotificationRead(n) { n.read = true; },

    // ---- user logs (simulation) ----
    get filteredLogs() {
        const q = this.logSearch.toLowerCase().trim();
        if (!q) return this.userLogs;
        return this.userLogs.filter(l => `${l.user} ${l.role} ${l.action} ${l.details} ${l.ip}`.toLowerCase().includes(q));
    },

    // ---- category actions ----
    openCategoryModal(cat = null) {
        if (cat) {
            this.categoryModal = { open: true, editingName: cat.name, name: cat.name, description: cat.description || '' };
        } else {
            this.categoryModal = { open: true, editingName: null, name: '', description: '' };
        }
    },
    saveCategory() {
        const name = (this.categoryModal.name || '').trim();
        if (!name) return;
        const description = (this.categoryModal.description || '').trim();
        if (!this.currentUnit.categories) this.currentUnit.categories = [];
        const cats = this.currentUnit.categories;
        if (this.categoryModal.editingName) {
            const existing = cats.find(c => c.name === this.categoryModal.editingName);
            if (existing) {
                const oldName = existing.name;
                existing.name = name;
                existing.description = description;
                if (oldName !== name) {
                    this.catalog.forEach(i => { if (i.cat === oldName) i.cat = name; });
                    if (this.activeCategory === oldName) this.activeCategory = name;
                }
            }
        } else if (!cats.some(c => c.name === name)) {
            cats.push({ name, description });
        }
        this.categoryModal.open = false;
    },
    selectCategory(cat) { this.activeCategory = (this.activeCategory === cat ? null : cat); },

    // ---- helpers ----
    _trashId() { return Date.now() + '-' + Math.random().toString(36).slice(2, 8); },
    _stamp() {
        const d = new Date();
        return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' }) + ' ' + d.toTimeString().slice(0, 5);
    },
    _today() { return new Date().toISOString().slice(0, 10); },
    _formatDate(value) {
        const d = value ? new Date(value) : new Date();
        if (isNaN(d.getTime())) return value || '';
        return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    },
    formatRp(n) { return 'Rp ' + (Number(n) || 0).toLocaleString('id-ID'); },
});
