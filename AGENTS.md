# AGENTS.md — KopiNgaji Project Context

> This file preserves deep context about the KopiNgaji codebase for AI agents.  
> **Last updated:** 2026-04-15

---

## 1. Project Overview

**KopiNgaji** is a marketplace platform that connects small coffee businesses (UMKM) with customers.  
It is built on **Laravel 11** with **PHP 8.2+**, styled with **TailwindCSS + AlpineJS**, and uses **DOKU** as the payment gateway.

### Core Value Proposition
- UMKM (sellers/owners) can register their business, manage products, handle orders, and withdraw earnings.
- Buyers can explore verified UMKMs, add products to cart, checkout (cash or non-cash), and track orders.
- Sellers verify buyer orders via QR code scanning.

---

## 2. Tech Stack

| Layer | Technology |
|-------|------------|
| Backend Framework | Laravel 11.x |
| PHP Version | ^8.2 |
| Database | MySQL (`DB_DATABASE=kopingaji`) |
| Frontend Build | Vite 5.x |
| CSS Framework | TailwindCSS 3.x + `@tailwindcss/forms` |
| JS Framework | AlpineJS 3.x |
| Auth Scaffolding | Laravel Breeze 2.x (Blade) |
| Payment Gateway | DOKU (Sandbox / Production) |
| QR Code Generator | `simplesoftwareio/simple-qrcode` ^4.2 |
| Indonesia Regions | `laravolt/indonesia` ^0.41 |
| Testing | PHPUnit 10.5 |

### Key Environment Variables
```env
APP_NAME=KopiNgaji
APP_URL=http://10.136.185.99:8000

DB_CONNECTION=mysql
DB_DATABASE=kopingaji
DB_USERNAME=root
DB_PASSWORD=

# DOKU Payment Gateway
DOKU_CLIENT_ID=your_sandbox_client_id
DOKU_SECRET_KEY=your_sandbox_secret_key
DOKU_IS_PRODUCTION=false
DOKU_WITHDRAWAL_FEE=6500
```

---

## 3. User Roles & Permissions

There are **3 roles** stored in `users.role`:

| Role | Description | Entry Point After Login |
|------|-------------|------------------------|
| `BUYER` | Browses UMKMs, buys products | `dashboard` → redirects to `umkms.index` |
| `OWNER` | Manages one UMKM, products, orders, withdrawals. **Can also buy from other UMKMs.** | `seller.dashboard` (with "Mode Pembeli" link) |
| `ADMIN` | Exists in schema but **no dedicated admin controllers yet**. Admin verification is likely manual DB-level or pending implementation. | — |

### Role Middleware
- Alias: `role`
- Class: `App\Http\Middleware\RoleMiddleware`
- Registered in `bootstrap/app.php`
- Usage example: `middleware(['auth', 'verified', 'role:BUYER'])`
- **Dual role**: Buyer routes now accept `role:BUYER,OWNER` so sellers can browse and purchase.

---

## 4. Business Flows

### 4.1 Buyer Flow
1. **Register/Login** as `BUYER`
2. **Dashboard** redirects to UMKM listing (`umkms.index`)
3. **Explore UMKMs** — only `is_verified = true` UMKMs are shown
4. **View UMKM Detail** — see active & approved products
5. **Product Detail** — view product info, add to cart
6. **Cart** — manage quantities, remove items (only from same UMKM effectively)
7. **Checkout** — choose payment method (`CASH` or `NON_CASH`) and delivery method (`AMBIL_LOKASI` or `KIRIM_ALAMAT`)
8. **Payment**
   - `CASH`: order created with `status = PENDING`
   - `NON_CASH`: redirected to DOKU payment URL; upon return/notify, status becomes `PAID`
9. **Order History** — view orders and their statuses
10. **Report** — buyers can report a product or UMKM

