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
extern float _8c226468_in_fr15;
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

    int r0, r1, r2, r3, r5, _8c226468_as_int_in_r13, b;
    float fr0, fr1, fr2, fr3, fr13, fr14, _8c226468_in_fr15;

    fr3 = _8c226468_in_fr15;
    fr14 = -127.f;
    _8c226468_as_int_in_r13 = (int) fr3;
    r0 = _8c0fcd50.field_0x00 & 2;
    fr3 = (float) _8c226468_as_int_in_r13;
    _8c226468_in_fr15 = fr3;

    if (r0 == 2) {
        fr3 = 10.f;
        fr2 = 3000.f;
        if (_8c226468_in_fr15 >= fr3 && fr2 > _8c226468_in_fr15) {
            // 8c01016c
            r3 = _8c0fcd50.field_0x08;
            fr0 = -10.f;
            fr3 = _8c226468_in_fr15;
            fr3 += fr0;
            fr0 = _8c0fcd50.field_0x18;
            fr2 = fr3;
            fr2 = fr0 * fr3 + fr2;
            fr3 = fr2;
            fr3 += fr14;

            // fr2 = _8c0fcd50.field_0x08
            // fr2 += _8c0fcd50.field_0x18 * (_8c226468_in_fr15 - 10.f)
            // fr3 = fr2
            // fr2 = _8c0fcd50.field_0x08;
            // fr2 += _8c0fcd50.field_0x18 * (_8c226468_in_fr15 - 10.f);
            // vol = (int) (_8c0fcd50.field_0x08 +  _8c0fcd50.field_0x18 * (_8c226468_in_fr15 - 10.f));
            sdMidiSetVol(
                _midi_handle_8c0fcd28[7],
                (Sint8) fr3,
                0
            );
        // 8c010192
        } else if (3000 <= _8c226468_in_fr15) {
            // 8c01019a
            r2 = _8c0fcd50.field_0x0c;
            r3 = (Sint16) -3000;
            r3 += _8c226468_as_int_in_r13;
            fr0 = _8c0fcd50.field_0x1c;
            fr2 = (float) r2;
            fr1 = (float) r3;
            fr1 *= fr0;
            fr2 -= fr1;
            fr2 += fr14;

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
            // fr1 = (float) _8c226468_in_fr15 + -3000
            // fr1 *= _8c0fcd50.field_0x1c
            // fr2 -= fr1
            // fr2 += -127.f
            // fr2 = (_8c0fcd50.field_0x0c - ((_8c226468_in_fr15 + -3000) * _8c0fcd50.field_0x1c)) + -127;
            sdMidiSetVol(
                _midi_handle_8c0fcd28[7],
                (Sint8) fr2,
                0
            );
        }
    }

    // LAB_8c0101bc
    b = _8c0fcd50.field_0x00 & 4;
    if (b == 4) {
        // 8c0101c4
        fr3 = _8c226468_in_fr15;
        fr0 = -1000.f;
        fr3 += fr0;
        fr0 = _8c0fcd50.field_0x20;
        fr14 += fr0 * fr3;

        // fr0 = -1000
        // fr3 =  _8c226468_in_fr15
        // fr3 += fr0 (_8c226468_in_fr15 += -1000)
        // fr0 = _8c0fcd50.field_0x20
        // fr14 += fr0 * fr3 (-127f += _8c0fcd50.field_0x20 * fr3)
        // param = (int) fr14
        // (int) (_8c0fcd50.field_0x20 * (_8c226468_in_fr15 + -1000) + -127.f)

        sdMidiSetVol(
            _midi_handle_8c0fcd28[6],
            (int) (_8c0fcd50.field_0x20 * (_8c226468_in_fr15 + -1000) + -127),
           0
        );

        // r3 = (Uint16) 2100;
        if (! (_8c226468_as_int_in_r13 > 2100)) {
            // 8c0101e2
            r1 = _8c0fcd50.field_0x00;
            r2 = -5;
            r5 = -127;
            r1 &= r2;
            _8c0fcd50.field_0x00 = r1;

            // r1 = _8c0fcd50.field_0x00
            // r2 = -5 (0xFB)
            // r5 = -0x7f (-127)
            // r1 &= 0xFB
            // _8c0fcd50.field_0x00 & 0xFB
            // _8c0fcd50.field_0x00 &= 0xFB;
            sdMidiSetVol(
                _midi_handle_8c0fcd28[6],
                -127,
                0
            );
        }
    }
}
