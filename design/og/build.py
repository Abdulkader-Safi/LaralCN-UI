#!/usr/bin/env python3
"""
Sovereign Forms — og:image for LaralCN-UI.

A taxonomic plate: the twenty-five registry primitives drawn as specimens.
Emits og.html, rasterised by Chrome at 1200x630, deviceScaleFactor 2.
"""

W, H = 1200, 630

GROUND = "#100E0C"
INK_1 = "#EDE7DC"  # primary ink
INK_2 = "#9C9288"  # secondary
INK_3 = "#5E564E"  # hairline / tertiary
INK_4 = "#332E29"  # faintest structure
ACCENT = "#AE6045"  # tempered oxide — used exactly three times

# ── armature ──────────────────────────────────────────────────────────────────
MARGIN = 62
CW, CH = 132, 92  # cell
BW, BH = 96, 46  # drawing box inside a cell
COLS, ROWS = 5, 5
PLATE_W = (COLS - 1) * CW + BW  # 624 — the specimens' true width
PX = W - MARGIN - PLATE_W  # right edge flush with the mirrored margin
PY = 122
LX = MARGIN

out = []
add = out.append


def esc(s):
    return s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")


def rect(x, y, w, h, r=0, fill="none", stroke=INK_2, sw=1.1, op=1):
    add(
        f'<rect x="{x:.2f}" y="{y:.2f}" width="{w:.2f}" height="{h:.2f}" rx="{r}" '
        f'fill="{fill}" stroke="{stroke}" stroke-width="{sw}" opacity="{op}"/>'
    )


def line(x1, y1, x2, y2, stroke=INK_2, sw=1.1, op=1, cap="round"):
    add(
        f'<line x1="{x1:.2f}" y1="{y1:.2f}" x2="{x2:.2f}" y2="{y2:.2f}" '
        f'stroke="{stroke}" stroke-width="{sw}" stroke-linecap="{cap}" opacity="{op}"/>'
    )


def circle(cx, cy, r, fill="none", stroke=INK_2, sw=1.1, op=1):
    add(
        f'<circle cx="{cx:.2f}" cy="{cy:.2f}" r="{r:.2f}" fill="{fill}" '
        f'stroke="{stroke}" stroke-width="{sw}" opacity="{op}"/>'
    )


def path(d, fill="none", stroke=INK_2, sw=1.1, op=1, cap="round", join="round"):
    add(
        f'<path d="{d}" fill="{fill}" stroke="{stroke}" stroke-width="{sw}" '
        f'stroke-linecap="{cap}" stroke-linejoin="{join}" opacity="{op}"/>'
    )


def text(x, y, s, size=10, fill=INK_2, family="mono", ls=0, weight=400, anchor="start", op=1):
    fam = "'Red Hat Mono'" if family == "mono" else "'Jura'"
    add(
        f'<text x="{x:.2f}" y="{y:.2f}" font-family="{fam}" font-size="{size}" '
        f'font-weight="{weight}" fill="{fill}" letter-spacing="{ls}" '
        f'text-anchor="{anchor}" opacity="{op}">{esc(s)}</text>'
    )


def chevron(cx, cy, s=3.2, direction="down", stroke=INK_2, sw=1.1, op=1):
    if direction == "down":
        d = f"M{cx - s:.2f} {cy - s / 1.8:.2f} L{cx:.2f} {cy + s / 1.8:.2f} L{cx + s:.2f} {cy - s / 1.8:.2f}"
    else:
        d = f"M{cx - s / 1.8:.2f} {cy - s:.2f} L{cx + s / 1.8:.2f} {cy:.2f} L{cx - s / 1.8:.2f} {cy + s:.2f}"
    path(d, stroke=stroke, sw=sw, op=op)


def scrim(x, y):
    """The dimmed page behind an overlay. One tone, used identically everywhere."""
    rect(x + 2, y + 2, 92, 42, 3, fill=INK_4, stroke="none", op=0.6)


# ── the twenty-five specimens ─────────────────────────────────────────────────
# Each receives the top-left corner of its 96x46 drawing box.


