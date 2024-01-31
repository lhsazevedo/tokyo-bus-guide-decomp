#include "shinobi.h"

extern NJS_POINT2 *_8c045578;
extern void *_8c0455e8;
extern NJS_CAMERA _8c1bb904;

extern void draw_8c022464(Uint32 p1);
extern NJS_CAMERA *_8c226558;
extern Uint32 _8c226560;
extern Uint32 _8c226564;
extern Bool is_fading_8c226568;
extern void (*_8c22656c)(void);
extern Uint32 _8c227d7c;
extern Uint32 _8c227d80;

extern NJS_POLYGON_VTX _8c0455a8[4];

void _8c022910() {
    if (_8c226560) {
        _8c05b7e0(0x100);
        njUserClipping(0, &_8c045578);
        _8c079330(_8c0455e8);

        _8c226558 = &_8c1bb904;

        draw_8c022464(0);
    }

    /* r4  = _8c227d80 */
    /* r5  = _8c227d7c */
    /* r6  = 0 */
    /* r7  = is_fading_8c226568 */
    /* r12 = 0xff000000 */
    /* r13 = _8c22656c */
    /* r14 =  */

    switch (_8c227d7c)
    {
    case 0:
        switch (_8c226564)
        {
        case 0:
            return;
            break;

        case 1:
            _8c227d7c = 1;
            _8c227d80 = 0xff000000;
            is_fading_8c226568 = TRUE;
            goto outerCase1;
            break;

        case 2:
            /* code */
            _8c227d7c = 2;
            _8c227d80 = 0;
            is_fading_8c226568 = TRUE;
            goto outerCase2;
            break;
        
        default:
            return;
            break;
        }
        break;
    
    case 1:
        outerCase1:
        _8c227d80 -= 0x44000000;

        if (_8c227d80 < 0x01000000 || !is_fading_8c226568) {
            _8c227d7c = 0;
            _8c226564 = 0;
            is_fading_8c226568 = FALSE;

            if ((Sint32) _8c22656c != -1) {
                _8c22656c();
                _8c22656c = (void *) -1;
            }

            // TODO
            // _8c0455b4 = uVar1 & 0xff000000;
            _8c0455a8[0].col = _8c227d80 & 0xff000000;
            _8c0455a8[1].col = _8c227d80 & 0xff000000;
            _8c0455a8[2].col = _8c227d80 & 0xff000000;
            _8c0455a8[3].col = _8c227d80 & 0xff000000;

            njDrawPolygon(_8c0455a8, 4, 1);
        }

        /* code */
        break;

    case 2:
        outerCase2:
        _8c227d80 += 0x00044000;

        if (_8c227d80 > 0x01000000 || !is_fading_8c226568) {
                _8c227d7c = 3;
                _8c226560 = 0;
                _8c227d80 = 0x00ff0000;
        }

        _8c0455a8[0].col = (_8c227d80 << 8) & 0xff000000;
        _8c0455a8[1].col = (_8c227d80 << 8) & 0xff000000;
        _8c0455a8[2].col = (_8c227d80 << 8) & 0xff000000;
        _8c0455a8[3].col = (_8c227d80 << 8) & 0xff000000;
        break;

    case 3:
        outerCase3:

        _8c227d7c = 0;
        _8c226564 = 0;
        is_fading_8c226568 = 0;

        if ((Sint32) _8c22656c != -1) {
            _8c22656c();
            _8c22656c = (void *) -1;
        }

        break;
    
    default:
        return;
        break;
    }
}
