<?php

namespace App\Support;

/**
 * Single source of truth for the mechanical half of the product copy standard
 * documented in database/data/research/product-copy-standard-research.md.
 *
 * The standard has three kinds of check and only one of them can be automated:
 *
 *   structure → derivable from products.json alone (word counts, bullet counts,
 *               paragraph counts, meta length, spec-row density). This class.
 *   listing   → derivable too, but about the record rather than the copy
 *               (no image, no price). Also this class.
 *   data      → a research judgement — "sources disagree", "no supplier data",
 *               "named in open issues". NOT derivable; those stay hand-assigned
 *               in publish-readiness.csv and are carried forward untouched by
 *               the catalogue:readiness command.
 *
 * Scored against the 683-row catalogue and the hand-built publish-readiness.csv
 * of 2026-09-03, this reproduces every one of the hand-assigned structure and
 * listing flags exactly.
 */
class CopyStandard
{
    /**
     * ⚠ These are the thresholds publish-readiness.csv was actually scored with,
     * and the ones the catalogue was written to (median short_description 25
     * words, 75% of rows between 18 and 38). §3 of the research doc still says
     * "8-30 words" and "≤ 12 words" per bullet, which matches neither the
     * scoreboard nor the copy — under those numbers 173 rows fail on short
     * description and 90 on bullet length. The doc line is the stale one; it is
     * flagged for correction rather than silently adopted here.
     */
    public const SHORT_DESCRIPTION_MIN_WORDS = 18;

    public const SHORT_DESCRIPTION_MAX_WORDS = 38;

    public const PARAGRAPHS_MIN = 2;

    public const BULLETS_MIN = 4;

    public const BULLETS_MAX = 6;

    public const BULLET_MAX_WORDS = 14;

    /** applySeo() uses meta_description verbatim and does not truncate it. */
    public const META_MAX_CHARS = 160;

    public const INFORMATIVE_SPEC_ROWS_MIN = 3;

    /**
     * Spec rows that identify the record rather than describe the machine. A
     * table holding only these tells the shopper nothing they cannot read off
     * the product title, so they do not count toward the density floor.
     */
    private const IDENTITY_LABELS = ['brand', 'model', 'model number', 'type'];

    /** Column order of database/data/research/publish-readiness.csv. */
    public const REPORT_HEADER = [
        'sku', 'brand', 'name', 'status', 'ready', 'structure_fails', 'data_fails', 'listing_fails',
    ];

    /**
     * One row's line in publish-readiness.csv. Lives here rather than in the
     * command so the test that asserts the committed report is still in step
     * cannot drift from the code that writes it.
     *
     * @param  array<string, mixed>  $row
     * @param  string  $dataFails  hand-assigned research column, carried through as-is
     * @return list<string>
     */
    public static function reportLine(array $row, string $dataFails = ''): array
    {
        $structure = self::structureFailures($row);
        $listing = self::listingFailures($row);

        return [
            (string) ($row['sku'] ?? ''),
            (string) ($row['brand'] ?? ''),
            (string) ($row['name'] ?? ''),
            (string) ($row['status'] ?? ''),
            $structure === [] && $listing === [] && $dataFails === '' ? 'yes' : 'no',
            implode('; ', $structure),
            $dataFails,
            implode('; ', $listing),
        ];
    }

    /**
     * Copy-standard failures for one products.json row, in the wording
     * publish-readiness.csv uses.
     *
     * @param  array<string, mixed>  $row
     * @return list<string>
     */
    public static function structureFailures(array $row): array
    {
        $fails = [];
        $m = self::measure($row);

        // Emitted widest-defect-first, the order the hand-built report used:
        // shape of the whole block, then its parts, then the standalone fields.
        // House format is prose paragraphs followed by an <h3> heading over a
        // <ul>. A row missing any of the three was never written to the standard.
        if (! $m['has_heading'] || ! $m['has_list'] || $m['paragraphs'] === 0) {
            $fails[] = 'not house format';
        }

        if ($m['paragraphs'] < self::PARAGRAPHS_MIN) {
            $fails[] = 'under '.self::PARAGRAPHS_MIN.' paragraphs';
        }

        if ($m['bullets'] < self::BULLETS_MIN || $m['bullets'] > self::BULLETS_MAX) {
            $fails[] = 'bullets outside '.self::BULLETS_MIN.'-'.self::BULLETS_MAX;
        }

        if ($m['longest_bullet_words'] > self::BULLET_MAX_WORDS) {
            $fails[] = 'bullet over '.self::BULLET_MAX_WORDS.' words';
        }

        if ($m['meta_chars'] === 0 || $m['meta_chars'] > self::META_MAX_CHARS) {
            $fails[] = 'meta missing or over '.self::META_MAX_CHARS;
        }

        if ($m['short_description_words'] < self::SHORT_DESCRIPTION_MIN_WORDS
            || $m['short_description_words'] > self::SHORT_DESCRIPTION_MAX_WORDS) {
            $fails[] = 'short description outside '
                .self::SHORT_DESCRIPTION_MIN_WORDS.'-'.self::SHORT_DESCRIPTION_MAX_WORDS.' words';
        }

        if ($m['informative_spec_rows'] < self::INFORMATIVE_SPEC_ROWS_MIN) {
            $fails[] = 'under '.self::INFORMATIVE_SPEC_ROWS_MIN.' informative spec rows';
        }

        return $fails;
    }

