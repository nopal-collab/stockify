<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        $admin   = User::firstOrCreate(['email' => 'admin@stockify.com'], [
            'name' => 'Admin Stockify', 'password' => Hash::make('password'), 'role' => 'admin',
        ]);
        $manajer = User::firstOrCreate(['email' => 'manajer@stockify.com'], [
            'name' => 'Budi Santoso', 'password' => Hash::make('password'), 'role' => 'manajer_gudang',
        ]);
        $staff   = User::firstOrCreate(['email' => 'staff@stockify.com'], [
            'name' => 'Siti Rahayu', 'password' => Hash::make('password'), 'role' => 'staff_gudang',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SUPPLIERS & CATEGORIES
        |--------------------------------------------------------------------------
        */

        $supElektronik = Supplier::firstOrCreate(['name' => 'PT Elektronik Nusantara'], [
            'phone' => '021-5551234', 'address' => 'Jl. Sudirman No. 45, Jakarta',
        ]);
        $supPakaian = Supplier::firstOrCreate(['name' => 'CV Sandang Jaya'], [
            'phone' => '022-7778899', 'address' => 'Jl. Braga No. 12, Bandung',
        ]);
        $supMakanan = Supplier::firstOrCreate(['name' => 'PT Pangan Makmur'], [
            'phone' => '031-4445566', 'address' => 'Jl. Darmo No. 88, Surabaya',
        ]);

        $catElektronik = Category::firstOrCreate(['name' => 'Elektronik'],        ['description' => null]);
        $catPakaian    = Category::firstOrCreate(['name' => 'Pakaian'],           ['description' => null]);
        $catMakanan    = Category::firstOrCreate(['name' => 'Makanan & Minuman'], ['description' => null]);

        /*
        |==========================================================================
        | A. ATRIBUT PRODUK — contoh lengkap semua tipe
        |==========================================================================
        |
        | Tipe yang tersedia:
        |   text   → input bebas (contoh: material, merek)
        |   number → input angka (contoh: berat, voltase)
        |   color  → color picker (contoh: warna produk)
        |   select → dropdown pilihan (contoh: ukuran, garansi)
        |
        */

        // Tipe: select
        $attrUkuran = ProductAttribute::firstOrCreate(['name' => 'Ukuran Pakaian'], [
            'type'        => 'select',
            'options'     => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
            'description' => 'Ukuran standar pakaian internasional',
        ]);

        $attrGaransi = ProductAttribute::firstOrCreate(['name' => 'Garansi'], [
            'type'        => 'select',
            'options'     => ['Tanpa Garansi', '1 Bulan', '3 Bulan', '6 Bulan', '1 Tahun', '2 Tahun'],
            'description' => 'Masa garansi resmi dari produsen',
        ]);

        $attrKapasitas = ProductAttribute::firstOrCreate(['name' => 'Kapasitas'], [
            'type'        => 'select',
            'options'     => ['64GB', '128GB', '256GB', '512GB', '1TB'],
            'description' => 'Kapasitas penyimpanan perangkat',
        ]);

        // Tipe: color
        $attrWarna = ProductAttribute::firstOrCreate(['name' => 'Warna'], [
            'type'        => 'color',
            'options'     => null,
            'description' => 'Warna utama produk',
        ]);

        // Tipe: number
        $attrBerat = ProductAttribute::firstOrCreate(['name' => 'Berat (kg)'], [
            'type'        => 'number',
            'options'     => null,
            'description' => 'Berat produk dalam kilogram',
        ]);

        $attrVoltase = ProductAttribute::firstOrCreate(['name' => 'Voltase (V)'], [
            'type'        => 'number',
            'options'     => null,
            'description' => 'Tegangan listrik yang dibutuhkan',
        ]);

        // Tipe: text
        $attrMaterial = ProductAttribute::firstOrCreate(['name' => 'Material'], [
            'type'        => 'text',
            'options'     => null,
            'description' => 'Bahan atau material utama produk',
        ]);

        $attrMerek = ProductAttribute::firstOrCreate(['name' => 'Merek'], [
            'type'        => 'text',
            'options'     => null,
            'description' => 'Nama merek atau brand produk',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PRODUK — dengan nilai atribut yang bervariasi
        |--------------------------------------------------------------------------
        */

        $products = [
            // Elektronik — pakai atribut: warna (color), garansi (select), kapasitas (select), berat (number), merek (text), voltase (number)
            [
                'data' => [
                    'category_id' => $catElektronik->id, 'supplier_id' => $supElektronik->id,
                    'name' => 'Laptop ASUS VivoBook 15', 'stock' => 25, 'min_stock' => 5,
                    'harga_beli' => 7500000, 'harga_jual' => 9200000,
                    'description' => 'Laptop tipis ringan Intel Core i5, RAM 8GB, SSD 512GB.',
                ],
                'attrs' => [
                    $attrWarna->id     => '#2563EB',
                    $attrGaransi->id   => '1 Tahun',
                    $attrKapasitas->id => '512GB',
                    $attrBerat->id     => '1.8',
                    $attrMerek->id     => 'ASUS',
                    $attrVoltase->id   => '220',
                ],
            ],
            [
                'data' => [
                    'category_id' => $catElektronik->id, 'supplier_id' => $supElektronik->id,
                    'name' => 'Smartphone Samsung Galaxy A54', 'stock' => 40, 'min_stock' => 8,
                    'harga_beli' => 4200000, 'harga_jual' => 5100000,
                    'description' => 'HP Android kamera 50MP, baterai 5000mAh, layar AMOLED 6.4".',
                ],
                'attrs' => [
                    $attrWarna->id     => '#1E1E1E',
                    $attrGaransi->id   => '1 Tahun',
                    $attrKapasitas->id => '128GB',
                    $attrBerat->id     => '0.202',
                    $attrMerek->id     => 'Samsung',
                ],
            ],
            [
                'data' => [
                    'category_id' => $catElektronik->id, 'supplier_id' => $supElektronik->id,
                    'name' => 'Printer Canon PIXMA G2020', 'stock' => 3, 'min_stock' => 5,
                    'harga_beli' => 1350000, 'harga_jual' => 1750000,
                    'description' => 'Printer inkjet multifungsi tangki tinta isi ulang.',
                ],
                'attrs' => [
                    $attrWarna->id   => '#000000',
                    $attrGaransi->id => '1 Tahun',
                    $attrBerat->id   => '3.8',
                    $attrMerek->id   => 'Canon',
                    $attrVoltase->id => '220',
                ],
            ],
            // Pakaian — pakai atribut: warna (color), ukuran (select), material (text), berat (number)
            [
                'data' => [
                    'category_id' => $catPakaian->id, 'supplier_id' => $supPakaian->id,
                    'name' => 'Kaos Polos Cotton Combed 30s', 'stock' => 150, 'min_stock' => 20,
                    'harga_beli' => 35000, 'harga_jual' => 65000,
                    'description' => 'Kaos polos berkualitas tinggi, lembut dan adem.',
                ],
                'attrs' => [
                    $attrWarna->id    => '#FFFFFF',
                    $attrUkuran->id   => 'M',
                    $attrMaterial->id => 'Cotton Combed 30s',
                    $attrBerat->id    => '0.18',
                ],
            ],
            [
                'data' => [
                    'category_id' => $catPakaian->id, 'supplier_id' => $supPakaian->id,
                    'name' => 'Jaket Fleece Polos', 'stock' => 60, 'min_stock' => 10,
                    'harga_beli' => 85000, 'harga_jual' => 145000,
                    'description' => 'Jaket fleece tebal, hangat untuk outdoor.',
                ],
                'attrs' => [
                    $attrWarna->id    => '#374151',
                    $attrUkuran->id   => 'L',
                    $attrMaterial->id => 'Fleece 270 GSM',
                    $attrBerat->id    => '0.45',
                ],
            ],
            // Makanan — pakai atribut: berat (number), merek (text)
            [
                'data' => [
                    'category_id' => $catMakanan->id, 'supplier_id' => $supMakanan->id,
                    'name' => 'Beras Premium 5kg', 'stock' => 4, 'min_stock' => 10,
                    'harga_beli' => 68000, 'harga_jual' => 82000,
                    'description' => 'Beras putih premium pulen dari petani lokal.',
                ],
                'attrs' => [
                    $attrBerat->id => '5',
                    $attrMerek->id => 'Cap Koki',
                ],
            ],
            [
                'data' => [
                    'category_id' => $catMakanan->id, 'supplier_id' => $supMakanan->id,
                    'name' => 'Minyak Goreng Bimoli 2L', 'stock' => 200, 'min_stock' => 30,
                    'harga_beli' => 28000, 'harga_jual' => 35000,
                    'description' => 'Minyak goreng sawit murni kemasan 2 liter.',
                ],
                'attrs' => [
                    $attrBerat->id => '1.84',
                    $attrMerek->id => 'Bimoli',
                ],
            ],
        ];

        foreach ($products as $item) {
            $product = Product::firstOrCreate(['name' => $item['data']['name']], $item['data']);

            foreach ($item['attrs'] as $attributeId => $value) {
                ProductAttributeValue::firstOrCreate(
                    ['product_id' => $product->id, 'product_attribute_id' => $attributeId],
                    ['value' => $value]
                );
            }
        }

        /*
        |==========================================================================
        | B. STOCK TRANSACTIONS — contoh semua status & tipe
        |==========================================================================
        |
        | type   : 'in'  = barang masuk, 'out' = barang keluar
        | status : 'pending'   = dibuat manajer, menunggu konfirmasi staff
        |          'confirmed' = sudah dikonfirmasi, stok sudah berubah
        |
        */

        $laptop  = Product::where('name', 'Laptop ASUS VivoBook 15')->first();
        $hp      = Product::where('name', 'Smartphone Samsung Galaxy A54')->first();
        $printer = Product::where('name', 'Printer Canon PIXMA G2020')->first();
        $kaos    = Product::where('name', 'Kaos Polos Cotton Combed 30s')->first();
        $jaket   = Product::where('name', 'Jaket Fleece Polos')->first();
        $beras   = Product::where('name', 'Beras Premium 5kg')->first();
        $minyak  = Product::where('name', 'Minyak Goreng Bimoli 2L')->first();

        // ── CONFIRMED (stok sudah berubah) ───────────────────────────────────
        $confirmed = [
            // Barang masuk bulan lalu
            ['product_id' => $laptop->id,  'user_id' => $manajer->id, 'type' => 'in',  'qty' => 15, 'note' => 'Restock batch 1 dari PT Elektronik Nusantara',       'created_at' => now()->subDays(20)],
            ['product_id' => $hp->id,      'user_id' => $manajer->id, 'type' => 'in',  'qty' => 25, 'note' => 'Penerimaan order bulan lalu',                        'created_at' => now()->subDays(18)],
            ['product_id' => $kaos->id,    'user_id' => $manajer->id, 'type' => 'in',  'qty' => 80, 'note' => 'Restock kaos dari CV Sandang Jaya',                  'created_at' => now()->subDays(15)],
            ['product_id' => $minyak->id,  'user_id' => $manajer->id, 'type' => 'in',  'qty' => 100,'note' => 'Penerimaan minyak goreng dari PT Pangan Makmur',     'created_at' => now()->subDays(14)],
            // Barang keluar minggu lalu
            ['product_id' => $laptop->id,  'user_id' => $manajer->id, 'type' => 'out', 'qty' => 5,  'note' => 'Pengiriman ke cabang Jakarta Selatan',               'created_at' => now()->subDays(10)],
            ['product_id' => $hp->id,      'user_id' => $manajer->id, 'type' => 'out', 'qty' => 8,  'note' => 'Penjualan ke reseller Bandung',                      'created_at' => now()->subDays(8)],
            ['product_id' => $kaos->id,    'user_id' => $manajer->id, 'type' => 'out', 'qty' => 30, 'note' => 'Distribusi ke toko retail Surabaya',                 'created_at' => now()->subDays(6)],
            ['product_id' => $minyak->id,  'user_id' => $manajer->id, 'type' => 'out', 'qty' => 50, 'note' => 'Pengiriman ke distributor Jawa Timur',               'created_at' => now()->subDays(5)],
            ['product_id' => $jaket->id,   'user_id' => $manajer->id, 'type' => 'in',  'qty' => 40, 'note' => 'Restock jaket musim dingin',                         'created_at' => now()->subDays(4)],
            ['product_id' => $jaket->id,   'user_id' => $manajer->id, 'type' => 'out', 'qty' => 10, 'note' => 'Pengiriman ke outlet Bandung',                       'created_at' => now()->subDays(2)],
        ];

        foreach ($confirmed as $t) {
            StockTransaction::create(array_merge($t, ['status' => 'confirmed']));
        }

        // ── PENDING (menunggu konfirmasi staff) ──────────────────────────────
        // Ini yang bisa dicoba staff untuk dikonfirmasi
        $pending = [
            ['product_id' => $beras->id,   'user_id' => $manajer->id, 'type' => 'in',  'qty' => 50, 'note' => 'Restock beras — perlu pengecekan fisik karung',      'created_at' => now()->subHours(6)],
            ['product_id' => $printer->id, 'user_id' => $manajer->id, 'type' => 'in',  'qty' => 5,  'note' => 'Penerimaan printer baru — cek kondisi & kelengkapan', 'created_at' => now()->subHours(4)],
            ['product_id' => $laptop->id,  'user_id' => $manajer->id, 'type' => 'in',  'qty' => 8,  'note' => 'Restock laptop batch 2 — verifikasi serial number',   'created_at' => now()->subHours(3)],
            ['product_id' => $kaos->id,    'user_id' => $manajer->id, 'type' => 'out', 'qty' => 20, 'note' => 'Permintaan kirim ke reseller Jakarta — siapkan dulu',  'created_at' => now()->subHours(2)],
            ['product_id' => $hp->id,      'user_id' => $manajer->id, 'type' => 'out', 'qty' => 5,  'note' => 'Retur ke supplier — unit display rusak',              'created_at' => now()->subHour()],
        ];

        foreach ($pending as $t) {
            StockTransaction::create(array_merge($t, ['status' => 'pending']));
        }

        /*
        |==========================================================================
        | C. STOCK OPNAME — 3 contoh semua status
        |==========================================================================
        |
        | status: draft       = baru dibuat, belum ada item diisi
        |         in_progress = sedang berjalan, staff sedang input stok fisik
        |         completed   = selesai, selisih sudah divalidasi
        |
        */

        $allProducts = Product::all();

        // ── 1. COMPLETED — opname bulan lalu, sudah selesai ─────────────────
        $opname1 = StockOpname::firstOrCreate(
            ['title' => 'Stock Opname Mei 2026'],
            [
                'notes'        => 'Opname rutin akhir bulan Mei. Semua produk diperiksa fisik oleh tim gudang.',
                'status'       => 'completed',
                'created_by'   => $admin->id,
                'completed_by' => $manajer->id,
                'completed_at' => now()->subDays(7),
            ]
        );

        // Data opname selesai — ada selisih pada beberapa produk
        $opname1Data = [
            // [system_stock, physical_stock, difference, notes]
            [$laptop->id,  15, 14, -1, 'Selisih 1 unit — kemungkinan unit display'],
            [$hp->id,      17, 17,  0, 'Sesuai sistem'],
            [$kaos->id,    50, 52,  2, 'Kelebihan 2 unit — kemungkinan salah catat sebelumnya'],
            [$minyak->id, 150, 148, -2, 'Selisih 2 unit — kemungkinan pecah dalam pengiriman'],
            [$jaket->id,   30, 30,  0, 'Sesuai sistem'],
            [$beras->id,    4,  4,  0, 'Sesuai sistem'],
        ];

        foreach ($opname1Data as [$productId, $sys, $phys, $diff, $note]) {
            StockOpnameItem::firstOrCreate(
                ['stock_opname_id' => $opname1->id, 'product_id' => $productId],
                ['system_stock' => $sys, 'physical_stock' => $phys, 'difference' => $diff, 'notes' => $note]
            );
        }

        // ── 2. IN_PROGRESS — opname sedang berjalan, bisa dicoba staff ──────
        $opname2 = StockOpname::firstOrCreate(
            ['title' => 'Stock Opname Juni 2026 — Minggu 1'],
            [
                'notes'      => 'Opname awal bulan Juni. Staff gudang silakan input stok fisik masing-masing produk.',
                'status'     => 'in_progress',
                'created_by' => $admin->id,
            ]
        );

        foreach ($allProducts as $p) {
            StockOpnameItem::firstOrCreate(
                ['stock_opname_id' => $opname2->id, 'product_id' => $p->id],
                [
                    'system_stock'   => $p->stock,
                    'physical_stock' => null,  // belum diisi — dicoba di UI
                    'difference'     => null,
                    'notes'          => null,
                ]
            );
        }

        // ── 3. DRAFT — baru dibuat, belum ada item sama sekali ───────────────
        StockOpname::firstOrCreate(
            ['title' => 'Stock Opname Juni 2026 — Minggu 2'],
            [
                'notes'      => 'Direncanakan untuk minggu kedua Juni. Belum dimulai.',
                'status'     => 'draft',
                'created_by' => $admin->id,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ACTIVITY LOGS
        |--------------------------------------------------------------------------
        */

        $logs = [
            [$admin->id,   'Tambah Atribut',      'Menambahkan atribut: Ukuran Pakaian (select)',            now()->subDays(20)],
            [$admin->id,   'Tambah Atribut',      'Menambahkan atribut: Warna (color)',                      now()->subDays(20)],
            [$admin->id,   'Tambah Atribut',      'Menambahkan atribut: Garansi (select)',                   now()->subDays(20)],
            [$manajer->id, 'Tambah Produk',       'Menambahkan produk: Laptop ASUS VivoBook 15',             now()->subDays(19)],
            [$manajer->id, 'Tambah Produk',       'Menambahkan produk: Smartphone Samsung Galaxy A54',       now()->subDays(19)],
            [$manajer->id, 'Buat Transaksi Masuk','Barang masuk 15 unit Laptop ASUS (pending)',              now()->subDays(6)],
            [$staff->id,   'Konfirmasi Transaksi','Mengkonfirmasi penerimaan 15 unit Laptop ASUS',           now()->subDays(6)],
            [$admin->id,   'Buat Stock Opname',   'Membuat sesi: Stock Opname Mei 2026',                     now()->subDays(8)],
            [$manajer->id, 'Selesaikan Opname',   'Menyelesaikan Stock Opname Mei 2026 — 6 produk diperiksa',now()->subDays(7)],
            [$manajer->id, 'Buat Transaksi Masuk','Barang masuk 50 unit Beras Premium (pending)',            now()->subHours(6)],
            [$manajer->id, 'Buat Transaksi Keluar','Barang keluar 20 unit Kaos (pending)',                   now()->subHours(2)],
            [$admin->id,   'Buat Stock Opname',   'Membuat sesi: Stock Opname Juni 2026 — Minggu 1',         now()->subHours(1)],
        ];

        foreach ($logs as [$userId, $activity, $description, $createdAt]) {
            ActivityLog::create([
                'user_id'     => $userId,
                'activity'    => $activity,
                'description' => $description,
                'created_at'  => $createdAt,
                'updated_at'  => $createdAt,
            ]);
        }
    }
}