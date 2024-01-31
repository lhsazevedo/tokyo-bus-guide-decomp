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

void drawSprite_8c014f54(ResourceGroup *struct1_r4, int texture_id, float x, float y, float priority) {
    int dat_entry;
    int *dat_section_base;
    int i;
    NJS_SPRITE sprite;
    void *var;
    int text_id_copy;

    // Floats
    // float fadd;
    float xa;
    float ya;
    float pri = priority;

    // Temp floats (remove?)
    float thepri;
    float xadd;
    float yadd;


    if (texture_id == 2000) {
        // 0x8c014f76
        dat_section_base = (int *) struct1_r4->contents_0x08;
    } else {
        // 0x8c014f78

        // // mov R5, R13
        // dat_section_base = texture_id;

        // // mov.l @(0x8,r4),r6
        // var = struct1_r4->contents_0x08;

        // // shll2 r13
        // dat_section_base *= 4;
        // // add r6,r13
        // dat_section_base += (int) var;
        // // mov.l @r13,r13
        // dat_section_base = *((int *) dat_section_base);
        // // shll2 r13
        // dat_section_base *= 4;
        // // add r6,r13
        // dat_section_base += (int) var;

        // mov     r5,r13
        // shll2   r13
        // mov.l   @(0x8,r4),r6
        // add     r6,r13
        // mov.l   @r13,r13
        // shll2   r13
        // add     r6,r13

        // Bem bom
        // int *disp = (int *) struct1_r4->contents_0x08;
        // int *tmp = disp + texture_id;
        // dat_section_base = disp + *tmp;

        // Melhor até agora
        dat_section_base = ((int *) struct1_r4->contents_0x08) + texture_id;
        dat_section_base = ((int *) struct1_r4->contents_0x08) + *dat_section_base;

        // Wrong registers only
        // texture_offset = texture_id;
        // intptr = struct1_r4->contents_0x08;
        // dat_section_base = intptr + texture_offset * 4;
        // dat_section_base = intptr + (* (int *)dat_section_base) * 4;
    }

    // fldi1     fr4
    // mov       #0x0,r14

    // mov.l     ->njDrawSprite2D_8c074c08,r11              = 8c074c08

    // mov.l      @r4,r3
    // mov.l     r3,@(0x18,r15)
    // mov.l     @(0x4,r4),r2
    // mov       #0x0,r4
    // mov       r4,r12
    // mov.l     r2,@(0x1c,r15)
    // mov.l     r4,@(0x14,r15)
    //  mov       #0xc,r0
    // fmov      fr4,@(r0,r15)
    // mov       #0x10,r0
    // fmov      fr4,@(r0,r15)

    // mova      FLOAT_8c015030,r0                          = 1.0E-4
    // fmov.s    @r0=>FLOAT_8c015030,fr14                   = 1.0E-4
    // bra       LAB_8c014fd0
    // _add      r13,r14

    dat_entry = 0;

    sprite.tlist = struct1_r4->tlist_0x00;
    sprite.tanim = struct1_r4->tanim_0x04;
    sprite.ang = 0;
    sprite.sx = 1.0f;
    sprite.sy = 1.0f;

    // i = 0;
    // fadd = 0.0001f;

    // dat_entry += (int) dat_section_base;

    for (
        i = 0, dat_entry = dat_entry + (int) dat_section_base;
        *((int *) (dat_section_base + i * sizeof(DatSect1Entry))) != -1;
        pri += .0001f, i++, dat_entry += 0xc
    ) {
        thepri = pri;

        xadd = *((float *) (dat_entry + 4));
        // xa = x + *((float *) (dat_entry + 4));
        sprite.p.x = x + xadd;

        yadd = *((float *) (dat_entry + 8));
        // ya = y + *((float *) (dat_entry + 8));
        sprite.p.y = y + yadd;

        // njDrawSprite2D_8c074c08
        njDrawSprite2D(&sprite, *((int *) dat_entry), thepri, NJD_SPRITE_ALPHA);
    }

    // dat_entry += (int) dat_section_base;

    // while (*((int *) (dat_section_base + i * sizeof(DatSect1Entry))) != -1) {
    //     // float local_local_x = local_x;
    //     // local_local_x += *((float *) (dat_entry + 4));
    //     // float local_local_y = local_y;
    //     // local_local_y += *((float *) (dat_entry + 8));
    //     xadd = *((float *) (dat_entry + 4));
    //     xa = x + xadd;
    //     sprite.p.x = xa;

    //     yadd = *((float *) (dat_entry + 8));
    //     ya = y + yadd;
    //     sprite.p.y = ya;

    //     // njDrawSprite2D_8c074c08
    //     njDrawSprite2D(&sprite, *((int *) dat_entry), pri, NJD_SPRITE_ALPHA);

    //     pri += .0001f;
    //     i++;
    //     dat_entry += 0xc;
    // }
}
