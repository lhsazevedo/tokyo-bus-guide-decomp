#include <shinobi.h>
#include <njdef.h>


#include "includes.h"
#include "_019100_8c014a9c_tasks.h"

#define TEX_BUFSIZE     0x20800
#define TEX_NUM         3072
#define CACHE_BUFSIZE   0x20000
#define SHAPE_BUFSIZE   512
#define RENDER_X        256
#define RENDER_Y        512

struct loadedNj {
    void *field_0x00;
    int *field_0x04;
}
typedef loadedNj;

extern NJS_MATRIX     var_matrix_8c2f8ca0[16];
extern NJS_VERTEX_BUF var_vbuf_8c255ca0[4096];
extern Sint8          var_texbuf_8c277ca0[TEX_BUFSIZE];
extern NJS_TEXMEMLIST var_tex_8c157af8[TEX_NUM];
extern Sint8          var_cachebuf_8c235ca0[CACHE_BUFSIZE];
extern Float          var_shapebuf_8c2f84a0[SHAPE_BUFSIZE];
extern Sint8          var_8c226070;
extern NJS_TEXNAME    var_texname_8c18acf8[1];
extern NJS_TEXLIST    init_texlist_8c03bf44;

extern Task var_tasks_8c1ba3c8[];
extern Task var_tasks_8c1ba5e8[];
extern Task var_tasks_8c1ba808[];
extern Task var_tasks_8c1bac28[];
extern Task var_tasks_8c1bb448[];

extern void* var_8c1bb86c;
extern void* var_8c1bc3ec;
extern void* var_8c1bc3f0;
extern void* var_8c1bc3f4;
extern void* var_8c1bc404;
extern void* var_8c226434;
extern void* var_8c226438;
extern void* var_8c228234;
extern void* var_8c227e20;
extern void* var_8c227e24;
extern void* var_8c2288f8;
extern void* var_8c1bc438;
extern void* var_8c1bc7a8;
extern void* var_8c1bc7b4;
extern void* var_8c2263a8;
extern void* var_8c1ba2e0;
extern void* var_8c1ba348;
extern void* var_8c1ba344;
extern void* var_8c225fb0;
extern void* var_8c1ba3c4;
extern void* var_8c1bc454;
extern void* var_8c1ba34c;

extern void* var_8c1bbddc;
extern void* var_8c1bbfdc;

extern int var_8c1bb8c4;
extern int var_8c1bb8d8;
extern int var_8c157a6c;

extern void* var_mark_parts_var_8c1bc41c;
extern void* var_mark_var_8c1bc420;
extern void* var_busstop_parts_var_8c1bc428;
extern void* var_busstop_var_8c1bc42c;
extern void* var_8c1bc3f8;
extern void* var_8c1bc3fc;
extern void* var_8c1bc400;
extern void* var_8c1ba1c8;
extern void* var_8c2260ac;
extern void* var_8c2260b8;
extern void* var_8c2260c4;
extern void* var_8c1bc440;
extern void* var_8c1bc444;
extern NJS_MOTION* var_loadedFooNjm_8c1bc448;
extern void* var_8c1bc410;
extern void* var_8c1bc414;

extern int var_8c157a78;
extern int var_8c157a7c;
extern Uint32 var_vibport_8c1ba354;
extern int init_8c03bd80;
extern int init_8c03bd84;

extern _task_8c013388;
extern nop_8c011120;
extern setUknPvmBool_8c014330;
extern int var_8c18ad14;

extern NJS_FOG_TABLE var_fogTable_8c18aaf8;

extern int var_8c1bc824[3];
extern char init_8c0460b0[];

extern float _var_8c1bc450;
extern int var_8c2260a8;
extern var_8c1ba3c8;
extern var_8c1bb8d0;
extern task_8c012cbc;
extern task_8c01677e;
extern var_8c1bb8d4;
extern task_8c012d06;
extern task_8c012d5a;
extern task_8c016bf4;
extern var_8c1bb8cc;
extern var_8c22847c;
extern var_8c1bb868;
extern var_8c228704;
extern var_8c1bb8c8;
extern var_8c157a64;
extern var_8c227dd4;
extern var_8c227da0;
extern var_8c1ba292;
extern var_8c227da8;
extern task_load_8c014338;
extern memblkSource_8c0fcd48;
extern memblkSource_8c0fcd4c;
extern var_8c157a60;
extern init_8c03bfa8;