### 4.2 Seller (Owner) Flow
1. **Register** as `OWNER` → system **auto-creates** a UMKM named `"{name}'s UMKM"` (unverified by default)
2. **Seller Dashboard** — shows stats, but warns if UMKM is not verified yet
3. **UMKM Management** — edit name/description (one UMKM per owner)
4. **Product Management** (CRUD)
   - Products have a **type**: `BARANG` or `JASA`
   - Products are created with `status = PENDING` and `is_active = true`
   - Must be `APPROVED` by admin and `is_active = true` to appear in buyer-facing pages
   - Supports up to 5 images; first image becomes thumbnail (`image_url`)
5. **Shipping Zones**
   - Create custom zones with name, cost, and list of area names
   - Buyer selects zone during checkout if choosing delivery `KIRIM_ALAMAT`
6. **Order Management**
   - View orders for their UMKM
   - Update status (`CANCELLED`) with transition guards
   - **QR Scan** page to verify buyer orders in person — scanning unlocks the `COMPLETED` button on the order detail page
   - **Kirim Notifikasi Selesai** — sends a Web Push to the buyer so the buyer can mark the order as `COMPLETED`
   - **Refund orders** — for CASH orders refund is immediate; for NON_CASH it creates a PENDING refund request for admin to process manually via DOKU
7. **Financial Reports**
   - View income statement (revenue, COGS, refunds, net profit)
   - View cash flow summary and daily revenue breakdown
   - Filter by date range
8. **Withdrawal**
   - Withdraw accumulated non-cash earnings
   - Platform fee is **split by product type**: Barang fee vs Jasa fee, each with its own threshold
   - Minimum withdrawal: **Rp 50,000**
   - Cannot create new withdrawal if one is already `PENDING`

---

## 5. Database Schema & Relationships

### Entity Relationship Summary
```
User (1) ──────< (1) UMKM
User (1) ──────< (*) Order        [as buyer]
User (1) ──────< (*) Withdrawal   [as owner]
User (1) ──────< (*) Report       [as reporter]

UMKM (1) ──────< (*) Product
UMKM (1) ──────< (*) Order

Product (1) ───< (*) OrderItem
Product (1) ───< (*) ProductImage
Product (1) ───< (*) Report

Order (1) ─────< (*) OrderItem
Order (1) ────── (1) Payment

Cart (1) ──────< (*) CartItem
CartItem (*) ──> (1) Product
```

### Important Table Details

#### `users`
- `role`: `BUYER`, `OWNER`, `ADMIN`
- `whatsapp`: nullable string
- `is_verified`: boolean (not heavily used yet)

#### `umkms`
- `owner_id` → FK users
- `is_verified`: boolean (default false) — **gatekeeper for seller features**
- `province_id`, `city_id`, `district_id`, `village_id` → nullable strings (linked to `laravolt/indonesia` tables)
- `address`: text (nullable)
- `latitude`: decimal(10,8) (nullable)
- `longitude`: decimal(11,8) (nullable)
- `platform_fee_type`: `percentage` | `flat`
- `platform_fee_rate`: decimal(5,2)
- `platform_fee_flat`: decimal(12,2)
- `tax_threshold`: decimal(12,2) — earnings threshold before platform fee kicks in for **BARANG**
- `platform_fee_type_jasa`: `percentage` | `flat`
- `platform_fee_rate_jasa`: decimal(5,2)
- `platform_fee_flat_jasa`: decimal(12,2)
- `tax_threshold_jasa`: decimal(12,2) — earnings threshold for **JASA**

#### `products`
- `umkm_id` → FK umkms
- `type`: `BARANG` | `JASA` (default `BARANG`)
- `price`, `cost_price`, `discount`: decimal(12,2)
- `stock`: integer
- `image_url`: string (thumbnail)
- `is_preorder`: boolean
- `status`: `PENDING` | `APPROVED` | `REJECTED`
- `is_active`: boolean (default true)

