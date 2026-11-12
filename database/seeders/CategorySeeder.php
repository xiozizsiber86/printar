<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Digital Printing',
                'description' => 'Layanan cetak digital untuk berbagai kebutuhan.',
            ],
            [
                'name' => 'Fotocopy',
                'description' => 'Layanan fotokopi dokumen hitam putih dan berwarna.',
            ],
            [
                'name' => 'Cetak Dokumen',
                'description' => 'Layanan cetak dokumen, tugas, dan laporan.',
            ],
            [
                'name' => 'Banner dan Spanduk',
                'description' => 'Layanan cetak banner, spanduk, dan baliho.',
            ],
            [
                'name' => 'Undangan',
                'description' => 'Layanan cetak undangan berbagai acara.',
            ],
            [
                'name' => 'Merchandise',
                'description' => 'Layanan cetak merchandise dan produk promosi.',
            ],
            [
                'name' => 'Jilid dan Laminating',
                'description' => 'Layanan penjilidan dan laminasi dokumen.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