def s_accordion(x, y):
    rect(x + 8, y + 2, 80, 11, 2.5, stroke=INK_3)
    chevron(x + 80, y + 7.5, 2.6, "down", INK_3)
    rect(x + 8, y + 16, 80, 20, 2.5, stroke=INK_2)
    line(x + 14, y + 24, x + 66, y + 24, INK_3, 1, 0.85)
    line(x + 14, y + 30, x + 52, y + 30, INK_3, 1, 0.85)
    rect(x + 8, y + 39, 80, 5, 2.5, stroke=INK_3, op=0.55)


def s_alert(x, y):
    rect(x + 6, y + 8, 84, 30, 4, stroke=INK_2)
    circle(x + 17, y + 18, 3.4, stroke=INK_2)
    line(x + 26, y + 18, x + 78, y + 18, INK_2, 1.4)
    line(x + 26, y + 28, x + 62, y + 28, INK_3, 1.1, 0.9)


def s_avatar(x, y):
    circle(x + 26, y + 23, 11.5, stroke=INK_2)
    path(f"M{x + 19.5:.2f} {y + 29.5:.2f} a6.5 5.5 0 0 1 13 0", stroke=INK_2, sw=1.1)
    circle(x + 26, y + 19.5, 4, stroke=INK_2)
    circle(x + 48, y + 23, 11.5, stroke=INK_3, op=0.75)
    circle(x + 70, y + 23, 11.5, stroke=INK_3, op=0.4)


def s_badge(x, y):
    rect(x + 12, y + 16, 30, 14, 7, fill=INK_1, stroke="none")
    rect(x + 48, y + 16, 34, 14, 7, stroke=INK_2)


def s_breadcrumb(x, y):
    line(x + 8, y + 23, x + 26, y + 23, INK_3, 1.4, 0.85)
    chevron(x + 34, y + 23, 3, "right", INK_3)
    line(x + 42, y + 23, x + 60, y + 23, INK_3, 1.4, 0.85)
    chevron(x + 68, y + 23, 3, "right", INK_3)
    line(x + 76, y + 23, x + 90, y + 23, INK_1, 1.6)


def s_button(x, y):
    rect(x + 6, y + 13, 40, 20, 4, fill=INK_1, stroke="none")
    rect(x + 52, y + 13, 40, 20, 4, stroke=INK_2)


def s_card(x, y):
    rect(x + 10, y + 3, 76, 40, 4, stroke=INK_2)
    line(x + 18, y + 14, x + 56, y + 14, INK_1, 1.6)
    line(x + 18, y + 24, x + 78, y + 24, INK_3, 1, 0.9)
    line(x + 18, y + 31, x + 66, y + 31, INK_3, 1, 0.9)
    line(x + 18, y + 38, x + 40, y + 38, INK_3, 1, 0.55)


def s_checkbox(x, y):
    rect(x + 14, y + 15, 16, 16, 3, fill=INK_1, stroke="none")
    path(f"M{x + 18:.2f} {y + 23:.2f} l3.4 3.4 l6.2 -7", stroke=GROUND, sw=2)
    line(x + 38, y + 23, x + 82, y + 23, INK_3, 1.4, 0.9)


def s_collapsible(x, y):
    line(x + 10, y + 8, x + 58, y + 8, INK_2, 1.4)
    chevron(x + 68, y + 8, 3, "down", INK_2)
    path(f"M{x + 16:.2f} {y + 16:.2f} v20", stroke=INK_3, sw=1, op=0.8)
    line(x + 24, y + 21, x + 74, y + 21, INK_3, 1.1, 0.9)
    line(x + 24, y + 30, x + 60, y + 30, INK_3, 1.1, 0.9)


def s_dialog(x, y):
    scrim(x, y)
    rect(x + 20, y + 10, 56, 26, 3.5, fill=GROUND, stroke=INK_1)
    line(x + 27, y + 19, x + 55, y + 19, INK_1, 1.5)
    line(x + 27, y + 26, x + 62, y + 26, INK_3, 1, 0.9)
    line(x + 66, y + 15, x + 70, y + 19, INK_2, 1, 0.9)
    line(x + 70, y + 15, x + 66, y + 19, INK_2, 1, 0.9)


