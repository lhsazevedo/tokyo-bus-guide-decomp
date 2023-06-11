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
// TODO: Move to constant section
extern const int const127_8c03bd90;
extern float _8c226468;
extern SDMIDI _midi_handle_8c0fcd28[7];

void FUN_sound_8c0100bc() {
    _8c0fcd50.field_0x18 = (float) const127_8c03bd90 / 2600;
    _8c0fcd50.field_0x1c = _8c0fcd50.field_0x18 * 2600 / 3000;
    _8c0fcd50.field_0x14 = const127_8c03bd90 * 30 / 100;
    _8c0fcd50.field_0x08 = const127_8c03bd90 * 40 / 100;
    _8c0fcd50.field_0x0c = _8c0fcd50.field_0x18 * 3000;
    _8c0fcd50.field_0x20 = (float) const127_8c03bd90 / 3900;
}

void FUN_mdiVol_8c010128() {
    // int a = _8c0fcd50.field_0x00 & 2;
    // int b;
    // float temp;
    // float fr2;
    // int vol;

    int int_temp, r13_8c226468_as_int;
    float fr15_8c226468, temp1;
    SDMIDI *midi_handle_a;
    // SDMIDI midi_handle_b;

    // fr14 = -127.f;
    r13_8c226468_as_int = (int) _8c226468;
    fr15_8c226468 = r13_8c226468_as_int;

    if ((_8c0fcd50.field_0x00 & 2) == 2) {
        midi_handle_a = &(*_midi_handle_8c0fcd28);
        midi_handle_a += 7;
        // fr3 = 10.f;
        // fr2 = 3000.f;
        if (!(10 > fr15_8c226468) && 3000 > fr15_8c226468) {
            sdMidiSetVol(
                *midi_handle_a,
                (float) _8c0fcd50.field_0x08 + (_8c0fcd50.field_0x18 * (fr15_8c226468 + -10)) + -127,
                0
            );
        // 8c010192
        } else if (3000 <= fr15_8c226468) {
                // 8c01019a
                sdMidiSetVol(
                    *midi_handle_a,
                    (float) _8c0fcd50.field_0x0c - (_8c0fcd50.field_0x1c * (r13_8c226468_as_int + -3000)) + -127,
                    0
                );
            // }
        }
    }

    // LAB_8c0101bc
    if ((_8c0fcd50.field_0x00 & 4) == 4) {
        // 8c0101c4
        // temp1 = 
        // fr3 = fr15;
        // fr0 = -1000;
        // fr3 += fr0;
        // temp1

        // fr0 = _8c0fcd50.field_0x20
        // fr14 += fr0 * fr3;

        // temp2 = fr15_8c226468;
        // temp2 += -1000;
        //temp1 = _8c0fcd50.field_0x20 * (fr15_8c226468 + -1000);
        sdMidiSetVol(
            _midi_handle_8c0fcd28[6],
            -127.f + _8c0fcd50.field_0x20 * (fr15_8c226468 + -1000.f),
           0
        );

        // r3 = (Uint16) 2100;
        if (! (r13_8c226468_as_int >= 2100)) {

            // midi_handle_b = _midi_handle_8c0fcd28[6];

            // 8c0101e2
            int_temp = _8c0fcd50.field_0x00;
            int_temp &= -5;
            _8c0fcd50.field_0x00 = int_temp;

            // r1 = _8c0fcd50.field_0x00
            // r2 = -5 (0xFB)
            // r5 = -0x7f (-127)
            // r1 &= 0xFB
            // _8c0fcd50.field_0x00 & 0xFB
            // _8c0fcd50.field_0x00 &= 0xFB;
            sdMidiSetVol(
                _midi_handle_8c0fcd28[6],
                -127.f,
                0
            );
        }
    }
}
