from PIL import Image, ImageDraw, ImageFont
import os

# ============================================================
# Map at browser render width (830x520)
# Normal badge size, but LARGER street name & building text
# ============================================================
width = 830
height = 520
background_color = (241, 245, 249)

img = Image.new('RGB', (width, height), background_color)
draw = ImageDraw.Draw(img)

# Colors
building_fill = (255, 255, 255)
building_stroke = (148, 163, 184)
building_shadow = (203, 213, 225)
square_fill = (220, 252, 231)
square_stroke = (134, 239, 172)
label_box_fill = (79, 70, 229)
label_text_color = (255, 255, 255)
street_text_color = (51, 65, 85)

# Fonts:
#   Street names  = 36pt (enlarged from 28)
#   Square text   = 30pt (enlarged from 22)
#   Badge letters = 16pt (small, proportional to badge)
try:
    font_street = ImageFont.truetype("/System/Library/Fonts/Helvetica-Bold.ttc", 36)
    font_label  = ImageFont.truetype("/System/Library/Fonts/Helvetica-Bold.ttc", 16)
    font_square = ImageFont.truetype("/System/Library/Fonts/Helvetica-Bold.ttc", 30)
except:
    font_street = ImageFont.load_default()
    font_label  = ImageFont.load_default()
    font_square = ImageFont.load_default()

# Layout Constants (same as original 830x520)
margin = 20
col_1_w = 200
street_v_w = 60
col_2_w = 250
street_v2_w = 60
col_3_w = 200

row_1_h = 140
street_h_h = 55
row_2_h = 140
street_h2_h = 55
row_3_h = 140

# X Coordinates
x1 = margin
x2 = x1 + col_1_w
x3 = x2 + street_v_w
x4 = x3 + col_2_w
x5 = x4 + street_v2_w
x6 = x5 + col_3_w

# Y Coordinates
y1 = margin
y2 = y1 + row_1_h
y3 = y2 + street_h_h
y4 = y3 + row_2_h
y5 = y4 + street_h2_h
y6 = y5 + row_3_h

# ---- Helpers ----

def draw_shadowed_rect(coords, fill, outline, radius=0, shadow_offset=4):
    x0, y0, x1, y1 = coords
    draw.rounded_rectangle(
        (x0 + shadow_offset, y0 + shadow_offset, x1 + shadow_offset, y1 + shadow_offset),
        radius=radius, fill=building_shadow
    )
    draw.rounded_rectangle(coords, radius=radius, fill=fill, outline=outline, width=2)


def draw_street_text(text, box, rotate=0):
    w, h = box[2] - box[0], box[3] - box[1]
    canvas_w, canvas_h = 700, 100
    txt_img = Image.new('RGBA', (canvas_w, canvas_h), (255, 255, 255, 0))
    t_draw = ImageDraw.Draw(txt_img)

    bbox = t_draw.textbbox((0, 0), text, font=font_street)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    t_draw.text(((canvas_w - tw) / 2, (canvas_h - th) / 2), text, font=font_street, fill=street_text_color)

    if rotate != 0:
        txt_img = txt_img.rotate(rotate, expand=True)

    iw, ih = txt_img.size
    cx, cy = box[0] + w / 2, box[1] + h / 2
    img.paste(txt_img, (int(cx - iw / 2), int(cy - ih / 2)), txt_img)


def draw_label_badge(cx, cy, letter):
    size = 30  # Small proportional badge
    box = (cx - size / 2, cy - size / 2, cx + size / 2, cy + size / 2)
    draw.rounded_rectangle(
        (box[0] + 2, box[1] + 2, box[2] + 2, box[3] + 2),
        radius=6, fill=(0, 0, 0, 60)
    )
    draw.rounded_rectangle(box, radius=5, fill=label_box_fill, outline=None)
    bbox = draw.textbbox((0, 0), letter, font=font_label)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    draw.text((cx - tw / 2, cy - th / 2 - 1), letter, font=font_label, fill=label_text_color)


# ---- Street Names (LARGE text) ----
draw_street_text("MAIN STREET", (0, y2, width, y3))
draw_street_text("ELIZABETH AVENUE", (0, y4, width, y5))
draw_street_text("BROAD STREET", (x2, 0, x3, height), rotate=90)
draw_street_text("HOGIE ROAD", (x4, 0, x5, height), rotate=90)