def s_dropdown(x, y):
    rect(x + 10, y + 1, 36, 13, 3, stroke=INK_2)
    chevron(x + 39, y + 7.5, 2.6, "down", INK_2)
    rect(x + 10, y + 18, 60, 26, 3.5, stroke=INK_2)
    line(x + 16, y + 25, x + 56, y + 25, INK_3, 1.1, 0.9)
    line(x + 16, y + 31, x + 48, y + 31, INK_3, 1.1, 0.9)
    line(x + 16, y + 37, x + 52, y + 37, INK_3, 1.1, 0.9)


def s_input(x, y):
    rect(x + 8, y + 14, 80, 18, 3.5, stroke=INK_2)
    line(x + 16, y + 19, x + 16, y + 27, INK_1, 1.4, 1, "butt")
    line(x + 22, y + 23, x + 46, y + 23, INK_3, 1.1, 0.85)


def s_label(x, y):
    line(x + 10, y + 9, x + 34, y + 9, INK_1, 1.8)
    rect(x + 10, y + 17, 76, 17, 3.5, stroke=INK_3)
    line(x + 17, y + 26, x + 44, y + 26, INK_3, 1.1, 0.7)


def s_radio(x, y):
    circle(x + 22, y + 23, 8, stroke=INK_1)
    circle(x + 22, y + 23, 3.6, fill=INK_1, stroke="none")
    circle(x + 48, y + 23, 8, stroke=INK_3)
    line(x + 62, y + 23, x + 88, y + 23, INK_3, 1.4, 0.9)


def s_select(x, y):
    rect(x + 8, y + 14, 80, 18, 3.5, stroke=INK_2)
    line(x + 16, y + 23, x + 48, y + 23, INK_3, 1.1, 0.85)
    chevron(x + 78, y + 23, 3, "down", INK_2)


def s_separator(x, y):
    line(x + 12, y + 12, x + 60, y + 12, INK_3, 1.1, 0.5)
    line(x + 6, y + 23, x + 90, y + 23, INK_1, 1.2)
    line(x + 12, y + 34, x + 48, y + 34, INK_3, 1.1, 0.5)


def s_sheet(x, y):
    scrim(x, y)
    rect(x + 58, y + 2, 36, 42, 3, fill=GROUND, stroke=INK_1)
    line(x + 65, y + 12, x + 87, y + 12, INK_1, 1.5)
    line(x + 65, y + 21, x + 83, y + 21, INK_3, 1.1, 0.9)
    line(x + 65, y + 28, x + 87, y + 28, INK_3, 1.1, 0.9)


def s_sidebar(x, y):
    rect(x + 4, y + 2, 88, 42, 3, stroke=INK_3)
    rect(x + 4, y + 2, 26, 42, 3, fill=INK_4, stroke=INK_3, op=0.9)
    line(x + 10, y + 12, x + 24, y + 12, INK_2, 1.3)
    line(x + 10, y + 20, x + 24, y + 20, INK_3, 1.2, 0.9)
    line(x + 10, y + 28, x + 20, y + 28, INK_3, 1.2, 0.9)
    line(x + 38, y + 14, x + 82, y + 14, INK_3, 1.1, 0.75)
    line(x + 38, y + 23, x + 74, y + 23, INK_3, 1.1, 0.55)


def s_skeleton(x, y):
    rect(x + 10, y + 8, 76, 8, 4, fill=INK_3, stroke="none", op=0.7)
    rect(x + 10, y + 21, 60, 8, 4, fill=INK_3, stroke="none", op=0.55)
    rect(x + 10, y + 34, 40, 8, 4, fill=INK_3, stroke="none", op=0.4)


def s_switch(x, y):
    rect(x + 16, y + 15, 34, 17, 8.5, stroke=INK_2)
    circle(x + 41.5, y + 23.5, 5.6, fill=ACCENT, stroke="none")  # accent 1 of 3
    rect(x + 60, y + 15, 34, 17, 8.5, stroke=INK_3, op=0.75)
    circle(x + 68.5, y + 23.5, 5.6, fill=INK_3, stroke="none", op=0.9)


