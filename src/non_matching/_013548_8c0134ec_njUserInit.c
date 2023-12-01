#include <shinobi.h>
#include "_019100_8c014a9c_tasks.h"

#define TEX_BUFSIZE     0x20800
#define TEX_NUM         3072
#define CACHE_BUFSIZE   0x20000
#define SHAPE_BUFSIZE   512
#define RENDER_X        256
#define RENDER_Y        512

extern NJS_MATRIX     var_matrix_8c2f8ca0[16];
extern NJS_VERTEX_BUF var_vbuf_8c255ca0[4096];
extern Sint8          var_texbuf_8c277ca0[TEX_BUFSIZE];
extern NJS_TEXMEMLIST var_tex_8c157af8[TEX_NUM];
extern Sint8          var_cachebuf_8c235ca0[CACHE_BUFSIZE];
extern Float          var_shapebuf_8c2f84a0[SHAPE_BUFSIZE];
extern Sint8          var_8c226070;
extern NJS_TEXNAME    var_texname_8c18acf8[1];
extern NJS_TEXLIST    init_texlist_8c03bf44;

extern Task* var_tasks_8c1ba3c8;
extern Task* var_tasks_8c1ba5e8;
extern Task* var_tasks_8c1ba808;
extern Task* var_tasks_8c1bac28;
extern Task* var_tasks_8c1bb448;

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

extern void* var_mark_parts_dat_8c1bc41c;
extern void* var_mark_dat_8c1bc420;
extern void* var_busstop_parts_dat_8c1bc428;
extern void* var_busstop_dat_8c1bc42c;
extern void* var_8c1bc3f8;
extern void* var_8c1bc3fc;
extern void* var_8c1bc400;
extern void* var_8c1ba1c8;
extern void* var_8c2260ac;
extern void* var_8c2260b8;
extern void* var_8c2260c4;
extern void* var_8c1bc440;
extern void* var_8c1bc444;
extern void* var_8c1bc448;
extern void* var_8c1bc410;
extern void* var_8c1bc414;

extern _task_8c013388;
extern nop_8c011120;
extern setUknPvmBool_8c014330;
extern var_8c18ad14;
extern FUN_8c0134d6;

struct uknStruct {
    int field_0x00;
    int field_0x04;
    int field_0x08;
}
typedef uknStruct;

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
        _njSetAspect(1, 0.91);
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

    clearTasks_8c014a9c(&var_tasks_8c1ba3c8, 0x10);
    clearTasks_8c014a9c(&var_tasks_8c1ba5e8, 0x10);
    clearTasks_8c014a9c(&var_tasks_8c1ba808, 0x20);
    clearTasks_8c014a9c(&var_tasks_8c1bac28, 0x40);
    clearTasks_8c014a9c(&var_tasks_8c1bb448, 0x20);

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

    request_dat_8c011182("\\SYSTEM", "mark_parts.dat", var_mark_parts_dat_8c1bc41c);
    request_dat_8c011182("\\SYSTEM", "mark.dat", var_mark_dat_8c1bc420);
    request_dat_8c011182("\\SYSTEM", "busstop_parts.dat", var_busstop_parts_dat_8c1bc428);
    request_dat_8c011182("\\SYSTEM", "busstop.dat", var_busstop_dat_8c1bc42c);

    request_pvm("\\SYSTEM", "loading.pvm", var_8c1bc3f8, 1, 0x80000000);

    request_dat_8c011182("\\SYSTEM", "load_parts.dat", var_8c1bc3fc);
    request_dat_8c011182("\\SYSTEM", "loading.dat", var_8c1bc400);
    request_dat_8c011182("\\SYSTEM", "bus_font.fff", var_8c1ba1c8);
    request_dat_8c011182("\\SYSTEM", "vm_bus.lcd", var_8c2260ac);
    request_dat_8c011182("\\SYSTEM", "vm_danger.lcd", var_8c2260b8);
    request_dat_8c011182("\\SYSTEM", "now_loading.lcd", var_8c2260c4);

    request_pvm("\\SYSTEM", "fuu.pvm", var_8c1bc440, 1, 0);

    request_nj_8c011492("\\SYSTEM", "fuu.njd", var_8c1bc444, 0);
    request_nj_8c011492("\\SYSTEM", "fuu.njm", var_8c1bc448, 0);
    request_nj_8c011492("\\SD_COMMON","3s_bus_m2.njm", var_8c1bc410, 0);
    request_nj_8c011492("\\SD_COMMON","3s_bus_m2.njs", var_8c1bc414, 0);

    resetUknPvmBool_8c014322();
    FUN_8c011fe0(&nop_8c011120, 0, 0, 0, &setUknPvmBool_8c014330);
    var_8c18ad14 = 0;
    gdFsEntryErrFuncAll(&FUN_8c0134d6, (void *) 0);
}
