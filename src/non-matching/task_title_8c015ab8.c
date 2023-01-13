// April 24, 2022
// For now we don't need to keep reversing this one...

#include "includes.h"

extern void _8c051618();
extern boolean getUknPvmBool_8c01432a();
extern void _8c011f7e();
extern void _8c01940e();
extern void push_fadein_8c015b5c();
extern void _8c05738a();
extern int _8c0fcd28;
extern int is_fading_8c226568;
extern void drawSprite_8c014f54(void *r4, int r5, float fr4, float fr5, float fr6);
extern void push_fadeout_8c015b60();

struct MenuState {
    void *field_0x00;
    void *field_0x04;
    void *field_0x08;
    DrawDatStruct1 *drawdatstruct1_0x0c;
    void *field_0x10;
    void *field_0x14;
    int mode_0x18;
    int field_0x1c;
    float field_0x20;
    float field_0x24;
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

void task_title_8c015ab8(Task *task, void *state) {
    // r12 = 0x8c226568
    // fr12 = -4.5
    // fr13 = -4.0
    // fr14 = -5.0
    // fr15 = 0

    int m = menu_state_8c1bc7a8.mode_0x18;

    if (m >= 0xb && m < 0xc && _8c1ba35c.field_0x10 != 8) {
        _8c051618(_8c0fcd28, 1, 0, 0);

        _8c1ba35c.field_0x10 = 0;
        menu_state_8c1bc7a8.mode_0x18 = 0xe;
        is_fading_8c226568 = 0;
    }

    switch (menu_state_8c1bc7a8.mode_0x18) {
        // 0x8c015b88 (0x8c015b32 + 4 + 0x052)
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

                    push_fadein_8c015b5c(20);

                    _8c05738a(0xff000000, 0xff000000, 0xff000000);
                }
            }

            return;

        // FORTYFIVE FADE IN
        // 0x8c015be4 (0x8c015b32 + 4 + 0x0AE)
        case 0x01:
            if (is_fading_8c226568 == 0) {
                menu_state_8c1bc7a8.mode_0x18 = 0x02;
                menu_state_8c1bc7a8.logo_timer_0x68 = 0;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 0, 0.0, 0.0, -5.0);
            return;

        // FORTYFIVE
        // 0x8c015bf4 (0x8c015b32 + 4 + 0x0BE)
        case 0x02:
            // r4 = 0x1e

            menu_state_8c1bc7a8.logo_timer_0x68++;

            if (menu_state_8c1bc7a8.logo_timer_0x68 > 0x1e) {
                menu_state_8c1bc7a8.mode_0x18 = 0x03;
                push_fadeout_8c015b60(20);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 0, 0.0, 0.0, -5.0);
            return;

        // FORTYFIVE FADE OUT
        // 0x8c015c0c (0x8c015b32 + 4 + 0x0D6)
        case 0x03:
            if (is_fading_8c226568 == 0) {
                drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 0, 0.0, 0.0, -5.0);
            } else {
                menu_state_8c1bc7a8.mode_0x18 = 0x04;

                push_fadein_8c015b5c(20);
            }

            return;

        // ADX FADE IN
        // 0x8c015c1e (0x8c015b32 + 4 + 0x0E8)
        case 0x04:
            if (is_fading_8c226568 == 0) {
                menu_state_8c1bc7a8.mode_0x18 = 0x05;
                menu_state_8c1bc7a8.logo_timer_0x68 = 0;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 3, 0.0, 0.0, -5.0);
            return;

        // ADX
        // 0x8c015c2e (0x8c015b32 + 4 + 0x0F8)
        case 0x05:
            menu_state_8c1bc7a8.logo_timer_0x68++;

            if (menu_state_8c1bc7a8.logo_timer_0x68 > 0x1e) {
                menu_state_8c1bc7a8.mode_0x18 = 0x06;
                push_fadeout_8c015b60(20);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 3, 0.0, 0.0, -5.0);

            break;

        // ADX FADE OUT
        // 0x8c015c46 (0x8c015b32 + 4 + 0x110)
        case 0x06:
            if (is_fading_8c226568 == 0) {
                drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 0, 0.0, 0.0, -5.0);
            } else {
                // VMU Check?
                if (_8c012984() == 0 || _8c019550("TOKYOBUS.001", 3) != 0) {
                    menu_state_8c1bc7a8.mode_0x18 = 0xa;
                } else {
                    menu_state_8c1bc7a8.mode_0x18 = 0x7;
                }

                push_fadein_8c015b5c(10);
            }

            break;

        // VMU WARNING FADE IN
        // 0x8c015c6c (0x8c015b32 + 4 + 0x136)
        case 0x07:
            break;

        // VMU WARNING
        // 0x8c015ca8 (0x8c015b32 + 4 + 0x172)
        case 0x08:
            break;

        // VMU WARNING FADE OUT
        // 0x8c015cd4 (0x8c015b32 + 4 + 0x19E)
        case 0x09:
            break;

        // TITLE FADE IN
        // 0x8c015cf2 (0x8c015b32 + 4 + 0x1BC)
        case 0x0a:
            if (is_fading_8c226568 == 0) {
                menu_state_8c1bc7a8.mode_0x18 = 0x0b;

                menu_state_8c1bc7a8.field_0x20 = 640;

                _8c010cd6(0, 0);
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 2, 0.0, 0.0, -5.0);

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 46, 0.0, 0.0, -7.0);

            break;

        // BUS SLIDE
        // 0x8c015d10 (0x8c015b32 + 4 + 0x1DA)
        case 0x0b:
            menu_state_8c1bc7a8.field_0x20 -= 5.11111;

            if (menu_state_8c1bc7a8.field_0x20 > 180) {
                // drawSprite_8c014f54();

                // ...
                break;
            } else {
                menu_state_8c1bc7a8.mode_0x18 = 0x0c;

                menu_state_8c1bc7a8.field_0x24 = 167.0;
            }

            // Missing break?

        // FLAG REVEAL
        // 0x8c015d4a (0x8c015b32 + 4 + 0x214)
        case 0x0c:
            menu_state_8c1bc7a8.field_0x24 -= 2.33333;

            if (menu_state_8c1bc7a8.field_0x24 <= 97) {
                menu_state_8c1bc7a8.mode_0x18 = 0x0e;
            }

            drawSprite_8c014f54(&menu_state_8c1bc7a8.drawdatstruct1_0x0c, 4, 302, menu_state_8c1bc7a8.field_0x24, -4.5);

            // drawSprite_8c014f54(...);

            // drawSprite_8c014f54(...);

            break;

        // Coming from demo?
        // 0x8c015d94 (0x8c015b32 + 4 + 0x25E)
        case 0x0d:
            // drawSprite_8c014f54(...) x 4
            break;

        // 0x8c015e18 (0x8c015b32 + 4 + 0x2E2)
        case 0x0e:
            // r14 = menu_state
            // r? = _8c1ba35c
            if (_8c1ba35c.field_0x10 == 8) {
                // 0x8c015e42
                if (++menu_state_8c1bc7a8.mode_0x18 == 1050) {
                    // 0x8c015e54
                    menu_state_8c1bc7a8.mode_0x18 = 0x11;

                    _8c010bae(0);
                    _8c010bae(1);

                    push_fadeout_8c022b60(60);
                }
            } else {
                // 0x8c015e20
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
        case 0x0f:
            break;

        // 0x8c015e98 (0x8c015b32 + 4 + 0x362)
        case 0x10:
            break;

        // 0x8c015f04 (0x8c015b32 + 4 + 0x3CE)
        case 0x11:
            break;
    }
}