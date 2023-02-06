#include <shinobi.h>
#include <includes.h>

enum TITLE_STATE {
    TITLE_INIT,

    TITLE_FORTYFIVE_FADEIN,
    TITLE_FORTYFIVE,
    TITLE_FORTYFIVE_FADEOUT,

    TITLE_ADX_FADEIN,
    TITLE_ADX,
    TITLE_ADX_FADEOUT,

    TITLE_VMU_WARN_FADEIN,
    TITLE_VMU_WARN,
    TITLE_VMU_WARN_FADEOUT,

    TITLE_FADEIN,
    TITLE_BUS_SLIDE,
    TITLE_FLAG_REVEAL,
    TITLE_0X0D,
    TITLE_0X0E,
    TITLE_0X0F,
    TITLE_0X10,
    TITLE_0X11
};
typedef enum TITLE_STATE TITLE_STATE;

struct MenuState {
    void *field_0x00;
    void *field_0x04;
    void *field_0x08;
    DrawDatStruct1 drawdatstruct1_0x0c;
    /* void *field_0x10; */
    /* void *field_0x14; */

    TITLE_STATE state_0x18;
    Uint32 field_0x1c;
    Float32 bus_x_pos_0x20;
    Float32 flag_y_pos_0x24;
    Uint32 field_0x28;
    Uint32 field_0x2c;
    Uint32 field_0x30;
    Uint32 field_0x34;
    Uint32 field_0x38;
    Uint32 field_0x3c;
    Uint32 field_0x40;
    Uint32 field_0x44;
    Uint32 field_0x48;
    Uint32 field_0x4c;
    Uint32 field_0x50;
    Uint32 field_0x54;
    Uint32 field_0x58;
    Uint32 field_0x5c;
    Uint32 field_0x60;
    Uint32 field_0x64;

    Sint32 logo_timer_0x68;
}
typedef MenuState;