# ---- Buildings ----
block_r = 10

def place_block(coords, label=None, label_pos='center'):
    draw_shadowed_rect(coords, building_fill, building_stroke, radius=block_r)
    if label:
        bx, by, bx2, by2 = coords
        pad = 18
        lx, ly = 0, 0
        if   label_pos == 'top_left':      lx, ly = bx + pad, by + pad
        elif label_pos == 'top_right':     lx, ly = bx2 - pad, by + pad
        elif label_pos == 'bottom_left':   lx, ly = bx + pad, by2 - pad
        elif label_pos == 'bottom_right':  lx, ly = bx2 - pad, by2 - pad
        elif label_pos == 'bottom_center': lx, ly = bx + (bx2 - bx) / 2, by2 - pad
        elif label_pos == 'center':        lx, ly = bx + (bx2 - bx) / 2, by + (by2 - by) / 2
        draw_label_badge(lx, ly, label)

# Row 1
place_block((x1, y1, x2, y2), 'A', 'bottom_center')

draw_shadowed_rect((x3, y1, x4, y2), building_fill, building_stroke, radius=block_r)
draw_label_badge(x3 + 18, y1 + 18, 'B')
draw_label_badge(x4 - 18, y1 + 18, 'D')
draw_label_badge(x3 + col_2_w / 2, y2 - 18, 'C')

place_block((x5, y1, x6, y2), 'E', 'top_left')
draw_label_badge(x5 + col_3_w / 2, y2 - 18, 'F')

# Row 2
place_block((x1, y3, x2, y4), 'G', 'top_right')

draw_shadowed_rect((x3, y3, x4, y4), square_fill, square_stroke, radius=block_r)
bbox = draw.textbbox((0, 0), "Georgetown\nSquare", font=font_square)
tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
cx_sq, cy_sq = x3 + col_2_w / 2, y3 + row_2_h / 2
draw.text((cx_sq - tw / 2, cy_sq - th / 2), "Georgetown\nSquare", font=font_square, fill=(21, 128, 61), align="center")

