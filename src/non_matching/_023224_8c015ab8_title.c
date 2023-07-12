// April 24, 2022
// For now we don't need to keep reversing this one...

#include <shinobi.h>
#include <sg_sd.h>
#include "_019100_8c014a9c_tasks.h"

struct ResourceGroup {
    char* parts;
    char* dat;
    char* pvm;
    Uint32 tex_count;
}
typedef ResourceGroup;

struct DrawDatStruct1 {
    NJS_TEXLIST *tlist_0x00;
    NJS_TEXANIM *tanim_0x04;
    void *contents_0x08;
    int field_0x0c;
}
typedef DrawDatStruct1;

struct MenuState {
    void *field_0x00;
    void *field_0x04;
    void *field_0x08;
    DrawDatStruct1 *drawDatStruct1_0x0c;
    void *field_0x10;
    void *field_0x14;
    int state_0x18;
    int field_0x1c;
    float busX_0x20;
    float flagY_0x24;
    int field_0x28;
    int field_0x2c;
    int field_0x30;
    int field_0x34;
    int field_0x38;
    int field_0x3c;
    int field_0x40;
    int field_0x44;
    int field_0x48;
    int field_0x4c;
    int field_0x50;
    int field_0x54;
    int field_0x58;
    int field_0x5c;
    int field_0x60;
    int field_0x64;
    int logo_timer_0x68;
}
typedef MenuState;

enum TITLE_STATE {
    TITLE_STATE_0X00_INIT,
    TITLE_STATE_0X01_FORTYFIVE_FADE_IN,
    TITLE_STATE_0X02_FORTYFIVE,
    TITLE_STATE_0X03_FORTYFIVE_FADE_OUT,
    TITLE_STATE_0X04_ADX_FADE_IN,
    TITLE_STATE_0X05_ADX,
    TITLE_STATE_0X06_ADX_FADE_OUT,
    TITLE_STATE_0X07_VMU_WARNING_FADE_IN,
    TITLE_STATE_0X08_VMU_WARNING,
    TITLE_STATE_0X09_VMU_WARNING_FADE_OUT,
    TITLE_STATE_0X0A_TITLE_FADE_IN,
    TITLE_STATE_0X0B_BUS_SLIDE,
    TITLE_STATE_0X0C_FLAG_REVEAL,
    TITLE_STATE_0X0D,
    TITLE_STATE_0X0E_PRESS_START,
    TITLE_STATE_0X0F_START_PRESSED,
    TITLE_STATE_0X10_START_PRESSED_FADE_OUT,
    TITLE_STATE_0X11_TIME_OUT
};

extern void _8c051618();
extern Bool getUknPvmBool_8c01432a();
extern void _8c011f7e();
extern void _8c01940e();
extern void push_fadein_8c022a9c();
extern SDMIDI midi_handle_8c0fcd28[7];
extern Bool isFading_8c226568;
extern void drawSprite_8c014f54(void *r4, int r5, float fr4, float fr5, float fr6);
extern void push_fadeout_8c022b60();
extern char* saveNames_8c044d50[11];
extern Bool _8c03bd80;
extern Bool _8c1bb8c4;
extern ResourceGroup titleResourceGroup_8c044254;
extern MenuState menuState_8c1bc7a8;
extern PDS_PERIPHERAL peripheral_8c1ba35c[2];
extern Task tasks_8c1ba3c8[16];
extern void task_8c012f44(Task* task, void* state);
extern NJS_TEXMEMLIST _8c157af8;
extern FUN_8c02ae3e(int p1, int p2, int p3, int p4, float fp1, int p5, int p6, int p7);
extern FUN_8c011f36(int p1, int p2, int p3, int p4);
extern void nop_8c011120();
extern void resetUknPvmBool_8c014322();
extern void* _8c225fb0;
extern FUN_8c019550(char** p1, int p2);
extern void _8c019e44(Task* task);
extern _8c016182();
extern _8c0159ac();
extern void FUN_8c011f6c();
extern void request_sys_resgrp_8c018568(DrawDatStruct1* dds, ResourceGroup* rg);
extern void requestCommonResources_8c01852c();
extern void setUknPvmBool_8c014330();
extern void FUN_8c011fe0(void* p1, int p2, int p3, int p4, void* p2);
extern void snd_8c010cd6(int p1, int p2);