#### `orders`
- `buyer_id`, `umkm_id` → FKs
- `shipping_zone_id` → nullable FK shipping_zones
- `status`: `PENDING` | `PAID` | `CANCELLED` | `COMPLETED` | `REFUNDED`
- `payment_method`: `CASH` | `NON_CASH`
- `delivery_method`: `AMBIL_LOKASI` | `KIRIM_ALAMAT`
- `shipping_address`: text (required if `KIRIM_ALAMAT`)
- `total_price`, `subtotal_amount`, `discount_amount`, `platform_fee_amount`, `net_amount`: decimal(12,2)
- `qr_code`: string (used as invoice/identifier for QR scanning)
- `is_scanned`: boolean
- `doku_invoice_id`, `doku_payment_url`: strings (for non-cash tracking)
- `whatsapp`: buyer contact

#### `order_items`
- `order_id`, `product_id` → FKs
- `quantity`, `price` (snapshot at purchase time)
- `product_type`: `BARANG` | `JASA` (snapshot from product at checkout)

#### `payments`
- `order_id` → unique FK orders
- `provider`, `reference_id`, `amount`, `paid_at`

#### `withdrawals`
- `owner_id` → FK users
- `amount` / `gross_amount`: requested amount
- `platform_fee_deduction`, `admin_fee_amount`, `net_disbursed`: deductions
- `bank_name`, `bank_code`, `bank_account`, `account_name`: disbursement info
- `status`: `PENDING` | `APPROVED` | `REJECTED`

#### `reports`
- `reporter_id`, `umkm_id` (nullable), `product_id` (nullable)
- `category`: `PRODUK_ILEGAL`, `PRODUK_BERBAHAYA`, `PENIPUAN`, `KONTEN_TIDAK_PANTAS`, `SPAM`, `LAINNYA`
- `status`: `PENDING` | `REVIEWED` | `DISMISSED`
- `admin_note`: nullable text

#### `carts` & `cart_items`
- One cart per user
- Cart items link to products with quantity

#### Region Tables (`laravolt/indonesia`)
- `provinces`, `cities`, `districts`, `villages` — auto-managed by the package.

---

## 6. Routing Structure

### Public / Auth
- `/` → redirect to `login`
- `/login`, `/register`, `/forgot-password`, `/reset-password` — Breeze auth

### Buyer Routes (`auth`, `verified`, `role:BUYER,OWNER`)
| Route | Controller | Name |
|-------|------------|------|
| GET `/dashboard` | redirect → `umkms.index` | dashboard |
| GET `/umkms` | `UmkmController@index` | umkms.index |
| GET `/umkms/{umkm}` | `UmkmController@show` | umkms.show |
| GET `/products/{product}` | `ProductController@show` | products.show |
| GET `/cart` | `CartController@index` | cart.index |
| POST `/cart` | `CartController@store` | cart.store |
| PUT `/cart/bulk-update` | `CartController@bulkUpdate` | cart.bulk-update |
| PUT `/cart/{cartItem}` | `CartController@update` | cart.update |
| DELETE `/cart/{cartItem}` | `CartController@destroy` | cart.destroy |
| GET `/checkout` | `CheckoutController@index` | checkout.index |
| POST `/checkout` | `CheckoutController@store` | checkout.store |
| GET `/orders` | `OrderController@index` | orders.index |
| GET `/orders/{order}` | `OrderController@show` | orders.show |
| GET `/reports/create` | `ReportController@create` | reports.create |
| POST `/reports` | `ReportController@store` | reports.store |

### DOKU Callbacks (public)
| Route | Controller | Name |
|-------|------------|------|
| POST `/doku/notify` | `OrderController@dokuNotify` | doku.notify |
| GET `/doku/redirect` | `OrderController@dokuRedirect` | doku.redirect |

