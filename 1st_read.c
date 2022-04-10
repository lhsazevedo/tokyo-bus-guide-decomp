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
    // No effect observed (without patching)
    _8c04f6f8();

    //   8c04f6da
    // No effect observed (without patching)
    _8c04f6e8();

    //   8c04f6e0
    //  Game runs here?
    mainfunc_8c010080();

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

void mainfunc_8c010080() {
    //   8c010088 0b 43
    // Note: takes some time...
    njUserInit_8c0134ec();

    // 0x8c01008c: Main game loop
    while (1) {
		if (njUserMain_8c01392e() < 0) break;
		njWaitVSync_8c0571e2();
	}

    // Game exits next.

    //   8c0100a0
    return njUserExit();
}

// ...

struct QueuedDat {
    char *basepath;
    char *filename;
    void *dest;
    unsigned int *uint_ukn2;
}
typedef QueuedDat;

// 0x8c935900
// TODO: Discover loaded flag - Appears to be setted at 8c0139c6 ?
QueuedDat *queued_dat_base;

// TODO: ?
QueuedDat queued_dats[10];

QueuedDat *ukn_dat_end_8c157a90;

int *ff_ptr_8c157a98 = 0;

char *cur_dir_8c157a80 = "DATA EMPTY.";

_dat_8c0111b4(UknDatStruct ukn_dat_struct) {
    QueuedDat *queued_dat = ukn_dat_struct->queued_dat;

    if (ukn_dat_struct->_08_int == 0) {
        for (; queued_dat < ukn_dat_end_8c157a90; queued_dat += sizeof(QueuedDat)) {
            if (queued_dat->uint_ukn2 == 0) {
                if (*queued_dat->basepath != '\0') {
                    if (!strcmp("DATA EMPTY.", queued_dat->basepath)) {
                        cur_dir_8c157a80 = queued_dat->basepath;

                        // gdFsChangeDir?
                        gdFsChangeDir_8c0532ac(queued_dat->basepath);
                    }

                    // gdFsOpen?
                    void *gdfs = gdFsOpen_8c053ba6(queued_dat->filename, 0);
                    ukn_dat_struct->gdfs = gdfs;

                    if (!gdfs) {
                        // break?
                    }

                    int size;
                    gdFsGetFileSize_8c053316(gdfs, &size);

                    if (!size) {
                        // break?
                    }

                    size = gdFsCalcSctSize(size);

                    void* dest = malloc_8c0544d6(size);

                    queued_dat->dest = dest;

                    int ret = gdFsRead_8c0533ee(gdfs, size, queued_dat->dest);

                    if (!ret) {
                        // break?
                    }

                    gdFsClose(gdfs);

                    queued_dat->uint_ukn2 = 1;
                }
            }
        }
    } else if (ukn_dat_struct->_08_int == 1) {

    }

    return;
}


// Called by by 0x8c014ae8 ?

