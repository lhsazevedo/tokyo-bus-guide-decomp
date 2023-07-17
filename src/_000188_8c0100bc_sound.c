#include <shinobi.h>
#include <sg_sd.h>

struct s_8c0fcd50 {
    int field_0x00;
    int field_0x04;
    int field_0x08;
    int field_0x0c;
    int field_0x10;
    int field_0x14;
    float field_0x18;
    float field_0x1c;
    float field_0x20;
}
typedef s_8c0fcd50;

extern s_8c0fcd50 _8c0fcd50;
/* TODO: Move to constant section */
extern const int const127_8c03bd90;
typedef struct _Test {
    float var0;
} Test;

extern Test _8c226468;
extern SDMIDI midi_handle_8c0fcd28[7];

void FUN_sound_8c0100bc() {
    _8c0fcd50.field_0x18 = (float) const127_8c03bd90 / 2600;
    _8c0fcd50.field_0x1c = _8c0fcd50.field_0x18 * 2600 / 3000;
    _8c0fcd50.field_0x14 = const127_8c03bd90 * 30 / 100;
    _8c0fcd50.field_0x08 = const127_8c03bd90 * 40 / 100;
    _8c0fcd50.field_0x0c = _8c0fcd50.field_0x18 * 3000;
    _8c0fcd50.field_0x20 = (float) const127_8c03bd90 / 3900;
}

void midiSetVol_8c010128() {
    int r13_8c226468_as_int = _8c226468.var0;

    if ((_8c0fcd50.field_0x00 & 2) == 2) {
        if (r13_8c226468_as_int >= 10.f && r13_8c226468_as_int < 3000.f) {
            sdMidiSetVol(
                midi_handle_8c0fcd28[7],
                _8c0fcd50.field_0x08 + (r13_8c226468_as_int - 10.f) * _8c0fcd50.field_0x18 - 127,
                0
            );
        /* 8c010192 */
        } else if (r13_8c226468_as_int >= 3000.f) {
            /* 8c01019a */
            sdMidiSetVol(
                midi_handle_8c0fcd28[7],
                _8c0fcd50.field_0x0c - (r13_8c226468_as_int - 3000) * _8c0fcd50.field_0x1c - 127,
                0
            );
        }
    }

    /* LAB_8c0101bc */
    if ((_8c0fcd50.field_0x00 & 4) == 4) {
        sdMidiSetVol(
            midi_handle_8c0fcd28[6],
            (r13_8c226468_as_int - 1000.f) * _8c0fcd50.field_0x20 - 127,
           0
        );

        if (r13_8c226468_as_int < 2100) {
            /* 8c0101e2 */
            _8c0fcd50.field_0x00 &= -5;

            sdMidiSetVol(
                midi_handle_8c0fcd28[6],
                -127,
                0
            );
        }
    }
}
