#include <shinobi.h>
#include "015ab8_title.h"

struct ResourceGroupSpriteEntry {
    int sprite_no_0x00;
    float x_0x04;
    float y_0x08;
}
typedef ResourceGroupSpriteEntry;

/**
 * Draws a sprite or series of sprites from a resource group.
 *
 * @note Address: 0x8c014f54
 * 
 * @param res        Pointer to the ResourceGroup containing sprite data
 * @param texture_id ID of the texture to draw (2000 for BUS_FONT.FFF)
 * @param x          X-coordinate for the sprite's position
 * @param y          Y-coordinate for the sprite's position
 * @param priority   Initial draw priority for the sprite
 */
void drawSprite_8c014f54(
    ResourceGroup *resource_group,
    int texture_id,
    float x,
    float y,
    float priority
) {
    ResourceGroupSpriteEntry *sprite_entry;
    int *dat_section_base;
    int i;
    NJS_SPRITE sprite;

    // Handle BUS_FONT.FFF
    if (texture_id == 2000) {
        sprite_entry = (ResourceGroupSpriteEntry *) resource_group->contents_0x08;
    } else {
        int *offset_table = resource_group->contents_0x08;
        int texture_offset = offset_table[texture_id];
        sprite_entry = (ResourceGroupSpriteEntry *) &((int *) resource_group->contents_0x08)[texture_offset];
    }

    // Initialize NJS_SPRITE
    sprite.tlist = resource_group->tlist_0x00;
    sprite.tanim = resource_group->tanim_0x04;
    sprite.ang = 0;
    sprite.sx = 1.0f;
    sprite.sy = 1.0f;

    for (i = 0; sprite_entry[i].sprite_no_0x00 != -1; i++) {
        sprite.p.x = x + sprite_entry[i].x_0x04;
        sprite.p.y = y + sprite_entry[i].y_0x08;

        njDrawSprite2D(&sprite, sprite_entry[i].sprite_no_0x00, priority, NJD_SPRITE_ALPHA);

        priority += .0001f;
    }
}

/**
 * Draws a sprite with linear interpolation between two points.
 *
 * @note Address: 0x8c014ff6
 * @note This function not used.
 *
 * @param start_x    The starting X-coordinate for the interpolation
 * @param start_y    The starting Y-coordinate for the interpolation
 * @param priority   The draw priority for the sprite
 * @param end_x      The ending X-coordinate for the interpolation
 * @param end_y      The ending Y-coordinate for the interpolation
 * @param steps_x    The number of steps in the X direction for interpolation
 * @param steps_y    The number of steps in the Y direction for interpolation
 * @param res_group  Pointer to the ResourceGroup containing sprite data
 * @param texture_id ID of the texture to draw
 */
void drawSpriteLerp_8c014ff6(
    float start_x,
    float start_y,
    float priority,
    float end_x,
    float end_y,
    int steps_x,
    int steps_y,
    ResourceGroup *res_group,
    int texture_id
){
    float steps_x_float = steps_x;
    float steps_y_float = steps_y;

    float x_step = (end_x - start_x) / steps_x_float;
    float y_step = (end_y - start_y) / steps_y_float;

    float lerp_x = start_x + steps_x_float * x_step;
    float lerp_y = start_y + steps_y_float * y_step;

    drawSprite_8c014f54(res_group, texture_id, lerp_x, lerp_y, priority);
}

/**
 * Retrieves the index for a given glyph based on the character code.
 *
 * @param character_code The character code for which to retrieve the font index.
 * @return The font index corresponding to the given character code.
 */
