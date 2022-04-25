#include "includes.h"

extern void _8c051618();
extern boolean getUknPvmBool_8c01432a();
extern void _8c011f7e();
extern void _8c01940e();
extern void push_fadein_8c015b5c();
extern void _8c05738a();
extern int _8c0fcd28;
extern int is_fading_8c226568;
extern void draw_dat_8c014f54(void *r4, int r5, float fr4, float fr5, float fr6);
extern void push_fadeout_8c015b60();

struct MenuState {
    void *field_0x00;
    void *field_0x04;
    void *field_0x08;
    void *field_0x0c;
    void *field_0x10;
    void *field_0x14;
    int mode_0x18;
    int field_0x1c;
    // ...
    int logo_timer_0x68;
}
typedef MenuState;

MenuState menu_state_8c1bc7a8;

struct UknMenuStruct1  {
    int field_0x00;
    int field_0x04;
    int field_0x08;
    int field_0x0c;
    int field_0x10;
}
typedef UknMenuStruct1;

UknMenuStruct1 _8c1ba35c;

void task_menu_8c015ab8(Task *task, void *state) {
    // r12 = 0x8c226568

    int m = menu_state_8c1bc7a8.mode_0x18;

    if (m >= 0xb && m < 0xc && _8c1ba35c.field_0x10 != 8) {
        _8c051618(_8c0fcd28, 1, 0, 0);

        _8c1ba35c.field_0x10 = 0;
        menu_state_8c1bc7a8.mode_0x18 = 0xe;
        is_fading_8c226568 = 0;
    }

    switch (menu_state_8c1bc7a8.mode_0x18) {
        case 0x00:
            if (getUknPvmBool_8c01432a()) {
                _8c011f7e();
                _8c01940e();

                if (task->field_0x08 != 0) {
                    // 0x8c015bd8
                    menu_state_8c1bc7a8.mode_0x18 = 0x0d;

                    push_fadein_8c015b5c(0xa);

                    // 0x8c015c84
                    _8c05738a(-1, -1, -1);
                } else {
                    // 0x8c015baa
                    menu_state_8c1bc7a8.mode_0x18 = 0x01;

                    push_fadein_8c015b5c(0x14);

                    _8c05738a(0xff000000, 0xff000000, 0xff000000);
                }
            }

            return;

        case 0x01:
            // FORTYFIVE FADE IN
            // 0x8c015be4

            if (is_fading_8c226568 == 0) {
                menu_state_8c1bc7a8.mode_0x18 = 0x02;
                menu_state_8c1bc7a8.logo_timer_0x68 = 0;
            }

            //                                                 > Texture ID?
            //                                                 |  X    Y     ?
            draw_dat_8c014f54(&menu_state_8c1bc7a8.field_0x0c, 0, 0.0, 0.0, -5.0);
            return;

        case 0x02:
            // FORTYFIVE
            // 0x8c015bf4
            // r4 = 0x1e

            menu_state_8c1bc7a8.logo_timer_0x68++;

            if (menu_state_8c1bc7a8.logo_timer_0x68 > 0x1e) {
                menu_state_8c1bc7a8.mode_0x18 = 0x03;
                push_fadeout_8c015b60(0x14);
            }

            draw_dat_8c014f54(&menu_state_8c1bc7a8.field_0x0c, 0, 0.0, 0.0, -5.0);
            return;

        case 0x03:
            // FORTYFIVE FADE OUT
            // 08c015c0c

            if (is_fading_8c226568 == 0) {
                draw_dat_8c014f54(&menu_state_8c1bc7a8.field_0x0c, 0, 0.0, 0.0, -5.0);
            } else {
                menu_state_8c1bc7a8.mode_0x18 = 0x04;

                push_fadein_8c015b5c(0x14);
            }

            return;

        case 0x04:
            // ADX FADE IN
            // 0x8c015c1e

            if (is_fading_8c226568 == 0) {
                menu_state_8c1bc7a8.mode_0x18 = 0x05;
                menu_state_8c1bc7a8.logo_timer_0x68 = 0;
            }

            draw_dat_8c014f54(&menu_state_8c1bc7a8.field_0x0c, 3, 0.0, 0.0, -5.0);
            return;

        case 0x05:
            // ADX
            break;

        case 0x06:
            // ADX FADE OUT
            break;

        case 0x07:
            break;

        case 0x08:
            break;

        case 0x09:
            break;

        case 0x0a:
            // TITLE FADE IN
            break;

        case 0x0b:
            // BUS SLIDE
            break;

        case 0x0c:
            // FLAG REVEAL
            break;

        case 0x0d:
            break;

        case 0x0e:
            break;

        case 0x0f:
            break;

        case 0x10:
            break;

        case 0x11:
            break;

        case 0x12:
            break;
    }
}