extern var_8c18ad1c;
extern var_8c228708;
extern Bool var_8c22655c;


struct uknStruct {
    int field_0x00;
    int field_0x04;
    int field_0x08;
}
typedef uknStruct;

struct s_8c18ad28 {
    int field_0x00;
    int field_0x04;
    Uint8 field_0x08;
    Uint8 field_0x09;
    Uint8 field_0x0a;
    Uint8 field_0x0b;
    float fogN_0x0c;
    float fogF_0x10;
}
typedef s_8c18ad28;
extern s_8c18ad28 *var_8c18ad28;

/* Matched :) */
void task_8c012f44()
{
    if ((var_8c157a78 != 0) && (var_8c157a7c == 0)) {
        FUN_8c010ca6(0);
        sdMidiStopAll();
        if (var_vibport_8c1ba354 != -1) {
        pdVibMxStop(var_vibport_8c1ba354);
        }
        FUN_8c016182();
        if (var_8c1bb8c4 != 0) {
            init_8c03bd80 = 1;
            init_8c03bd84 = 0;
        } else {
            FUN_8c015fd6(1);
        }
    }
}

/* Matched :) */
void task_8c012f9c(Task *task, void* state) {
    Bool r7;
    Float speed_fr2;

    if (var_8c1bb8d0 != 1 && var_8c18ad1c == 2 && var_8c228708 == 0) {
        r7 = TRUE;
    } else {
        r7 = FALSE;
    }

    if (var_busState_8c1bb9d0.speed_0x27c == 0) {
        switch (task->field_0x08) {
            case 0:
                if (var_busState_8c1bb9d0.bus_substate_0x3c0 == 0) {
                    var_8c22655c = 0;
                    if (r7 == FALSE) {
                        var_busState_8c1bb9d0.mirror_0x268 = 2;
                    } else {
                        var_busState_8c1bb9d0.mirror_0x268 = 0;
                    }

                    /* 8c012ff6 */
                    task->field_0x08 = 1;
                } else {
                    if (var_busState_8c1bb9d0.mirror_0x268 != 3) {
                        var_8c22655c = 0;
                        freeTask_8c014b66(task);
                    }
                }
                break;

            case 1:
            default:
                // Nothing...
                break;
        }
    } else {
        var_8c22655c = 0;
        if (r7 == FALSE) {
            var_busState_8c1bb9d0.field_0x25c = 0;
        }

        var_busState_8c1bb9d0.mirror_0x268 = 0;

        freeTask_8c014b66(task);
    }

    njControl3D(0);
}

void FUN_8c01306e(void)
{
    Task *created_task;
    void* created_state;

    njInitMatrix(var_matrix_8c2f8ca0, 16, 0);
    njSetBackColor(0,0,0);
    njSetFogColor(ARGB(
        var_8c18ad28->field_0x0b,
        var_8c18ad28->field_0x0a,
        var_8c18ad28->field_0x09,
        var_8c18ad28->field_0x08
    ));

    njGenerateFogTable3(var_fogTable_8c18aaf8, var_8c18ad28->fogN_0x0c, var_8c18ad28->fogF_0x10);
    njFogEnable();
    kmSetCheapShadowMode(0x80);
    kmSetFogTable(var_fogTable_8c18aaf8);

    clearTasks_8c014a9c(var_tasks_8c1ba5e8, 0x10);
    clearTasks_8c014a9c(var_tasks_8c1ba808, 0x20);
    clearTasks_8c014a9c(var_tasks_8c1bac28, 0x40);
    clearTasks_8c014a9c(var_tasks_8c1bb448, 0x20);

    njRandomSeed(var_8c157a64);
    FUN_8c012160(var_8c157a64);
    FUN_8c0121a2(var_8c157a64);

    FUN_8c0128cc(1);

    if (var_8c1bb8d0 != 2) {
        pushTask_8c014ae8(var_tasks_8c1ba3c8, &task_8c012cbc, &created_task, &created_state, 0);
        pushTask_8c014ae8(var_tasks_8c1ba5e8, &task_8c01677e, &created_task, &created_state, 0);
    } else {
        if (var_8c1bb8d4 == 0) {
            pushTask_8c014ae8(var_tasks_8c1ba3c8, &task_8c012d06, &created_task, &created_state, 0);
        } else {
            pushTask_8c014ae8(var_tasks_8c1ba3c8, &task_8c012d5a, &created_task, &created_state, 0);
            created_task->field_0x08 = 0;
            created_task->field_0x0c = (void*) 0;
        }
        pushTask_8c014ae8(var_tasks_8c1ba5e8, &task_8c016bf4, &created_task, &created_state, 0);
        FUN_8c025af4();
    }

    var_8c1bb8cc = 0;
    var_8c22847c = 0;

    FUN_8c023610();
    FUN_8c02845a();

    if (var_8c1bb8d0 != 2) {
        FUN_8c029920();
    }

    FUN_8c0296d6();
    FUN_8c02769e();
    FUN_8c0222dc();
    FUN_8c02a6ac();
    FUN_8c02c46a();
    FUN_8c02018c();
    FUN_8c02d968();
    FUN_8c020528();
    pushTask_8c014ae8(var_tasks_8c1ba5e8, &task_8c012f9c, &created_task, &created_state, 0);
    created_task->field_0x08 = 0;
    FUN_8c0228a2();
}

