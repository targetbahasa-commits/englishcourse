#!/usr/bin/env python3
# gen_turtle_svg.py  —  Sea Turtle Life Cycle SVG generator

output = []

def add(s):
    output.append(s)

# ─────────────────────────────────────────────────────────────
# Turtle helper  (renders facing right by default; flip=True → left)
# ─────────────────────────────────────────────────────────────
def turtle_svg(cx, cy, scale=1.0, rot=0, flip=False):
    sx = -scale if flip else scale
    lines = [
        f'<g transform="translate({cx},{cy}) rotate({rot}) scale({sx},{scale})" opacity="0.92">',
        # body
        '<ellipse cx="0" cy="0" rx="20" ry="13" fill="#b8b8b8" stroke="#444" stroke-width="1.2"/>',
        # inner shell ring
        '<ellipse cx="0" cy="0" rx="9" ry="6" fill="none" stroke="#555" stroke-width="0.9"/>',
        # shell hex spokes
        '<line x1="0" y1="-6"  x2="0"   y2="-13" stroke="#555" stroke-width="0.7"/>',
        '<line x1="0" y1="6"   x2="0"   y2="13"  stroke="#555" stroke-width="0.7"/>',
        '<line x1="-9" y1="0"  x2="-20" y2="0"   stroke="#555" stroke-width="0.7"/>',
        '<line x1="9"  y1="0"  x2="20"  y2="0"   stroke="#555" stroke-width="0.7"/>',
        '<line x1="6"  y1="-5" x2="15"  y2="-10" stroke="#555" stroke-width="0.7"/>',
        '<line x1="-6" y1="-5" x2="-15" y2="-10" stroke="#555" stroke-width="0.7"/>',
        '<line x1="6"  y1="5"  x2="15"  y2="10"  stroke="#555" stroke-width="0.7"/>',
        '<line x1="-6" y1="5"  x2="-15" y2="10"  stroke="#555" stroke-width="0.7"/>',
        # head (right side)
        '<ellipse cx="24" cy="-1" rx="7" ry="5" fill="#a5a5a5" stroke="#444" stroke-width="1.2"/>',
        # front flippers
        '<ellipse cx="7" cy="-18" rx="13" ry="4" fill="#a0a0a0" stroke="#444" stroke-width="1" transform="rotate(-25,7,-18)"/>',
        '<ellipse cx="7" cy="18"  rx="13" ry="4" fill="#a0a0a0" stroke="#444" stroke-width="1" transform="rotate(25,7,18)"/>',
        # hind flippers
        '<ellipse cx="-12" cy="-12" rx="9" ry="3.5" fill="#a0a0a0" stroke="#444" stroke-width="1" transform="rotate(35,-12,-12)"/>',
        '<ellipse cx="-12" cy="12"  rx="9" ry="3.5" fill="#a0a0a0" stroke="#444" stroke-width="1" transform="rotate(-35,-12,12)"/>',
        # tail
        '<ellipse cx="-24" cy="0" rx="5" ry="2.5" fill="#a0a0a0" stroke="#444" stroke-width="1"/>',
        '</g>',
    ]
    return '\n'.join(lines)

# ─────────────────────────────────────────────────────────────
# Label box helper
# ─────────────────────────────────────────────────────────────
def lbox(x, y, w, lines):
    lh = 17
    pad = 9
    h = pad * 2 + lh * len(lines)
    output.append(f'<rect x="{x}" y="{y}" width="{w}" height="{h}" rx="4" fill="white" stroke="#888" stroke-width="1.5"/>')
    for i, txt in enumerate(lines):
        ty = y + pad + lh * (i + 1) - 3
        fw = "bold" if i == 0 else "normal"
        cx = x + w // 2
        output.append(f'<text x="{cx}" y="{ty}" text-anchor="middle" font-size="12.5" font-weight="{fw}" font-family="Arial,sans-serif" fill="#1a1a1a">{txt}</text>')

