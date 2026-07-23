#!/usr/bin/env python3
"""AI product-image enhancement via the Gemini image API ("Nano Banana").

Sends one product photo to Gemini with an editing prompt that sharpens/cleans the
shot and neutralises the background, then writes the returned image. Intended to run
*before* scripts/process_product_image.py (which does the true transparent cutout +
square centering), so this only has to improve clarity and lighting.

    GEMINI_API_KEY=... python scripts/gemini_enhance.py <input> <output>
        [--model gemini-2.5-flash-image] [--timeout 120]

Uses only the Python standard library (no extra dependencies). Exits non-zero with a
message on stderr so the caller can log and fall back to the un-enhanced original.

IMPORTANT: AI regenerates the image and may subtly alter product details. This is a
deliberate, opt-in step - the prompt instructs the model to preserve the product
exactly, but callers should treat the output as needing human review.
"""

from __future__ import annotations

import argparse
import base64
import json
import mimetypes
import os
import sys
import urllib.error
import urllib.request
from pathlib import Path

PROMPT = (
    "Recreate this as a high-resolution, razor-sharp, professional e-commerce product "
    "photograph on a pure white studio background. Keep the product EXACTLY as shown: "
    "identical shape, proportions, colours, materials, buttons, ports, and all text, "
    "labels, logos and model numbers. Do not add, remove, redesign, or invent any part. "
    "Only improve focus, lighting, clarity and noise; remove the original background and "
    "any clutter. Center the product with a small even margin."
)

ENDPOINT = "https://generativelanguage.googleapis.com/v1beta/models/{model}:generateContent"


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(description="Enhance a product image with Gemini.")
    parser.add_argument("input", help="Path to the source image.")
    parser.add_argument("output", help="Path to write the enhanced image.")
    parser.add_argument("--model", default="gemini-2.5-flash-image", help="Gemini image model id.")
    parser.add_argument("--timeout", type=int, default=120, help="HTTP timeout in seconds.")
    return parser.parse_args()


def extract_image(payload: dict) -> bytes | None:
    """Pull the first inline image out of a generateContent response."""
    for candidate in payload.get("candidates", []):
        for part in candidate.get("content", {}).get("parts", []):
            inline = part.get("inlineData") or part.get("inline_data")
            if inline and inline.get("data"):
                return base64.b64decode(inline["data"])
    return None


def main() -> int:
    args = parse_args()

    api_key = os.environ.get("GEMINI_API_KEY", "").strip()
    if not api_key:
        print("GEMINI_API_KEY is not set", file=sys.stderr)
        return 3

    src = Path(args.input)
    if not src.is_file():
        print(f"input not found: {src}", file=sys.stderr)
        return 2

    mime = mimetypes.guess_type(str(src))[0] or "image/jpeg"
    data = base64.b64encode(src.read_bytes()).decode("ascii")

    body = json.dumps({
        "contents": [{
            "parts": [
                {"text": PROMPT},
                {"inline_data": {"mime_type": mime, "data": data}},
            ],
        }],
        "generationConfig": {"responseModalities": ["TEXT", "IMAGE"]},
    }).encode("utf-8")

    request = urllib.request.Request(
        ENDPOINT.format(model=args.model),
        data=body,
        headers={"Content-Type": "application/json", "x-goog-api-key": api_key},
        method="POST",
    )

    try:
        with urllib.request.urlopen(request, timeout=args.timeout) as response:
            payload = json.loads(response.read().decode("utf-8"))
    except urllib.error.HTTPError as exc:
        detail = exc.read().decode("utf-8", "replace")[:500]
        print(f"gemini HTTP {exc.code}: {detail}", file=sys.stderr)
        return 1
    except Exception as exc:  # noqa: BLE001 - report and let the caller fall back.
        print(f"gemini request failed: {exc}", file=sys.stderr)
        return 1

    image = extract_image(payload)
    if image is None:
        print("gemini returned no image", file=sys.stderr)
        return 1

    out = Path(args.output)
    out.parent.mkdir(parents=True, exist_ok=True)
    out.write_bytes(image)
    print(str(out))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
