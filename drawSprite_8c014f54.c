// June 18, 2022
// Functionally matching, but still using different registers...

#include "includes.h"
#include "ninja.h"

struct DatSect1Entry {
    int sprite_no_0x00;
    float x_0x04;
    float y_0x08;
}
typedef DatSect1Entry;

void drawSprite_8c014f54(DrawDatStruct1 *struct1_r4, int texture_id, float x, float y, float priority) {
    // fr12 = fr4 = x
    // fr13 = fr5 = y
    // fr15 = fr6 = priority

    char *dat_section_base;
    int *dat_offset;
    int i;
    int offset;
    DatSect1Entry *dat_entry = NULL;
    NJS_SPRITE sprite;
    int bpr = 0;
    // float increment;
    float pri = priority;
    char *intptr;
    int texture_offset;

    if (texture_id == 2000) {
        // 0x8c014f76
        dat_section_base = struct1_r4->contents_0x08;
    } else {
        // 0x8c014f78

        // Wrong registers only
        texture_offset = texture_id;
        intptr = struct1_r4->contents_0x08;
        dat_section_base = intptr + texture_offset * 4;
        dat_section_base = intptr + (* (int *)dat_section_base) * 4;
    }

    dat_entry = 0;

    sprite.tlist = struct1_r4->tlist_0x00;
    sprite.tanim = struct1_r4->tanim_0x04;
    sprite.ang = 0;
    sprite.sx = 1.0f;
    sprite.sy = 1.0f;

    i = 0;
    // increment = 0.0001;

    dat_entry = (DatSect1Entry *) ((int) dat_entry + (int) dat_section_base);

    while (*((int *) (dat_section_base + i * sizeof(DatSect1Entry))) != -1) {
        float xa = x + dat_entry->x_0x04;
        float ya = y + dat_entry->y_0x08;
        sprite.p.x = xa;
        sprite.p.y = ya;

        njDrawSprite2D_8c074c08(&sprite, dat_entry->sprite_no_0x00, NJD_SPRITE_ALPHA, pri);

        pri += 0.0001;
        i++;
        dat_entry++;
    }
}