# ─────────────────────────────────────────────────────────────
# SVG HEADER
# ─────────────────────────────────────────────────────────────
add('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 760" width="960" height="760">')
add('<defs>')
add('  <marker id="mA" viewBox="0 0 14 14" refX="13" refY="7" markerWidth="10" markerHeight="10" orient="auto">')
add('    <path d="M0,0 L14,7 L0,14 Z" fill="#333"/>')
add('  </marker>')
add('  <marker id="mB" viewBox="0 0 12 12" refX="11" refY="6" markerWidth="8" markerHeight="8" orient="auto">')
add('    <path d="M0,0 L12,6 L0,12 Z" fill="#666"/>')
add('  </marker>')
add('</defs>')

# ─────────────────────────────────────────────────────────────
# BACKGROUND
# ─────────────────────────────────────────────────────────────
add('<rect width="960" height="760" fill="white"/>')
add('<rect x="8" y="8" width="944" height="744" rx="5" fill="none" stroke="#ccc" stroke-width="1.5"/>')

# ─────────────────────────────────────────────────────────────
# TITLE
# ─────────────────────────────────────────────────────────────
add('<rect x="278" y="17" width="404" height="44" rx="5" fill="white" stroke="#888" stroke-width="1.8"/>')
add('<text x="480" y="44" text-anchor="middle" font-size="16.5" font-weight="bold" font-family="Arial,sans-serif" fill="#111" letter-spacing="1.5">LIFE CYCLE OF SEA TURTLES</text>')

# ─────────────────────────────────────────────────────────────
# MAIN ARROWS
# ─────────────────────────────────────────────────────────────

# 1. BIG LEFT ARC ARROW (thick dark, hatchlings → coastal foraging, going up left side)
#    Cubic bezier: start (290,572), ctrl1 (40,500), ctrl2 (40,240), end (415,122)
add('<path d="M 290 572 C 40 500 40 240 415 122"')
add('      stroke="#3a3a3a" stroke-width="34" fill="none"')
add('      marker-end="url(#mA)" stroke-linecap="round"/>')

# 2. TOP-RIGHT THICK ARROW (coastal foraging → mating/right side)
add('<path d="M 522 118 C 680 76 798 168 826 292"')
add('      stroke="#3a3a3a" stroke-width="30" fill="none"')
add('      marker-end="url(#mA)" stroke-linecap="round"/>')

# 3. LARGE CENTER DOWNWARD ARROW (adult females return to foraging)
add('<path d="M 447 162 L 447 432 L 417 432 L 463 502 L 509 432 L 479 432 L 479 162 Z"')
add('      fill="#c8c8c8" stroke="#aaa" stroke-width="1.5"/>')

# 4. Small connecting arrows
# Adults migrate → Mating areas
add('<line x1="783" y1="268" x2="808" y2="284" stroke="#666" stroke-width="2" marker-end="url(#mB)"/>')
# Mating areas box right-side → down to 2-week intervals
add('<line x1="879" y1="326" x2="879" y2="408" stroke="#666" stroke-width="2" marker-end="url(#mB)"/>')
# 2 week intervals → Nesting
add('<path d="M 822 454 C 822 510 718 522 648 590"')
add('      stroke="#666" stroke-width="2" fill="none" marker-end="url(#mB)"/>')
# Nesting → Eggs
add('<path d="M 558 610 C 555 648 525 655 500 661"')
add('      stroke="#666" stroke-width="2" fill="none" marker-end="url(#mB)"/>')
# Eggs area toward hatchlings (dashed, emergence)
add('<path d="M 316 673 C 278 690 238 664 232 604"')
add('      stroke="#888" stroke-width="1.8" fill="none" stroke-dasharray="5,3" marker-end="url(#mB)"/>')

# ─────────────────────────────────────────────────────────────
# LABEL BOXES
# ─────────────────────────────────────────────────────────────
lbox(46,  93,  176, ['Developmental', 'migration', '30-50 years'])
lbox(296, 72,  224, ['Coastal shallow water', 'foraging', 'Immature and adult turtles'])
lbox(646, 83,  186, ['Adult male', 'returns to foraging area'])
lbox(44,  262, 142, ['Lost years', '5-20 years'])
lbox(36,  405, 163, ['Open ocean', 'surface foraging'])
lbox(134, 563, 103, ['Hatchlings'])
lbox(600, 242, 182, ['Adults migrate', 'to mating areas'])
lbox(807, 280, 142, ['Mating areas', 'shallow waters'])
lbox(788, 408, 120, ['2 week', 'intervals'])
lbox(556, 588,  90, ['Nesting'])
lbox(314, 653, 184, ['Eggs 8-10 week', 'incubation'])
lbox(345, 482, 184, ['Adult females', 'return to foraging', 'area'])

