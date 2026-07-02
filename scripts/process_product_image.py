#!/usr/bin/env python3
"""Product image processor: remove background, center on a square canvas, export WebP.

Called from the `products:process-images` Artisan command (one invocation per image),
but also usable standalone:

    python scripts/process_product_image.py <input> <output> [--size 1200] [--margin 0.06]
        [--bg transparent|FFFFFF] [--quality 90] [--model isnet-general-use]

The rembg model is downloaded and cached on first use (~/.u2net). Subsequent runs are
offline. Exits non-zero with a message on stderr when processing fails so the caller
can log and skip the image.
"""

from __future__ import annotations

import argparse
import sys
from pathlib import Path


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(description="Remove bg, square-center, export WebP.")
    parser.add_argument("input", help="Path to the source image.")
    parser.add_argument("output", help="Path to write the processed WebP image.")
    parser.add_argument("--size", type=int, default=1200, help="Square canvas edge in px.")
    parser.add_argument(
        "--margin",
        type=float,
        default=0.06,
        help="Empty margin around the subject as a fraction of the canvas (0-0.4).",
    )
    parser.add_argument(
        "--bg",
        default="transparent",
        help="'transparent' or a hex colour (e.g. FFFFFF) for the square backdrop.",
    )
    parser.add_argument("--quality", type=int, default=90, help="WebP quality (1-100).")
    parser.add_argument(
        "--model",
        default="isnet-general-use",
        help="rembg model name (isnet-general-use gives clean product cutouts).",
    )
    return parser.parse_args()


def hex_to_rgba(value: str) -> tuple[int, int, int, int]:
    value = value.lstrip("#")
    if len(value) == 3:
        value = "".join(ch * 2 for ch in value)
    if len(value) != 6:
        raise ValueError(f"Invalid hex colour: {value}")
    r, g, b = (int(value[i : i + 2], 16) for i in (0, 2, 4))
    return (r, g, b, 255)


def main() -> int:
    args = parse_args()

    # Imported here so --help works even before deps are installed.
    from PIL import Image
    from rembg import new_session, remove

    src = Path(args.input)
    if not src.is_file():
        print(f"input not found: {src}", file=sys.stderr)
        return 2

    margin = min(max(args.margin, 0.0), 0.4)
    canvas = max(args.size, 16)

    try:
        with Image.open(src) as im:
            im = im.convert("RGBA")

            # 1. Remove the background -> RGBA with an alpha cutout. post_process_mask
            #    cleans up stray specks that would otherwise throw off the bounding box.
            session = new_session(args.model)
            cut = remove(im, session=session, post_process_mask=True)

            # 2. Trim to the subject's bounding box so centering is accurate. Compute the
            #    box from a *thresholded* alpha mask so faint semi-transparent noise in
            #    the corners doesn't inflate the box (which would push the subject off
            #    center). Anything below the alpha threshold is treated as background.
            alpha = cut.getchannel("A")
            mask = alpha.point(lambda a: 255 if a >= 12 else 0)
            bbox = mask.getbbox()
            if bbox:
                cut = cut.crop(bbox)

            # 3. Size the square canvas to the subject so we never upscale (which would
            #    blur small source images). The canvas is the subject's longest side
            #    plus margin, capped at --size; the subject is then scaled to fill the
            #    margined inner region exactly. For sources smaller than the cap this is
            #    a no-op scale at native resolution; larger sources are scaled down.
            longest = max(cut.width, cut.height)
            span = 1.0 - 2.0 * margin
            canvas = min(canvas, max(int(round(longest / span)), 16))
            inner = max(int(round(canvas * span)), 1)
            scale = inner / longest
            subject = cut.resize(
                (max(int(round(cut.width * scale)), 1), max(int(round(cut.height * scale)), 1)),
                Image.LANCZOS,
            )

            # 4. Paste centered onto the square backdrop.
            if args.bg.lower() == "transparent":
                backdrop = Image.new("RGBA", (canvas, canvas), (0, 0, 0, 0))
            else:
                backdrop = Image.new("RGBA", (canvas, canvas), hex_to_rgba(args.bg))

            offset = (
                (canvas - subject.width) // 2,
                (canvas - subject.height) // 2,
            )
            backdrop.paste(subject, offset, subject)

            # 5. Export WebP. Flatten if an opaque backdrop was requested.
            out = Path(args.output)
            out.parent.mkdir(parents=True, exist_ok=True)
            if args.bg.lower() == "transparent":
                backdrop.save(out, "WEBP", quality=args.quality, method=6)
            else:
                backdrop.convert("RGB").save(out, "WEBP", quality=args.quality, method=6)
    except Exception as exc:  # noqa: BLE001 - report and let the caller decide.
        print(f"processing failed: {exc}", file=sys.stderr)
        return 1

    print(str(Path(args.output)))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
