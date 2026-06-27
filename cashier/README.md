# FitHub — Sistem Kasir (POS) Kona Fight Camp

Aplikasi kasir / **Point of Sale (POS)** multi-unit untuk Kona Fight Camp. Berupa satu halaman (single-page) berbasis HTML + Tailwind CSS + Alpine.js, **tanpa proses build**. Mendukung tiga unit usaha: **Gym**, **Store**, dan **Kitchen**.

> 🛠️ **Status & roadmap:** saat ini berupa **prototipe front-end statis**. Pengembangan lanjutan direncanakan memakai **Laravel (terbaru) + Alpine.js**. Konteks teknis untuk developer/AI agent ada di bagian [Dokumentasi untuk AI Agents](#dokumentasi-untuk-ai-agents) dan [Rencana Pengembangan: Laravel + Alpine.js](#rencana-pengembangan-laravel--alpinejs).

## Fitur
- **Multi-unit** — beralih cepat antara Gym, Store, dan Kitchen dari header.
- **Dashboard** — ringkasan pendapatan, jumlah item/member, total transaksi, dan aktivitas terbaru per unit.
- **POS Terminal** — pilih produk, kelola keranjang (tambah/kurang qty, hapus item), hitung subtotal, pajak 11%, total, dan checkout.
- **Struk digital** — setelah checkout, struk transaksi dapat **diunduh sebagai gambar PNG** dan dilengkapi **QR Code** yang bisa dipindai untuk verifikasi.
- **Members** (khusus Gym) — daftar, tambah, dan hapus keanggotaan.
- **Inventory** — katalog produk/paket per kategori, tambah & edit item, serta tambah & edit kategori.
- **Pencarian cepat** — filter member & produk secara real-time.
- **Mobile friendly** — tata letak menyesuaikan ukuran layar; sidebar dapat di-_show/hide_ (drawer) pada tampilan mobile.

## Teknologi
- [Tailwind CSS](https://tailwindcss.com) (via CDN)
- [Alpine.js 3](https://alpinejs.dev) (via CDN)
- [Font Awesome 6](https://fontawesome.com) (via CDN)
- [qrcode-generator](https://github.com/kazuhikoarase/qrcode-generator) — pembuat QR Code (via CDN)
- [html2canvas](https://html2canvas.hertzen.com) — render struk menjadi gambar PNG (via CDN)
- Font Plus Jakarta Sans (Google Fonts)

> Seluruh dependency dimuat lewat CDN, sehingga butuh koneksi internet saat halaman pertama kali dibuka.

## Struktur Folder
```
cashier/
├── index.html        # Seluruh UI + logika aplikasi (Alpine.js)
├── README.md         # Dokumen ini
└── data/
    ├── gym.json      # Kategori, katalog paket, dan daftar member Gym
    ├── store.json    # Kategori & katalog produk Store
    └── kitchen.json  # Kategori & katalog menu Kitchen
```

## Menjalankan
> ⚠️ **Wajib lewat HTTP server.** Aplikasi memuat data dari `data/*.json` menggunakan `fetch`, sehingga membuka `index.html` langsung (protokol `file://`) akan **gagal memuat data**.

Jalankan salah satu perintah berikut dari dalam folder `cashier/`:

```bash
# Opsi 1 — Node.js
npx serve

# Opsi 2 — Python 3
python -m http.server 8000

# Opsi 3 — PHP
php -S localhost:8000
```

Lalu buka URL yang ditampilkan (mis. `http://localhost:8000`) di browser.

## Format Data
Setiap unit memiliki file JSON tersendiri di dalam folder `data/`.

### `gym.json`
```json
{
  "unit": "gym",
  "label": "Gym",
  "tagline": "Membership",
  "icon": "fa-dumbbell",
  "categories": [
    { "name": "Membership", "description": "Paket keanggotaan akses gym berulang" }
  ],
  "catalog": [
    { "id": 1, "name": "Monthly Premium", "cat": "Membership", "price": 450000, "stock": 999, "emoji": "🏋️" }
  ],
  "members": [
    { "id": "MB001", "name": "Budi Santoso", "package": "Monthly Premium", "type": "Local", "expiry": "15 Aug 2026" }
  ]
}
```

### `store.json` & `kitchen.json`
Strukturnya sama seperti `gym.json`, namun **tanpa** field `members` (hanya `categories` dan `catalog`).

### Keterangan field
- `categories[]` — `name` (wajib) dan `description` (opsional).
- `catalog[]` — `id`, `name`, `cat` (harus cocok dengan salah satu nama kategori), `price` (Rupiah, berupa angka), `stock`, dan `emoji` (opsional).
- `members[]` (khusus gym) — `id`, `name`, `package`, `type` (`Local`/`Tourist`), dan `expiry`.

## Cara Pakai Singkat
1. Pilih unit (Gym / Store / Kitchen) di header.
2. Gunakan navigasi sidebar untuk berpindah antara Dashboard / POS / Members / Inventory.
3. Pada **POS**, klik produk untuk menambahkannya ke keranjang, lalu tekan **Checkout**.
4. Pada **Inventory**, kelola item & kategori; pada **Members**, kelola keanggotaan gym.

### Struk & QR Code
- Setelah menekan **Checkout**, modal menampilkan **struk** berisi rincian item, subtotal, pajak, dan total.
- Tekan tombol **Download** untuk menyimpan struk sebagai gambar **PNG**.
- **QR Code** pada struk memuat ringkasan transaksi (no. struk, unit, item, total) dan dapat **dipindai** untuk verifikasi.
- Catatan: pembuatan QR & unduhan memakai pustaka CDN, sehingga butuh koneksi internet.
### Tampilan Mobile
- Ketuk ikon **☰ (menu)** di kiri atas untuk **menampilkan** sidebar.
- Ketuk ikon **✕** atau area gelap (backdrop) di luar sidebar untuk **menutupnya**.
- Sidebar otomatis tertutup setelah sebuah menu dipilih.
- Saat menambah item ke keranjang, muncul **notifikasi** dengan tombol **Lihat Keranjang**, plus **tombol keranjang melayang** (pojok kanan bawah) berisi jumlah item untuk akses cepat ke keranjang.

## Catatan & Keterbatasan
- Data bersifat **in-memory**: perubahan (tambah member/item/kategori, transaksi checkout) **tidak tersimpan** dan akan hilang ketika halaman di-refresh.
- Pajak dihitung tetap **11%** dari subtotal.
- Tanggal/jam pada header masih statis (sekadar contoh tampilan).
- Data transaksi awal pada Dashboard hanya berupa contoh.

## Dokumentasi untuk AI Agents
Bagian ini merangkum cara kerja sistem agar developer maupun AI agent dapat memahami dan melanjutkan pengembangan (termasuk migrasi ke Laravel + Alpine.js) tanpa harus membaca seluruh `index.html`.

### Arsitektur saat ini
- Seluruh UI dan logika berada di satu file `index.html`.
- Logika dikelola oleh **satu komponen Alpine** bernama `posApp` (`Alpine.data('posApp', () => ({ ... }))` di dalam tag `<script>`), terpasang pada root `<div x-data="posApp">`.
- Data contoh dimuat dari `data/{gym,store,kitchen}.json` via `fetch` pada `init()`.
- **Tidak ada backend/persistensi** — semua perubahan hanya hidup di memori browser.
- Penanda lokasi kode (cari komentar ini di `index.html`): `<!-- Sidebar -->`, `<!-- DASHBOARD -->`, `<!-- POS -->`, `<!-- MEMBERS -->`, `<!-- INVENTORY -->`, `<!-- Add-to-cart toast -->`, `<!-- Mobile quick-access cart button -->`.

### Peta fitur utama
1. **Multi-unit** — `activeUnit` ∈ `gym|store|kitchen`. Metadata di `unitInfo`, navigasi per unit di `navConfig`. Mengganti unit mereset `activeCategory` dan mengembalikan `activeTab` ke `dashboard` bila tab tak tersedia di unit itu.
2. **Navigasi / Tabs** — `activeTab` ∈ `dashboard|pos|members|inventory`. Tab `members` hanya ada di unit gym.
3. **Dashboard** — kartu Total Revenue (`totalRevenue`), Active Members/Total Items, Transactions (`unitTransactions.length`), Recent Activity, dan Overview unit.
4. **POS + Keranjang** — daftar produk `posItems` (katalog + filter pencarian); aksi `addToCart`, `cartQty`, `removeCartItem`, `clearCart`; ringkasan `subtotal`/`tax`/`total`/`cartCount`; notifikasi toast + tombol keranjang melayang (mobile).
5. **Checkout + Struk + QR** — `checkout()` membuat transaksi & objek `receipt`; `receiptText()` menyusun isi QR; `renderReceiptQR()` (qrcode-generator → data URL); `downloadReceipt()` (html2canvas → PNG).
6. **Members (gym)** — `openMemberModal`, `saveMember`, `askDeleteMember`, `confirmDeleteMember`; daftar terfilter `filteredMembers`.
7. **Inventory item** — `openItemModal`, `saveItem` (tambah/edit); daftar `inventoryItems` (filter kategori + pencarian).
8. **Kategori** — `openCategoryModal`, `saveCategory` (tambah/edit + rename cascade ke item), `selectCategory`, `normalizeCategories`.
9. **Pencarian** — `searchQuery` + helper `matches()`.
10. **Responsif & Sidebar drawer** — `sidebarOpen` (off-canvas di mobile).

### Aturan bisnis (pertahankan saat migrasi)
- `subtotal = Σ(price × qty)`; `tax = round(subtotal × 0.11)`; `total = subtotal + tax`.
- Nomor struk: `TRX` + 3 digit dari `(jumlah transaksi + 1)`. Karena ada 3 transaksi contoh, checkout pertama = `TRX004`.
- ID member baru: `MB` + 3 digit dari `(jumlah member + 1)`; default `type='Local'`, `expiry='30 Days'`, `package` = paket pertama.
- ID item baru: `Date.now()` (timestamp); item baru diberi `emoji='🆕'`.
- `membershipPackages` diturunkan dari nama katalog unit **gym** (fallback `['1 Month','3 Months','12 Months']`).
- Kategori selalu dinormalisasi ke objek `{ name, description }` (mendukung legacy array string).
- Rename kategori ikut memperbarui `cat` pada semua item terkait dan `activeCategory`.
- `addToCart`: bila item sudah ada di keranjang → `qty++`.
- `formatRp(n)` → `Intl` locale `id-ID` dengan awalan `Rp `.

### Referensi state & method `posApp`
- **State:** `activeTab`, `activeUnit`, `searchQuery`, `activeCategory`, `sidebarOpen`, `loading`, `loadError`, `units`, `cart`, `transactions`, `memberModal`, `itemModal`, `categoryModal`, `confirmModal`, `checkoutModal`, `receipt`, `receiptQrUrl`, `toast`.
- **Computed (getter):** `unitNav`, `currentUnit`, `catalog`, `unitCategories`, `members`, `itemNoun`, `pageTitle`, `membershipPackages`, `posItems`, `inventoryItems`, `filteredMembers`, `unitTransactions`, `totalRevenue`, `subtotal`, `tax`, `total`, `cartCount`.
- **Method:** `init`, `loadData`, `normalizeCategories`, `matches`, `addToCart`, `cartQty`, `removeCartItem`, `clearCart`, `showToast`, `goToCart`, `checkout`, `receiptText`, `renderReceiptQR`, `downloadReceipt`, `openMemberModal`, `saveMember`, `askDeleteMember`, `confirmDeleteMember`, `openItemModal`, `saveItem`, `openCategoryModal`, `saveCategory`, `selectCategory`, `itemCount`, `catCount`, `formatRp`.

### Konvensi untuk AI agents
- Tambah fitur dengan pola sama: tambah **state** + **method** di `posApp`, lalu blok **UI** di tab terkait.
- Pertahankan util & aturan: `formatRp`, pajak 11%, pola ID, normalisasi kategori.
- Validasi cepat sebelum selesai: keseimbangan tag HTML, cek sintaks JS, dan jalankan lewat **HTTP server** (karena `fetch` butuh `http`).

## Rencana Pengembangan: Laravel + Alpine.js
Panduan migrasi dari prototipe statis ke aplikasi **Laravel (terbaru) + Alpine.js** dengan persistensi database, autentikasi kasir, dan API.

### Prinsip
- **Pertahankan Alpine.js** untuk interaktivitas (keranjang, modal, toast, sidebar); pindahkan **data & aturan bisnis** ke server (Laravel).
- Ganti CDN dengan **Vite + npm** (Tailwind + Alpine di-bundle); ganti `fetch('data/*.json')` dengan endpoint Laravel atau data awal via Blade `@json`.

### Skema database (saran)
- `units` — `id`, `slug` (`gym|store|kitchen`), `label`, `tagline`, `icon`.
- `categories` — `id`, `unit_id` → units, `name`, `description` (nullable).
- `products` — `id`, `unit_id` → units, `category_id` → categories, `name`, `price` (integer Rupiah), `stock`, `emoji` (nullable).
- `members` — `id`, `code` (`MB001`), `name`, `package`, `type` (`Local|Tourist`), `expiry` (date), relasi ke unit gym.
- `transactions` — `id`, `ref` (`TRX001`), `unit_id`, `subtotal`, `tax`, `total`, `status`, `cashier_id` → users, `created_at`.
- `transaction_items` — `id`, `transaction_id` → transactions, `product_id` (nullable), `name`, `qty`, `price`, `line_total`.

### Endpoint (saran)
```
GET  /api/units/{unit}            -> { unit, label, categories[], catalog[], members[]? }
POST /api/units/{unit}/checkout   -> body { items:[{product_id,qty}] } => 201 { ref, subtotal, tax, total, items[] }
GET  /api/units/{unit}/transactions
CRUD /api/units/{unit}/products
CRUD /api/units/{unit}/categories
CRUD /api/gym/members
```

### Pemetaan kode prototipe → Laravel
- `data/*.json` → **Seeder** (mis. `DatabaseSeeder` membaca JSON yang ada lalu mengisi `units`, `categories`, `products`, `members`).
- `loadData()` → request ke `GET /api/units/{unit}` (atau data awal dari controller via Blade).
- `checkout()` → `POST .../checkout` di `TransactionController@store` (buat `transaction` + `transaction_items`, kurangi `stock`, hasilkan `ref` di sisi server).
- `saveItem` / `saveCategory` / `saveMember` / delete → controller resource + Form Request validation.
- Pajak 11% → pindahkan ke `config/pos.php` (mis. `'tax_rate' => 0.11`).
- Pola ID (`TRXxxx`, `MBxxx`) → kolom + accessor/generator server-side agar format tampilan tetap konsisten.
- Struk QR/PNG → boleh tetap client-side (qrcode-generator + html2canvas) atau server-side (`endroid/qr-code`, PDF via `barryvdh/laravel-dompdf`).
- Auth kasir → Laravel Breeze/Fortify; identitas kasir menggantikan "John Doe • Cashier".

### Belum ada di prototipe (tambahkan di Laravel)
- Persistensi data (semua perubahan kini hilang saat refresh).
- Pengurangan **stock** saat checkout.
- Tanggal/jam header masih statis → gunakan waktu server / real-time.
- Otorisasi & multi-user (kasir) serta riwayat transaksi nyata.

---
Bagian dari proyek [187-konafightcamp.com](../README.md).
