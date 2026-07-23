@php
    $branding = app(\App\Settings\BrandingSettings::class);
    $store = $branding->store_name ?: config('app.name', 'Sheffield');
    $logoUrl = $branding->favicon_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($branding->favicon_path)
        : '/favicon.svg';
    $contactEmail = app(\App\Settings\BusinessSettings::class)->contact_email ?: 'info@sheffieldafrica.com';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex,nofollow" />
    <title>{{ $store }} - Down for maintenance</title>
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0f1d33;
            background-image: linear-gradient(rgba(15, 29, 51, 0.93), rgba(15, 29, 51, 0.93)),
                url('/images/WEBSITE%20CIRCLES-01.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #e6ddc8;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            padding: 2rem;
        }

        .card {
            max-width: 30rem;
            text-align: center;
        }

        .logo {
            height: 3rem;
            width: auto;
            margin: 0 auto;
        }

        h1 {
            margin: 0.75rem 0 1rem;
            font-size: 1.9rem;
            color: #f6ecd9;
        }

        p {
            margin: 0;
            line-height: 1.65;
            color: #c9bea4;
        }

        .contact {
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #c9bea4;
        }

        .contact a {
            color: #f6ecd9;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="card">
        <img class="logo" src="{{ $logoUrl }}" alt="{{ $store }}" />
        <h1>We’ll be right back</h1>
        <p>{{ $message }}</p>
        <p class="contact">Reach us on <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
    </div>
</body>

</html>