void task_title_8c015ab8(Task* task, void *state) {
    /*
     * r14 = menuState_8c1bc7a8
     * fr12 = -4.5
     * fr13 = -4.0
     * fr14 = -5.0
     * fr15 = 0.0
     * r12 = is_fading_8c015b50
     * r9 = PDS_PERIPHERAL* peripheral_8c1ba35c
     * r10 = 0
     */
    PDS_PERIPHERAL* per = &peripheral_8c1ba35c[0];

    if (menuState_8c1bc7a8.state_0x18 >= TITLE_STATE_0X0B_BUS_SLIDE /* 8c015aec */
        && menuState_8c1bc7a8.state_0x18 <= TITLE_STATE_0X0C_FLAG_REVEAL /* 8c015af6 */
        && per->press & PDD_DGT_ST /* 8c015afa */
    ) {
        /* 8c015b00 */
        sdMidiPlay(midi_handle_8c0fcd28[0], 1, 0, 0);

        per->press = 0;
        menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0E_PRESS_START;
        isFading_8c226568 = FALSE;
    }

    /* 8c015b18
     * r11 = push_fadeout_8c022b60
     * r4 = 30 0x1e
     * r0 = menuState_8c1bc7a8.state_0x18
     * 
     */

    switch (menuState_8c1bc7a8.state_0x18) {
        /* 0x8c015b88 (0x8c015b32 + 4 + 0x052) */
        case TITLE_STATE_0X00_INIT:
            if (getUknPvmBool_8c01432a() == FALSE) {
                /* 8c015b96 */
                _8c011f7e();
                _8c01940e();

                if (task->field_0x08 == FALSE) {
                    /* 8c015bd8 */
                    menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X01_FORTYFIVE_FADE_IN;

                    push_fadein_8c022a9c(20);

                    /* 8c015c84 */
                    njSetBackColor(0xff000000, 0xff000000, 0xff000000);
                } else {
                    /* 8c015baa */
                    menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0D;

                    push_fadein_8c022a9c(10);

                    njSetBackColor(0xffffffff, 0xffffffff, 0xffffffff);
                }
            }

            break;

        /* 0x8c015be4 (0x8c015b32 + 4 + 0x0AE) */
        case TITLE_STATE_0X01_FORTYFIVE_FADE_IN:
            if (isFading_8c226568 == FALSE) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X02_FORTYFIVE;
                menuState_8c1bc7a8.logo_timer_0x68 = 0;
            }

            /* 0x8c015c1a (shared) */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 0, 0.0, 0.0, -5.0);

            break;

        /* 0x8c015bf4 (0x8c015b32 + 4 + 0x0BE) */
        case TITLE_STATE_0X02_FORTYFIVE:
            /* menuState_8c1bc7a8.logo_timer_0x68++; */
            if (++menuState_8c1bc7a8.logo_timer_0x68 > 30) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X03_FORTYFIVE_FADE_OUT;
                push_fadeout_8c022b60(20);
            }

            /* 0x8c015c1a (shared) */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 0, 0.0, 0.0, -5.0);

            break;

        // 0x8c015c0c (0x8c015b32 + 4 + 0x0D6)
        case TITLE_STATE_0X03_FORTYFIVE_FADE_OUT:
            if (isFading_8c226568 == FALSE) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X04_ADX_FADE_IN;
                push_fadein_8c022a9c(20);
            } else {
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 0, 0.0, 0.0, -5.0);
            }

            break;

        // 0x8c015c1e (0x8c015b32 + 4 + 0x0E8)
        case TITLE_STATE_0X04_ADX_FADE_IN:
            if (isFading_8c226568 == FALSE) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X05_ADX;
                menuState_8c1bc7a8.logo_timer_0x68 = 0;
            }

            /* 8c015c68 (shared) */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 3, 0.0, 0.0, -5.0);
            break;

        // 0x8c015c2e (0x8c015b32 + 4 + 0x0F8)
        case TITLE_STATE_0X05_ADX:
            /* menuState_8c1bc7a8.logo_timer_0x68++; */
            if (++menuState_8c1bc7a8.logo_timer_0x68 > 30) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X06_ADX_FADE_OUT;
                push_fadeout_8c022b60(20);
            }

            /* 8c015c68 (shared) */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 3, 0.0, 0.0, -5.0);

            break;

        // 0x8c015c46 (0x8c015b32 + 4 + 0x110)
        case TITLE_STATE_0X06_ADX_FADE_OUT:
            if (isFading_8c226568 == FALSE) {
                // VMU Check?
                if (_8c012984() == FALSE || FUN_8c019550(saveNames_8c044d50, 3) == FALSE) {
                    /* 8c015c62 */
                    menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X07_VMU_WARNING_FADE_IN;
                } else {
                    /* 8c015cda */
                    menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0A_TITLE_FADE_IN;
                }

                /* 8c015cde */
                push_fadein_8c022a9c(10);
            } else {
                /* 8c015c68 (shared) */
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 3, 0.0, 0.0, -5.0);
            }

            break;

        // 0x8c015c6c (0x8c015b32 + 4 + 0x136)
        case TITLE_STATE_0X07_VMU_WARNING_FADE_IN:
            if (isFading_8c226568 == FALSE) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X08_VMU_WARNING;
            }

            /* 8c015c78 */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 17, 0.0, 0.0, -5.0);

            /* 8c015c84 (shared) */
            njSetBackColor(0xffffffff, 0xffffffff, 0xffffffff);
            break;

        // 0x8c015ca8 (0x8c015b32 + 4 + 0x172)
        case TITLE_STATE_0X08_VMU_WARNING:
            if (
                per->press & (PDD_DGT_TA | PDD_DGT_ST)
                || FUN_8c019550(saveNames_8c044d50, 3)
            ) {
                sdMidiPlay(midi_handle_8c0fcd28[0], 1, 0, 0);
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X09_VMU_WARNING_FADE_OUT;
                push_fadeout_8c022b60(10);
            }

            /* 8c015ce8 (shared) */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 17, 0.0, 0.0, -5.0);

            break;

        // 0x8c015cd4 (0x8c015b32 + 4 + 0x19E)
        case TITLE_STATE_0X09_VMU_WARNING_FADE_OUT:
            if (isFading_8c226568 == FALSE) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0A_TITLE_FADE_IN;
                push_fadein_8c022a9c(10);
            } else {
                /* 8c015ce8 (shared) */
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 17, 0.0, 0.0, -5.0);
            }
            break;

        // 0x8c015cf2 (0x8c015b32 + 4 + 0x1BC)
        case TITLE_STATE_0X0A_TITLE_FADE_IN:
            if (isFading_8c226568 == FALSE) {
                /* 8c015cf2 */
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0B_BUS_SLIDE;
                menuState_8c1bc7a8.busX_0x20 = 640;

                /* Related to music */
                snd_8c010cd6(0, 0);
            }

            /* 8c015d7c (shared) - Draw title */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 2, 0.0, 0.0, -5.0);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 46, 0.0, 0.0, -7.0);

            break;

        /* 0x8c015d10 (0x8c015b32 + 4 + 0x1DA) */
        case TITLE_STATE_0X0B_BUS_SLIDE:
            menuState_8c1bc7a8.busX_0x20 -= 5.111111; /* ~ 46/9 */

            if (menuState_8c1bc7a8.busX_0x20 <= 180) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0C_FLAG_REVEAL;
                menuState_8c1bc7a8.flagY_0x24 = 167.0;
            } else {
                /* 8c015d38 - Draw bus */
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 1, menuState_8c1bc7a8.busX_0x20, 0.0, -4.0);

                /* 8c015d7c (shared) - Draw title */
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 2, 0.0, 0.0, -5.0);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 46, 0.0, 0.0, -7.0);

                break;
            }

            /* Missing break! */

        /* 0x8c015d4a (0x8c015b32 + 4 + 0x214) */
        case TITLE_STATE_0X0C_FLAG_REVEAL:
            menuState_8c1bc7a8.flagY_0x24 -= 2.3333333; /* ~ 7/3 */

            if (menuState_8c1bc7a8.flagY_0x24 <= 97) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0E_PRESS_START;
            }

            /* 8c015d6a - Draw flag */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 4, 302, menuState_8c1bc7a8.flagY_0x24, -4.5);

            /* 8c015da4 - Draw bus */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 1, 180, 0.0, -4.0);

            /* 8c015db4 - Draw title */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 2, 0.0, 0.0, -5.0);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 46, 0.0, 0.0, -7.0);

            break;

        /* 0x8c015e18 (0x8c015b32 + 4 + 0x2E2) */
        case TITLE_STATE_0X0E_PRESS_START:
            if (per->press & PDD_DGT_ST) {
                /* 8c015e20 */
                FUN_8c010bae(0);
                FUN_8c010bae(1);

                sdMidiPlay(midi_handle_8c0fcd28[0], 1, 0, 0);

                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X0F_START_PRESSED;
                menuState_8c1bc7a8.logo_timer_0x68 = 0;
            } else {
                /* 8c015e42 */
                if (++menuState_8c1bc7a8.field_0x64 > 1050) {
                    /* 8c015e54 */
                    menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X11_TIME_OUT;
                    FUN_8c010bae(0);
                    FUN_8c010bae(1);

                    push_fadeout_8c022b60(60);
                }
            }

            /* 8c015f60 (shared) */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 5, 0, 0, -4.5);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 6, 0, 0, -4.5);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 4, 302, 97, -4.5);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 1, 180, 0, -4);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 2, 0, 0, -5);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 46, 0, 0, -7);

            break;

        /* 0x8c015e68 (0x8c015b32 + 4 + 0x332) */
        case TITLE_STATE_0X0F_START_PRESSED:
            if (++menuState_8c1bc7a8.logo_timer_0x68 > 10) {
                menuState_8c1bc7a8.state_0x18 = TITLE_STATE_0X10_START_PRESSED_FADE_OUT;
                push_fadeout_8c022b60(10);
            }

            /* 8c015e7e */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 5, 0, 0, -4.5);
            if ((menuState_8c1bc7a8.logo_timer_0x68 & 1) != 0) {
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 6, 0, 0, -4.5);
            }
            /* 8c015f7c */
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 4, 302, 97, -4.5);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 1, 180, 0, -4);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 2, 0, 0, -5);
            drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 46, 0, 0, -7);
            break;

        /* 0x8c015e98 (0x8c015b32 + 4 + 0x362) */
        case TITLE_STATE_0X10_START_PRESSED_FADE_OUT:
            FUN_8c019550(saveNames_8c044d50, 3);

            if (isFading_8c226568 == FALSE) {
                if (!_8c03bd80) {
                    /* 8c015eb2 */
                    _8c1bb8c4 = FALSE;

                    /* Push menu task */
                    _8c019e44(task);
                }
            } else {
                /* 8c015ed6 */
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 5, 0, 0, -4.5);

                if ((++menuState_8c1bc7a8.logo_timer_0x68 & 1) != 0) {
                    drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 6, 0, 0, -4.5);
                }
                /* 8c015f7c */
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 4, 302, 97, -4.5);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 1, 180, 0, -4);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 2, 0, 0, -5);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 46, 0, 0, -7);
            }

            break;

        /* 0x8c015f04 (0x8c015b32 + 4 + 0x3CE) */
        case TITLE_STATE_0X11_TIME_OUT:
            if (isFading_8c226568 == FALSE) {
                if (_8c03bd80 == FALSE) {
                    _8c016182();
                    _8c0159ac();
                }
            } else {
                /* 8c015f60 (shared) */
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 5, 0, 0, -4.5);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 6, 0, 0, -4.5);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 4, 302, 97, -4.5);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 1, 180, 0, -4);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 2, 0, 0, -5);
                drawSprite_8c014f54(&menuState_8c1bc7a8.drawDatStruct1_0x0c, 46, 0, 0, -7);
            }
            break;
    }
}

