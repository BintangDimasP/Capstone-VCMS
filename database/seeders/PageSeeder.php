<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;


class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home - Hero Section',
                'slug'  => 'home-hero',
                'content' => json_encode([
                    'headline' => 'Selamat Datang di Website Kami',
                    'subheadline' => 'VCMS Dynamic Content',
                    'button_text' => 'Explore Now',
                    'image' => null
                ])
            ],
            [
                'title' => 'Home - Layanan',
                'slug'  => 'home-layanan',
                'content' => json_encode([
                    'items' => [
                        ['icon' => 'service-icon-1', 'title' => 'Layanan 1', 'desc' => 'Deskripsi layanan 1'],
                        ['icon' => 'service-icon-2', 'title' => 'Layanan 2', 'desc' => 'Deskripsi layanan 2'],
                    ]
                ])
            ],
            [
                'title' => 'Home - Berita',
                'slug'  => 'home-berita',
                'content' => json_encode([
                    'limit' => 3,
                    'show_date' => true
                ])
            ],
            [
                'title' => 'Home - Footer',
                'slug'  => 'home-footer',
                'content' => json_encode([
                    'copyright' => '© 2025 - Semua Hak Dilindungi',
                    'address'   => 'Jl. Contoh No 123',
                    'email'     => 'info@example.com',
                ])
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
