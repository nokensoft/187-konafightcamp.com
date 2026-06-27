# FitHub POS — Cashier (Laravel)

Laravel port of the static FitHub multi-unit POS prototype (`../cashier/index.html`).
**Phase 1 (current):** Blade template prototype with auth, roles, and a frontend
build pipeline. All catalog data is still in memory (seeded from JSON); the
relational database + CRUD layer is intentionally deferred to Phase 2.

## Stack
- **Laravel 12** (PHP 8.2) with **SQLite**
- **Laravel Breeze** (Blade) for authentication
- **Tailwind CSS 3**, **Alpine.js 3**, **Font Awesome 6** — bundled via **Vite** (no CDN)
- **qrcode-generator** + **html2canvas** for the downloadable QR receipt
- **Plus Jakarta Sans** via `@fontsource`
- UI language: **English**; currency: **Rupiah (Rp)**

## Roles
Two roles on the `users.role` column, enforced by the `role` middleware
(`App\Http\Middleware\EnsureUserHasRole`) and the `isManager` flag in the UI:
- **manager** — full access: inventory & category management, member management, and the **Trash** (recycle bin).
- **cashier** — Dashboard + POS terminal, with read-only Members/Inventory.

### Demo accounts (password: `password`)
- Manager — `manager@kfc.test`
- Cashier — `cashier@kfc.test`

## Features
- Multi-unit (Gym / Store / Kitchen) switcher
- Dashboard, POS terminal (cart, 11% tax, checkout), Members, Inventory
- Digital receipt with scannable **QR code** + PNG download
- **Trash / recycle bin**: deleting a member or item moves it to Trash; restore or delete permanently (manager only)

## Getting started
```bash
composer install
npm install
# .env is already configured for SQLite; otherwise: cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev            # or: npm run build
php artisan serve
```
Then open the served URL and log in with one of the demo accounts.

## Project layout
- `app/Http/Controllers/PosController.php` — loads JSON data, passes it + role to the view
- `resources/data/{gym,store,kitchen}.json` — seed catalog data (Phase 1)
- `resources/js/posApp.js` — the Alpine component (state, cart, checkout, QR, trash)
- `resources/views/pos/` — `index.blade.php` + `partials/` (sidebar, header, dashboard, pos, members, inventory, trash, modals, toast)
- `app/Http/Middleware/EnsureUserHasRole.php` — `role:manager` / `role:cashier` guard

## Tests
```bash
php artisan test
```

## Phase 2 (planned)
- Relational schema: `units`, `categories`, `products`, `members`, `transactions`, `transaction_items` with **soft deletes** backing the recycle bin
- Resource CRUD controllers + Form Request validation
- Server-side checkout (ref generation + stock decrement) and real transaction history
- Optional server-side QR / PDF receipts