Uint16 getGlyphIndex_8c015034(Uint16 character_code)
{
    // Font file offset table
    static const Uint16 font_section_offsets[40] = {
        0x0000, /* Special characters */
        0x005E, /* Special characters */
        0x006C, /* Digits and Roman */
        0x00AA, /* Hiragana */
        0x00FD, /* Katakana */
        0x0153, /* Greek */
        0x0183, /* Cyrillic */
        /* Kanji (32 sets with 94 kanji each)*/
        0x01C5, 0x0223, 0x0281, 0x02DF, 0x033D, 0x039B, 0x03F9, 0x0457,
        0x04B5, 0x0513, 0x0571, 0x05CF, 0x062D, 0x068B, 0x06E9, 0x0747,
        0x07A5, 0x0803, 0x0861, 0x08BF, 0x091D, 0x097B, 0x09D9, 0x0A37,
        0x0A95, 0x0AF3, 0x0B51, 0x0BAF, 0x0C0D, 0x0C6B, 0x0CC9, 0x0D27,
        0x0000
    };

    while (1) {
        Uint8 high_byte = (character_code >> 8) + 0x7f;
        Uint8 low_byte;
        Uint8 offset_index;

        // Check if high_byte is within valid range
        if (high_byte >= 0x6f || (high_byte >= 0x1f && high_byte < 0x3f)) {
            character_code = 0x81A6;  // Default character code
            continue;
        }

        if (high_byte >= 0x1f) high_byte -= 0x40;
        offset_index = (high_byte * 2) + 0x21;
        character_code += 0xc0;
        low_byte = (Uint8) character_code;

        // Check low_byte validity
        if (low_byte >= 0xbd || low_byte == 0x3f) {
            character_code = 0x81A6;  // Default character code
            continue;
        }

        if (low_byte < 0x3f) low_byte++;

        if (low_byte >= 0x5f) {
            low_byte -= 0x3e;
            offset_index++;
        } else {
            low_byte += 0x20;
        }

        switch (offset_index) {
            case 0x23:
                if (low_byte >= 0x61) low_byte -= 0x6;
                if (low_byte >= 0x41) low_byte -= 0x7;
                low_byte -= 0xf;
                break;

            case 0x26:
                if (low_byte >= 0x41) low_byte -= 0x8;
                break;

            case 0x27:
                if ((low_byte) >= 0x51) low_byte -= 0xf;
                break;

            default:
                if (offset_index >= 0x28) {
                    if (offset_index >= 0x30) {
                        if (offset_index >= 0x50) {
                            character_code = 0x81A6;  // Default character code
                            continue;
                        }
                        offset_index -= 0x8;
                    } else {
                        character_code = 0x81A6;  // Default character code
                        continue;
                    }
                }
                break;
        }

        offset_index -= 0x21;
        low_byte -= 0x21;
        return font_section_offsets[offset_index] + low_byte;
    }
}

#define PACKED_GLYPH_SIZE   0xc0
#define UNPACKED_GLYPH_SIZE 0xc0 * 4
#define GLYPH_TEXTURE_WIDTH 32
#define GLYPH_TEXTURE_SIZE  GLYPH_TEXTURE_WIDTH * GLYPH_TEXTURE_WIDTH
#define GLYPH_WIDTH    24
#define GLYPH_HEIGHT   32
#define GLYPH_PALETTE_SIZE  4

/**
 * Unpacks and processes a glyph's texture data from the compressed font.
 *
 * This function takes a character code and unpacks its associated font data into 
 * a texture buffer. The unpacked data is processed and translated into color values 
 * using a provided color array. The final texture twiddled for rendering.
 *
 * @param char_code The character code corresponding to the glyph to unpack.
 * @param colors An array of four 16-bit color values used to translate the unpacked font data.
 * @param font The compressed font data.
 * @param dest The destination buffer for the twiddled texture data.
 */
