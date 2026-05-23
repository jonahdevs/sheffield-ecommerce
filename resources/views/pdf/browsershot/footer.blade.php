<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            font-size: 9px;
            color: #6B7280;
        }

        .footer {
            width: 100%;
            padding: 8px 40px;
            border-top: 1px solid #E5E7EB;
            display: flex;
            align-items: flex-start;
        }

        .col {
            margin-right: 32px;
        }

        .col-name {
            font-size: 11px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 3px;
        }

        .col-detail {
            font-size: 9px;
            color: #6B7280;
            line-height: 1.6;
        }

        .prepared-by-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9CA3AF;
            margin-bottom: 2px;
        }

        .prepared-by-name {
            font-size: 9px;
            color: #111827;
        }

        .prepared-by-date {
            font-size: 8px;
            color: #6B7280;
        }

        .page-number {
            font-size: 9px;
            color: #9CA3AF;
        }
    </style>
</head>

<body>
    <div class="footer">

        @if (!empty($isInternal))
            {{-- PACKING SLIP footer: prepared by (left) | page number (right) --}}
            @if (!empty($preparedByName))
                <div class="col">
                    <div class="prepared-by-label">Prepared By</div>
                    <div class="prepared-by-name">{{ $preparedByName }}</div>
                    <div class="prepared-by-date">{{ $preparedAt }}</div>
                </div>
            @endif

            <div style="margin-left: auto;" class="page-number">
                Page <span class="pageNumber"></span> of <span class="totalPages"></span>
            </div>

        @else
            {{-- QUOTATION / INVOICE footer: company info | contact | prepared by --}}
            <div class="col">
                <div class="col-name">Sheffield Steel Systems Limited</div>
                <div class="col-detail">
                    Off Old Mombasa Road, Opposite Hilton Garden Inn<br>
                    P.O. Box 48670-00100, Nairobi, Kenya<br>
                    PIN: P051148391Z
                </div>
            </div>

            <div class="col col-detail">
                +254 713 444 000 / +254 713 777 111<br>
                info@sheffieldafrica.com<br>
                www.sheffieldafrica.com
            </div>

            @if (!empty($preparedByName))
                <div>
                    <div class="prepared-by-label">Prepared By</div>
                    <div class="prepared-by-name">{{ $preparedByName }}</div>
                    <div class="prepared-by-date">{{ $preparedAt }}</div>
                </div>
            @endif
        @endif

    </div>
</body>

</html>
