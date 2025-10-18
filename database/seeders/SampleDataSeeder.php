<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample brands
        $brands = [
            [
                'name' => 'Shyna Care',
                'slug' => 'shyna-care',
                'description' => 'Brand terpercaya untuk produk consumable medis berkualitas tinggi.',
            ],
            [
                'name' => 'ShynaMed',
                'slug' => 'shynamed',
                'description' => 'Solusi instrument medis dengan teknologi terdepan.',
            ],
            [
                'name' => 'ShyNLAB',
                'slug' => 'shynlab',
                'description' => 'Peralatan laboratorium medis yang akurat dan handal.',
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        // Create sample categories
        $categories = [
            [
                'brand_id' => 1,
                'name' => 'Consumable',
                'slug' => 'consumable',
                'description' => 'Produk consumable medis sekali pakai.',
            ],
            [
                'brand_id' => 2,
                'name' => 'Instrument',
                'slug' => 'instrument',
                'description' => 'Alat instrument medis untuk diagnosis dan perawatan.',
            ],
            [
                'brand_id' => 3,
                'name' => 'Laboratory',
                'slug' => 'laboratory',
                'description' => 'Peralatan laboratorium medis.',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Alcohol Swab 70%',
                'slug' => 'alcohol-swab-70',
                'brand_id' => 1,
                'category_id' => 1,
                'description' => 'Alcohol swab 70% untuk sterilisasi kulit sebelum injeksi atau prosedur medis lainnya. Praktis dan higienis.',
                'size' => '100 pcs/pack',
                'price' => 25000,
                'stock' => 100,
                'e_catalog_url' => 'https://example.com/alcohol-swab',
                'is_active' => true,
            ],
            [
                'name' => 'Surgical Mask 3 Ply',
                'slug' => 'surgical-mask-3-ply',
                'brand_id' => 1,
                'category_id' => 1,
                'description' => 'Masker bedah 3 lapis dengan filter bakteri dan virus. Nyaman digunakan untuk aktivitas sehari-hari.',
                'size' => '50 pcs/box',
                'price' => 45000,
                'stock' => 50,
                'e_catalog_url' => 'https://example.com/surgical-mask',
                'is_active' => true,
            ],
            [
                'name' => 'Infusion Set',
                'slug' => 'infusion-set',
                'brand_id' => 1,
                'category_id' => 1,
                'description' => 'Set infus lengkap dengan jarum, selang, dan regulator. Steril dan aman untuk penggunaan medis.',
                'size' => '1 set',
                'price' => 15000,
                'stock' => 200,
                'e_catalog_url' => 'https://example.com/infusion-set',
                'is_active' => true,
            ],
            [
                'name' => 'Patient Monitor',
                'slug' => 'patient-monitor',
                'brand_id' => 2,
                'category_id' => 2,
                'description' => 'Monitor pasien dengan layar LCD 12 inch, mengukur EKG, tekanan darah, suhu, dan saturasi oksigen.',
                'size' => '45 x 35 x 15 cm',
                'price' => 15000000,
                'stock' => 5,
                'e_catalog_url' => 'https://example.com/patient-monitor',
                'is_active' => true,
            ],
            [
                'name' => 'ECG Machine',
                'slug' => 'ecg-machine',
                'brand_id' => 2,
                'category_id' => 2,
                'description' => 'Mesin EKG 12 lead dengan printer thermal dan layar LCD. Akurat untuk diagnosis jantung.',
                'size' => '40 x 30 x 20 cm',
                'price' => 25000000,
                'stock' => 3,
                'e_catalog_url' => 'https://example.com/ecg-machine',
                'is_active' => true,
            ],
            [
                'name' => 'Hematology Analyzer',
                'slug' => 'hematology-analyzer',
                'brand_id' => 3,
                'category_id' => 3,
                'description' => 'Analisis hematologi otomatis dengan 22 parameter. Hasil cepat dan akurat untuk diagnosis darah.',
                'size' => '60 x 50 x 40 cm',
                'price' => 50000000,
                'stock' => 2,
                'e_catalog_url' => 'https://example.com/hematology-analyzer',
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create sample settings
        Setting::create([
            'company_name' => 'PT. Makmur Mandiri Medika',
            'company_tagline' => 'Solution for Medical Devices',
            'address' => 'Jl. Pendidikan, Komplek Pesona Cilebut 1 Blok. B2 No.3, Sukaraja, Bogor',
            'phone' => '+62 251 1234567',
            'email' => 'info@makmurmandirimedika.com',
            'whatsapp_link' => 'https://wa.me/6281234567890',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.123456789!2d106.123456789!3d-6.123456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sPT%20Makmur%20Mandiri%20Medika!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid',
        ]);

        $this->command->info('Sample data created successfully!');
    }
}
