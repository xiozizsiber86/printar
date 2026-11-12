<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $shop = Shop::where('name', 'Printar Digital Printing')->first();

        if (!$shop) {
            return;
        }

        $services = [
            [
                'category' => 'Cetak Dokumen',
                'name' => 'Cetak Dokumen Hitam Putih',
                'description' => 'Layanan cetak dokumen hitam putih.',
                'price' => 500,
                'unit' => 'lembar',
            ],
            [
                'category' => 'Cetak Dokumen',
                'name' => 'Cetak Dokumen Warna',
                'description' => 'Layanan cetak dokumen berwarna.',
                'price' => 1500,
                'unit' => 'lembar',
            ],
            [
                'category' => 'Fotocopy',
                'name' => 'Fotocopy Hitam Putih',
                'description' => 'Layanan fotokopi dokumen hitam putih.',
                'price' => 300,
                'unit' => 'lembar',
            ],
            [
                'category' => 'Fotocopy',
                'name' => 'Fotocopy Warna',
                'description' => 'Layanan fotokopi dokumen berwarna.',
                'price' => 1500,
                'unit' => 'lembar',
            ],
            [
                'category' => 'Digital Printing',
                'name' => 'Cetak Foto 4R',
                'description' => 'Layanan cetak foto ukuran 4R.',
                'price' => 3000,
                'unit' => 'lembar',
            ],
            [
                'category' => 'Banner dan Spanduk',
                'name' => 'Cetak Banner',
                'description' => 'Layanan cetak banner untuk promosi dan acara.',
                'price' => 25000,
                'unit' => 'meter',
            ],
            [
                'category' => 'Jilid dan Laminating',
                'name' => 'Laminating A4',
                'description' => 'Layanan laminating dokumen ukuran A4.',
                'price' => 5000,
                'unit' => 'lembar',
            ],
        ];

        foreach ($services as $data) {
            $category = Category::where('name', $data['category'])->first();

            if (!$category) {
                continue;
            }

            Service::updateOrCreate(
                [
                    'shop_id' => $shop->id,
                    'name' => $data['name'],
                ],
                [
                    'category_id' => $category->id,
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'unit' => $data['unit'],
                    'is_active' => true,
                ]
            );
        }
    }
}
