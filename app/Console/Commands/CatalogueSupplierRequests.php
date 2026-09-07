<?php

namespace App\Console\Commands;

use App\Support\CopyStandard;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Writes one specification-request sheet per brand, covering every published row
 * whose record holds too little specification to write a product page from.
 *
 * Section V of catalogue-open-issues.md established that the live site cannot close
 * this gap — 70 of these rows do not exist there at all — so the remaining route is
 * to ask the supplier. These sheets are meant to be sent as they stand.
 *
 * Regenerate after any harvest: rows that gain a specification drop off their sheet.
 */
#[Signature('catalogue:supplier-requests {--write : Write the sheets to database/data/research/supplier-requests}')]
#[Description('Build per-brand specification request sheets for rows with no usable spec.')]
class CatalogueSupplierRequests extends Command
{
    private const OUT = 'data/research/supplier-requests';

    private const INDEX = 'data/research/supplier-requests.md';

    /** A row holding this many informative spec rows can already be written up. */
    private const ENOUGH = 4;

    private const BASE = [
        'External dimensions W x D x H (mm)',
        'Net weight (kg)',
        'Body / contact material and grade',
    ];

    private const ELECTRICAL = [
        'Voltage, frequency and phase',
        'Power rating (kW or W)',
    ];

    /**
     * Matched against the LEAF category, most specific first. Matching the whole
     * category path asked a heat lamp for its GN pan configuration and an induction
     * hob for its gas type, so the leaf is what counts.
     *
     * @return list<array{0: string, 1: list<string>}>
     */
    private function buckets(): array
    {
        return [
            // Passive goods first. Asking a chopping board for its voltage, or a
            // dishwasher rack for its water connection, reads as a form letter.
            ['/Chopping Boards|Dishwasher Racks|Processor Discs|Oven Accessories|Storage Containers/i', [
                'Material, grade and thickness', 'Overall dimensions (mm)', 'Capacity or working size',
                'Compatible machine or oven models', 'Dishwasher safe yes/no',
            ]],
            ['/Cleaner, Care|Green Tabs|Cleaning Chemicals/i', [
                'Pack size and unit count', 'Dosage per cycle', 'Compatible machine models',
                'Safety data sheet', 'Shelf life',
            ]],
            ['/Heat Lamps|Plate & Cup Warmers/i', [...self::ELECTRICAL,
                'Lamp type and rating', 'Heated area or lamp diameter (mm)',
                'Mounting method and height', 'Thermostat range if fitted',
            ]],
            ['/Insect Killers/i', [...self::ELECTRICAL,
                'Lamp type and wattage', 'Effective coverage area (m2)',
                'Mounting method', 'Catch method - glue board or electric grid',
            ]],
            ['/Induction Cookers/i', [...self::ELECTRICAL,
                'Number of zones', 'Power levels or steps', 'Hob top material',
                'Usable pan diameter range (mm)',
            ]],
            ['/Water Boilers|Urns|Juice Dispensers|Coffee Servery/i', [...self::ELECTRICAL,
                'Tank or bowl capacity (litres)', 'Draw-off or output rate',
                'Operating temperature range (C)', 'Refrigerated or heated',
            ]],
            ['/Pots|Pans|Pressure Cooker/i', [
                'Diameter and height (mm)', 'Capacity (litres)', 'Material, grade and gauge',
                'Lid included yes/no', 'Induction compatible yes/no',
            ]],
            // \bIce\b, not "Ice " — the bare substring matched "Ju(ice D)ispensers".
            ['/Refrigerat|Freezer|Chiller|Display|\bIce\b/i', [...self::ELECTRICAL,
                'Gross and net capacity (litres)', 'Operating temperature range (C)',
                'Refrigerant type and charge', 'Insulation type and thickness',
                'Defrost method', 'Climate class',
            ]],
            ['/Fryer|Oven|Cooking Range|Grill|Toaster|Pasta Cooker/i', [...self::ELECTRICAL,
                'Pan or tank capacity (litres)', 'Operating temperature range (C)',
                'Gas type and rating (kW / BTU) if gas', 'Chamber or tray dimensions',
            ]],
            ['/Processor|Mincer|Saw|Chipper|Peeler|Slicer|Marinator|Cutter/i', [...self::ELECTRICAL,
                'Throughput (kg/h or pieces/min)', 'Motor rating (kW)',
                'Blade or disc sizes supplied', 'Feed opening size',
            ]],
            ['/Juice|Blender|Beverage|Coffee/i', [...self::ELECTRICAL,
                'Output (litres/h or cups/h)', 'Bowl or tank capacity (litres)', 'Motor speed (rpm)',
            ]],
            ['/Mixer|Dough|Bakery/i', [...self::ELECTRICAL,
                'Bowl capacity (litres)', 'Motor rating (kW)', 'Speeds and rpm at each speed',
            ]],
            ['/Shelving|Racking|Thermobox|Thermotray|Trolley|Cart/i', [
                'Capacity (litres) or shelf load (kg)', 'Material and grade',
                'Number of shelves or tiers', 'Castors or feet',
            ]],
            ['/Wash|Sanitis|Water Softener|Hygiene/i', [...self::ELECTRICAL,
                'Water connection size', 'Material and grade', 'Coverage or flow rate',
            ]],
            ['/Buffet|Servery|Warmer|Bain Marie|Chafing/i', [...self::ELECTRICAL,
                'Pan configuration (GN sizes)', 'Operating temperature range (C)',
                'Fuel type if not electric',
            ]],
            ['/Floor Care|Cleaning|Vacuum|Brush/i', [...self::ELECTRICAL,
                'Working width (mm)', 'Tank or bag capacity', 'Compatible machine models',
            ]],
        ];
    }