place_block((x5, y3, x6, y4), 'H', 'bottom_left')
def generate_town_centre_map():
    # ============================================================
    # Map at browser render width (830x520)
    # Normal badge size, but LARGER street name & building text
    # ============================================================
    width = 830
    height = 520
    background_color = (241, 245, 249)

    img = Image.new('RGB', (width, height), background_color)
    draw = ImageDraw.Draw(img)

    # Colors
    building_fill = (255, 255, 255)
    building_stroke = (148, 163, 184)
    building_shadow = (203, 213, 225)
    square_fill = (220, 252, 231)
    square_stroke = (134, 239, 172)
    label_box_fill = (79, 70, 229)
    label_text_color = (255, 255, 255)
    street_text_color = (51, 65, 85)

    # Fonts:
    #   Street names  = 36pt (enlarged from 28)
    #   Square text   = 30pt (enlarged from 22)
    #   Badge letters = 16pt (small, proportional to badge)
    try:
        font_street = ImageFont.truetype("/System/Library/Fonts/Helvetica-Bold.ttc", 36)
        font_label  = ImageFont.truetype("/System/Library/Fonts/Helvetica-Bold.ttc", 16)
        font_square = ImageFont.truetype("/System/Library/Fonts/Helvetica-Bold.ttc", 30)
    except:
        font_street = ImageFont.load_default()
        font_label  = ImageFont.load_default()
        font_square = ImageFont.load_default()

    # Layout Constants (same as original 830x520)
    margin = 20
    col_1_w = 200
    street_v_w = 60
    col_2_w = 250
    street_v2_w = 60
    col_3_w = 200

    row_1_h = 140
    street_h_h = 55
    row_2_h = 140
    street_h2_h = 55
    row_3_h = 140

    # X Coordinates
    x1 = margin
    x2 = x1 + col_1_w
    x3 = x2 + street_v_w
    x4 = x3 + col_2_w
    x5 = x4 + street_v2_w
    x6 = x5 + col_3_w

    # Y Coordinates
    y1 = margin
    y2 = y1 + row_1_h
    y3 = y2 + street_h_h
    y4 = y3 + row_2_h
    y5 = y4 + street_h2_h
    y6 = y5 + row_3_h

    # ---- Helpers ----

    def draw_shadowed_rect(coords, fill, outline, radius=0, shadow_offset=4):
        x0, y0, x1, y1 = coords
        draw.rounded_rectangle(
            (x0 + shadow_offset, y0 + shadow_offset, x1 + shadow_offset, y1 + shadow_offset),
            radius=radius, fill=building_shadow
        )
        draw.rounded_rectangle(coords, radius=radius, fill=fill, outline=outline, width=2)


    def draw_street_text(text, box, rotate=0):
        w, h = box[2] - box[0], box[3] - box[1]
        canvas_w, canvas_h = 700, 100
        txt_img = Image.new('RGBA', (canvas_w, canvas_h), (255, 255, 255, 0))
        t_draw = ImageDraw.Draw(txt_img)

        bbox = t_draw.textbbox((0, 0), text, font=font_street)
        tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
        t_draw.text(((canvas_w - tw) / 2, (canvas_h - th) / 2), text, font=font_street, fill=street_text_color)

        if rotate != 0:
            txt_img = txt_img.rotate(rotate, expand=True)

        iw, ih = txt_img.size
        cx, cy = box[0] + w / 2, box[1] + h / 2
        img.paste(txt_img, (int(cx - iw / 2), int(cy - ih / 2)), txt_img)


    def draw_label_badge(cx, cy, letter):
        size = 30  # Small proportional badge
        box = (cx - size / 2, cy - size / 2, cx + size / 2, cy + size / 2)
        draw.rounded_rectangle(
            (box[0] + 2, box[1] + 2, box[2] + 2, box[3] + 2),
            radius=6, fill=(0, 0, 0, 60)
        )
        draw.rounded_rectangle(box, radius=5, fill=label_box_fill, outline=None)
        bbox = draw.textbbox((0, 0), letter, font=font_label)
        tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
        draw.text((cx - tw / 2, cy - th / 2 - 1), letter, font=font_label, fill=label_text_color)


    # ---- Street Names (LARGE text) ----
    draw_street_text("MAIN STREET", (0, y2, width, y3))
    draw_street_text("ELIZABETH AVENUE", (0, y4, width, y5))
    draw_street_text("BROAD STREET", (x2, 0, x3, height), rotate=90)
    draw_street_text("HOGIE ROAD", (x4, 0, x5, height), rotate=90)

    # ---- Buildings ----
    block_r = 10

    def place_block(coords, label=None, label_pos='center'):
        draw_shadowed_rect(coords, building_fill, building_stroke, radius=block_r)
        if label:
            bx, by, bx2, by2 = coords
            pad = 18
            lx, ly = 0, 0
            if   label_pos == 'top_left':      lx, ly = bx + pad, by + pad
            elif label_pos == 'top_right':     lx, ly = bx2 - pad, by + pad
            elif label_pos == 'bottom_left':   lx, ly = bx + pad, by2 - pad
            elif label_pos == 'bottom_right':  lx, ly = bx2 - pad, by2 - pad
            elif label_pos == 'bottom_center': lx, ly = bx + (bx2 - bx) / 2, by2 - pad
            elif label_pos == 'center':        lx, ly = bx + (bx2 - bx) / 2, by + (by2 - by) / 2
            draw_label_badge(lx, ly, label)

    # Row 1
    place_block((x1, y1, x2, y2), 'A', 'bottom_center')

    draw_shadowed_rect((x3, y1, x4, y2), building_fill, building_stroke, radius=block_r)
    draw_label_badge(x3 + 18, y1 + 18, 'B')
    draw_label_badge(x4 - 18, y1 + 18, 'D')
    draw_label_badge(x3 + col_2_w / 2, y2 - 18, 'C')

    place_block((x5, y1, x6, y2), 'E', 'top_left')
    draw_label_badge(x5 + col_3_w / 2, y2 - 18, 'F')

    # Row 2
    place_block((x1, y3, x2, y4), 'G', 'top_right')

    draw_shadowed_rect((x3, y3, x4, y4), square_fill, square_stroke, radius=block_r)
    bbox = draw.textbbox((0, 0), "Georgetown\nSquare", font=font_square)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    cx_sq, cy_sq = x3 + col_2_w / 2, y3 + row_2_h / 2
    draw.text((cx_sq - tw / 2, cy_sq - th / 2), "Georgetown\nSquare", font=font_square, fill=(21, 128, 61), align="center")

    place_block((x5, y3, x6, y4), 'H', 'bottom_left')

    # Row 3
    place_block((x1, y5, x2, y6), 'I', 'top_right')
    place_block((x3, y5, x4, y6), 'J', 'top_right')
    place_block((x5, y5, x6, y6), 'K', 'top_left')

    # Save the image
    try:
        output_dir = "public/assets/images"
        os.makedirs(output_dir, exist_ok=True)
        img.save(f"{output_dir}/town_centre_map.png")
        print(f"Map saved to {output_dir}/town_centre_map.png ({width}x{height})")
    except Exception as e:
        print(f"Error saving image: {e}")