# ─────────────────────────────────────────────────────────────
# TURTLE ILLUSTRATIONS
# ─────────────────────────────────────────────────────────────
# Large adult on left arc — developmental migration area
output.append(turtle_svg(228, 160, scale=2.2, rot=-20))
# Large turtle on arc — mid upper left
output.append(turtle_svg(170, 285, scale=1.9, rot=-8, flip=True))
# Medium turtle — lost years
output.append(turtle_svg(182, 390, scale=1.5, rot=5, flip=True))
# Smaller turtle — open ocean foraging
output.append(turtle_svg(188, 468, scale=1.2, rot=10, flip=True))
# Tiny hatchlings cluster (near Hatchlings label)
output.append(turtle_svg(230, 545, scale=0.75, rot=15))
output.append(turtle_svg(255, 558, scale=0.62, rot=-20))
output.append(turtle_svg(208, 558, scale=0.55, rot=30))
output.append(turtle_svg(272, 546, scale=0.58, rot=5))
output.append(turtle_svg(218, 532, scale=0.50, rot=-15))
# Adult in coastal foraging area (top center)
output.append(turtle_svg(538, 148, scale=1.8, rot=5))
# Adult male (top right)
output.append(turtle_svg(720, 143, scale=1.4, rot=12))
# Turtles right side — post mating
output.append(turtle_svg(706, 332, scale=1.2, rot=18))
output.append(turtle_svg(755, 418, scale=1.0, rot=28, flip=True))
output.append(turtle_svg(715, 472, scale=0.9, rot=15, flip=True))
# Nesting mother (bottom right area)
output.append(turtle_svg(618, 636, scale=1.5, rot=-8, flip=True))

# ─────────────────────────────────────────────────────────────
# EGG CLUSTER (bottom center, on the sand)
# ─────────────────────────────────────────────────────────────
add('<g transform="translate(402,686)">')
add('  <ellipse cx="0"   cy="0"   rx="12" ry="10" fill="#e8e0c8" stroke="#bbb" stroke-width="1.5"/>')
add('  <ellipse cx="23"  cy="4"   rx="12" ry="10" fill="#e8e0c8" stroke="#bbb" stroke-width="1.5"/>')
add('  <ellipse cx="12"  cy="-16" rx="11" ry="9"  fill="#e8e0c8" stroke="#bbb" stroke-width="1.5"/>')
add('  <ellipse cx="-18" cy="-8"  rx="11" ry="9"  fill="#e0d8c0" stroke="#bbb" stroke-width="1.5"/>')
add('  <ellipse cx="-5"  cy="-24" rx="10" ry="8"  fill="#ddd0b8" stroke="#bbb" stroke-width="1.5"/>')
add('  <ellipse cx="16"  cy="16"  rx="10" ry="8"  fill="#ddd0b8" stroke="#bbb" stroke-width="1.5"/>')
add('  <ellipse cx="-16" cy="12"  rx="9"  ry="8"  fill="#d8cfb5" stroke="#bbb" stroke-width="1.5"/>')
add('</g>')

# ─────────────────────────────────────────────────────────────
# CAPTION
# ─────────────────────────────────────────────────────────────
add('<text x="952" y="754" text-anchor="end" font-size="9" font-family="Arial" fill="#ccc">IELTS Writing Task 1 – Life Cycle Diagram</text>')

# ─────────────────────────────────────────────────────────────
# CLOSE SVG
# ─────────────────────────────────────────────────────────────
add('</svg>')

svg_content = '\n'.join(output)

with open(
    '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/sea_turtle_life_cycle.svg',
    'w', encoding='utf-8'
) as f:
    f.write(svg_content)

print(f"OK. Lines: {svg_content.count(chr(10))}, chars: {len(svg_content)}")