    public function handle(): int
    {
        $rows = $this->collect();

        if ($rows === []) {
            $this->info('Nothing to request — every published row carries a usable specification.');

            return self::SUCCESS;
        }

        $byBrand = collect($rows)->groupBy('brand')->sortByDesc(fn ($l) => $l->count());

        $this->info(sprintf(
            '%d product(s) across %d brand(s) need a specification; %d hold none at all.',
            count($rows),
            $byBrand->count(),
            collect($rows)->where('held', [])->count(),
        ));
        $this->newLine();
        $this->table(
            ['products', 'no spec at all', 'brand'],
            $byBrand->map(fn ($list, $brand) => [
                $list->count(),
                $list->where('held', [])->count(),
                $brand,
            ])->values()->all(),
        );

        if (! $this->option('write')) {
            $this->newLine();
            $this->comment('Dry run — pass --write to rebuild '.self::OUT);

            return self::SUCCESS;
        }

        $this->write($byBrand);
        $this->newLine();
        $this->info('Wrote '.$byBrand->count().' sheet(s) to '.self::OUT);

        return self::SUCCESS;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function collect(): array
    {
        $catalogue = json_decode(File::get(database_path('data/products.json')), true);
        $rows = [];

        foreach ($catalogue as $row) {
            if (($row['status'] ?? '') !== 'published') {
                continue;
            }

            // Only rows the copy standard is already failing on structural grounds —
            // a row that reads fine is not worth a supplier's attention.
            if (CopyStandard::structureFailures($row) === []) {
                continue;
            }

            $held = collect(CopyStandard::specRows($row))
                ->reject(fn (array $cells) => in_array(
                    mb_strtolower(trim($cells[0])), ['brand', 'model', 'model number', 'type'], true,
                ))
                ->map(fn (array $cells) => $cells[0])
                ->values()
                ->all();

            if (count($held) >= self::ENOUGH) {
                continue;
            }

            $category = is_array($row['category'] ?? null) ? $row['category'][0] : ($row['category'] ?? '');

            $rows[] = [
                'sku' => $row['sku'],
                'brand' => $row['brand'] ?? 'UNKNOWN',
                'name' => $row['name'] ?? '',
                'model' => $row['model_number'] ?? '',
                'category' => $category,
                'held' => $held,
                'need' => $this->requestedFor($category, (string) ($row['name'] ?? ''), $held),
            ];
        }

        return $rows;
    }

    /**
     * @param  list<string>  $held
     * @return list<string>
     */
    private function requestedFor(string $category, string $name, array $held): array
    {
        $leaf = trim(Str::afterLast($category, '>'));

        $specific = self::ELECTRICAL;
        foreach ($this->buckets() as [$pattern, $fields]) {
            if (preg_match($pattern, $leaf)) {
                $specific = $fields;
                break;
            }
        }

        // A hand-cranked machine has no voltage, no motor and no rpm. The category
        // cannot tell us this; the product name can — "Manual Vegetable Slicer".
        if (preg_match('/\bmanual\b/i', $name)) {
            $specific = array_values(array_filter(
                $specific,
                fn (string $f) => ! preg_match('/voltage|power rating|motor|rpm|speed/i', $f),
            ));
            $specific[] = 'Operation - hand crank, lever or press';
        }

        // Consumables have no body, no footprint and no weight worth quoting.
        $base = preg_match('/Cleaner, Care|Green Tabs|Cleaning Chemicals/i', $leaf)
            ? []
            // Drop a base field the bucket covers in a better-suited form: a stock pot
            // wants "diameter and height", not that plus a generic W x D x H.
            : array_filter(self::BASE, fn (string $b) => ! collect($specific)->contains(
                fn (string $s) => (Str::contains($b, 'dimension') && Str::contains(mb_strtolower($s), ['dimension', 'diameter and height']))
                    || (Str::contains($b, 'material') && Str::contains(mb_strtolower($s), 'material')),
            ));

        $wanted = [...$base, ...$specific];
        $heldLower = array_map('mb_strtolower', $held);

        // Never ask for what the record already carries.
        return array_values(array_filter($wanted, function (string $want) use ($heldLower) {
            $k = mb_strtolower($want);

            foreach ($heldLower as $h) {
                $covered = (str_contains($k, 'dimension') && str_contains($h, 'dimension'))
                    || (str_contains($k, 'net weight') && str_contains($h, 'weight'))
                    || (str_contains($k, 'voltage') && (str_contains($h, 'voltage') || str_contains($h, 'power suppl')))
                    || (str_contains($k, 'power rating') && $h === 'power')
                    || (str_contains($k, 'capacity') && str_contains($h, 'capacity'))
                    || (str_contains($k, 'temperature') && str_contains($h, 'temperature'))
                    || (str_contains($k, 'refrigerant') && str_contains($h, 'refrigerant'))
                    || (str_contains($k, 'insulation') && str_contains($h, 'insulation'))
                    || (str_contains($k, 'material') && str_contains($h, 'material'))
                    || (str_contains($k, 'motor') && str_contains($h, 'motor'))
                    || (str_contains($k, 'throughput') && (str_contains($h, 'capacity') || str_contains($h, 'yield')));

                if ($covered) {
                    return false;
                }
            }

            return true;
        }));
    }

    /**
     * @param  Collection<string, Collection<int, array<string, mixed>>>  $byBrand
     */
    private function write($byBrand): void
    {
        $dir = database_path(self::OUT);
        File::ensureDirectoryExists($dir);

        foreach (File::files($dir) as $stale) {
            File::delete($stale->getPathname());
        }

        $index = "# Supplier specification requests\n\n"
            ."Generated by `php artisan catalogue:supplier-requests --write`. One sheet per brand,\n"
            .'covering every published row whose record holds fewer than '.self::ENOUGH." informative\n"
            ."specification rows — the rows that cannot be written up no matter how much editing is done.\n\n"
            ."Section V of `catalogue-open-issues.md` established that the live site cannot supply these:\n"
            ."70 of them do not exist there at all. Asking the supplier is the route that closes the gap.\n\n"
            ."Rerun after any harvest — a row that gains a specification drops off its sheet.\n\n"
            ."| brand | products | with no spec at all | sheet |\n|---|---:|---:|---|\n";

        foreach ($byBrand as $brand => $list) {
            $slug = Str::slug($brand);
            File::put($dir.'/'.$slug.'.md', $this->sheet($brand, $list));

            $index .= sprintf(
                "| %s | %d | %d | [%s.md](supplier-requests/%s.md) |\n",
                $brand, $list->count(), $list->where('held', [])->count(), $slug, $slug,
            );
        }

        $index .= sprintf(
            "| **total** | **%d** | **%d** | |\n",
            $byBrand->flatten(1)->count(),
            $byBrand->flatten(1)->where('held', [])->count(),
        );

        File::put(database_path(self::INDEX), $index);
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $list
     */
    private function sheet(string $brand, $list): string
    {
        $none = $list->where('held', [])->count();

        $md = "# Specification request - {$brand}\n\n"
            ."**{$list->count()} product".($list->count() > 1 ? 's' : '').'** on the Sheffield Steel Systems '
            .'catalogue carry too little specification to publish a usable product page. Below is every one '
            ."of them and exactly which figures are missing.\n\n"
            .'Where a row already holds a figure it is shown under "already on file" - please correct it if '
            ."it is wrong, but it does not need re-supplying.\n\n";

        if ($none > 0) {
            $md .= "> {$none} of these {$list->count()} hold **no specification at all** beyond brand, model "
                ."and product type.\n\n";
        }

        $md .= "---\n\n";

        foreach ($list->sortBy(fn (array $r) => count($r['held'])) as $r) {
            $md .= '## '.($r['model'] ?: $r['sku'])." - {$r['name']}\n\n"
                ."- **Our reference:** `{$r['sku']}`\n"
                ."- **Category:** {$r['category']}\n"
                .'- **Already on file:** '.($r['held'] === [] ? '_nothing_' : implode(', ', $r['held']))."\n\n"
                ."**Please supply:**\n\n";

            foreach ($r['need'] as $need) {
                $md .= "- [ ] {$need}\n";
            }

            $md .= "\n";
        }

        return $md."---\n\nPlease return a datasheet or a filled copy of this list. A manufacturer spec "
            ."sheet or catalogue page is ideal - we will transcribe it.\n";
    }
}
