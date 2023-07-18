#include <shinobi.h>
#include <sg_sd.h>
#include <cri_adxt.h>

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
extern SDMIDI midi_handle_8c0fcd28[7];

typedef struct _Test {
    float var0;
} Test;

typedef struct _Test2 {
    Uint32 var0;
} Test2;

extern Test _8c226468;
extern Uint32 _8c1bbcb0;

#define WKSIZE 184516
extern char work_8c0fcd74[WKSIZE * 2];
extern ADXT adxt_8c0fcd20[2];

/* Matched */
midiSetPitch_8c01023c()
{
    int _8c226468_as_int = _8c226468.var0;

    if (_8c226468_as_int > 10.f && _8c226468_as_int < 3000.f) {
        sdMidiSetPitch(
            midi_handle_8c0fcd28[6],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
        sdMidiSetPitch(
            midi_handle_8c0fcd28[7],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
    } else if (_8c226468_as_int >= 3000.f && _8c226468_as_int < 4000.f) {
        sdMidiSetPitch(
            midi_handle_8c0fcd28[6],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
        sdMidiSetPitch(
            midi_handle_8c0fcd28[7],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
    }
}

FUN_8c0102d8()
{
    /*
     * r5 = _8c1bbcb0
     * r12 = __midi_handle_8c010348[6]
     * r14 = _8c0fcd50
     * r4 = _8c0fcd50 & 1
     */

    int _8c226468_as_int = _8c226468.var0;
    int bcb0 = _8c1bbcb0;
    int _8c0fcd50_field_0x00_temp = _8c0fcd50.field_0x00 & 1;

    if (_8c0fcd50_field_0x00_temp != 1 && bcb0 == 1) {
            /* 8c010312 */
            sdMidiSetPitch(midi_handle_8c0fcd28[6], -200, 0);
            sdMidiSetVol(midi_handle_8c0fcd28[6], _8c0fcd50.field_0x14 - 127, 0);
            sdMidiPlay(midi_handle_8c0fcd28[6], 1, 43, 0);

            _8c0fcd50.field_0x00 = 0;
            _8c0fcd50.field_0x00 |= 1;
        // }
    } else if (_8c0fcd50_field_0x00_temp == 1) {
            if (bcb0 != 1) {
                /* 8c010378 */
                sdMidiSetVol(midi_handle_8c0fcd28[6], -127, 2000);
                _8c0fcd50.field_0x00 &= (char) 0xfe;
            }
        // }
    }

    _8c0fcd50_field_0x00_temp = _8c0fcd50.field_0x00 & 2;
    /* 8c010388 */
    if (_8c0fcd50_field_0x00_temp != 2 && _8c226468_as_int >= 400.f) {
        sdMidiSetPitch(midi_handle_8c0fcd28[7], 0, 0);
        sdMidiSetVol(midi_handle_8c0fcd28[7], -127, 0);
        sdMidiPlay(midi_handle_8c0fcd28[7], 1, 44, 0);

        _8c0fcd50.field_0x00 |= 2;
    } else if (_8c0fcd50_field_0x00_temp == 2 && _8c226468_as_int < 400.f) {
        _8c0fcd50.field_0x00 &= (char) 0xfd;
    }

    // _8c0fcd50_field_0x00_temp = _8c0fcd50.field_0x00 & 4;
    /* 8c0103de */
    if ((_8c0fcd50.field_0x00 & 4) != 4 && _8c226468_as_int >= 2100.f) {
        sdMidiSetPitch(midi_handle_8c0fcd28[6], 0, 0);
        sdMidiSetVol(midi_handle_8c0fcd28[6], -127, 0);
        sdMidiPlay(midi_handle_8c0fcd28[6], 1, 45, 0);

        _8c0fcd50.field_0x00 |= 4;
    }
}

/* Matched */
createAdxHandles_8c010428()
{
    Sint8 i = 0;
    do
    {
        adxt_8c0fcd20[i] = ADXT_Create(2, &work_8c0fcd74[i * WKSIZE], WKSIZE);
        i++;
    } while (i < 2);
}

/* Matched */
createMidiHandles_8c010468()
{
    SDMIDI* handle = &midi_handle_8c0fcd28[0];
    do {
        sdMidiOpenPort(handle);
        handle++;
    } while (handle < &midi_handle_8c0fcd28[8]);
}

/* Matched */
createAdxAndMidiHandles_8c01048e()
{
    createAdxHandles_8c010428();
    createMidiHandles_8c010468();
}

FUN_8c0104d6()
{

}

FUN_8c010532()
{

}
