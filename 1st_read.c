/* Tokyo Bus Guide IP.BIN
 *
 * reg[REG] = access to register REG
 *
 */

typedef enum {FALSE, TRUE} boolean;

// ac010000: entry
//  - Write to register ff00001c
//  - Jump to 8c04f6c0

_8c04f6c0() {
    //   8c04f6c0 24 d2         mov.l     LAB_8c04f754,r2
    //   8c04f6c2 22 4f         sts.l     PR,@-r15
    //   8c04f6c4 22 63         mov.l     @r2=>DAT_f649f449,r3
    // r3 = "---\n", but used as an address?
    //   8c04f6c6 30 61         mov.b     @r3,r1
    // r1 = 0

    //   0x8c04f6c8 to 0x8c04f6d4
    // Write "SEGA" (or "AGES" ?) from 0x8c00c000 to 0x8c00f400
    // TODO

    //   8c04f6d6
    // No effect observed
    _8c04f6f8();

    //   8c04f6da
    // No effect observed
    _8c04f6e8();

    //   8c04f6e0
    //  Game runs here?
    _8c010080();

    // f6e4
    _8c04f6f0();

    // f6f4
    _8c051e1a();


    //   8c04f6de 21 d2         mov.l     PTR_DAT_8c04f764,r2                        = 8c09067a
    //   8c04f6e0 52 1f         mov.l     r5,@(0x8,r15)
    //   8c04f6e2 62 85         mov.w     @(0x4,r6)=>DAT_f80bf82f,r0
    //   8c04f6e4 14 7c         add       #0x14,r12
    //   8c04f6e6 c3 63         mov       r12,r3

}

void _8c010080() {
    //   8c010088 0b 43
    // Note: takes some time...
    _8c0134ec();

    //   8c01008c
    // TODO: Main game loop?
    // 8c01008c doesnt break on demo. Or does it?
    while (!_8c01392e()) {
        _8c0571e2();
    }

    //   8c0100a0
    return _8c0139d4();
}

// ...

struct _8c315be8 {};
typedef struct _8c315be8 _8c315be8;

boolean _8c0571e2_b = FALSE;

// TODO: Check initial value
boolean _8c315598_c = FALSE;

void _8c0571e2() { 
    //   8c0571f6
    //   in r12
    _8c315be8 a = _8c0807b2();

    

    //   8c057200
    if (_8c0571e2_b) {
        while (_8c315598_c) {
            // ...
        }
        
        //   8c05722a
        if (reg[R14] < 166000) {
            _8c0571cc();
        }

        _8c096be0();

        // 0x8c3153dc = 0
        // 0x8c3153e0 = 0
        // 0x8c3153e4 = 0
        // _8c315404++

        _8c0966a0(_8c315404);
        _8c05413a();
        _8c0807b2();

        // ...
    }

}

_8c315be8 _8c0807b2() {}

// ...