    /**
     * Record-level failures that stop a row selling regardless of its copy.
     *
     * @param  array<string, mixed>  $row
     * @return list<string>
     */
    public static function listingFailures(array $row): array
    {
        $fails = [];

        if (blank($row['image'] ?? null)) {
            $fails[] = 'no image';
        }

        if (! is_numeric($row['price'] ?? null) || (float) $row['price'] <= 0) {
            $fails[] = 'no price';
        }

        return $fails;
    }

    /**
     * Every number the standard is expressed in, for one row. Exposed so the
     * readiness report can show how far a row misses by, not just that it does.
     *
     * @param  array<string, mixed>  $row
     * @return array<string, int|bool>
     */
    public static function measure(array $row): array
    {
        $description = (string) ($row['description'] ?? '');

        $paragraphs = self::captures('/<p\b[^>]*>(.*?)<\/p>/is', $description);
        $bullets = self::captures('/<li\b[^>]*>(.*?)<\/li>/is', $description);

        $bulletWords = array_map(self::countWords(...), $bullets);

        return [
            'short_description_words' => self::countWords((string) ($row['short_description'] ?? '')),
            'paragraphs' => count($paragraphs),
            'prose_words' => array_sum(array_map(self::countWords(...), $paragraphs)),
            'bullets' => count($bullets),
            'longest_bullet_words' => $bulletWords === [] ? 0 : max($bulletWords),
            'has_heading' => (bool) preg_match('/<h3\b/i', $description),
            'has_list' => (bool) preg_match('/<ul\b/i', $description),
            'meta_chars' => mb_strlen(trim(self::text((string) ($row['meta_description'] ?? '')))),
            'spec_rows' => count(self::specRows($row)),
            'informative_spec_rows' => count(array_filter(
                self::specRows($row),
                fn (array $cells) => ! in_array(mb_strtolower(trim($cells[0])), self::IDENTITY_LABELS, true),
            )),
        ];
    }

    /**
     * Label/value pairs from a row's technical_specification table.
     *
     * ⚠ 11 records store their spec as a <p> list rather than a <table> (see
     * catalogue-open-issues.md §S4). Those legitimately yield no rows here, and
     * a caller appending a spec row must check for a <table> before doing so.
     *
     * @param  array<string, mixed>  $row
     * @return list<array{0: string, 1: string}>
     */
    public static function specRows(array $row): array
    {
        $spec = (string) ($row['technical_specification'] ?? '');

        if (! preg_match('/<table\b/i', $spec)) {
            return [];
        }

        $rows = [];

        foreach (self::captures('/<tr\b[^>]*>(.*?)<\/tr>/is', $spec) as $tr) {
            $cells = array_map(
                fn (string $cell) => trim(self::text($cell)),
                self::captures('/<t[dh]\b[^>]*>(.*?)<\/t[dh]>/is', $tr),
            );

            if ($cells === []) {
                continue;
            }

            $rows[] = [$cells[0], $cells[1] ?? ''];
        }

        return $rows;
    }

    /**
     * @return list<string>
     */
    private static function captures(string $pattern, string $subject): array
    {
        preg_match_all($pattern, $subject, $matches);

        return $matches[1] ?? [];
    }

    /**
     * Markup to readable text. Tags become a space because they are genuine word
     * boundaries; entities become their character because they are not — decoding
     * &deg; to a space split "+100&deg;C" into two words and over-counted every
     * temperature range in the catalogue by one.
     */
    private static function text(string $html): string
    {
        $stripped = preg_replace('/<[^>]+>/', ' ', $html) ?? '';

        return html_entity_decode($stripped, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private static function countWords(string $html): int
    {
        // /u so the non-breaking space a decoded &nbsp; leaves behind counts as
        // whitespace rather than as part of the word beside it.
        $words = preg_split('/\s+/u', trim(self::text($html)), -1, PREG_SPLIT_NO_EMPTY);

        return count($words ?: []);
    }
}