unpackGlyph_8c015110(Uint16 char_code, Uint16 colors[GLYPH_PALETTE_SIZE], Uint8 *font, Sint16 *dest)
{
    /* Buffer for the unpacked font data */
    Uint8 unpacked[UNPACKED_GLYPH_SIZE] = {0};
    /* Buffer for the mapped texture */
    Sint16 mapped[GLYPH_TEXTURE_SIZE] = {0};

    Uint16 offset = getGlyphIndex_8c015034(char_code) * PACKED_GLYPH_SIZE;
    size_t i;
    size_t j;

    // Unpack font data
    for (i = 0; i < PACKED_GLYPH_SIZE; i++) {
        Uint8 byte = font[offset + i];

        unpacked[(i * 4)]     = (byte >> 6) & 0x3;
        unpacked[(i * 4) + 1] = (byte >> 4) & 0x3;
        unpacked[(i * 4) + 2] = (byte >> 2) & 0x3;
        unpacked[(i * 4) + 3] = byte & 0x3;
    };

    // Create color mapped texture
    for (i = j = 0; i < GLYPH_TEXTURE_SIZE; i++) {
        Uint8 color_index;

        // Texture is square, but glyphs are 24 pixels wide
        if ((i % GLYPH_TEXTURE_WIDTH) >= GLYPH_WIDTH)
            continue;

        color_index = unpacked[j++];
        if (color_index < GLYPH_PALETTE_SIZE) {
            mapped[i] = colors[color_index];
        }
    }

    // Apply twiddle transformation
    njTwiddledTexture(dest, mapped, GLYPH_TEXTURE_WIDTH);
}

extern Sint16 *var_8c1bc7a0;
extern void *var_8c1bc7a4;
extern void *var_8c1bc78c;
extern NJS_TEXLIST *var_glyphTexlists_8c1bc790;
extern void *var_8c1bc794[3];
extern void *var_8c1bc79c;
extern Sint16 init_8c044128[];
extern Sint16 init_8c04413c[];

void FUN_alloc_8c01524c()
{
    int i;
    var_8c1bc7a0 = syMalloc(0x200 * sizeof(Sint16));
    for (i = 0; i < 0x200; i++) {
        var_8c1bc7a0[i] = (Uint16) -1;
    }

    var_8c1bc7a4 = syMalloc(0x800);
    var_8c1bc78c = syMalloc(0x1800);
    var_glyphTexlists_8c1bc790 = syMalloc(0x200 * sizeof(NJS_TEXLIST));
    var_8c1bc794[1] = init_8c044128;
    var_8c1bc794[2] = init_8c04413c;
}

void FUN_free_8c01529c()
{
    int i;
    for (i = 0; i < 0x200; i++) {
        if (var_8c1bc7a0[i] < -19) {
            njReleaseTexture(&var_glyphTexlists_8c1bc790[i]);
        }
    };
    syFree(var_glyphTexlists_8c1bc790);
    syFree(var_8c1bc78c);
    syFree(var_8c1bc7a4);
    syFree(var_8c1bc7a0);
}

typedef struct {
    int field_0x00;
    int field_0x04;
    float field_0x08;
    int width_0x0c;
    int height_0x10;
    int field_0x14;
    int field_0x18;
    Uint16 field_0x1c;
    Uint16 field_0x1e;
    Uint16 character_count_0x20;
    Uint16 tag_count_0x22;
    Uint16 field_0x24;
    Uint16 field_0x26;
    Uint16 field_0x28;
    Uint16 field_0x2a;
    Uint16 *char_codes_0x2c;
    int field_0x30;
    Float *line_offsets_0x34;
    void *text_0x38;
} TextBox;

/**
 * Creates a TextBox with the specified parameters.
 *
 * @param p1 The value for field_0x00.
 * @param p2 The value for field_0x04.
 * @param p3 The value for field_0x08.
 * @param width The width of the TextBox.
 * @param height The height of the TextBox.
 * @param p6 The value for field_0x14.
 * @param p7 The value for field_0x18.
 * @param p8 The value for field_0x30.
 * @return A pointer to the created TextBox.
 */