### Region API (public)
| Route | Controller | Name |
|-------|------------|------|
| GET `/api/regions/provinces` | `RegionController@provinces` | regions.provinces |
| GET `/api/regions/provinces/{province}/cities` | `RegionController@cities` | regions.cities |
| GET `/api/regions/cities/{city}/districts` | `RegionController@districts` | regions.districts |
| GET `/api/regions/districts/{district}/villages` | `RegionController@villages` | regions.villages |

### Seller Routes (`auth`, `verified`, `role:OWNER`, prefix `seller`)
| Route | Controller | Name |
|-------|------------|------|
| GET `/dashboard` | `Seller\DashboardController@index` | seller.dashboard |
| GET `/finance` | `Seller\FinanceReportController@index` | seller.finance.index |
| Resource `/shipping-zones` | `Seller\ShippingZoneController` | seller.shipping-zones.* |
| GET `/umkm/create` | `Seller\UmkmController@create` | seller.umkm.create |
| POST `/umkm` | `Seller\UmkmController@store` | seller.umkm.store |
| GET `/umkm/edit` | `Seller\UmkmController@edit` | seller.umkm.edit |
| PUT `/umkm` | `Seller\UmkmController@update` | seller.umkm.update |
| Resource `/products` | `Seller\ProductController` | seller.products.* |
| PATCH `/products/{product}/toggle-active` | `Seller\ProductController@toggleActive` | seller.products.toggle-active |
| DELETE `/product-images/{productImage}` | `Seller\ProductController@deleteImage` | seller.product-images.destroy |
| GET `/orders` | `Seller\OrderController@index` | seller.orders.index |
| GET `/orders/scan/qr` | `Seller\OrderController@scan` | seller.orders.scan |
| GET `/orders/{order}` | `Seller\OrderController@show` | seller.orders.show |
| PATCH `/orders/{order}/status` | `Seller\OrderController@updateStatus` | seller.orders.update-status |
| POST `/orders/{order}/refund` | `Seller\OrderController@refund` | seller.orders.refund |
| Resource `/withdrawals` (index, create, store) | `Seller\WithdrawalController` | seller.withdrawals.* |

### Profile Routes (`auth`)
| Route | Controller | Name |
|-------|------------|------|
| GET `/profile` | `ProfileController@edit` | profile.edit |
| PATCH `/profile` | `ProfileController@update` | profile.update |
| DELETE `/profile` | `ProfileController@destroy` | profile.destroy |

---

## 7. New Features & Rules

### Nearby UMKM (Buyer)
- Buyers can click "Cari UMKM Terdekat" on the UMKM listing page.
- The browser requests geolocation permission; if granted, the page reloads with `?lat=...&lng=...`.
- `UmkmController@index` uses the **Haversine formula** to sort verified UMKMs by distance (only those with `latitude` and `longitude` set).
- Distance is displayed in km on each UMKM card.

### Shipping Zones (Seller)
- Sellers define shipping zones by selecting **Kecamatan** (district) via a cascade UI: Province → City → District checklist.
- `shipping_zone_areas` now stores `district_id` (reference to `laravolt/indonesia` `districts` table) alongside `area_name`.
- Old text-based areas remain visible but new zones use real district data.

## 8. Critical Business Rules

### Order Status Transitions (Seller)
Handled in `Seller\OrderController@updateStatus`:
```php
'PENDING' + CASH    → ['COMPLETED', 'CANCELLED']
'PENDING' + NON_CASH → ['COMPLETED']
'PAID'               → ['COMPLETED']
default              → []
```

### Refund Flow
- Seller initiates refund from order detail for `PAID` or `COMPLETED` orders.
- **CASH**: refund record created as `APPROVED`, stock restored, order status becomes `REFUNDED`.
- **NON_CASH**: refund record created as `PENDING`. Seller/admin must coordinate manual refund via DOKU dashboard. Once processed, admin updates refund status to `APPROVED` (outside current scope, done via DB/command).

### Product Visibility (Buyer-facing)
A product is visible ONLY if:
- `is_active = true`
- `status = 'APPROVED'`
- Its UMKM has `is_verified = true`

