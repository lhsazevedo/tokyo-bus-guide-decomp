// April 24, 2022
// For now we don't need to keep reversing this one...

#include <shinobi.h>
#include <sg_sd.h>
#include <includes.h>
#include <_19124_8c014ab4_tasks.h>
#include <_23224_8c015ab8_task_title.h>

// extern void sdMidiPlay(Uint32 *p1, Uint32 p2, Uint32 p3, Uint32 p4);
// extern boolean getUknPvmBool_8c01432a();
// extern void _8c011f7e();
// extern void _8c01940e();
// extern void push_fadein_8c015b5c();
// extern void njSetBackColor();

extern SDMIDI midi_handle_8c0fcd28;
extern Bool is_fading_8c226568;
extern void drawSprite_8c014f54(DrawDatStruct1 *drawdatstruct, Uint32 texture_id, Float32 x, Float32 y, Float32 priority);

// p2 is a ResourceGroup
extern void request_sys_resgrp_8c018568(void *p1, void *p2);

extern void nop_8c011120();
extern void resetUknPvmBool_8c014322();

// extern void push_fadeout_8c022b60();
extern TaskAction task_8c012f44;
extern void _8c019e44(Task *task);
extern char s_TOKYOBUS_001_8c037f60[13];
extern Uint32 _8c03bd80;
extern void *title_resource_group_8c044254;
extern NJS_TEXMEMLIST *_8c157af8;
extern PDS_PERIPHERAL per_8c1ba35c;
extern Task *_8c1ba3c8;
extern Uint32 _8c1bb8c4;
extern MenuState menu_state_8c1bc7a8;
extern void *_8c1bc7b4;
extern Sint32 _8c225fb0;

