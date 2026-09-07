<?php

use App\Support\CopyStandard;
use Illuminate\Support\Facades\File;

// The copy standard in database/data/research/product-copy-standard-research.md
// was prose, and publish-readiness.csv was assembled by hand — so the scoreboard
// aged the moment any copy was edited, and a pass could quietly undo an earlier
// one. These checks make the report a derived artefact: edit copy, rerun
// `php artisan catalogue:readiness --write`, and the diff shows what moved.
// Pure JSON validation, so no seeding is needed.

/** @return array<int, array<string, mixed>> */
function copyStandardRows(): array
{
    return json_decode(File::get(database_path('data/products.json')), true);
}

/** @return array<string, array<string, string>> keyed by SKU */
function committedReadiness(): array
{
    $lines = preg_split('/\r?\n/', trim(File::get(database_path('data/research/publish-readiness.csv'))));
    $header = str_getcsv(array_shift($lines));

    return collect($lines)
        ->map(fn (string $line) => array_combine($header, str_getcsv($line)))
        ->keyBy('sku')
        ->all();
}

it('keeps publish-readiness.csv in step with the catalogue', function () {
    // The report is the scoreboard the copy passes are planned against. If it
    // can drift from products.json it is worse than no report, because it reads
    // as current. Rerun `php artisan catalogue:readiness --write` to fix.
    $committed = committedReadiness();
    $stale = [];

    foreach (copyStandardRows() as $row) {
        $sku = $row['sku'] ?? '';
        $line = $committed[$sku] ?? null;

        if ($line === null) {
            $stale[] = $sku.' → missing from the report';

            continue;
        }

        $fresh = CopyStandard::reportLine($row, $line['data_fails']);
        $expected = array_combine(CopyStandard::REPORT_HEADER, $fresh);

        foreach (['ready', 'structure_fails', 'listing_fails'] as $column) {
            if ($line[$column] !== $expected[$column]) {
                $stale[] = sprintf(
                    '%s %s → report says "%s", catalogue scores "%s"',
                    $sku, $column, $line[$column], $expected[$column],
                );
            }
        }
    }

    expect($stale)->toBe([]);
});

it('never lets the publishable count go backwards', function () {
    // A ratchet, not a target. 374 of 683 rows were ready when the standard was
    // first enforced on 2026-09-04; raise this number as passes land so a later
    // edit cannot silently undo them.
    $ready = collect(copyStandardRows())
        ->filter(fn (array $row) => CopyStandard::structureFailures($row) === []
            && CopyStandard::listingFailures($row) === [])
        ->count();

    expect($ready)->toBeGreaterThanOrEqual(374);
});

it('measures a spec table without counting its identity rows', function () {
    // The density floor exists so a shopper learns something the product title
    // did not already tell them. Brand/Model/Type rows are identity, not spec —
    // counting them would pass a table that says nothing.
    $row = [
        'technical_specification' => '<table><tbody>'
            .'<tr><td><strong>Brand</strong></td><td>SKYMSEN</td></tr>'
            .'<tr><td><strong>Model</strong></td><td>GC16</td></tr>'
            .'<tr><td><strong>Cut Size</strong></td><td>16 &times; 16 mm</td></tr>'
            .'</tbody></table>',
    ];

    expect(CopyStandard::measure($row))
        ->spec_rows->toBe(3)
        ->informative_spec_rows->toBe(1);
});

it('counts an entity as a character, not a word break', function () {
    // Decoding &deg; to a space split "+100&deg;C" into two words and pushed
    // IMG/BUF/00155 over the short_description ceiling on a punctuation mark.
    $row = ['short_description' => 'Holds +50 to +100&deg;C and 0 to +6&deg;C.'];

    expect(CopyStandard::measure($row)['short_description_words'])->toBe(8);
});
