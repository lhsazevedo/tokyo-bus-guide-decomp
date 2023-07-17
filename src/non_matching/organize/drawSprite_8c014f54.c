/* June 18, 2022 */
/* Functionally matching, but still using different registers... */

#include "includes.h"
#include "ninja.h"

struct DatSect1Entry {
    int sprite_no_0x00;
    float x_0x04;
    float y_0x08;
}
typedef DatSect1Entry;

void drawSprite_8c014f54(ResourceGroup *struct1_r4, int texture_id, float x, float y, float priority) {
    DatSect1Entry *dat_entry;
    int *dat_section_base;
    int i;
    NJS_SPRITE sprite;

    float pri = priority;
    float fadd = .0001f;

    if (texture_id == 2000) {
        /* 0x8c014f76 */
        dat_section_base = (int *) struct1_r4->contents_0x08;
    } else {
        /* Melhor até agora */
        dat_section_base = ((int *) struct1_r4->contents_0x08) + texture_id;
        dat_section_base = ((int *) struct1_r4->contents_0x08) + *dat_section_base;

        /* Wrong registers only */
        /* texture_offset = texture_id; */
        /* intptr = struct1_r4->contents_0x08; */
        /* dat_section_base = intptr + texture_offset * 4; */
        /* dat_section_base = intptr + (* (int *)dat_section_base) * 4; */
    }

    dat_entry = NULL;

    sprite.tlist = struct1_r4->tlist_0x00;
    sprite.tanim = struct1_r4->tanim_0x04;
    sprite.ang = 0;
    sprite.sx = 1.0f;
    sprite.sy = 1.0f;

    i = 0;
    dat_entry = (char *) dat_entry + (int) dat_section_base;

    for (;
        *(dat_section_base + i * 3) != -1;
        pri += fadd, i++, dat_entry++
    ) {
        sprite.p.x = x + dat_entry->x_0x04;
        sprite.p.y = y + dat_entry->y_0x08;

        /* njDrawSprite2D_8c074c08 */
        ((void (*)( NJS_SPRITE *sp, Int n, Float pri, Uint32 attr)) 0x8c074c08)(&sprite, dat_entry->sprite_no_0x00, pri, NJD_SPRITE_ALPHA);
        /* njDrawSprite2D(&sprite, dat_entry->sprite_no_0x00, pri, NJD_SPRITE_ALPHA); */
    }
}