void task_title_8c015ab8(Task *task, void *state) {
    // r12 = 0x8c226568
    // fr12 = -4.5
    // fr13 = -4.0
    // fr14 = -5.0
    // fr15 = 0

    TITLE_STATE title_state = menu_state_8c1bc7a8.state_0x18;

    if (title_state >= TITLE_BUS_SLIDE && title_state <= TITLE_FLAG_REVEAL) {
        if (per_8c1ba35c.press & NJD_DGT_ST) {
            sdMidiPlay(midi_handle_8c0fcd28, 1, 0, 0);

            per_8c1ba35c.press = 0;
            menu_state_8c1bc7a8.state_0x18 = TITLE_0X0E;
            is_fading_8c226568 = 0;
        }
    }

    switch (menu_state_8c1bc7a8.state_0x18) {
        case TITLE_INIT:
            if (!getUknPvmBool_8c01432a()) {
                _8c011f7e();
                _8c01940e();

                if (task->field_0x08 == 0) {
                    // 0x8c015baa
                    menu_state_8c1bc7a8.state_0x18 = TITLE_FORTYFIVE_FADEIN;

                    push_fadein_8c015b5c(20);

                    njSetBackColor(0xff000000, 0xff000000, 0xff000000);
                    //return;
                } else {
                    // 0x8c015bd8
                    menu_state_8c1bc7a8.state_0x18 = 0x0d;

                    push_fadein_8c015b5c(0xa);

                    // 0x8c015c84
                    njSetBackColor(0xffffffff, 0xffffffff, 0xffffffff);
                    //return;
                }
            }

            break;

        // FORTYFIVE FADE IN
        // 0x8c015be4 (0x8c015b32 + 4 + 0x0AE)
        case TITLE_FORTYFIVE_FADEIN:
            if (!is_fading_8c226568) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_FORTYFIVE;
                menu_state_8c1bc7a8.logo_timer_0x68 = 0;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 0, 0.0, 0.0, -5.0);
            break;

        // FORTYFIVE
        // 0x8c015bf4 (0x8c015b32 + 4 + 0x0BE)
        case TITLE_FORTYFIVE:
            if (++menu_state_8c1bc7a8.logo_timer_0x68 > 0x1e) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_FORTYFIVE_FADEOUT;
                push_fadeout_8c022b60(20);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 0, 0.0, 0.0, -5.0);
            break;

        // FORTYFIVE FADE OUT
        // 0x8c015c0c (0x8c015b32 + 4 + 0x0D6)
        case TITLE_FORTYFIVE_FADEOUT:
            if (!is_fading_8c226568) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_ADX_FADEIN;
                push_fadein_8c015b5c(20);
                return;
            }
            
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 0, 0.0, 0.0, -5.0);
            break;

        // ADX FADE IN
        // 0x8c015c1e (0x8c015b32 + 4 + 0x0E8)
        case TITLE_ADX_FADEIN:
            if (!is_fading_8c226568) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_ADX;
                menu_state_8c1bc7a8.logo_timer_0x68 = 0;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 3, 0.0, 0.0, -5.0);
            break;

        // ADX
        // 0x8c015c2e (0x8c015b32 + 4 + 0x0F8)
        case TITLE_ADX:
            if (++menu_state_8c1bc7a8.logo_timer_0x68 > 0x1e) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_ADX_FADEOUT;
                push_fadeout_8c022b60(20);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 3, 0.0, 0.0, -5.0);

            break;

        // ADX FADE OUT
        // 0x8c015c46 (0x8c015b32 + 4 + 0x110)
        case TITLE_ADX_FADEOUT:
            if (!is_fading_8c226568) {
                // VMU Check?
                if (_8c012984() == 0 || _8c019550(s_TOKYOBUS_001_8c037f60, 3) == 0) {
                    menu_state_8c1bc7a8.state_0x18 = TITLE_VMU_WARN_FADEIN;
                    push_fadein_8c015b5c(10);
                } else {
                    menu_state_8c1bc7a8.state_0x18 = TITLE_FADEIN;
                    push_fadein_8c015b5c(10);
                }

                return;
            }
            
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 3, 0.0, 0.0, -5.0);
            break;

        // VMU WARNING FADE IN
        // 0x8c015c6c (0x8c015b32 + 4 + 0x136)
        case TITLE_VMU_WARN_FADEIN:
            if (!is_fading_8c226568) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_VMU_WARN;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 17, 0.0, 0.0, -5.0);

            njSetBackColor(0xffffffff, 0xffffffff, 0xffffffff);
            
            break;

        // VMU WARNING
        // 0x8c015ca8 (0x8c015b32 + 4 + 0x172)
        case TITLE_VMU_WARN:
            if (per_8c1ba35c.press != 0 || _8c019550(s_TOKYOBUS_001_8c037f60, 3) != 0) {
                sdMidiPlay(midi_handle_8c0fcd28, 1, 0, 0);
                menu_state_8c1bc7a8.state_0x18 = TITLE_VMU_WARN_FADEOUT;
                push_fadeout_8c022b60(10);

                return;
            }
            
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 17, 0.0, 0.0, -5.0);
            break;

        // VMU WARNING FADE OUT
        // 0x8c015cd4 (0x8c015b32 + 4 + 0x19E)
        case TITLE_VMU_WARN_FADEOUT:
            if (!is_fading_8c226568) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_FADEIN;
                push_fadein_8c015b5c(10);

                return;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 17, 0.0, 0.0, -5.0);
            break;

        // TITLE FADE IN
        // 0x8c015cf2 (0x8c015b32 + 4 + 0x1BC)
        case TITLE_FADEIN:
            if (is_fading_8c226568 != 0) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_BUS_SLIDE;

                menu_state_8c1bc7a8.bus_x_pos_0x20 = 640;

                snd_8c010cd6(0, 0);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0.0, 0.0, -5.0);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0.0, 0.0, -7.0);

            break;

        // BUS SLIDE
        // 0x8c015d10 (0x8c015b32 + 4 + 0x1DA)
        case TITLE_BUS_SLIDE:
            menu_state_8c1bc7a8.bus_x_pos_0x20 -= 5.11111;

            if (menu_state_8c1bc7a8.bus_x_pos_0x20 > 180) {
                // drawSprite_8c014f54();
                drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 1, 0.0, 0.0, -5.0);

                drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0.0, 0.0, -5.0);

                drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0.0, 0.0, -7.0);

                // ...
                return;
            } else {
                menu_state_8c1bc7a8.state_0x18 = TITLE_FLAG_REVEAL;

                menu_state_8c1bc7a8.flag_y_pos_0x24 = 167.0;
            }

            // Missing break?

        // FLAG REVEAL
        // 0x8c015d4a (0x8c015b32 + 4 + 0x214)
        case TITLE_FLAG_REVEAL:
            menu_state_8c1bc7a8.flag_y_pos_0x24 -= 2.33333;

            if (menu_state_8c1bc7a8.flag_y_pos_0x24 <= 97) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_0X0E;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 4, 302, menu_state_8c1bc7a8.flag_y_pos_0x24, -4.5);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 1, 0.0, 0.0, -5.0);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0.0, 0.0, -5.0);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0.0, 0.0, -7.0);

            break;

        // Coming from demo?
        // 0x8c015d94 (0x8c015b32 + 4 + 0x25E)
        case TITLE_0X0D:
            if (!is_fading_8c226568) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_0X0E;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 5, 0, 0, -4.5);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 6, 0, 0, -4.5);

            // 0x8c015f7c
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 4, 302, 97, -4.5);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 1, 180, 0, -4);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0, 0, -5);

            // 0x8c015fac - 0x8c015fb4
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0, 0, -7);

            break;

        // 0x8c015e18 (0x8c015b32 + 4 + 0x2E2)
        case TITLE_0X0E:
            // r? = per_8c1ba35c
            if ((per_8c1ba35c.press & NJD_DGT_ST) != 0) {
                _8c010bae(0);
                _8c010bae(1);

                sdMidiPlay(midi_handle_8c0fcd28, 1, 0, 0);

                menu_state_8c1bc7a8.state_0x18 = TITLE_0X0F;
                menu_state_8c1bc7a8.logo_timer_0x68 = 0;
            } else {
                menu_state_8c1bc7a8.field_0x64++;

                if (menu_state_8c1bc7a8.field_0x64 >= 0x41a) {
                    menu_state_8c1bc7a8.state_0x18 = TITLE_0X11;

                    _8c010bae(0);
                    _8c010bae(1);

                    push_fadeout_8c022b60(60);
                }
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 5, 0, 0, -4.5);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 6, 0, 0, -4.5);

            // 0x8c015f7c
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 4, 302, 97, -4.5);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 1, 180, 0, -4);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0, 0, -5);

            // 0x8c015fac - 0x8c015fb4
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0, 0, -7);

            break;

        // 0x8c015e68 (0x8c015b32 + 4 + 0x332)
        case TITLE_0X0F:
            if (++menu_state_8c1bc7a8.logo_timer_0x68 > 10) {
                menu_state_8c1bc7a8.state_0x18 = TITLE_0X10;

                push_fadeout_8c022b60(10);
            }

            if ((menu_state_8c1bc7a8.logo_timer_0x68 & 1) != 0) {
                drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 6, 0, 0, -4.5);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 4, 302, 97, -4.5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 1, 180, 0, -4);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0, 0, -5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0, 0, -7);

            break;

        // 0x8c015e98 (0x8c015b32 + 4 + 0x362)
        case TITLE_0X10:
            _8c019550(s_TOKYOBUS_001_8c037f60, 3);

            if (!is_fading_8c226568) {
                if (_8c03bd80 == 0) {
                    _8c1bb8c4 = 0;

                    _8c019e44(task);
                }
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 5, 0, 0, -4.5);

            if ((++menu_state_8c1bc7a8.logo_timer_0x68 & 1) != 0) {
                drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 6, 0, 0, -4.5);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 4, 302, 97, -4.5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 1, 180, 0, -4);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0, 0, -5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0, 0, -7);

            break;

        // 0x8c015f04 (0x8c015b32 + 4 + 0x3CE)
        case TITLE_0X11:

            if (!is_fading_8c226568) {
                if (_8c03bd80 == 0) {
                    _8c016182();
                    _8c0159ac();
                }
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 5, 0, 0, -4.5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 6, 0, 0, -4.5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 4, 302, 97, -4.5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 1, 180, 0, -4);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0, 0, -5);
            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0, 0, -7);

            break;
    }
}

void _8c015fd6() {
    Task *t1;
    Task *t2;

    _8c0128cc(0);

    pushTask_8c014ae8(_8c1ba3c8, task_8c012f44, &t1, NULL, 0);
    njSetBackColor(0xffffffff, 0xffffffff, 0xffffffff);
    pushTask_8c014ae8(_8c1ba3c8, task_title_8c015ab8, &t2, NULL, 0);

    menu_state_8c1bc7a8.state_0x18 = TITLE_INIT;
    menu_state_8c1bc7a8.field_0x64 = 0;

    njGarbageTexture(_8c157af8, 0xc00);

    _8c02ae3e(-2, 0x20, 0x178, 0x240, 0x40);
    _8c011f36(8, 0, 0, 8);
    _8c011f6c();

    _8c225fb0 = -1;

    request_sys_resgrp_8c018568(_8c1bc7b4, title_resource_group_8c044254);
    _8c01852c();
    setUknPvmBool_8c014330();
    _8c011fe0(nop_8c011120, 0, 0, 0, resetUknPvmBool_8c014322);
}
