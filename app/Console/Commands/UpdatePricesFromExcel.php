<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class UpdatePricesFromExcel extends Command
{
    protected $signature = 'products:update-prices 
                            {file? : Path to Excel file (default: database/seeders/data/E-C0MMERCE APPROVED PRICE LIST.xlsx)}
                            {--dry-run : Show what would be updated without making changes}
                            {--backup : Create backup before updating}
                            {--debug : Show detailed debug information}';

    protected $description = 'Update product prices from Excel file using Item No (SKU) as identifier';

    public function handle()
    {
        $filePath = $this->argument('file') ?? database_path('seeders/data/E-C0MMERCE APPROVED PRICE LIST.xlsx');
        $isDryRun = $this->option('dry-run');
        $createBackup = $this->option('backup');

        // Check if Excel file exists
        if (!File::exists($filePath)) {
            $this->error("Excel file not found: {$filePath}");
            return Command::FAILURE;
        }

        // Check if products.json exists
        $jsonPath = database_path('seeders/data/products.json');
        if (!File::exists($jsonPath)) {
            $this->error("products.json not found: {$jsonPath}");
            return Command::FAILURE;
        }

        $this->info('📊 Reading Excel file...');

        // Read all sheets from Excel file
        $allSheets = Excel::toCollection(new class implements ToCollection {
            public function collection(Collection $collection)
            {
            }
        }, $filePath);

        if ($allSheets->isEmpty()) {
            $this->error('Excel file is empty');
            return Command::FAILURE;
        }

        $this->info("✓ Found " . $allSheets->count() . " sheet(s) in Excel file");

        // Build price map from all sheets
        $priceMap = [];
        $totalExcelRows = 0;
        $debug = $this->option('debug');

        foreach ($allSheets as $sheetIndex => $sheetData) {
            if ($sheetData->isEmpty()) {
                continue;
            }

            // Try to find header row (look for "item no" in first 5 rows)
            $headerRowIndex = null;
            foreach ($sheetData->take(5) as $index => $row) {
                $rowText = strtolower($row->implode(' '));
                if (str_contains($rowText, 'item no') || str_contains($rowText, 'item_no') || str_contains($rowText, 'sku')) {
                    $headerRowIndex = $index;
                    break;
                }
            }

            if ($headerRowIndex === null) {
                $this->warn("Sheet {$sheetIndex}: Could not find header row, skipping.");
                continue;
            }

            // Get headers
            $headers = $sheetData->get($headerRowIndex)->map(fn($cell) => trim(strtolower($cell ?? '')))->toArray();

            // Find column indexes
            $itemNoIndex = null;
            $priceIndex = null;

            foreach ($headers as $index => $header) {
                if ($header === 'item no' || $header === 'item no.') {
                    $itemNoIndex = $index;
                }
                if (str_contains($header, 'e-commerce') && str_contains($header, 'inclusive')) {
                    $priceIndex = $index;
                }
            }

            if ($itemNoIndex === null || $priceIndex === null) {
                $this->warn("Sheet {$sheetIndex}: Missing 'Item No' or price column, skipping. Columns: " . implode(', ', $headers));
                continue;
            }

            $sheetPricesBefore = count($priceMap);

            foreach ($sheetData->skip($headerRowIndex + 1) as $row) {
                $itemNo = trim($row[$itemNoIndex] ?? '');
                $price = $row[$priceIndex] ?? null;

                if (!empty($itemNo)) {
                    $totalExcelRows++;
                }

                if ($debug && (count($priceMap) - $sheetPricesBefore) < 3) {
                    $this->line("Sheet {$sheetIndex} - Row: ItemNo='{$itemNo}', Price='{$price}'");
                }

                if (!empty($itemNo) && $price !== null && $price !== '') {
                    $cleanPrice = preg_replace('/[^0-9.]/', '', (string) $price);
                    if (is_numeric($cleanPrice) && (float) $cleanPrice > 0) {
                        $priceMap[$itemNo] = (float) $cleanPrice;
                    }
                }
            }

            $sheetCount = count($priceMap) - $sheetPricesBefore;
            $this->info("  Sheet {$sheetIndex}: loaded {$sheetCount} prices");
        }

        if ($debug) {
            $this->newLine();
            $this->info('First 5 items in price map:');
            $count = 0;
            foreach ($priceMap as $sku => $price) {
                $this->line("  {$sku} => {$price}");
                if (++$count >= 5)
                    break;
            }
            $this->newLine();
        }

        $this->info("✓ Loaded " . count($priceMap) . " prices from Excel");
        $this->newLine();

        // Load products.json
        $products = json_decode(File::get($jsonPath), true);

        if (!is_array($products)) {
            $this->error('Invalid products.json format');
            return Command::FAILURE;
        }

        // Create backup if requested
        if ($createBackup && !$isDryRun) {
            $timestamp = now()->format('Y-m-d_His');
            $backupPath = database_path("seeders/data/products.json.backup.{$timestamp}");
            File::copy($jsonPath, $backupPath);
            $this->info("✓ Backup created: products.json.backup.{$timestamp}");
            $this->newLine();
        }

        // Update prices
        $stats = [
            'matched' => 0,
            'updated' => 0,
            'unchanged' => 0,
            'not_found' => 0,
        ];

        $this->info('🔄 Processing products...');
        $progressBar = $this->output->createProgressBar(count($products));

        foreach ($products as &$product) {
            $sku = $product['sku'] ?? null;

            if (!$sku) {
                $progressBar->advance();
                continue;
            }

            if (isset($priceMap[$sku])) {
                $stats['matched']++;
                $newPrice = $priceMap[$sku];
                $oldPrice = $product['price'] ?? 0;

                if ($oldPrice != $newPrice) {
                    if (!$isDryRun) {
                        $product['price'] = $newPrice;
                    }
                    $stats['updated']++;
                } else {
                    $stats['unchanged']++;
                }
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Save updated products.json
        if (!$isDryRun && $stats['updated'] > 0) {
            $jsonOutput = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            File::put($jsonPath, $jsonOutput);
            $this->info('✓ Updated products.json');
        }

        // Display summary
        $this->newLine();
        $this->info('=== Update Summary ===');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Products matched by SKU', $stats['matched']],
                ['Prices updated', $stats['updated']],
                ['Prices unchanged (same value)', $stats['unchanged']],
                ['Total products in JSON', count($products)],
                ['Total products in Excel', $totalExcelRows],
                ['Total prices loaded (with valid price)', count($priceMap)],
            ]
        );

        if ($isDryRun) {
            $this->newLine();
            $this->warn('🔍 DRY RUN MODE: No changes were saved.');
            $this->info('Run without --dry-run to apply changes.');
        }

        return Command::SUCCESS;
    }
}
