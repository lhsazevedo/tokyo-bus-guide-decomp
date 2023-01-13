#include "includes.h"
#include "ninja.h"

struct menuTextboxStruct {
    int field0_0x0;
    int field1_0x4;
    int field2_0x8;
    int field2_2_0xc;
    int field3_0x10;
    int field4_0x14;
    int field5_0x18;
    unsigned short field6_0x1c;
    unsigned short field7_0x1e;
    unsigned short field8_0x20;
    short field9_0x22;
    int field10_0x24;
    int field11_0x26;
    int field12_0x28;
    int field13_0x2a;
    short *field14_0x2c;
    int field15_0x30;
    int field16_0x34;
    char * field17_0x38;
};
typedef menuTextboxStruct;

struct otherMenuTextboxStruct {
    short field_0x00;
    int field_0x04;
    char *field_0x08;

    NJS_TEXNAME *texnames_0x10;

    short field_0x14;

    char field_0x28;
    char field_0x29;
    field_0x2c;
    NJS_TEXINFO * texinfo_0x30;
};
typedef otherMenuTextboxStruct;


int _8c1bc790;
short *u16_ptr_8c1bc7a0;
Uint16 *tex_8c1bc7a4;
NJS_TEXNAME *texnames_8c1bc78c;
NJS_TEXLIST *texlists_8c1bc790;

void _8c0155e0_menuTextboxTextSub(menuTextboxStruct *txtStr, int param_r5) {
    short char_count_r0;
    short current_char_r3;
    otherMenuTextboxStruct localStr;

    if (txtStr->field17_0x38 == NULL) {
        return 0;
    }

    if (*txtStr->field17_0x38 == 0) {
        return 0;
    }

    if (param_r5 < txtStr->field8_0x20) {
        // 8c01561a
        char_count_r0 = txtStr->field9_0x22 + txtStr->field8_0x20;
    } else {
        // 8c015648
        char_count_r0 = txtStr->field7_0x1e + param_r5;
    }

    // 8c01564c
    localStr.field_0x14 = char_count_r0;
    localStr.field_0x00 = 0;

    localStr.field_0x08 = localStr.field_0x28;
    localStr.field_0x04 = localStr.field_0x29;
    
    // fr15 = 24.0

    // 8c015912
    char_count_r0 = localStr.field_0x14;
    current_char_r3 = localStr.field_0x00;
    while (current_char_r3 < char_count_r0) {
        unsigned short r11;
        unsigned short r3;
        int uVar4_r2;

        uVar4_r2 = txtStr->field6_0x1c + txtStr->field7_0x1e;

        r3 = localStr.field_0x00;
        r11 = localStr.field_0x00;
        r11 *= 2;

        if (r3 >= uVar4_r2) {
            char *puVar5;
            char *r3_2;

            // 8c015680
            puVar5 = txtStr->field17_0x38 + txtStr->field7_0x1e * 3 + txtStr->field6_0x1c * 2;

            // 8c015698
            if (*puVar5 == '<') {
                if (puVar5[1] == 'E') {
                    // 8c0156e0
                    uVar4_r2 =  0xfffe;
                    txtStr->field14_0x2c + r11 = uVar4_r2;
                } else if (puVar5[1] == 'D') {

                } else {
                    if (puVar5[1] == 'C') {

                    } else if (puVar5[1] == 'R') {

                    }
                }
                txtStr->field7_0x1e++;
            } else {
                int uVar9_r13 = 0;
                do {
                    // 8c015742
                    if (*(u16_ptr_8c1bc7a0 + uVar9_r13) == -1) {
                        // 8c015754
                        *localStr.field_0x08 = *puVar5;
                        *localStr.field_0x04 = *puVar5 + 1;

                        // If skipped, it repeats the same character
                        _8c015110(
                            *localStr.field_0x08 << 8 | *localStr.field_0x04,
                            &txtStr->field10_0x24,
                            _8c1ba1c8,
                            tex_8c1bc7a4
                        );

                        // 8c015780
                        njSetTextureInfo(
                            localStr.texinfo_0x30,
                            tex_8c1bc7a4,
                            0x100,
                            0x20,
                            0x20
                        );

                        localStr.texnames_0x10 = texnames_8c1bc78c[uVar9_r13];

                        // 8c015794
                        njSetTextureName(
                            texnames_8c1bc78c + uVar9_r13,
                            localStr.field_0x2c,
                            uVar9_r13,
                            NJD_TEXATTR_TYPE_MEMORY | NJD_TEXATTR_GLOBALINDEX
                        );

                        // 8c0157b2
                        localStr.field_0x0c = uVar9_r13 * 8;

                        // 8c0157bc
                        texlists_8c1bc790[uVar9_r13].textures = texnames_8c1bc78c[localStr.texnames_0x10];

                        // 8c0157ca
                        texlists_8c1bc790[localStr.field2_2_0xc].nbTexture = 1;

                        // 8c0157d2
                        u16_ptr_8c1bc7a0[uVar9_r13] = uVar9_r13;

                        // 8c0157dc
                        txtStr->field14_0x2c[r11] = uVar9_r13;

                        // 8c0157e0
                        njLoadTexture(texlists_8c1bc790[localStr.field2_2_0xc]);

                        // 8c0157ec ee 85         mov.w     @(0x1c,r14),r0
                        // 8c0157ee 01 70         add       #0x1,r0
                        // 8c0157f0 05 a0         bra       LAB_8c0157fe
                        // 8c0157f2 ee 81         _mov.w    r0,@(0x1c,r14)
                        txtStr->field6_0x1c++;

                        break;
                    }

                    uVar9_r13 = uVar9_r13 + 1;
                } while (uVar9_r13 < 0x200);

                if (uVar9_r13 >= 0x200) {
                    return 0xffffffff;
                }
            }
        }

        // 8c015834
        r0_2 = txtStr->field14_0x2c;
        r3 = *(r0_2 + r11);

        if (r3 >= 0xffed) {
            // 8c0158fc
            r0_2 = txtStr->field14_0x2c;
            r3 = *(r0_2 + r11);

            if (r3 != 0xfffe) {
                // TODO
                // 8c015908 c3 68         mov       r12,r8
                // 8c01590a 01 79         add       #0x1,r9
            }

            // 8c01590c
            localStr.field_0x00++;
        } else {
            // 8c015840
        }
    }

    // 8c01591e
    return 1;
}
