<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Storage;

class AdminQuotationPdfController extends Controller
{
    public function __construct(private readonly DocumentService $documents) {}

    public function __invoke(Quote $quote)
    {
        abort_unless(auth()->user()?->is_staff, 403);

        $quote->load(['items.product', 'user']);

        if (! $quote->document_path || ! Storage::disk('local')->exists($quote->document_path)) {
            $path = $this->documents->generateQuotation($quote);

            abort_if(! $path, 500, 'Unable to generate quotation PDF.');

            $quote->refresh();
        }

        return Storage::disk('local')->response(
            $quote->document_path,
            "Quotation-{$quote->reference}.pdf",
            ['Content-Type' => 'application/pdf'],
            'inline'
        );
    }
}