void FUN_8c015fd6 (Bool direct) {
    /* Frame:
     * -0x04 R14 backup
     * -0x08 PR backup
     * -0x0c r4 
     * -0x10 created_state
     * -0x14 created_task
     * -0x18 (5th param to pushTask)
     * -0x1c (5th param to pushTask)
     */
    Task* created_task;
    void* created_state;
    /* Bool direct_local; */
    FUN_8c0128cc(0);

    /* 8c015ff4 */
    pushTask_8c014ae8(tasks_8c1ba3c8, task_8c012f44, &created_task, &created_state, 0);

    /* 8c015ffe */
    njSetBackColor(0,0,0);

    /* 8c016012 */
    pushTask_8c014ae8(tasks_8c1ba3c8, task_title_8c015ab8, &created_task, &created_state, 0);

    /* 8c01601e */
    menuState_8c1bc7a8.state_0x18 = 0;

    /* 8c016020 */
    /* direct_local = FALSE; */

    /* 8c016022 */
    menuState_8c1bc7a8.field_0x64 = 0;

    /* 8c016024 */
    /* direct_local = direct; */

    /* 8c01602a */
    created_task->field_0x08 = direct;

    /* 8c01602e */
    _8c1bb8c4 = 1;

    /* 8c016034 */
    njGarbageTexture(&_8c157af8, 3072);

    /* 8c01604e */
    FUN_8c02ae3e(0x20, 0x178, 0x240, 0x40, -2.0, 0, 0, -1);

    /* 8c01605a */
    FUN_8c011f36(8, 0, 0, 8);

    /* 8c016060 */
    FUN_8c011f6c();

    /* 8c01606c */
    _8c225fb0 = (void *) -1;

    /* 8c016070 */
    request_sys_resgrp_8c018568(menuState_8c1bc7a8.drawDatStruct1_0x0c, &titleResourceGroup_8c044254);

    /* 8c016076 */
    requestCommonResources_8c01852c();

    /* 8c01607c */
    setUknPvmBool_8c014330();

    /* 8c01608c */
    FUN_8c011fe0(nop_8c011120, 0, 0, 0, resetUknPvmBool_8c014322);
}
