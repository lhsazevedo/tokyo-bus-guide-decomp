#include "includes.h"
#include "ninja.h"

struct DrawDatStruct1 {
    NJS_TEXLIST *tlist_0x00;
    NJS_TEXANIM *tanim_0x04;
    char *contents_0x08;
    int field_0x0c;
}
typedef DrawDatStruct1;

struct DatSect1Entry {
    int sprite_no_0x00;
    float x_0x04;
    float y_0x08;
}
typedef DatSect1Entry;

// NJS_SPRITE?
// struct DrawDatXY {
//     float x_0x00;
//     float y_0x04;
//     int field_0x08;
//     float float_0x0c;
//     float float_0x10;
//     int int_0x14;
//     void *ptr_0x18;
//     void *ptr_0x1c;
// }
// typedef DrawDatXY;


void drawSprite_8c014f54(DrawDatStruct1 *struct1_r4, int texture_id, float x, float y, float priority) {
    // fr12 = fr4 = x
    // fr13 = fr5 = y
    // fr15 = fr6 = priority

    char *dat_section_base;
    int *dat_offset;
    int i;
    int offset;
    DatSect1Entry *dat_section = NULL;
    NJS_SPRITE sprite;
    int bpr = 0;
    int pri = priority;

    if (texture_id == 2000) {
        // 0x8c014f76
        dat_section_base = struct1_r4->contents_0x08;
    } else {
        // 0x8c014f78
        // r13 = r5 = texture_id
        // r13 = texture_id * 4
        // r6 = struct_r4->contents_0x08
        // r13 = r13 + r6

        // GOOD
        // int *intptr = struct1_r4->contents_0x08;
        // dat_section_base = intptr;
        // dat_section_base += texture_id;
        // dat_section_base = intptr + *dat_section_base;

        // ?
        dat_section_base = struct1_r4->contents_0x08 + texture_id * 4;
        dat_section_base = struct1_r4->contents_0x08 + (*(int*)dat_section_base) * 4;

        // BAD
        // int *intptr = struct1_r4->contents_0x08;
        // int *offsetptr = intptr + texture_id;
        // int *newptr = (intptr + *offsetptr);
        // dat_section_base = (DatSect1Entry *)newptr;

        // BAD
        // int *intptr = struct1_r4->contents_0x08;
        // int offset = (intptr + texture_id);

        // dat_section_base = intptr;
        // dat_section_base += texture_id;
        // dat_section_base = intptr + *offset;

        // int offset = texture_id * 4;
        // offset += struct1_r4->contents_0x08;
        // dat_section_base = struct1_r4->contents_0x08 + offset;
        // dat_section_base = struct1_r4->contents_0x08 + *(int*)dat_section_base * 4;
    }

    // dat_section;

    sprite.tlist = struct1_r4->tlist_0x00;
    sprite.tanim = struct1_r4->tanim_0x04;
    sprite.ang = 0;
    sprite.sx = sprite.sy = 1.0;

    i = 0;
    dat_section = (DatSect1Entry*)dat_section_base;

    while (*(dat_section_base + i * (sizeof(DatSect1Entry) / 4)) != -1) {
        sprite.p.x = x + dat_section->x_0x04;
        sprite.p.y = y + dat_section->y_0x08;

        njDrawSprite2D_8c074c08(&sprite, dat_section->sprite_no_0x00, NJD_SPRITE_ALPHA, pri);

        pri += 0.0001;
        i++;
        dat_section++;
    }
}
