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
extern SDMIDI midi_handle_8c0fcd28[7];

typedef struct _Test {
    float var0;
} Test;

extern Test _8c226468;

/* Matched */
FUN_8c01023c()
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