### Cart Cleanup
When buyer visits `/cart`, items whose product is inactive or not approved are automatically removed with a warning flash message.

### Checkout Constraint
The cart is filtered to **only the first UMKM's products** during checkout.  
Mixed-UMKM carts are not fully supported; items from other UMKMs are ignored in the checkout logic.

### Owner Self-Purchase Restriction
An `OWNER` **cannot** add their own UMKM's products to the cart or checkout from their own store. This is enforced in:
- `CartController@store` — rejects adding product to cart.
- `CheckoutController@index` and `@store` — redirects back with error if cart contains products from their own UMKM.

### Stock Management
Stock is decremented at checkout time (`CheckoutController@store`). If stock is insufficient, checkout fails with an error.

---

## 8. Payment Gateway (DOKU)

### Service Class
`App\Services\DokuService`

### Flow
1. Buyer selects `NON_CASH` at checkout.
2. `CheckoutController` calls `DokuService::createPaymentUrl()`.
3. DOKU returns a `payment.url`.
4. Order is updated with `doku_invoice_id` and `doku_payment_url`.
5. Buyer is redirected to DOKU.
6. After payment, DOKU calls:
   - `POST /doku/notify` — sets order status to `PAID`
   - `GET /doku/redirect` — also sets order status to `PAID` and redirects to order detail

> **Note:** Signature generation uses HMAC-SHA256 with digest of the JSON body.

---

## 9. Withdrawal & Fee Structure (Split by Product Type)

### Earnings Calculation
```php
$totalEarnings = Order::where('umkm_id', $umkm->id)
    ->where('status', 'COMPLETED')
    ->where('payment_method', 'NON_CASH')
    ->sum('net_amount');

// Split by product type snapshot in order_items
$barangEarnings = DB::table('order_items')->join('orders', ...)
    ->where('product_type', 'BARANG')->sum('quantity * price');

$jasaEarnings = DB::table('order_items')->join('orders', ...)
    ->where('product_type', 'JASA')->sum('quantity * price');

$totalWithdrawn = Withdrawal::where('owner_id', $user->id)
    ->whereIn('status', ['PENDING', 'APPROVED'])
    ->sum('gross_amount');

$availableBalance = $totalEarnings - $totalWithdrawn;
```

### Deductions (`Umkm::calculateWithdrawalDeductions($grossAmount, $totalEarningsBarang, $totalEarningsJasa)`)
1. **Portion Allocation**
   - Barang portion = `grossAmount * (barangEarnings / totalEarnings)`
   - Jasa portion = `grossAmount * (jasaEarnings / totalEarnings)`
2. **Barang Platform Fee**
   - Only applies if `tax_threshold > 0` AND `totalEarningsBarang > tax_threshold`.
   - Type `percentage` or `flat` using barang fee settings
3. **Jasa Platform Fee**
   - Only applies if `tax_threshold_jasa > 0` AND `totalEarningsJasa > tax_threshold_jasa`.
   - Type `percentage` or `flat` using jasa fee settings
4. **DOKU Admin Fee**
   - Fixed global fee from `env('DOKU_WITHDRAWAL_FEE', 6500)`
   - Always deducted from disbursed amount
5. **Net Disbursed** = `grossAmount - barangFee - jasaFee - dokuAdminFee`

---

## 10. QR Code & Order Completion Flow

### QR Code Feature
- Each order has a `qr_code` field populated with the invoice number (`INV-{random}`).
- Sellers can open `/seller/orders/scan/qr` to scan a buyer's QR code.
- When scanned and matched, the seller can verify and update the order status directly to `COMPLETED`.

