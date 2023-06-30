#include <shinobi.h>

struct s_8c157a48 {
    int field_0x00;
    int field_0x04;
    int field_0x08;
    int field_0x0c;
}
typedef s_8c157a48;

struct ukn_01 {
    int field_0x00;
    Uint8 flag;
    Uint8 power;
    Uint8 freq;
}
typedef s_ukn_01;

extern s_8c157a48 _8c157a48;
extern s_ukn_01* _8c03be5c;

void FUN_8c010e90(int port) {
    PDS_VIBPARAM param;
    s_ukn_01* r13_02;

    r13_02 = *(&_8c03be5c + _8c157a48.field_0x00);

    if (!_8c157a48.field_0x08) {
        int r0;
        s_ukn_01* r0_2;

        param.unit = 1;

        r0_2 = _8c157a48.field_0x08 + r13_02;
        param.flag = r0_2->flag;

        r0_2 = _8c157a48.field_0x08 + r13_02;
        param.power = r0_2->power;

        r0_2 = _8c157a48.field_0x08 + r13_02;
        param.freq = r0_2->freq;

        param.inc = 0;

        pdVibMxStart(port, &param);

        _8c157a48.field_0x08++;
        _8c157a48.field_0x0c = 1;
    } else if ((r13_02 + (_8c157a48.field_0x08 - 1))->field_0x00 < _8c157a48.field_0x04) {
        /* 8c010f02 */
        pdVibMxStop(port);

        _8c157a48.field_0x04 = 0;

        if ((r13_02 + _8c157a48.field_0x08)->field_0x00 == 0) {
            /* 8c010f18 */
            FUN_8c010fbe();
        } else {
            int r0;
            s_ukn_01* r0_2;

            /* 8c010f20 */
            param.unit = 1;

            r0_2 = _8c157a48.field_0x08 + r13_02;
            param.flag = r0_2->flag;

            r0_2 = _8c157a48.field_0x08 + r13_02;
            param.power = r0_2->power;

            r0_2 = _8c157a48.field_0x08 + r13_02;
            param.freq = r0_2->freq;

            param.inc = 0;

            while (1) {
                int r = pdVibMxStart(port, &param);
                if (!r)
                    break;
            }

            _8c157a48.field_0x08++;
        }
    }

    /* 8c010f5c */
    if (_8c157a48.field_0x0c == 1) {
        /* 8c010f62 */
        _8c157a48.field_0x04++; 
    }

    /* 8c010f68 */
}

FUN_8c010f7a(int param) {
    if (param < 8) {
        if (_8c157a48.field_0x0c == 1) {
            if (_8c157a48.field_0x00 > 8) {
                return;
            }

            _8c157a48.field_0x00 = 8;
        } else {
            if (!_8c157a48.field_0x0c) {
                FUN_8c010fbe();
            }

            _8c157a48.field_0x00 = 8;
        }
    }
}

FUN_8c010fae(int port) {
    if (_8c157a48.field_0x00 != 7) {
        FUN_8c010e90(port);
        return;
    }
}

FUN_8c010fbe() {
    memset(&_8c157a48, 0, 16);
    _8c157a48.field_0x00 = 7;
}