def generate_main_square_map():
    # Constants
    WIDTH = 830
    HEIGHT = 750
    # Premium Map Palette
    BG_COLOR = "#F8FAFC"      # Slate-50
    ROAD_COLOR = "#CBD5E1"    # Slate-300
    ROAD_BORDER = "#94A3B8"   # Slate-400
    BUILDING_FILL = "#FFFFFF"
    BUILDING_STROKE = "#64748B" # Slate-500
    BUILDING_SHADOW = "#E2E8F0" # Slate-200
    MAIN_SQUARE_FILL = "#DCFCE7" # Green-100
    MAIN_SQUARE_STROKE = "#22C55E" # Green-500
    
    # Create image
    img = Image.new('RGB', (WIDTH, HEIGHT), color=BG_COLOR)
    draw = ImageDraw.Draw(img)

    # Load Fonts
    try:
        font_path = "/System/Library/Fonts/Helvetica-Bold.ttc"
        marker_font = ImageFont.truetype(font_path, 22)
        large_label_font = ImageFont.truetype(font_path, 32)
    except:
        marker_font = ImageFont.load_default()
        large_label_font = ImageFont.load_default()

    # ---- Helpers ----
    def add_noise(image, intensity=0.02):
        """Adds subtle grain to better match printed materials"""
        import random
        width, height = image.size
        pixels = image.load()
        for x in range(width):
            for y in range(height):
                r, g, b = pixels[x, y]
                noise = random.randint(int(-255 * intensity), int(255 * intensity))
                pixels[x, y] = (
                    max(0, min(255, r + noise)),
                    max(0, min(255, g + noise)),
                    max(0, min(255, b + noise))
                )

    def draw_rounded_path(points, width, color):
        """Draws a path with rounded corners/ends"""
        draw.line(points, fill=color, width=width, joint='curve')
        # Add round circles at endpoints for perfect round caps
        for p in points:
            x, y = p
            r = width / 2
            draw.ellipse([x - r, y - r, x + r, y + r], fill=color)

    def draw_shadowed_rect(coords, fill, outline, radius=12):
        x0, y0, x1, y1 = coords
        # Soft Shadow
        offset = 6
        draw.rounded_rectangle(
            (x0 + offset, y0 + offset, x1 + offset, y1 + offset),
            radius=radius, fill=BUILDING_SHADOW
        )
        # Main Box
        draw.rounded_rectangle(coords, radius=radius, fill=fill, outline=outline, width=3)

    def draw_badge(bx, by, letter):
        size = 36
        draw.rounded_rectangle(
            [bx, by, bx + size, by + size],
            radius=8,
            fill="#4338CA", # Indigo-700
            outline=None
        )
        bbox = draw.textbbox((0, 0), letter, font=marker_font)
        tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
        draw.text(
            (bx + (size - tw) / 2, bx + (size - th) / 2 - 2), # Corrected Center logic
            letter,
            fill="white",
            font=marker_font
        )
        # Re-center text accurately
        draw.text(
             (bx + (size - tw) / 2, by + (size - th) / 2 - 1),
             letter,
             fill="white",
             font=marker_font
        )

    # ---- Layout Coordinates ----
    
    ms_w, ms_h = 240, 100
    ms_x = (WIDTH - ms_w) / 2
    ms_y = 240 # Shifted down slightly

    box_w, box_h = 180, 100
    col_left_x = 100
    col_right_x = WIDTH - 100 - box_w
    
    row_1_y = 50   # A, B
    row_3_y = 420  # C, D
    row_4_y = 600  # E, F

    # ---- Draw Paths ----
    
    path_width = 40
    
    ms_center_x = WIDTH / 2
    ms_center_y = ms_y + ms_h / 2
    
    # 1. Main Vertical Spine (Rounded)
    draw_rounded_path(
        [(ms_center_x, ms_y + ms_h - 20), (ms_center_x, row_4_y + box_h/2)],
        path_width, ROAD_COLOR
    )

    # 2. Horizontal Branches
    # C/D Branch
    path_cd_y = row_3_y + box_h/2
    draw_rounded_path(
        [(col_left_x + box_w - 20, path_cd_y), (col_right_x + 20, path_cd_y)],
        path_width, ROAD_COLOR
    )
    
    # E/F Branch
    path_ef_y = row_4_y + box_h/2
    draw_rounded_path(
        [(col_left_x + box_w - 20, path_ef_y), (col_right_x + 20, path_ef_y)],
        path_width, ROAD_COLOR
    )

    # 3. Y-Branch (Upper)
    # Start from Center MS
    # Curve to Left A
    # Start: (ms_center_x, ms_y + 20)
    # End A: (col_left_x + box_w, row_1_y + box_h/2)
    # End B: (col_right_x, row_1_y + box_h/2)
    
    # Draw thick lines for Y-branch
    start_pt = (ms_center_x, ms_y + 30)
    end_a = (col_left_x + box_w + 20, row_1_y + box_h - 20)
    end_b = (col_right_x - 20, row_1_y + box_h - 20)
    
    draw_rounded_path([start_pt, end_a], path_width, ROAD_COLOR)
    draw_rounded_path([start_pt, end_b], path_width, ROAD_COLOR)

    # ---- Draw Objects ----

    # Main Square
    draw_shadowed_rect(
        (ms_x, ms_y, ms_x + ms_w, ms_y + ms_h),
        fill=MAIN_SQUARE_FILL,
        outline=MAIN_SQUARE_STROKE
    )
    # Add inner texture/dashed line for "park" effect
    draw.rounded_rectangle(
        (ms_x + 10, ms_y + 10, ms_x + ms_w - 10, ms_y + ms_h - 10),
        radius=8, fill=None, outline="#86EFAC", width=2
    )
    
    bbox = draw.textbbox((0, 0), "Main Square", font=large_label_font)
    tw, th = bbox[2] - bbox[0], bbox[3] - bbox[1]
    draw.text(
        (ms_x + (ms_w - tw) / 2, ms_y + (ms_h - th) / 2),
        "Main Square",
        fill="#15803D", # Green-700
        font=large_label_font
    )

    # Place Boxes
    def place_box(x, y, label, badge_pos='top_left'):
        draw_shadowed_rect((x, y, x + box_w, y + box_h), BUILDING_FILL, BUILDING_STROKE)
        
        # Determine badge coordinates
        gap = 12
        if badge_pos == 'top_left':
            bx, by = x + gap, y + gap
        elif badge_pos == 'top_right':
            bx, by = x + box_w - 36 - gap, y + gap
        elif badge_pos == 'bottom_left':
            bx, by = x + gap, y + box_h - 36 - gap
        elif badge_pos == 'bottom_right':
            bx, by = x + box_w - 36 - gap, y + box_h - 36 - gap
             
        draw_badge(bx, by, label)

    # Row 1
    place_box(col_left_x, row_1_y, 'A', 'top_left')
    place_box(col_right_x, row_1_y, 'B', 'top_right')

    # Row 3
    place_box(col_left_x, row_3_y, 'C', 'bottom_left')
    place_box(col_right_x, row_3_y, 'D', 'bottom_right')

    # Row 4
    place_box(col_left_x, row_4_y, 'E', 'bottom_left')
    place_box(col_right_x, row_4_y, 'F', 'bottom_right')

    # Add Noise for Texture
    add_noise(img, 0.03)

    # Save
    try:
        output_dir = "public/assets/images"
        os.makedirs(output_dir, exist_ok=True)
        img.save(f"{output_dir}/main_square_map.png", quality=95)
        print(f"Map saved to {output_dir}/main_square_map.png ({WIDTH}x{HEIGHT})")
    except Exception as e:
        print(f"Error saving image: {e}")

if __name__ == "__main__":
    generate_town_centre_map()
    generate_main_square_map()