void FUN_8c01328c() {
    Task *created_task;
    void* created_state;
  
    if (var_8c1bb8d0 == 0) {
        var_8c1bb868 = var_8c1bc824[0];
        var_8c228704 = var_8c1bc824[1];
        var_8c1bb8c8 = var_8c1bc824[2];
        var_8c157a64 = FUN_8c012166();
    } else if ((var_8c1bb8d0 == 2) && (var_8c1bb8d4 != 0)) {
        var_8c227dd4 = init_8c0460b0[var_8c1bb868 - 0x26];
        FUN_8c01895e();
    } else {
        var_8c227dd4 = 0;
    }

    njRandomSeed(var_8c157a64);
    FUN_8c012160(var_8c157a64);
    FUN_8c0121a2(var_8c157a64);
    FUN_8c0121e8();
    var_8c227da0 = var_8c1ba292;
    var_8c227da8 = 0;
    njSetBackColor(ARGB(255, 65, 141, 255), ARGB(255, 65, 141, 255), ARGB(255, 65, 141, 255));
    var_8c157a6c = 1;

    pushTask_8c014ae8(var_tasks_8c1ba3c8, &task_load_8c014338, &created_task, created_state, 0);
    created_task->field_0x08 = 0;
    created_task->field_0x0c = (void*) 0;

    njGarbageTexture(var_tex_8c157af8, TEX_NUM);
    FUN_8c011f36(0x20,0x800,0x800,0x40);
    return;
}

void task_8c013388(Task *task, void *state) {
    if (task->field_0x08 == 0) {
        Bool b = getUknPvmBool_8c01432a();
        if (b) {
            float fr3;
            task->field_0x08++;
            fr3 = var_loadedFooNjm_8c1bc448->nbFrame;

            if (var_loadedFooNjm_8c1bc448->nbFrame < 0) {
                fr3 += 4294967296.f;
            }

            fr3 -= -1;
            _var_8c1bc450 = fr3;

            FUN_8c011f6c();
            request_dat_8c011182("\\SOUND","manatee.drv", &memblkSource_8c0fcd48);
            request_dat_8c011182("\\SOUND","bus.mlt", &memblkSource_8c0fcd4c);
            resetUknPvmBool_8c014322();
            FUN_8c011fe0(&nop_8c011120, 0, 0, 0, &setUknPvmBool_8c014330);
        }
    } else if ((task->field_0x08 == 1) && (getUknPvmBool_8c01432a() != 0)) {
        FUN_8c011f7e();
        freeTask_8c014b66(task);
        FUN_8c010e18();
        var_8c2260a8 = 1;
        FUN_8c015fd6(0);
    }
}

void usrGdErrFunc_8c0134d6(void *obj, Sint32 errcode) {
  if (errcode == GDD_ERR_TRAYOPEND || errcode == GDD_ERR_UNITATTENT) {
    var_8c18ad14 = 1;
  }
}

