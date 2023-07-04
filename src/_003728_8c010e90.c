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
        param.unit = 1;

        param.flag = (r13_02 + _8c157a48.field_0x08)->flag;
        param.power = (r13_02 + _8c157a48.field_0x08)->power;
        param.freq = (r13_02 + _8c157a48.field_0x08)->freq;

        param.inc = 0;

        pdVibMxStart(port, &param);

        _8c157a48.field_0x08++;
        _8c157a48.field_0x0c = 1;
    } else if ((r13_02 + (_8c157a48.field_0x08 - 1))->field_0x00 < _8c157a48.field_0x04) {
        pdVibMxStop(port);

        _8c157a48.field_0x04 = 0;

        if ((r13_02 + _8c157a48.field_0x08)->field_0x00 == 0) {
            FUN_8c010fbe();
        } else {
            param.unit = 1;

            param.flag = (r13_02 + _8c157a48.field_0x08)->flag;
            param.power = (r13_02 + _8c157a48.field_0x08)->power;
            param.freq = (r13_02 + _8c157a48.field_0x08)->freq;

            param.inc = 0;

            while (1) {
                int r = pdVibMxStart(port, &param);
                if (!r)
                    break;
            }

            _8c157a48.field_0x08++;
        }
    }

    if (_8c157a48.field_0x0c == 1) {
        _8c157a48.field_0x04++; 
    }
}

FUN_8c010f7a(int param) {
    if (param < 8) {
        if (_8c157a48.field_0x0c == 1) {
            if (param > _8c157a48.field_0x00) {
                _8c157a48.field_0x00 = param;
            }
        } else if (_8c157a48.field_0x0c == 0) {
            FUN_8c010fbe();
            _8c157a48.field_0x00 = param;
        }
    }
}

FUN_8c010fae(int port) {
    if (_8c157a48.field_0x00 != 7) {
        FUN_8c010e90(port);
    }
}

FUN_8c010fbe() {
    memset(&_8c157a48, 0, sizeof(s_8c157a48));
    _8c157a48.field_0x00 = 7;
}
