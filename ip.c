/* Tokyo Bus Guide IP.BIN
 *
 * reg[REG] = access to register REG
 * 
 * June 8, 2022
 * This was a great start for learning how SH4 asm instructions translates to
 * rough C files. Now I'm moving on to the game code itself...
 *
 */

typedef enum {FALSE, TRUE} boolean;

void _ac008300_main() {
    reg[CCN_CCR] = 0x92B;

    // 0xac00830c overrides _8c0083a8_license_screen's return address to 0xac00b700
    _8c0083a8_license_screen();
}

// ...

void _8c0083a8_license_screen() {
    _8c0083c0_clear_ram();

    // TODO
    *((char*)0x8ced3d9c) = 0;


    _8c0083f8_license_screen2();
}

// ...

// Clear ram from 0x8ced3d00 to 0x8ced3d9f (159 bytes)
void _8c0083c0_clear_ram() {
    char* from = (char *) 0x8ced3d00;

    while (from < 0x8ced3da0) {
        *from++ = 0;
    }
}

void _8c0083f8_license_screen2() {
    _8c009dec();

    // Backup IMASK
    char local_2c_imask = (reg[SR] >> 4) & 0x0F;

    // Set IMASK
    reg[SR] = (reg[SR] & 0xffffff0f) | 0xf0;

    int local_8_9858_result = _8c009858();
    int local_c;

    // 0x8c00841e: Restore IMASK
    reg[SR] = (reg[SR] & 0xffffff0f) | (local_2c_imask << 4);

    if (local_8_9858_result != 4) {
        if (local_8_9858_result == 1 || local_8_9858_result == 3) {
            local_c = 8;
        } else {
            local_c = 6;
        }
    } else {
        local_c = 9;
    }


    // 0x8c008460: Backup IMASK
    local_2c_imask = (reg[SR] >> 4) & 0x0F;

    // Set IMASK
    reg[SR] = (reg[SR] & 0xffffff0f) | 0xf0;

    //   8c008474 f8 54         mov.l     @(0x20,r15)=>local_c,r4
    //   8c008476 18 d3         mov.l     ->FUN_8c009074,r3                          = 8c009074
    //   8c008478 0b 43         jsr       @r3=>FUN_8c009074                          undefined FUN_8c009074()
    //   8c00847a 09 00         _nop
    _8c009074(local_c);

    // 0x8c00847c: Restore IMASK
    reg[SR] = (reg[SR] & 0xffffff0f) | (local_2c_imask << 4);

    // NO TEX HERE
    _8c00853c(local_c);

    // 8c00849a
    // NO TEX HERE 
    _8c00908c(1);

    // 8c0084a0
    // NO TEX HERE
    int local_10 = _8c009e12();

    int local_28 = 0;
    boolean local_20 = FALSE;

    int local_1c;
    do {
        //   8c0084b0
        // LOOP1: NO TEX HERE
        // LOOP2: NO TEX HERE
        // LOOP3: NO TEX HERE
        int local_14 = _8c009e12();

        //   8c0084bc
        // LOOP1: NO TEX HERE
        // LOOP2: NO TEX HERE
        // LOOP3: NO TEX HERE
        int local_18 = _8c009e1c(local_10, local_14);

        //   8c0084c6
        // LOOP1: NO TEX HERE
        // LOOP2: NO TEX HERE
        // LOOP3: NO TEX HERE
        local_1c = _8c009e24(local_18);

        int local_24 = 0;
        while (local_24 < 10000) {
            local_24++;
        }

        //   8c0084fe
        local_28++;

        //   8c008504
        if (local_28 >= 4000) {
            local_20 = TRUE;
        }

        // 8c008510
    } while (local_1c < 2000000 || !local_20)

    _8c000800_bios_call(0);
}

// ...

// Bootstrap 1

// _ac00b700
// - Data hops,
// - Set stack pointer
// - Jump to 0x8c00d820

_8c00d820() {
    //   8c00d820 0a d0         mov.l     ->FUN_8c00d940,r0                          = 8c00d940
    //   8c00d822 00 e1         mov       #0x0,r1
    //   8c00d824 0b 40         jsr       @r0=>FUN_8c00d940                          undefined FUN_8c00d940()
    //   8c00d826 09 00         _nop
    _8c00d940(0); // param in r1?

    _8c00d900();

    _8c00d888();

    _8c00dae0();

    _8c00db40();

    return _8c00d86c();
}

// _8c00d86c
// _8c00e000_bootstrap2      1ST_READ.BIN is address here :)
// > _8c00e010
// > _8c00e000
// > _ac00e020

_ac00e020() {
    // 0xac00e020
    _ac00e114(?); // => ac00e126...

    // Set IMASK
    reg[SR] => (reg[SR] & 0xffffff0f) | 0xf0;

    // 0xac00e044: Set stack register r15

    // 0xac00e050: ?
    _ac00e108();

    if (!_ac00e144(0xacfd0000, 0xacfc0000, 0xacfe0000, 0xacff0000)) {
        _ac00e218(0xacfd0000, 0xacfc0000, 0xacfe0000, 0xacff0000);
    }

    _ac00eef0(0x0c00fc00, 0, 0x400);

    // 0xac00e0b8: Reset registers
    // 0xac00e0d6: Update stack register (8c00f400)
    // 0xac00e0da: Update other registers

    // Call 1ST_READ.BIN
    // Or ((void (*)(void)) 0xac010000)(); ?
    _ac010000();

    // Then call 0x0
    ((void (*)(void)) 0x0)();
}