void njUserInit_8c0134ec() {
    NJS_TEXINFO info;
    Task *created_task;
    void* created_state;
    uknStruct *r2;

    /* 8c0134fc */
    njSetTextureMemorySize(0x100000);

    if (syCblCheckCable() == SYE_CBL_CABLE_VGA) {
        sbInitSystem(NJD_RESOLUTION_VGA, NJD_FRAMEBUFFER_MODE_RGB565, 2);
    } else {
        sbInitSystem(NJD_RESOLUTION_640x480_NTSCNI, NJD_FRAMEBUFFER_MODE_RGB565, 2);
        njSetAspect(1, 0.91);
    }

    njInitMatrix(var_matrix_8c2f8ca0, 16, 0);
    njInit3D(var_vbuf_8c255ca0, 4096);
    njInitVertexBuffer(800000, 320000, 320000, 320000, 20000);
    njInitTextureBuffer(var_texbuf_8c277ca0, TEX_BUFSIZE);
    njInitTexture(var_tex_8c157af8, TEX_NUM);
    njInitCacheTextureBuffer(var_cachebuf_8c235ca0, CACHE_BUFSIZE);
    njInitShape(var_shapebuf_8c2f84a0);
    syRtcInit();

    var_8c226070 = FUN_8c010924();
    if (var_8c226070 >= 0) {
        _setSoundMode_8c0108c0(var_8c226070);
    } else {
        _setSoundMode_8c0108c0(0);
    }

    FUN_8c010fbe();
    BupInit_8c014b8c();

    njSetTextureInfo(&info, (Uint16 *) var_vbuf_8c255ca0, NJD_TEXFMT_STRIDE | NJD_TEXFMT_RGB_565, RENDER_X, RENDER_Y);

    njSetTextureName(&var_texname_8c18acf8[0], &info, 999, NJD_TEXATTR_TYPE_MEMORY|NJD_TEXATTR_GLOBALINDEX);
    njSetRenderWidth(256);
    njLoadTexture(&init_texlist_8c03bf44);

    clearTasks_8c014a9c(var_tasks_8c1ba3c8, 0x10);
    clearTasks_8c014a9c(var_tasks_8c1ba5e8, 0x10);
    clearTasks_8c014a9c(var_tasks_8c1ba808, 0x20);
    clearTasks_8c014a9c(var_tasks_8c1bac28, 0x40);
    clearTasks_8c014a9c(var_tasks_8c1bb448, 0x20);

    var_8c1bb86c = (void *) -1;

    FUN_8c013bbc(&var_8c1bbddc, 0x20);
    FUN_8c013bbc(&var_8c1bbfdc, 0x41);

    var_8c1bc3ec = (void *) -1;
    var_8c1bc3f0 = (void *) -1;
    var_8c1bc3f4 = (void *) -1;

    FUN_8c02171c();
    FUN_8c029acc();
    FUN_8c02aa28();

    var_8c1bc404 = (void *) -1;
    var_8c226434 = (void *) -1;
    var_8c226438 = (void *) -1;
    var_8c228234 = (void *) -1;
    var_8c227e20 = (void *) -1;
    var_8c227e24 = (void *) -1;
    var_8c2288f8 = (void *) -1;
    var_8c1bc438 = (void *) -1;
    var_8c1bc7a8 = (void *) -1;
    var_8c1bc7b4 = (void *) -1;
    var_8c2263a8 = (void *) -1;
    var_8c1ba2e0 = (void *) -1;
    var_8c1ba348 = (void *) -1;
    var_8c1ba344 = (void *) -1;
    var_8c225fb0 = (void *) -1;
    var_8c1ba3c4 = (void *) -1;
    var_8c1bc454 = (void *) -1;
    var_8c1ba34c = (void *) -1;

    var_8c1bb8c4 = 0;
    var_8c1bb8d8 = 100;
    var_8c157a6c = 0;

    FUN_8c01c8dc();
    FUN_8c0189d2();
    njSetBorderColor(0);
    FUN_8c01c8fc(3);
    FUN_8c01c910();

    pushTask_8c014ae8(var_tasks_8c1ba3c8, &_task_8c013388, &created_task, &created_state, 0);

    r2 = (uknStruct *) created_task->field_0x08;
    r2->field_0x08 = 0;

    FUN_8c011f36(0x10, 8, 0, 8);
    FUN_8c011f6c();

    request_dat_8c011182("\\SYSTEM", "mark_parts.dat", var_mark_parts_var_8c1bc41c);
    request_dat_8c011182("\\SYSTEM", "mark.dat", var_mark_var_8c1bc420);
    request_dat_8c011182("\\SYSTEM", "busstop_parts.dat", var_busstop_parts_var_8c1bc428);
    request_dat_8c011182("\\SYSTEM", "busstop.dat", var_busstop_var_8c1bc42c);

    request_pvm("\\SYSTEM", "loading.pvm", var_8c1bc3f8, 1, 0x80000000);

    request_dat_8c011182("\\SYSTEM", "load_parts.dat", var_8c1bc3fc);
    request_dat_8c011182("\\SYSTEM", "loading.dat", var_8c1bc400);
    request_dat_8c011182("\\SYSTEM", "bus_font.fff", var_8c1ba1c8);
    request_dat_8c011182("\\SYSTEM", "vm_bus.lcd", var_8c2260ac);
    request_dat_8c011182("\\SYSTEM", "vm_danger.lcd", var_8c2260b8);
    request_dat_8c011182("\\SYSTEM", "now_loading.lcd", var_8c2260c4);

    request_pvm("\\SYSTEM", "fuu.pvm", var_8c1bc440, 1, 0);

    request_nj_8c011492("\\SYSTEM", "fuu.njd", var_8c1bc444, 0);
    request_nj_8c011492("\\SYSTEM", "fuu.njm", var_loadedFooNjm_8c1bc448, 0);
    request_nj_8c011492("\\SD_COMMON","3s_bus_m2.njm", var_8c1bc410, 0);
    request_nj_8c011492("\\SD_COMMON","3s_bus_m2.njs", var_8c1bc414, 0);

    resetUknPvmBool_8c014322();
    FUN_8c011fe0(&nop_8c011120, 0, 0, 0, &setUknPvmBool_8c014330);
    var_8c18ad14 = 0;
    gdFsEntryErrFuncAll(&usrGdErrFunc_8c0134d6, (void *) 0);
}

