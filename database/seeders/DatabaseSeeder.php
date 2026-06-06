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
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. USERS — 3 role
        |--------------------------------------------------------------------------
        */

        $admin = User::firstOrCreate(
            ['email' => 'admin@stockify.com'],
            [
                'name'     => 'Admin Stockify',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $manajer = User::firstOrCreate(
            ['email' => 'manajer@stockify.com'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'manajer_gudang',
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@stockify.com'],
            [
                'name'     => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'role'     => 'staff_gudang',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. SETTINGS
        |--------------------------------------------------------------------------
        */

        Setting::firstOrCreate(
            ['key' => 'app_name'],
            ['value' => 'Stockify']
        );

        Setting::firstOrCreate(
            ['key' => 'app_logo'],
            ['value' => null]
        );

        /*
        |--------------------------------------------------------------------------
        | 3. SUPPLIERS
        |--------------------------------------------------------------------------
        */

        $suppliers = [
            [
                'name'    => 'PT Elektronik Nusantara',
                'email'   => 'info@elektronik-nusantara.com',
                'phone'   => '021-5551234',
                'address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
            ],
            [
                'name'    => 'CV Sandang Jaya',
                'email'   => 'order@sandangjaya.co.id',
                'phone'   => '022-7778899',
                'address' => 'Jl. Braga No. 12, Bandung',
            ],
            [
                'name'    => 'PT Pangan Makmur',
                'email'   => 'supply@panganmakmur.com',
                'phone'   => '031-4445566',
                'address' => 'Jl. Darmo No. 88, Surabaya',
            ],
            [
                'name'    => 'UD Mebel Sejahtera',
                'email'   => 'mebel.sejahtera@gmail.com',
                'phone'   => '0274-3332211',
                'address' => 'Jl. Malioboro No. 5, Yogyakarta',
            ],
        ];

        foreach ($suppliers as $s) {
            Supplier::firstOrCreate(['name' => $s['name']], $s);
        }

        $sup1 = Supplier::where('name', 'PT Elektronik Nusantara')->first();
        $sup2 = Supplier::where('name', 'CV Sandang Jaya')->first();
        $sup3 = Supplier::where('name', 'PT Pangan Makmur')->first();
        $sup4 = Supplier::where('name', 'UD Mebel Sejahtera')->first();

        /*
        |--------------------------------------------------------------------------
        | 4. CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = ['Elektronik', 'Pakaian', 'Makanan & Minuman', 'Furnitur', 'Alat Tulis'];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat]);
        }

        $catElektronik = Category::where('name', 'Elektronik')->first();
        $catPakaian    = Category::where('name', 'Pakaian')->first();
        $catMakanan    = Category::where('name', 'Makanan & Minuman')->first();
        $catFurnitur   = Category::where('name', 'Furnitur')->first();
        $catAlatTulis  = Category::where('name', 'Alat Tulis')->first();

        /*
        |--------------------------------------------------------------------------
        | 5. PRODUCT ATTRIBUTES
        |--------------------------------------------------------------------------
        */

        $attrWarna = ProductAttribute::firstOrCreate(
            ['name' => 'Warna'],
            [
                'type'        => 'color',
                'options'     => null,
                'description' => 'Warna produk',
            ]
        );

        $attrUkuran = ProductAttribute::firstOrCreate(
            ['name' => 'Ukuran'],
            [
                'type'        => 'select',
                'options'     => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                'description' => 'Ukuran pakaian',
            ]
        );

        $attrBerat = ProductAttribute::firstOrCreate(
            ['name' => 'Berat (kg)'],
            [
                'type'        => 'number',
                'options'     => null,
                'description' => 'Berat produk dalam kg',
            ]
        );

        $attrGaransi = ProductAttribute::firstOrCreate(
            ['name' => 'Garansi'],
            [
                'type'        => 'select',
                'options'     => ['1 Bulan', '3 Bulan', '6 Bulan', '1 Tahun', '2 Tahun'],
                'description' => 'Masa garansi produk',
            ]
        );

        $attrMaterial = ProductAttribute::firstOrCreate(
            ['name' => 'Material'],
            [
                'type'        => 'text',
                'options'     => null,
                'description' => 'Bahan / material produk',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 6. PRODUCTS
        |--------------------------------------------------------------------------
        */

        $products = [
            // Elektronik
            [
                'category_id' => $catElektronik->id,
                'supplier_id' => $sup1->id,
                'name'        => 'Laptop ASUS VivoBook 15',
                'description' => 'Laptop tipis dan ringan dengan prosesor Intel Core i5, RAM 8GB, SSD 512GB. Cocok untuk pelajar dan profesional.',
                'stock'       => 25,
                'min_stock'   => 5,
                'harga_beli'  => 7500000,
                'harga_jual'  => 9200000,
                'attrs'       => [
                    $attrWarna->id   => '#2563EB',
                    $attrBerat->id   => '1.8',
                    $attrGaransi->id => '1 Tahun',
                ],
            ],
            [
                'category_id' => $catElektronik->id,
                'supplier_id' => $sup1->id,
                'name'        => 'Smartphone Samsung Galaxy A54',
                'description' => 'HP Android terbaru dengan kamera 50MP, baterai 5000mAh, layar Super AMOLED 6.4 inci.',
                'stock'       => 40,
                'min_stock'   => 8,
                'harga_beli'  => 4200000,
                'harga_jual'  => 5100000,
                'attrs'       => [
                    $attrWarna->id   => '#1E1E1E',
                    $attrBerat->id   => '0.202',
                    $attrGaransi->id => '1 Tahun',
                ],
            ],
            [
                'category_id' => $catElektronik->id,
                'supplier_id' => $sup1->id,
                'name'        => 'Printer Canon PIXMA G2020',
                'description' => 'Printer inkjet multifungsi dengan tangki tinta isi ulang. Hemat biaya cetak untuk kebutuhan kantor.',
                'stock'       => 3,
                'min_stock'   => 5,
                'harga_beli'  => 1350000,
                'harga_jual'  => 1750000,
                'attrs'       => [
                    $attrWarna->id   => '#000000',
                    $attrBerat->id   => '3.8',
                    $attrGaransi->id => '1 Tahun',
                ],
            ],
            // Pakaian
            [
                'category_id' => $catPakaian->id,
                'supplier_id' => $sup2->id,
                'name'        => 'Kaos Polos Cotton Combed 30s',
                'description' => 'Kaos polos berkualitas tinggi dari bahan cotton combed 30s. Lembut, adem, dan awet untuk pemakaian sehari-hari.',
                'stock'       => 150,
                'min_stock'   => 20,
                'harga_beli'  => 35000,
                'harga_jual'  => 65000,
                'attrs'       => [
                    $attrWarna->id    => '#FFFFFF',
                    $attrUkuran->id   => 'M',
                    $attrMaterial->id => 'Cotton Combed 30s',
                ],
            ],
            [
                'category_id' => $catPakaian->id,
                'supplier_id' => $sup2->id,
                'name'        => 'Jaket Fleece Polos',
                'description' => 'Jaket fleece tebal dan hangat, cocok untuk outdoor maupun aktivitas sehari-hari. Tersedia berbagai ukuran.',
                'stock'       => 60,
                'min_stock'   => 10,
                'harga_beli'  => 85000,
                'harga_jual'  => 145000,
                'attrs'       => [
                    $attrWarna->id    => '#374151',
                    $attrUkuran->id   => 'L',
                    $attrMaterial->id => 'Fleece 270 GSM',
                ],
            ],
            // Makanan
            [
                'category_id' => $catMakanan->id,
                'supplier_id' => $sup3->id,
                'name'        => 'Minyak Goreng Bimoli 2L',
                'description' => 'Minyak goreng sawit murni kemasan 2 liter. Bebas kolesterol, jernih, dan tahan lama untuk memasak.',
                'stock'       => 200,
                'min_stock'   => 30,
                'harga_beli'  => 28000,
                'harga_jual'  => 35000,
                'attrs'       => [
                    $attrBerat->id => '1.84',
                ],
            ],
            [
                'category_id' => $catMakanan->id,
                'supplier_id' => $sup3->id,
                'name'        => 'Beras Premium 5kg',
                'description' => 'Beras putih premium pulen, hasil panen terbaik dari petani lokal. Bebas kutu dan bersih.',
                'stock'       => 4,
                'min_stock'   => 10,
                'harga_beli'  => 68000,
                'harga_jual'  => 82000,
                'attrs'       => [
                    $attrBerat->id => '5',
                ],
            ],
            // Furnitur
            [
                'category_id' => $catFurnitur->id,
                'supplier_id' => $sup4->id,
                'name'        => 'Kursi Kerja Ergonomis',
                'description' => 'Kursi kerja dengan sandaran punggung ergonomis, penyangga lumbar, dan ketinggian yang dapat disesuaikan.',
                'stock'       => 18,
                'min_stock'   => 3,
                'harga_beli'  => 850000,
                'harga_jual'  => 1250000,
                'attrs'       => [
                    $attrWarna->id    => '#1F2937',
                    $attrMaterial->id => 'Mesh & Foam',
                    $attrBerat->id    => '12',
                ],
            ],
            // Alat Tulis
            [
                'category_id' => $catAlatTulis->id,
                'supplier_id' => null,
                'name'        => 'Pulpen Pilot G2 (1 Lusin)',
                'description' => 'Pulpen gel premium Pilot G2, tinta hitam halus dan tidak mudah bocor. Isi 12 pcs per lusin.',
                'stock'       => 80,
                'min_stock'   => 15,
                'harga_beli'  => 42000,
                'harga_jual'  => 60000,
                'attrs'       => [
                    $attrWarna->id => '#000000',
                ],
            ],
        ];

        foreach ($products as $p) {
            $attrs = $p['attrs'] ?? [];
            unset($p['attrs']);

            $product = Product::firstOrCreate(['name' => $p['name']], $p);

            foreach ($attrs as $attributeId => $value) {
                ProductAttributeValue::firstOrCreate(
                    [
                        'product_id'           => $product->id,
                        'product_attribute_id' => $attributeId,
                    ],
                    ['value' => $value]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 7. STOCK TRANSACTIONS — contoh semua status
        |--------------------------------------------------------------------------
        */

        $laptop    = Product::where('name', 'Laptop ASUS VivoBook 15')->first();
        $hp        = Product::where('name', 'Smartphone Samsung Galaxy A54')->first();
        $kaos      = Product::where('name', 'Kaos Polos Cotton Combed 30s')->first();
        $minyak    = Product::where('name', 'Minyak Goreng Bimoli 2L')->first();
        $beras     = Product::where('name', 'Beras Premium 5kg')->first();
        $printer   = Product::where('name', 'Printer Canon PIXMA G2020')->first();

        $transactions = [
            // Confirmed (sudah diproses — stok sudah berubah)
            [
                'product_id' => $laptop->id,
                'user_id'    => $manajer->id,
                'type'       => 'in',
                'qty'        => 10,
                'note'       => 'Penerimaan batch pertama dari PT Elektronik Nusantara',
                'status'     => 'confirmed',
                'created_at' => now()->subDays(15),
            ],
            [
                'product_id' => $laptop->id,
                'user_id'    => $manajer->id,
                'type'       => 'out',
                'qty'        => 3,
                'note'       => 'Pengiriman ke cabang Jakarta Selatan',
                'status'     => 'confirmed',
                'created_at' => now()->subDays(10),
            ],
            [
                'product_id' => $hp->id,
                'user_id'    => $manajer->id,
                'type'       => 'in',
                'qty'        => 20,
                'note'       => 'Restock bulan ini',
                'status'     => 'confirmed',
                'created_at' => now()->subDays(8),
            ],
            [
                'product_id' => $kaos->id,
                'user_id'    => $manajer->id,
                'type'       => 'in',
                'qty'        => 50,
                'note'       => 'Barang masuk dari CV Sandang Jaya',
                'status'     => 'confirmed',
                'created_at' => now()->subDays(5),
            ],
            [
                'product_id' => $minyak->id,
                'user_id'    => $manajer->id,
                'type'       => 'out',
                'qty'        => 30,
                'note'       => 'Distribusi ke toko retail Surabaya',
                'status'     => 'confirmed',
                'created_at' => now()->subDays(3),
            ],
            // Pending — menunggu konfirmasi staff
            [
                'product_id' => $beras->id,
                'user_id'    => $manajer->id,
                'type'       => 'in',
                'qty'        => 50,
                'note'       => 'Restock beras dari PT Pangan Makmur, menunggu pemeriksaan fisik',
                'status'     => 'pending',
                'created_at' => now()->subHours(5),
            ],
            [
                'product_id' => $printer->id,
                'user_id'    => $manajer->id,
                'type'       => 'in',
                'qty'        => 5,
                'note'       => 'Pengiriman printer, perlu pengecekan kondisi',
                'status'     => 'pending',
                'created_at' => now()->subHours(2),
            ],
            [
                'product_id' => $kaos->id,
                'user_id'    => $manajer->id,
                'type'       => 'out',
                'qty'        => 20,
                'note'       => 'Permintaan pengiriman ke reseller Bandung',
                'status'     => 'pending',
                'created_at' => now()->subHour(),
            ],
        ];

        foreach ($transactions as $t) {
            StockTransaction::create($t);
        }

        /*
        |--------------------------------------------------------------------------
        | 8. STOCK OPNAME — 1 selesai, 1 sedang berjalan
        |--------------------------------------------------------------------------
        */

        // Opname sudah selesai
        $opname1 = StockOpname::firstOrCreate(
            ['title' => 'Stock Opname Mei 2026'],
            [
                'notes'        => 'Opname rutin akhir bulan Mei 2026. Semua produk diperiksa.',
                'status'       => 'completed',
                'created_by'   => $admin->id,
                'completed_by' => $manajer->id,
                'completed_at' => now()->subDays(7),
            ]
        );

        foreach (Product::take(4)->get() as $p) {
            StockOpnameItem::firstOrCreate(
                ['stock_opname_id' => $opname1->id, 'product_id' => $p->id],
                [
                    'system_stock'   => $p->stock + rand(0, 3),
                    'physical_stock' => $p->stock,
                    'difference'     => rand(-2, 0),
                    'notes'          => 'Diperiksa oleh Siti Rahayu',
                ]
            );
        }

        // Opname sedang berjalan
        $opname2 = StockOpname::firstOrCreate(
            ['title' => 'Stock Opname Juni 2026'],
            [
                'notes'      => 'Opname rutin awal bulan Juni 2026.',
                'status'     => 'in_progress',
                'created_by' => $admin->id,
            ]
        );

        foreach (Product::get() as $p) {
            StockOpnameItem::firstOrCreate(
                ['stock_opname_id' => $opname2->id, 'product_id' => $p->id],
                [
                    'system_stock'   => $p->stock,
                    'physical_stock' => null,
                    'difference'     => null,
                    'notes'          => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 9. ACTIVITY LOGS
        |--------------------------------------------------------------------------
        */

        $logs = [
            ['user_id' => $admin->id,   'activity' => 'Login',             'description' => 'Admin masuk ke sistem',                           'created_at' => now()->subDays(15)],
            ['user_id' => $admin->id,   'activity' => 'Tambah Kategori',   'description' => 'Menambahkan kategori baru: Elektronik',            'created_at' => now()->subDays(15)],
            ['user_id' => $admin->id,   'activity' => 'Tambah Supplier',   'description' => 'Menambahkan supplier: PT Elektronik Nusantara',    'created_at' => now()->subDays(14)],
            ['user_id' => $manajer->id, 'activity' => 'Tambah Produk',     'description' => 'Menambahkan produk baru: Laptop ASUS VivoBook 15', 'created_at' => now()->subDays(13)],
            ['user_id' => $manajer->id, 'activity' => 'Buat Transaksi Masuk', 'description' => 'Barang masuk 10 unit Laptop ASUS',             'created_at' => now()->subDays(10)],
            ['user_id' => $staff->id,   'activity' => 'Konfirmasi Transaksi', 'description' => 'Mengkonfirmasi penerimaan 10 unit Laptop ASUS', 'created_at' => now()->subDays(10)],
            ['user_id' => $manajer->id, 'activity' => 'Buat Transaksi Keluar', 'description' => 'Barang keluar 3 unit Laptop ke cabang Jakarta', 'created_at' => now()->subDays(8)],
            ['user_id' => $staff->id,   'activity' => 'Konfirmasi Transaksi', 'description' => 'Mengkonfirmasi pengeluaran 3 unit Laptop',      'created_at' => now()->subDays(8)],
            ['user_id' => $admin->id,   'activity' => 'Buat Stock Opname',  'description' => 'Membuat sesi stock opname: Stock Opname Mei 2026', 'created_at' => now()->subDays(7)],
            ['user_id' => $manajer->id, 'activity' => 'Selesaikan Opname',  'description' => 'Menyelesaikan Stock Opname Mei 2026',             'created_at' => now()->subDays(7)],
            ['user_id' => $manajer->id, 'activity' => 'Buat Transaksi Masuk', 'description' => 'Barang masuk 50 unit Beras Premium (pending)',  'created_at' => now()->subHours(5)],
            ['user_id' => $manajer->id, 'activity' => 'Buat Transaksi Masuk', 'description' => 'Barang masuk 5 unit Printer Canon (pending)',   'created_at' => now()->subHours(2)],
        ];

        foreach ($logs as $log) {
            ActivityLog::create($log);
        }
    }
}