#include "includes.h"

extern int obj_port_hanlde_8c0fcd28;
extern int _8c18ad20;
extern void *_8c1bb868;
extern int _8c1bb8c8;
extern int replay_gameplay_8c1bb8d0;
extern void *bus_state_8c1bb9d0;
extern void *bus_8c1bbd9c;
extern int _8c2264d4;
extern float _8c227db0;
extern float _8c227db4;
extern int _8c228660;
extern int _8c228b3c;

struct BusState {
    int distance_traveled_0x070;
    int ang_0x074;
    int acc_0x078;
    int ang_0x07c;
    int blinker_0x080;
    int field_0x084;

    float field_0x0f4;
    float field_0x100;

    int ang_0x250;
    int ang_0x258;

    int mirror_0x268;

    int bus_state_0x2b4;

    float field_0x278;
    float speed_0x27c;
    float acc_hist_0x280[4];

    int gear_0x2f4;

    int bus_substate_0x3c0;
    int field_0x3c4;
}
typedef BusState;
BusState bus_state_8c1bb9d0;

void _8c022bdc_task_bus(Task *task, void *state) {
    int local_34;

    _8c2264d4 = _8c1bb868->field_0x4;

    _8c228660 = 0;
    bus_state_8c1bb9d0.blinker_0x080 = 0;

    float fr0 = _8c02ff08(bus_state_8c1bb9d0.field_0x278);
    fr0 *= 65536.0;

    fr0 /= 6.283184;

    local_34 = (int) fr0;

    if (bus_state_8c1bb9d0.field_0x0f4 > bus_state_8c1bb9d0.field_0x100) {
        local_34 = -local_34;
    }

    bus_state_8c1bb9d0.ang_0x250 = local_34;

    float speed_fr15 = bus_state_8c1bb9d0.speed_0x27c;

    switch (bus_state_8c1bb9d0.bus_state_0x2b4)
    {
        // Boarding
        case 0:
            // 8c022c7c
            switch (bus_state_8c1bb9d0.bus_substate_0x3c0)
            {
                // TODO
                case 0:
                    // 8c022c8a
                    if (!bus_state_8c1bb9d0.field_0x3c4) {
                        // Door opening sound
                        _sdMidiPlay(obj_port_hanlde_8c0fcd28, 1, 0x1d, 0);
                        bus_state_8c1bb9d0.bus_substate_0x3c0 = 1;

                        _8c227db0 = 0.f;
                    }
                    break;
                
                // FADING IN
                case 1:
                    // 8c022caa 
                    _8c227db0 += 0.5;

                    if (_8c227db0 > _8c227db4) {
                        // 8c022cbc
                        bus_state_8c1bb9d0.bus_substate_0x3c0 = 2;
                        _8c227db0 = _8c227db4;

                        bus_state_8c1bb9d0.field_0x3c4 = 0;
                    }
                    break;
            }
            break;
        
        // Driving
        case 1:
            /* code */
            switch (bus_state_8c1bb9d0.bus_substate_0x3c0)
            {
                // DOOR OPEN
                case 2:
                    // 8c022d14
                    // TODO
                    break;

                // DOOR CLOSING
                case 3:
                    // 8c022d3e
                    // TODO
                    break;
            }
            break;

        // TODO
        case 2:
            /* code */
            break;

        // TODO
        default:
            break;
    }

    // 8c022f72
    _8c010c6e();

    // TODO: If moving
    if (bus_state_8c1bb9d0.speed_0x27c != 0.f) {
        // 8c022f86
        _8c023938();

        _8c023cba();


        _8c228b3c = _8c1bb868->field_0x10;

        // Related to traffic violation?
        // TODO
        int *result = bus_state_8c1bb9d0.field_0x2d0(
            bus_state_8c1bb9d0.field_0x340,
            bus_state_8c1bb9d0.field_0x118,
            bus_state_8c1bb9d0.field_0x11c,
            bus_state_8c1bb9d0.field_0x120
        );

        // 8c022fae
        if (result) {
            // 8c022fb4
            bus_state_8c1bb9d0.field_0x34c = *result++;
            bus_state_8c1bb9d0.field_0x350 = *result++;
            bus_state_8c1bb9d0.field_0x354 = *result++;
            bus_state_8c1bb9d0.field_0x358 = *result;
        }

        // TODO...
        // 8c022fcc  mov.w     DAT_8c02306a,r0                            = 02D0h
        // 8c022fce  mov.w     DAT_8c023074,r4                            = 035Ch
        // 8c022fd0  mov.l     @(r0,r14),r3=>DAT_8c1bbca0                 = ??
        // 8c022fd2  mov.w     DAT_8c023072,r0                            = 012Ch
        // 8c022fd4  fmov.s    @(r0,r14),fr6=>DAT_8c1bbafc                = ??
        // 8c022fd6  add       #-0x4,r0
        // 8c022fd8  fmov.s    @(r0,r14),fr5=>DAT_8c1bbaf8                = ??
        // 8c022fda  add       #-0x4,r0
        // 8c022fdc  fmov.s    @(r0,r14),fr4=>DAT_8c1bbaf4                = ??
        // 8c022fde  jsr       @r3
        // 8c022fe0  _add      r14,r4=>DAT_8c1bbd2c                       = ??
        // 8c022fe2  mov       r0,r4
        // 8c022fe4  tst       r4,r4
        // 8c022fe6  bt        LAB_8c023000
        // 8c022fe8  mov.w     DAT_8c023076,r0                            = 0368h
        // 8c022fea  mov.l     @r4+,r3
        // 8c022fec  mov.l     r3,@(r0,r14)=>DAT_8c1bbd38                 = ??
        // 8c022fee  add       #0x4,r0
        // 8c022ff0  mov.l     @r4+,r3
        // 8c022ff2  mov.l     r3,@(r0,r14)=>DAT_8c1bbd3c                 = ??
        // 8c022ff4  add       #0x4,r0
        // 8c022ff6  mov.l     @r4+,r3
        // 8c022ff8  mov.l     r3,@(r0,r14)=>DAT_8c1bbd40                 = ??
        // 8c022ffa  add       #0x4,r0
        // 8c022ffc  mov.l     @r4,r2
        // 8c022ffe  mov.l     r2,@(r0,r14)=>DAT_8c1bbd44                 = ??

    }

    // 8c0230ec 31 d2         mov.l     DAT_8c0231b4,r2                            = 8C1BB8C8h
    // 8c0230ee 22 63         mov.l     @r2=>DAT_8c1bb8c8,r3                       = ??
    // 8c0230f0 38 23         tst       r3,r3
    // 8c0230f2 22 89         bt        LAB_8c02313a
    // TODO: ?
    if (_8c1bb8c8) {
        // 8c0230f2 (...)

        // 8c0230f4  mov.w     DAT_8c0231a2,r0                            = 0250h
        // 8c0230f6  mov.w     DAT_8c0231a4,r7                            = FF4Ah
        // 8c0230f8  mov.l     @(r0,r14),r3=>DAT_8c1bbc20                 = ??
        // 8c0230fa  add       #0x4,r0
        // 8c0230fc  mov.l     @(r0,r14),r4=>DAT_8c1bbc24                 = ??
        // 8c0230fe  add       #0x4,r0
        // 8c023100  mov.l     @(r0,r14),r5=>DAT_8c1bbc28                 = ??
        // 8c023102  sub       r3,r4
        // 8c023104  mov.l     @(r0,r14),r3=>DAT_8c1bbc28                 = ??
        // 8c023106  mov.w     DAT_8c0231a6,r6                            = 00B6h
        // 8c023108  cmp/ge    r4,r3
        // 8c02310a  bt/s      LAB_8c02311a
        // 8c02310c  _sub      r4,r5
        // 8c02310e  cmp/ge    r7,r5
        // 8c023110  bt        LAB_8c023124
        // 8c023112  mov.w     DAT_8c0231a8,r0                            = 0258h
        // 8c023114  mov.l     @(r0,r14),r4=>DAT_8c1bbc28                 = ??
        // 8c023116  bra       LAB_8c023124
        // 8c023118  _add      r6,r4
        // ...
    }

    //  8c023140  mov       r13,r5
    //  8c023144  mov       r9,r4
    //  8c023148  fmov      fr14,fr4

    // 8c02313c  mov       #0x70,r0
    // 8c02313e  mov.l     @(r0,r14),r2=>DAT_8c1bba40                 = ??

    //  8c02313a  mov.w     DAT_8c0231ae,r1                            = 027Ch
    // 8c023142  add       r14,r1
    // 8c023146  fmov.s    @r1=>DAT_8c1bbc4c,fr3                      = ??
    // 8c02314a  fmul      fr13,fr3
    // 8c02314c  ftrc      fr3,FPUL
    // 8c02314e  sts       FPUL,r3
    int speed_int = (int) bus_state_8c1bb9d0.speed_0x27c * 65536.0;

    // 8c023150  sub       r3,r2
    // 8c023152  mov.l     r2,@(r0,r14)=>DAT_8c1bba40                 = ??
    bus_state_8c1bb9d0.distance_traveled_0x070 -= speed_int;

    // 8c023154  mov.w     DAT_8c0231a8,r0                            = 0258h
    // 8c023156  mov.l     @(r0,r14),r3=>DAT_8c1bbc28                 = ??
    // 8c023158  mov       #0x74,r0
    // 8c02315a  mov.l     r3,@(r0,r14)=>DAT_8c1bba44                 = ??
    bus_state_8c1bb9d0.ang_0x074 = bus_state_8c1bb9d0.ang_0x258;

    // 8c02315c  bra       LAB_8c023170
    // 8c02315e  _mov      #0x10,r12

    // Shift acceleration history
    // TODO

    int r5 = 0;
    int uVar2 = 4;
    float maybefr4 = 0.5;

    while (uVar2 < 0x10) {
        // 8c023160  mov.w     DAT_8c0231b0,r6                            = 0280h
        // 8c023162  add       r14,r6
        // 8c023164  mov       r6,r0
        // 8c023166  fmov.s    @(r0,r4),fr5=>DAT_8c1bbc54                 = ??
        float temp = bus_state_8c1bb9d0.acc_hist_0x280[uVar2];

        // 8c023168  add       #0x4,r4
        uVar2++;

        // 8c02316a  fadd      fr5,fr4
        maybefr4 += temp;

        // 8c02316c  fmov      fr5,@(r0,r5)=>DAT_8c1bbc50                 = ??
        bus_state_8c1bb9d0.acc_hist_0x280[r5] = temp;

        // 8c02316e  add       #0x4,r5
        r5++;
    }

    //  8c023176  mov       #-0x5b,r5

    // 8c023174  mov.w     WORD_8c0231ae,r0                           = 27Ch
    // 8c023178  fmov.s    @(r0,r14),fr5=>DAT_8c1bbc4c                = ??
    float speed_fr5 = bus_state_8c1bb9d0.speed_0x27c;

    // 8c02317c  fsub      fr15,fr5
    speed_fr5 -= speed_fr15;

    // 8c02317e  fadd      fr5,fr4
    maybefr4 += speed_fr5;

    //  8c02317a  add       #0x10,r0
    // 8c023180  fmov      fr5,@(r0,r14)=>DAT_8c1bbc5c                = ??
    bus_state_8c1bb9d0.acc_hist_0x280[3] = speed_fr5;

    // 8c023186  fmov      fr4,fr2
    float new_acc_float = maybefr4;

    //  8c023182  mova      FLOAT_8c0231b8,r0                          = 1024.0
    //  8c023184  fmov.s    @r0=>FLOAT_8c0231b8,fr3                    = 1024.0
    // 8c023188  fmul      fr3,fr2
    new_acc_float *= 1024.f;

    // 8c02318a  ftrc      fr2,FPUL
    // 8c02318c  sts       FPUL,r4
    int new_acc_int = (int) new_acc_float;

    // Clamp new acc
    // 8c02318e  cmp/ge    r5,r4
    // 8c023190  bt        LAB_8c0231bc
    // 8c023192  bra       LAB_8c0231c4
    // 8c023194  _mov      r5,r4
    if (new_acc_int < -91) {
        new_acc_int = -91;
    } else if (new_acc_int >= 91) {
        new_acc_int = 91;
    }

    // 8c0231c4  mov       #0x78,r0
    // 8c0231c8  mov.l     r4,@(r0,r14)=>DAT_8c1bba48                 = ??
    bus_state_8c1bb9d0.acc_0x078 = new_acc_int;

    // 8c0231ca  mov.w     DAT_8c023282,r0                            = 0258h
    // 8c0231cc  mov.l     @(r0,r14),r3=>DAT_8c1bbc28                 = ??
    //  8c0231d4  lds       r3,FPUL
    //  8c0231d6  float     FPUL,fr3
    int angular_0x258_int = bus_state_8c1bb9d0.ang_0x258;
    float angular_0x258_float = (float) angular_0x258_int;

    // 8c0231ce  add       #0x24,r0
    // 8c0231d0  fmov.s    @(r0,r14),fr2=>DAT_8c1bbc4c                = ??
    float new_angular_0x07c_float = bus_state_8c1bb9d0.speed_0x27c;

    // 8c0231d8  fmul      fr3,fr2
    new_angular_0x07c_float *= angular_0x258_float;

    //  8c0231d2  mova      FLOAT_8c023294,r0                            = 0.2
    // 8c0231da  fmov.s    @r0=>FLOAT_8c023294,fr3                      = 0.2
    // 8c0231dc  fmul      fr3,fr2
    new_angular_0x07c_float *= 0.2;

    // 8c0231de  fneg      fr2
    new_angular_0x07c_float = -new_angular_0x07c_float;

    // 8c0231e0  ftrc      fr2,FPUL
    // 8c0231e2  sts       FPUL,r4
    int new_angular_0x07c_int = (int) new_angular_0x07c_float;

    // Clamp new angular
    //  8c0231c6  mov.w     DAT_8c023284,r5                            = FD28h
    // 8c0231e4  cmp/ge    r5,r4
    // 8c0231e6  bt        LAB_8c0231ec
    // 8c0231e8  bra       LAB_8c0231f4
    // 8c0231ea  _mov      r5,r4
    // 8c0231ec  mov.w     DAT_8c023286,r5                            = 02D8h
    // 8c0231ee  cmp/gt    r5,r4
    // 8c0231f0  bf        LAB_8c0231f4
    // 8c0231f2  mov       r5,r4
    if (new_angular_0x07c_int < -728) {
        new_angular_0x07c_int = -728;
    } else if (new_angular_0x07c_int >= 728) {
        new_angular_0x07c_int = 728;
    }

    // 8c0231f6  mov       #0x7c,r0
    // 8c0231f8  mov.l     r4,@(r0,r14)=>DAT_8c1bba4c                 = ??
    bus_state_8c1bb9d0.ang_0x07c = new_angular_0x07c_int;

    //  8c0231f4  mov.l     PTR_DAT_8c023298,r3                        = 8c18ad20
    // 8c0231fa  mov.l     @r3=>DAT_8c18ad20,r0                       = ??
    // 8c0231fc  cmp/eq    #0x1,r0
    // 8c0231fe  bt        LAB_8c023208
    // 8c023200  cmp/eq    #0x2,r0
    // 8c023202  bt        LAB_8c023212
    // 8c023204  bra       LAB_8c02321a
    // 8c023206  _nop
    // TODO: Blinker ? (Maybe not)
    if (_8c18ad20 == 1) {
        // 8c023208  mov.w     DAT_8c023288,r0                            = 0080h
        // 8c02320a  mov.l     @(r0,r14),r2=>DAT_8c1bba50                 = ??
        // 8c02320c  or        r12,r2
        // 8c02320e  bra       LAB_8c02321a
        // 8c023210  _mov.l    r2,@(r0,r14)=>DAT_8c1bba50                 = ??
        bus_state_8c1bb9d0.blinker_0x080 |= 0x10;
    } else if (_8c18ad20 == 2) {
        // 8c023212  mov.l     ->FUN_8c028022,r2                          = 8c028022
        // 8c023214  mov.l     PTR_DAT_8c02329c,r0                        = 8c1bbd9c
        // 8c023216  jsr       @r2=>FUN_8c028022                          undefined FUN_8c028022(int p
        // 8c023218  _mov.l    @r0=>DAT_8c1bbd9c,r4                       = ??
        // TODO: If skipped, doesn't affect blinker.
        prob_blinker_8c028022(bus_8c1bbd9c);
    }

    // 8c02321a  mov.w     DAT_8c02328a,r0                            = 02F4h
    // 8c02321c  mov.l     @(r0,r14),r0=>DAT_8c1bbcc4                 = ??
    // 8c02321e  cmp/eq    #0x5,r0
    // 8c023220  bf        LAB_8c02323a
    // If not reverse gear
    if (bus_state_8c1bb9d0.gear_0x2f4 != 5) {
        // 8c02323a  mov.w     DAT_8c02328e,r0                            = 025Ch
        // 8c02323c  mov.l     @(r0,r14),r0=>DAT_8c1bbc2c                 = ??
        // 8c02323e  tst       r0,r0
        // 8c023240  bf        LAB_8c023250

        // 8c023242  mov.w     DAT_8c023290,r0                            = 0260h
        // 8c023244  mov.l     ->FUN_8c0518f8,r3                          = 8c0518f8
        // 8c023246  mov.l     r13,@(r0,r14)=>DAT_8c1bbc30                = ??
        // 8c023248  jsr       @r3=>FUN_8c0518f8                          int FUN_8c0518f8(undefined *
        // 8c02324a  _mov.l    @(0x4,r11)=>DAT_8c0fcd2c,r4                = ??
        // 8c02324c  bra       LAB_8c0232b0
        // 8c02324e  _nop

    } else {
        // 8c023222
    }

    // 8c0232b0  mov.l     DAT_8c0232f8,r2                            = 8C1BBD9Ch
    // 8c0232b2  mov.l     ->FUN_8c020594,r3                          = 8c020594
    // 8c0232b4  mov.w     DAT_8c0232f4,r4                            = 0084h
    // 8c0232b6  mov.l     @r2=>DAT_8c1bbd9c,r5                       = ??
    // 8c0232b8  jsr       @r3=>FUN_8c020594                          undefined FUN_8c020594(undef
    // 8c0232ba  _add      r14,r4
    // TODO
    // Update bus model position (doesn't affect steering and collision)
    move_bus_model_8c020594(bus_state_8c1bb9d0.field_0x084, bus_8c1bbd9c);

    // 8c0232bc
    if (replay_gameplay_8c1bb8d0 == 2) {
        // Demo camera
        demoUpdateCamera_8c025906();
    } else {
        // Gameplay
        gameplayRenderBusUpdateCamera_8c025078();
    }

    // 8c0232d4  add       #0x4,r15
    // 8c0232d6  lds.l     @r15+,PR=>local_30
    // 8c0232d8  mov.l     PTR_LAB_8c02330c,r3                        = 8c025604
    // 8c0232da  fmov.s    @r15+=>Stack[-0x2c],fr12
    // 8c0232dc  fmov.s    @r15+=>local_28,fr13
    // 8c0232de  fmov.s    @r15+=>local_28+0x4,fr14
    // 8c0232e0  fmov.s    @r15+=>local_20,fr15
    // 8c0232e2  mov.l     @r15+=>local_20+0x4,r8
    // 8c0232e4  mov.l     @r15+=>local_18,r9
    // 8c0232e6  mov.l     @r15+=>local_14,r10
    // 8c0232e8  mov.l     @r15+=>local_10,r11
    // 8c0232ea  mov.l     @r15+=>local_c,r12
    // 8c0232ec  mov.l     @r15+=>local_c[4],r13
    // 8c0232ee  jmp       @r3=>LAB_8c025604
    // 8c0232f0  _mov.l    @r15+=>local_c[8],r14
    // If skipped: no bus reflex on mirrors
    return _8c025604();
}