sortQueuedDats_8c011310() {
    // The comments below are relative to the marks_parts.dat call

    // 0x8c157a8c = QueuedDat *queued_dat_base
    // 0x8c935900 = char* queued_dat_base->basepath
    // 0x8c033380 = char '\'

    // 0x8c011322: r12 = 0x8c157a8c = 0x8c935900 = 0x8c033380 = "\SYSTEM"
    // 0x8c011324: r8  = 0x8c157a90 = 0x8c9359a0 = 0xffffffff
    // 0x8c011326: r2  = 0x8c935900 = 0x8c033380 = "\SYSTEM"
    // 0x8c011328: r3  = 0x8c9359a0 = 0xffffffff
    // 0x8c01132a: r2 != r3 (0x8c935900 != 0x8c9359a0)

    //                                TODO
    //                               vvvvvvv
    if (queued_dat_base->basepath != reg[r3]) {

        // malloc?
        //                                              TODO
        //                                             vvvvvvv
        void *temp_queued_dats_maybe = malloc_8c0544d6(reg[r4] - queued_dat_base->basepath);
        // temp_queued_dats_maybe = allocated memory (0xa0 bytes?)

        boolean swapped;

        do {
            swapped = FALSE;

            QueuedDat* next_queued_dat_base = queued_dat_base + sizeof(QueuedDat);

            while (queued_dat_base < reg[r2]) {
                if (strcmp(queued_dat_base->filename, next_queued_dat_base->filename)) {
                    memcpy(queued_dat_base, temp_queued_dats_maybe, 0x10);
                    memcpy(next_queued_dat_base, queued_dat_base, 0x10);
                    memcpy(temp_queued_dats_maybe, next_queued_dat_base, 0x10);

                    swapped = TRUE;
                }

                queued_dat_base += sizeof(QueuedDat);
            }
        } while (swapped);

        free(temp_queued_dats_maybe);

        //   8c01139c 08 20         tst       r0,r0
        //   8c01139e 02 8f         bf/s      LAB_8c0113a6
        //   8c0113a0 04 7f         _add      #0x4,r15
        
        // 1st param is a func**
        // 2nd param is a func* (QueuedDat)
        // 3rd param is a unknown * 
        // 4rd param is a unknown * --> 0x8C2260D4 on this call
        //     appears to be destination
        if (_8c014ae8(_8c1ba3c8, _8c0111b4, ptr1, ptr2, 0)) {
            // TODO:
            //   8c0113a6 c2 62         mov.l     @r12=>DAT_8c157a8c,r2
            //   8c0113a8 f2 63         mov.l     @r15=>local_28,r3
            //   8c0113aa 1f d1         mov.l     PTR_PTR_s_DATA_EMPTY_8c011428,r1           = 8c03be7c
            //   8c0113ac 26 13         mov.l     r2,@(0x18,r3)
            //   8c0113ae f2 63         mov.l     @r15=>local_28,r3
            //   8c0113b0 1e d0         mov.l     PTR_DAT_8c01142c,r0                        = 8c157a80
            //   8c0113b2 a2 13         mov.l     r10,@(0x8,r3)
            //   8c0113b4 1b d3         mov.l     PTR_DAT_8c011424,r3                        = 8c157a88
            //   8c0113b6 a2 23         mov.l     r10,@r3=>DAT_8c157a88
            //   8c0113b8 12 62         mov.l     @r1=>PTR_s_DATA_EMPTY_8c03be7c,r2          = 8c03334c
            //   8c0113ba 22 20         mov.l     r2,@r0=>DAT_8c157a80
            //   8c0113bc 01 e0         mov       #0x1,r0

            return 1;
        }
    }

    return 0;
}

_8c014ae8(param1, param2, param3, param4, param5) {
    local8 = param2;
    local4 = param3;
}

void njUserInit_8c0134ec() {
    _8c01356c(0x100000);

    if (_8c0550b0() == 0) {
        _8c013574(0x31, 0, 2);
    } else {
        _8c0149b0(0x38, 0, 2);

        _8c079318(1.0, 0.91);
    }

    // 0x8c01358c
    void *_8c2f8ca0 = (void *) 0x8c2f8ca0;
    _8c073248(_8c2f8ca0, 0x10, 0);

    // 0x8c013596
    void *_8c255ca0 = (void *) 0x8c255ca0;
    _8c05b7b0(_8c255ca0, 0x0800);

    // 0x8c013596
    // njInitVertexBuffer?
    _8c056ea2(800000, 320000, 320000, 320000, 20000);

    // 0x8c0135b2
    void *_8c277ca0 = (void *) 0x8C277CA0;
    _8c059dcc(_8c277ca0, 0x80800);

    // 0x8c0135bc
    void *_8c157af8 = (void *) 0x8C157AF8;
    _8c059de2(_8c157af8, 0x0c00);

    void *_8c235ca0 = (void *) 0x8c235ca0;
    _8c057f18(_8c235ca0, 0x20000);

    // 0x8c0135d0
    void *_8c2f84a0 = (void *) 0x8c2f84a0;
    _8c05b62e(_8c2f84a0);

    _8c05483c();

    // 0x8c0135de
    char a = _8c010924();

    if (a < 0) {
        // ...
    } else {
        // ...
    }

    // ...
}

struct _8c315be8 {};
typedef struct _8c315be8 _8c315be8;

boolean _8c0571e2_update_b = FALSE;

// TODO: Check initial value
boolean _8c315598_c = FALSE;