def s_table(x, y):
    rect(x + 8, y + 6, 80, 34, 2, stroke=INK_3)
    line(x + 8, y + 17, x + 88, y + 17, INK_2, 1.1)
    line(x + 8, y + 28.5, x + 88, y + 28.5, INK_3, 1, 0.7)
    line(x + 35, y + 6, x + 35, y + 40, INK_3, 1, 0.7)
    line(x + 62, y + 6, x + 62, y + 40, INK_3, 1, 0.7)


def s_tabs(x, y):
    rect(x + 12, y + 4, 72, 17, 4, stroke=INK_3)
    rect(x + 15, y + 7, 33, 11, 2.5, fill=INK_1, stroke="none")
    line(x + 12, y + 30, x + 84, y + 30, INK_3, 1.1, 0.9)
    line(x + 12, y + 38, x + 62, y + 38, INK_3, 1.1, 0.6)


def s_textarea(x, y):
    rect(x + 10, y + 5, 76, 36, 3.5, stroke=INK_2)
    line(x + 17, y + 15, x + 78, y + 15, INK_3, 1.1, 0.85)
    line(x + 17, y + 23, x + 78, y + 23, INK_3, 1.1, 0.85)
    line(x + 17, y + 31, x + 54, y + 31, INK_3, 1.1, 0.85)


def s_toast(x, y):
    scrim(x, y)
    rect(x + 34, y + 22, 58, 20, 3.5, fill=GROUND, stroke=INK_1)
    circle(x + 43, y + 32, 3, stroke=INK_2)
    line(x + 51, y + 29, x + 85, y + 29, INK_2, 1.3)
    line(x + 51, y + 36, x + 73, y + 36, INK_3, 1, 0.85)


def s_tooltip(x, y):
    rect(x + 22, y + 6, 52, 17, 4, fill=INK_1, stroke="none")
    line(x + 30, y + 14.5, x + 66, y + 14.5, GROUND, 1.6)
    path(
        f"M{x + 44:.2f} {y + 23:.2f} L{x + 48:.2f} {y + 28:.2f} L{x + 52:.2f} {y + 23:.2f} Z",
        fill=INK_1,
        stroke="none",
    )
    circle(x + 48, y + 36, 6, stroke=INK_3)


SPECIMENS = [
    ("accordion", s_accordion),
    ("alert", s_alert),
    ("avatar", s_avatar),
    ("badge", s_badge),
    ("breadcrumb", s_breadcrumb),
    ("button", s_button),
    ("card", s_card),
    ("checkbox", s_checkbox),
    ("collapsible", s_collapsible),
    ("dialog", s_dialog),
    ("dropdown-menu", s_dropdown),
    ("input", s_input),
    ("label", s_label),
    ("radio", s_radio),
    ("select", s_select),
    ("separator", s_separator),
    ("sheet", s_sheet),
    ("sidebar", s_sidebar),
    ("skeleton", s_skeleton),
    ("switch", s_switch),
    ("table", s_table),
    ("tabs", s_tabs),
    ("textarea", s_textarea),
    ("toast", s_toast),
    ("tooltip", s_tooltip),
]

# ── ground ────────────────────────────────────────────────────────────────────
add(f'<rect width="{W}" height="{H}" fill="{GROUND}"/>')

# ── plate header, set on the same line as the left column's plate index ───────
HEAD_Y = 56
text(PX, HEAD_Y, "TWENTY-FIVE PRIMITIVES", 9, INK_2, ls=2.6)
text(PX + PLATE_W, HEAD_Y, "EACH SELF-CONTAINED", 9, INK_3, ls=2.6, anchor="end")

# ruler ticks: a measured interval, not a drawn rule
TICK_Y = 76
TICKS = 41
for i in range(TICKS):
    tx = PX + PLATE_W * i / (TICKS - 1)
    tall = i % 5 == 0
    line(tx, TICK_Y, tx, TICK_Y + (6.5 if tall else 3.5), INK_3, 1, 0.7 if tall else 0.34, "butt")

# ── specimens ─────────────────────────────────────────────────────────────────
for i, (name, draw) in enumerate(SPECIMENS):
    col, row = i % COLS, i // COLS
    cx, cy = PX + col * CW, PY + row * CH
    draw(cx, cy)
    text(cx, cy + 64, f"{i + 1:02d}", 8, INK_2, ls=1.4)
    text(cx + 18, cy + 64, name.upper(), 8, INK_3, ls=1.4)