### Order Completion Methods
1. **QR Scan (Seller)** — Seller scans buyer's QR code and is redirected to the order detail with `?scanned=true`. A **"Selesaikan Pesanan"** button appears only in this context; pressing it marks the order `COMPLETED` and sets `is_scanned = true`. There is no direct completion button on the seller orders list.
2. **Buyer Manual Completion (Non-QR)** — If the seller is not present to scan, the buyer must wait for the seller to confirm delivery first. Once the seller presses **"Kirim Notifikasi Selesai"**, the buyer's order detail will reveal the **"Selesaikan Pesanan"** button. Only then can the buyer mark the order as `COMPLETED`.
3. **Seller Notification (Web Push)** — If the buyer hasn't completed the order, the seller can press **"Kirim Notifikasi Selesai"** from the seller order detail. This updates `seller_completion_notified_at`, unlocks the completion button on the buyer's order detail, and sends a **native Web Push notification** to the buyer's browser (if permission is granted).

### Web Push Setup
- Uses `minishlink/web-push` PHP library and browser Service Worker (`public/sw.js`).
- Requires `VAPID_PUBLIC_KEY`, `VAPID_PRIVATE_KEY`, and `VAPID_SUBJECT` in `.env`.
- Buyer subscriptions are stored in `push_subscriptions` table.

---

## 11. File Structure Conventions

### Controllers
- `app/Http/Controllers/` — buyer-facing & general controllers
- `app/Http/Controllers/Auth/` — Breeze auth controllers
- `app/Http/Controllers/Seller/` — seller/owner-specific controllers

### Views
- `resources/views/` — root views
- `resources/views/seller/` — seller panel views
- `resources/views/auth/` — Breeze auth views
- Layouts: `resources/views/layouts/app.blade.php` (buyer), `seller.blade.php` (seller)

### Storage
- Product images are stored in `storage/app/public/products`
- Accessed via `asset('storage/' . $path)`

---

## 12. Development Commands

```bash
# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database with sample data (Admin, Owner, Buyer, Products, Orders, etc.)
php artisan db:seed

# Start dev server
php artisan serve

# Build assets
npm run dev      # development
npm run build    # production

# Run tests
php artisan test
```

---

## 13. Known Constraints & Assumptions

1. **One UMKM per Owner** — enforced in `Seller\UmkmController` and auto-creation on registration.
2. **Single-UMKM Checkout** — if cart contains products from multiple UMKMs, only the first UMKM's products are checked out.
3. **No Admin Panel (yet)** — product approval (`status = APPROVED`) and UMKM verification (`is_verified = true`) likely require direct DB manipulation or an admin panel that is not yet built.
4. **DOKU Integration is Sandbox-ready** — signature verification on notify is simplified for development.
5. **Minimal API routes** — primarily server-rendered Blade views. Exception: public `/api/regions/*` endpoints for province/city/district/village data consumed by AlpineJS cascade selects.
6. **Report review workflow** — reports are stored with `status = PENDING`; no admin review UI exists yet.
7. **Dual-role sellers** — `OWNER` users can browse the buyer marketplace and place orders. Navigation includes "Mode Pembeli" (seller nav) and "Mode Seller" (buyer nav dropdown).
8. **Shipping zones** — each UMKM can define multiple custom zones with costs. Zones are defined by selecting real Indonesian districts (Kecamatan) via cascade select. Buyer selects zone during checkout for `KIRIM_ALAMAT`.
9. **Nearby UMKM** — requires UMKM owners to set their latitude/longitude in their profile. Buyers without geolocation permission will see the default listing.
10. **Refund admin process** — non-cash refunds create a `PENDING` record. An admin must manually process via DOKU and then update the refund status (currently no admin UI; use DB/tinker).

---

## 14. When Modifying This Project

- **Follow Laravel 11 conventions** and existing coding style.
- **Respect role middleware** on routes; buyer routes use `role:BUYER,OWNER`, seller routes use `role:OWNER`.
- **Preserve stock logic** — any change to checkout or cart must maintain stock integrity.
- **Preserve DOKU signature logic** if touching `DokuService`.
- **Update this AGENTS.md** if you change architecture, add new roles, modify the fee structure, or introduce new major features.