void njWaitVSync_8c0571e2() { 
    //   8c0571f6
    //   in r12
    _8c315be8 a = _8c0807b2();

    // 0x8C057202
    // If skipped: No effect observed...
    // If return here: No game update, song continues.
    if (_8c0571e2_update_b) {

        // TODO: Find declaration
        int local_r14 = 0;

        // 0x8c057222
        // 166000 is at 0x8c057318
        // TODO: No effect observed changing this number...
        while (_8c315598_c || local_r14 < 166000) {
            _8c0807b2();
            ... = _8c0807bc(...);
            local_r14 = _8c0807f6(...);
        }

        //   8c05722a
        if (local_r14 < 166000) {
            _8c0571cc();
        }
    }

    // 0x8c057234
    // If skipped
    //   - at SEGA: Freeze, able to return
    //   - at Title screen: Screen freeze, audio continues, able to press enter. Crashes soon after.
    //   - at demo: Instant crash
    _8c096be0();

    // 0x8c3153dc = 0
    // 0x8c3153e0 = 0
    // 0x8c3153e4 = 0
    // _8c315404++

    // 0x8c057254
    // If skipped: Rushes licenses and runs demo without graphics
    _8c0966a0(_8c315404);

    // 0x8c057254
    // If skipped: No input
    _8c05413a();

    // 0x8c05725e: No effect observed
    _8c0807b2();

    // 0x8c057262
    // Some writes...
}

_8c315be8 _8c0807b2() {}

// ...

int _8c0807f6(int r4_param1) {
    int r4_copy = (r4_param1 & 0x7f) * 100;

    int r4_copy2 = (r4_param1 >> 25) * 100;

    return (r4_copy >> 25) + r4_copy2;
}

// ...


// Pretty long
_8c096be0 () {
    //   8c096be0 e6 2f         mov.l     r14,@-r15=>local_4
    //   8c096be2 d6 2f         mov.l     r13,@-r15=>local_8
    //   8c096be4 c6 2f         mov.l     r12,@-r15=>local_c
    //   8c096be6 b6 2f         mov.l     r11,@-r15=>local_10
    //   8c096be8 a6 2f         mov.l     r10,@-r15=>local_14
    //   8c096bea 96 2f         mov.l     r9,@-r15=>local_18
    //   8c096bec 86 2f         mov.l     r8,@-r15=>local_1c
    //   8c096bee 22 4f         sts.l     PR,@-r15=>local_20
    // Save regs

    //   8c096bf0 a8 7f         add       #-0x58,r15
    //   8c096bf2 83 d3         mov.l     PTR_DAT_8c096e00,r3                        = 8c0e9c04
    //   8c096bf4 f3 62         mov       r15,r2
    //   8c096bf6 10 72         add       #0x10,r2
    //   8c096bf8 32 61         mov.l     @r3=>DAT_8c0e9c04,r1                       = 80000000h
    //   8c096bfa 31 50         mov.l     @(0x4,r3)=>DAT_8c0e9c08,r0
    //   8c096bfc 12 22         mov.l     r1,@r2=>local_68
    //   8c096bfe 01 12         mov.l     r0,@(0x4,r2)=>local_64
    //   8c096c00 33 50         mov.l     @(0xc,r3)=>DAT_8c0e9c10,r0
    //   8c096c02 32 51         mov.l     @(0x8,r3)=>DAT_8c0e9c0c,r1                 = 00800400h
    //   8c096c04 12 12         mov.l     r1,@(0x8,r2)=>local_60
    //   8c096c06 03 12         mov.l     r0,@(0xc,r2)=>local_5c
    //   8c096c08 35 50         mov.l     @(0x14,r3)=>DAT_8c0e9c18,r0                = FFFFFFFFh
    //   8c096c0a 34 51         mov.l     @(0x10,r3)=>DAT_8c0e9c14,r1                = FFFFFFFFh
    //   8c096c0c 14 12         mov.l     r1,@(0x10,r2)=>local_58
    //   8c096c0e 05 12         mov.l     r0,@(0x14,r2)=>local_54
    //   8c096c10 37 50         mov.l     @(0x1c,r3)=>DAT_8c0e9c20,r0                = FFFFFFFFh
    //   8c096c12 36 51         mov.l     @(0x18,r3)=>DAT_8c0e9c1c,r1                = FFFFFFFFh
    //   8c096c14 16 12         mov.l     r1,@(0x18,r2)=>local_50
    //   8c096c16 07 12         mov.l     r0,@(0x1c,r2)=>local_4c
    //   8c096c18 7a d2         mov.l     DAT_8c096e04,r2                            = 8C34E7D8h
    //   8c096c1a 22 60         mov.l     @r2=>DAT_8c34e7d8,r0
    //   8c096c1c 40 c8         tst       #0x40,r0
    //   8c096c1e 0d 89         bt        LAB_8c096c3c



    // ...
}