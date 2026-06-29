<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PageSeeder extends Seeder
{
    /**
     * Legal & policy pages. Where a Markdown file exists under
     * database/data/legal/{slug}.md its contents become the page body;
     * otherwise a placeholder is seeded for editing in the admin.
     *
     * @var list<array{slug: string, title: string, meta_description: ?string}>
     */
    private array $pages = [
        ['slug' => 'terms-and-conditions', 'title' => 'Terms & Conditions', 'meta_description' => 'The terms governing the purchase and supply of goods from Sheffield Steel Systems Limited.'],
        ['slug' => 'terms-of-service', 'title' => 'Terms of Service', 'meta_description' => 'The general terms of service governing Sheffield Steel Systems Limited products and services.'],
        ['slug' => 'privacy-policy', 'title' => 'Privacy Policy', 'meta_description' => 'How Sheffield Steel Systems Limited collects, uses and protects your personal data.'],
        ['slug' => 'returns-policy', 'title' => 'Returns Policy', 'meta_description' => 'Sheffield\'s exchange-only returns policy: eligibility, credit notes and how exchanges work.'],
        ['slug' => 'shipping-policy', 'title' => 'Shipping Policy', 'meta_description' => null],
        ['slug' => 'cookie-policy', 'title' => 'Cookie Policy', 'meta_description' => null],
    ];

    public function run(): void
    {
        $placeholder = 'This content is managed in the admin under Content → Pages. Replace this placeholder with the real copy.';

        foreach ($this->pages as $page) {
            $file = database_path("data/legal/{$page['slug']}.md");

            Page::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'body' => File::exists($file) ? trim(File::get($file)) : $placeholder,
                    'meta_description' => $page['meta_description'],
                    'is_published' => true,
                ],
            );
        }
    }
}