# ── left column ───────────────────────────────────────────────────────────────
# corner registration mark, aligned to the plate header's baseline
line(LX, HEAD_Y - 4, LX + 13, HEAD_Y - 4, INK_3, 1, 0.85, "butt")
line(LX, HEAD_Y - 4, LX, HEAD_Y + 9, INK_3, 1, 0.85, "butt")
text(LX + 24, HEAD_Y, "PLATE I", 9, INK_2, ls=2.6)

# wordmark
text(LX - 3, 246, "LaralCN-UI", 56, INK_1, family="jura", ls=1.5, weight=300)
text(LX, 280, "Copy-and-own Blade components for Laravel.", 12.5, INK_2, ls=0.1)

# data block — the leader rules sit on a single measured column
DY, ROW = 336, 27
LEAD_X1, LEAD_X2, VAL_X = LX + 104, LX + 152, LX + 158
data = [
    ("SPECIMENS", "25", INK_1),
    ("DEPENDENCIES", "0", ACCENT),  # accent 2 of 3
    ("RADIUS", "0.625REM", INK_1),
    ("TAILWIND", "V4 · OKLCH", INK_1),
]
for i, (k, v, col) in enumerate(data):
    yy = DY + i * ROW
    text(LX, yy, k, 9, INK_3, ls=2.2)
    line(LEAD_X1, yy - 3, LEAD_X2, yy - 3, INK_4, 1, 1, "butt")
    text(VAL_X, yy, v, 9, col, ls=2.2)

# colophon — set on the baseline of the last row of specimen labels, so the
# two columns terminate together on one invisible line
COLO_Y = PY + (ROWS - 1) * CH + 64
text(LX, COLO_Y, "GITHUB.COM/ABDULKADER-SAFI/LARALCN-UI", 8, INK_3, ls=1.8, op=0.9)

# closing registration mark, mirroring the opening one — accent 3 of 3
RX, RY = W - MARGIN, H - (HEAD_Y - 4)
line(RX, RY - 13, RX, RY, ACCENT, 1, 0.9, "butt")
line(RX - 13, RY, RX, RY, ACCENT, 1, 0.9, "butt")

body = "\n".join(out)

html = f"""<!doctype html>
<meta charset="utf-8">
<title>LaralCN-UI — og:image</title>
<style>
  @font-face {{ font-family:'Jura'; src:url('fonts/Jura-Light.ttf') format('truetype'); font-weight:300; font-display:block; }}
  @font-face {{ font-family:'Jura'; src:url('fonts/Jura-Medium.ttf') format('truetype'); font-weight:500; font-display:block; }}
  @font-face {{ font-family:'Red Hat Mono'; src:url('fonts/RedHatMono-Regular.ttf') format('truetype'); font-weight:400; font-display:block; }}
  @font-face {{ font-family:'Red Hat Mono'; src:url('fonts/RedHatMono-Bold.ttf') format('truetype'); font-weight:700; font-display:block; }}
  html,body {{ margin:0; padding:0; background:{GROUND}; }}
  #artboard {{ width:{W}px; height:{H}px; overflow:hidden; }}
  svg {{ display:block; }}
</style>
<div id="artboard">
<svg xmlns="http://www.w3.org/2000/svg" width="{W}" height="{H}" viewBox="0 0 {W} {H}"
     shape-rendering="geometricPrecision" text-rendering="geometricPrecision">
  <defs>
    <filter id="grain" x="0" y="0" width="100%" height="100%">
      <feTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="3" stitchTiles="stitch" result="n"/>
      <feColorMatrix in="n" type="saturate" values="0"/>
    </filter>
  </defs>
{body}
  <rect width="{W}" height="{H}" filter="url(#grain)" opacity="0.05"
        style="mix-blend-mode:overlay" pointer-events="none"/>
</svg>
</div>
"""

import pathlib

pathlib.Path(__file__).with_name("og.html").write_text(html)
print(f"wrote og.html — {len(SPECIMENS)} specimens, plate {PLATE_W}px at x={PX}, {W}x{H}")