TextBox* createTextBox_8c0152fc(int p1, int p2, float p3, int width, int height, int p6, int p7, int p8)
{
    // Sample parameters
    // 0x20, 0x178, -2.0, 0x240,
    // 0x40,     0,    0,    -1,
    int character_count;
    int i;
    TextBox *box = syMalloc(sizeof(TextBox));
    box->field_0x00 = p1;
    box->field_0x04 = p2;
    box->field_0x08 = p3;
    box->width_0x0c = width;
    box->height_0x10 = height;
    box->field_0x14 = p6;
    box->field_0x18 = p7;
    box->field_0x24 = 0x0000;
    box->field_0x26 = 0xa94a;
    box->field_0x28 = 0xbdef;
    box->field_0x2a = 0xc631;
    character_count = 0x28 + (width / GLYPH_WIDTH) * (height / GLYPH_HEIGHT);
    box->char_codes_0x2c = syMalloc(character_count * sizeof(Uint16));
    box->line_offsets_0x34 = syMalloc(height / 0x20 * sizeof(Float));
    box->field_0x30 = p8;

    for (i = 0; i < character_count; i++) {
        box->char_codes_0x2c[i] = (Uint16) -1;
    }

    box->text_0x38 = NULL;

    return box;
}

/**
 * Frees the memory allocated for a TextBox.
 *
 * @todo Write a test for this function.
 * @param box The TextBox to be freed.
 */
void freeTextBox_8c015410(TextBox *box)
{
    if (box->char_codes_0x2c) {
        syFree(box->char_codes_0x2c);
    }
    if (box->line_offsets_0x34) {
        syFree(box->line_offsets_0x34);
    }
    syFree(box);
}

int prepareTextBoxLayout_8c01543a(TextBox *box, char *text)
{
    int i;
    int current_line;
    int character_count;
    int line_count;
    const int characters_per_line = box->width_0x0c / GLYPH_WIDTH;

    // Check if the box already contains characters
    if (*box->char_codes_0x2c != (Uint16) -1) {
        int i;
        int available_characters;

        // Release textures for existing characters
        for (i = 0; i < (box->character_count_0x20 + box->tag_count_0x22); i++) {
            if (box->char_codes_0x2c[i] < 0xffed) {
                njReleaseTexture(&var_glyphTexlists_8c1bc790[box->char_codes_0x2c[i]]);
                var_8c1bc7a0[box->char_codes_0x2c[i]] = -1;
            }
        }

        // Reset character codes
        available_characters = 0x28 + characters_per_line * (box->height_0x10 / GLYPH_HEIGHT);
        for (i = 0; i < available_characters; i++) {
            box->char_codes_0x2c[i] = 0xffff;
        }
    }

    // If the input text is empty, set the box text and return
    if (*text == '\0') {
        box->text_0x38 = text;
        return 0;
    }

    // Count the number of tags in the text
    box->tag_count_0x22 = 0;
    for (i = 0; text[i] != '\0'; i++) {
        if (text[i] == '<') {
            box->tag_count_0x22++;
        }
    }

    // Calculate the number of characters (excluding tags)
    // In Shift JIS, characters can be 1 or 2 bytes. This assumes 2 bytes per character.
    character_count = (strlen(text) - box->tag_count_0x22 * 3) / 2;

    box->text_0x38 = text;
    box->field_0x1c = 0;
    box->field_0x1e = 0;
    box->character_count_0x20 = character_count;

    // Initialize line offsets
    line_count = box->height_0x10 / 0x20;
    for (i = 0; i < line_count; i++) {
        box->line_offsets_0x34[i] = 0.0f;
    }

    // Process the text, handling tags and line wrapping
    current_line = 0;
    while (*text) {
        // Handle tags
        if (*text == '<') {
            // Line break tag
            if (*++text == 'E') {
                if (current_line >= line_count)
                    break;
                current_line++;
            }
            text += 2;
            continue;
        }

        // Wrap text if the current line is full
        if ((box->line_offsets_0x34[current_line] / 2) >= characters_per_line) {
            if (current_line >= line_count)
                break;
            current_line++;
        };

        box->line_offsets_0x34[current_line] += 1;

        text++;
    }

    // Center-align text on each line
    for (i = 0; i < line_count; i++) {
        box->line_offsets_0x34[i] = (characters_per_line - (box->line_offsets_0x34[i] / 2)) / 2;
    }

    return character_count;
}