int njUserMain_8c01392e(void) {
    GDFS gdfs;
    Sint32 stat;

    if (init_8c03bd80 != 0) {
        /* 8c01393e */
        /* Hit on title screen, after fadein */
        if (init_8c03bd84 == 0) {
            if (var_vibport_8c1ba354 != -1) {
                pdVibMxStop(var_vibport_8c1ba354);
            }

            /* 8c0139be (shared) */
            return -1;
        }

        execTasks_8c014b42(var_tasks_8c1ba3c8);
        return 0;
    }

    /* 8c013956 */
    /* Hit just before logo/menu */
    if (var_8c157a60 == 0) {
        /* 8c01395e */
        if (init_8c03bfa8 == 0) {
            /* 8c013966 */
            if (!gdFsReqDrvStat()) {
                init_8c03bfa8 = 1;
            }
        } else {
            gdfs = gdFsGetSysHn();
            stat = gdFsGetStat(gdfs);
            if (stat != GDD_STAT_BUSY) {
                init_8c03bfa8 = 0;
            }
        }
    }

    /* 8c01398a */
    stat = gdFsGetDrvStat();
    if (stat == GDD_DRVSTAT_OPEN) {
        /* 8c0139b2 */
        if (var_vibport_8c1ba354 != -1) {
            pdVibMxStop(var_vibport_8c1ba354);
        }

        return -1;
    }

    /* 8c013994 */
    stat = gdFsGetDrvStat();
    if ((stat == GDD_DRVSTAT_OPEN) || (stat == GDD_DRVSTAT_BUSY)) {
        /* 8c0139a4 */
        gdFsReqDrvStat();
    }

    /* 8c0139aa */
    if (var_8c18ad14 != 0) {
        /* 8c0139b2 */
        if (var_vibport_8c1ba354 != -1) {
            pdVibMxStop(var_vibport_8c1ba354);
        }

        return -1;
    };

    execTasks_8c014b42(var_tasks_8c1ba3c8);
    return 0;
}

void njUserExit_8c0139d4(void) {
  njExitTexture();
  sbExitSystem();
  syBtExit();
}
