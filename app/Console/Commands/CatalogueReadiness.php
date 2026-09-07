<?php

namespace App\Console\Commands;

use App\Support\CopyStandard;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Rescores products.json against the copy standard and rewrites
 * database/data/research/publish-readiness.csv.
 *
 * The report used to be assembled by hand, which meant it aged the moment any
 * copy was edited and could not be trusted to say what a pass had actually
 * moved. Only the structure and listing columns are computed — the data column
 * records research judgements that no rule can derive, so it is read back from
 * the existing CSV and carried forward untouched.
 */
#[Signature('catalogue:readiness {--write : Rewrite publish-readiness.csv in place} {--sku= : Explain one SKU in detail}')]
#[Description('Score every catalogue row against the product copy standard.')]
class CatalogueReadiness extends Command
{
    private const CSV = 'data/research/publish-readiness.csv';

    public function handle(): int
    {
        $rows = json_decode(File::get(database_path('data/products.json')), true);

        if (! is_array($rows)) {
            $this->error('products.json did not parse.');

            return self::FAILURE;
        }

        if ($sku = $this->option('sku')) {
            return $this->explain($rows, $sku);
        }

        $carried = $this->existingDataFails();

        $scored = array_map(
            fn (array $row) => CopyStandard::reportLine($row, $carried[$row['sku'] ?? ''] ?? ''),
            $rows,
        );

        $this->summarise($scored);

        if (! $this->option('write')) {
            $this->newLine();
            $this->comment('Dry run — pass --write to rewrite '.self::CSV);

            return self::SUCCESS;
        }

        $this->write($scored);
        $this->newLine();
        $this->info('Wrote '.self::CSV);

        return self::SUCCESS;
    }

    /**
     * The data column is hand-assigned research (sources disagree, no supplier
     * data, named in open issues). Nothing here can recompute it, so it is
     * preserved verbatim rather than blanked on every run.
     *
     * @return array<string, string>
     */
    private function existingDataFails(): array
    {
        $path = database_path(self::CSV);

        if (! File::exists($path)) {
            return [];
        }

        $handle = fopen($path, 'r');
        fgetcsv($handle);                     // header
        $carried = [];

        while (($line = fgetcsv($handle)) !== false) {
            if (isset($line[0], $line[6])) {
                $carried[$line[0]] = $line[6];
            }
        }

        fclose($handle);

        return $carried;
    }

    /**
     * @param  list<list<string>>  $scored
     */
    private function write(array $scored): void
    {
        $lines = array_map(
            self::encode(...),
            [CopyStandard::REPORT_HEADER, ...$scored],
        );

        File::put(database_path(self::CSV), implode("\n", $lines)."\n");
    }

    /**
     * PHP 8.4's fputcsv quotes any field holding a space, which would rewrite
     * all 683 rows on the first run and bury the real changes in the diff. This
     * quotes only where RFC 4180 requires it, matching the file already on disk.
     *
     * @param  list<string>  $fields
     */
    private static function encode(array $fields): string
    {
        return implode(',', array_map(
            fn (string $field) => preg_match('/[",\r\n]/', $field)
                ? '"'.str_replace('"', '""', $field).'"'
                : $field,
            $fields,
        ));
    }

    /**
     * @param  list<list<string>>  $scored
     */
    private function summarise(array $scored): void
    {
        $ready = count(array_filter($scored, fn (array $l) => $l[4] === 'yes'));
        $reasons = [];

        foreach ($scored as $line) {
            foreach ([5, 6, 7] as $column) {
                foreach (array_filter(array_map('trim', explode(';', $line[$column]))) as $reason) {
                    $reasons[$reason] = ($reasons[$reason] ?? 0) + 1;
                }
            }
        }

        arsort($reasons);

        $this->info(sprintf(
            '%d of %d rows ready to publish — %d blocked.',
            $ready,
            count($scored),
            count($scored) - $ready,
        ));
        $this->newLine();

        $this->table(
            ['rows', 'blocker', 'fixable by'],
            array_map(fn (string $reason, int $count) => [
                $count,
                $reason,
                $this->lane($reason),
            ], array_keys($reasons), $reasons),
        );
    }

    /**
     * Says what each blocker actually needs, so the report sorts into work that
     * can be done at a desk and work that is waiting on somebody else.
     */
    private function lane(string $reason): string
    {
        return match (true) {
            str_contains($reason, 'no image'), str_contains($reason, 'no price') => 'catalogue admin',
            str_contains($reason, 'disagree'),
            str_contains($reason, 'supplier'),
            str_contains($reason, 'open issues'),
            str_contains($reason, 'our records only'),
            str_contains($reason, 'not yet listed'),
            str_contains($reason, 'template skeleton'),
            // A thin spec table is a source-data gap, not a writing one. The
            // standard is explicit that padding it out invents facts.
            str_contains($reason, 'informative spec rows') => 'research / a source',
            default => 'editing',
        };
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     */
    private function explain(array $rows, string $sku): int
    {
        $row = collect($rows)->firstWhere('sku', $sku);

        if ($row === null) {
            $this->error("No catalogue row with SKU {$sku}.");

            return self::FAILURE;
        }

        $this->info($row['sku'].' — '.($row['name'] ?? ''));
        $this->newLine();

        $measure = CopyStandard::measure($row);
        $limits = [
            'short_description_words' => CopyStandard::SHORT_DESCRIPTION_MIN_WORDS.'-'.CopyStandard::SHORT_DESCRIPTION_MAX_WORDS,
            'paragraphs' => '>= '.CopyStandard::PARAGRAPHS_MIN,
            'bullets' => CopyStandard::BULLETS_MIN.'-'.CopyStandard::BULLETS_MAX,
            'longest_bullet_words' => '<= '.CopyStandard::BULLET_MAX_WORDS,
            'meta_chars' => '1-'.CopyStandard::META_MAX_CHARS,
            'informative_spec_rows' => '>= '.CopyStandard::INFORMATIVE_SPEC_ROWS_MIN,
            'prose_words' => '120-180 target',
        ];

        $this->table(
            ['measure', 'value', 'standard'],
            array_map(
                fn (string $key) => [$key, var_export($measure[$key], true), $limits[$key] ?? ''],
                array_keys($measure),
            ),
        );

        foreach ([...CopyStandard::structureFailures($row), ...CopyStandard::listingFailures($row)] as $fail) {
            $this->warn('  ✗ '.$fail);
        }

        return self::SUCCESS;
    }
}
