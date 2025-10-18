<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Makmur Mandiri Medika',
                'address' => 'Jl. Contoh Alamat No. 123, Jakarta Selatan, DKI Jakarta 12345',
                'email' => 'info@makmurmandirimedika.com',
                'phone' => '+62 21 1234 5678',
                'whatsapp_link' => 'https://wa.me/6281234567890',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=...',
                'catalog_pdf_path' => null,
            ]
        );
    }
}
