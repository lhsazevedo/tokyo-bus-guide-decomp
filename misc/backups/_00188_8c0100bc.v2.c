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
    _8c0fcd50.field_0x18 = const127_8c03bd90 / 2600.f;
    _8c0fcd50.field_0x1c = _8c0fcd50.field_0x18 * 2600.f / 3000.f;
    _8c0fcd50.field_0x14 = const127_8c03bd90 * 30 / 100;
    _8c0fcd50.field_0x08 = const127_8c03bd90 * 40 / 100;
    _8c0fcd50.field_0x0c = (int) (_8c0fcd50.field_0x18 * 3000.f);
    _8c0fcd50.field_0x20 = const127_8c03bd90 / 3900.f;
}

void FUN_mdiVol_8c010128() {
    // int a = _8c0fcd50.field_0x00 & 2;
    // int b;
    // float temp;
    // float fr2;
    // int vol;

    int r13_8c226468_as_int;
    float fr15_8c226468, temp1, temp2;
    SDMIDI *midi_handle_a;

    // fr14 = -127.f;
    r13_8c226468_as_int = (int) _8c226468;
    fr15_8c226468 = (float) r13_8c226468_as_int;

    if ((_8c0fcd50.field_0x00 & 2) == 2) {
        midi_handle_a = &(*_midi_handle_8c0fcd28);
        midi_handle_a += 7;
        // fr3 = 10.f;
        // fr2 = 3000.f;
        if (!(10 > fr15_8c226468) && 3000 > fr15_8c226468) {
            // fr2 = _8c0fcd50.field_0x08 + (_8c0fcd50.field_0x18 * (fr15_8c226468 + -10.f));

            // if (fr15_8c226468 >= 10 && 3000 > fr15_8c226468) {
            // 8c01016c
            // r3 = _8c0fcd50.field_0x08;
            // fr0 = -10.f;
            // fr3 = fr15_8c226468 + -10.f;
            // fr3 += -10.f;
            // fr0 = _8c0fcd50.field_0x18;
            //fr2 = _8c0fcd50.field_0x08 + (_8c0fcd50.field_0x18 * (fr15_8c226468 + -10.f));
            // fr2 += _8c0fcd50.field_0x18 * fr3;
            // fr3 = fr2;
            // fr3 += fr14;

            // fr2 = _8c0fcd50.field_0x08
            // fr2 += _8c0fcd50.field_0x18 * (fr15_8c226468 - 10.f)
            // fr3 = fr2
            // fr2 = _8c0fcd50.field_0x08;
            // fr2 += _8c0fcd50.field_0x18 * (fr15_8c226468 - 10.f);
            // vol = (int) (_8c0fcd50.field_0x08 +  _8c0fcd50.field_0x18 * (fr15_8c226468 - 10.f));
            sdMidiSetVol(
                *midi_handle_a,
                ((_8c0fcd50.field_0x08 + (_8c0fcd50.field_0x18 * (fr15_8c226468 + -10.f))) + -127.f),
                0
            );
        // 8c010192
        } else {
            if (3000 <= fr15_8c226468) {
                // 8c01019a
                // fr2 = _8c0fcd50.field_0x0c - (_8c0fcd50.field_0x1c * (r13_8c226468_as_int + -3000));

                // r2 = _8c0fcd50.field_0x0c;
                //r3 = ((Sint16) -3000) + r13_8c226468_as_int;
                // r3 += r13_8c226468_as_int;
                // fr0 = _8c0fcd50.field_0x1c;
                // fr2 = _8c0fcd50.field_0x0c - (_8c0fcd50.field_0x1c * (r13_8c226468_as_int + -3000));
                // fr1 = (float) r3;
                // fr1 *= _8c0fcd50.field_0x1c;
                // fr2 -= fr1;
                // fr2 += fr14;

                // r2 = _8c0fcd50.field_0x0c
                // r0 = H'1C
                // r3 = -3000
                // r6 = 0
                // FPUL = r2
                // r3 += r13 (r3 += (int) global)   <------------- ?
                // fr0 = _8c0fcd50.field_0x1c
                // fr2 = FPUL (fr2 = (float) _8c0fcd50.field_0x0c)
                // FPUL = r3
                // fr1 = FPUL (fr1 = (float) r3)
                // fr1 *= fr0 (fr1 *= _8c0fcd50.field_0x1c)
                // fr2 -= fr1
                // fr2 += fr14 (fr2 += -127.f)
                // r5 = (int) fr2

                // fr2 = (float) _8c0fcd50.field_0x0c
                // fr1 = (float) fr15_8c226468 + -3000
                // fr1 *= _8c0fcd50.field_0x1c
                // fr2 -= fr1
                // fr2 += -127.f
                // fr2 = (_8c0fcd50.field_0x0c - ((fr15_8c226468 + -3000) * _8c0fcd50.field_0x1c)) + -127;
                sdMidiSetVol(
                    *midi_handle_a,
                    ((_8c0fcd50.field_0x0c - (_8c0fcd50.field_0x1c * (r13_8c226468_as_int + -3000))) + -127.f),
                    0
                );
            }
        }
    }

    // LAB_8c0101bc
    if ((_8c0fcd50.field_0x00 & 4) == 4) {
        // 8c0101c4
        // fr14 = -127.f + _8c0fcd50.field_0x20 * (fr15_8c226468 + (-1000.f))

        // fr3 = fr15_8c226468 + (-1000.f);
        // fr0 = -1000.f;
        // fr3 += fr0;
        // fr0 = _8c0fcd50.field_0x20;
        // fr14 = -127.f + _8c0fcd50.field_0x20 * (fr15_8c226468 + (-1000.f));
        // fr14 += _8c0fcd50.field_0x20 * fr3;

        // fr0 = -1000
        // fr3 =  fr15_8c226468
        // fr3 += fr0 (fr15_8c226468 += -1000)
        // fr0 = _8c0fcd50.field_0x20
        // fr14 += fr0 * fr3 (-127f += _8c0fcd50.field_0x20 * fr3)
        // param = (int) fr14
        // (int) (_8c0fcd50.field_0x20 * (fr15_8c226468 + -1000) + -127.f)

        sdMidiSetVol(
            _midi_handle_8c0fcd28[6],
            (-127.f + _8c0fcd50.field_0x20 * (fr15_8c226468 + -1000.f)),
           0
        );

        // r3 = (Uint16) 2100;
        if (! (r13_8c226468_as_int >= 2100)) {
            // 8c0101e2
            // r1 = _8c0fcd50.field_0x00;
            // r2 = -5;
            // r5 = -127;
            // r1 &= r2;
            _8c0fcd50.field_0x00 = _8c0fcd50.field_0x00 & 0xFB;

            // r1 = _8c0fcd50.field_0x00
            // r2 = -5 (0xFB)
            // r5 = -0x7f (-127)
            // r1 &= 0xFB
            // _8c0fcd50.field_0x00 & 0xFB
            // _8c0fcd50.field_0x00 &= 0xFB;
            sdMidiSetVol(
                _midi_handle_8c0fcd28[6],
                (Sint8) -127,
                0
            );
        }
    }
}
