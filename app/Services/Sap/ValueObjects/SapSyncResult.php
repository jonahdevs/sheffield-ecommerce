<?php

namespace App\Services\Sap\ValueObjects;

final readonly class SapSyncResult
{
    /**
     * @param  array<string, mixed>  $rawResponse
     * @param  bool  $alreadyExists  SAP reported the invoice was already created
     *                               for this order - a benign, idempotent outcome
     *                               rather than a fresh creation.
     */
    public function __construct(
        public string $docEntry,
        public ?string $docNumber,
        public array $rawResponse = [],
        public bool $alreadyExists = false,
    ) {}
}
