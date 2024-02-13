#include <shinobi.h>
#include <sg_sd.h>
#include <cri_adxt.h>
#include <cri_adxf.h>
#include <string.h>

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

/* === Structs === */
struct s_8c226468 {
    float var0;
}
typedef s_8c226468;

struct AdxfPartitionInfo {
    char* fname_0x00;
    int nfile_0x04;
}
typedef AdxfPartitionInfo;

struct s_8c03bd88 {
    int field_0x00;
    int field_0x04;
}
typedef s_8c03bd88;

struct s_8c157a34 {
    int flags_0x00;
    int field_0x04;
    int field_0x08;
    int field_0x0c;
    int field_0x10;
}
typedef s_8c157a34;

/* === External vars === */
extern Uint32 _8c1bbcb0;
extern s_8c226468 _8c226468;

/* === Uninitialized vars === */
ADXT adxtHandles_8c0fcd20[2];
SDMIDI midiHandles_8c0fcd28[8];
void* memblkSource_8c0fcd48;
void* memblkSource_8c0fcd4c;
s_8c0fcd50 _8c0fcd50;

#define WKSIZE 184516
// #define	MAX_NFILES (256)
#define	MAX_NFILES (1424)
char work_8c0fcd74[WKSIZE * 2];
char adxf_work_8c156efc[ADXF_CALC_PTINFO_SIZE(MAX_NFILES)];

s_8c157a34 _8c157a34;

/* === Initialized vars === */
int init_8c03bd80 = 0;
int init_8c03bd80 = 1;
s_8c03bd88 _8c03bd88 = {
    990,
    990
};
int _8c03bd90 = 127;
AdxfPartitionInfo adxfPartitionInfo_8c03bd94[] = {
    { "bgm.afs", 0x50 },
    { "voice.afs", 0x52e },
    { "", 0 },
};

/* === Prototypes === */
void midiResetFxAndPlay_8c010846(int hld_idx, int data_num);
void FUN_8c0109c0();
void FUN_8c010ca6(Bool p1);
int snd_8c010cd6(int p1, int p2);


void FUN_sound_8c0100bc() {
    _8c0fcd50.field_0x18 = (float) _8c03bd90 / 2600;
    _8c0fcd50.field_0x1c = _8c0fcd50.field_0x18 * 2600 / 3000;
    _8c0fcd50.field_0x14 = _8c03bd90 * 30 / 100;
    _8c0fcd50.field_0x08 = _8c03bd90 * 40 / 100;
    _8c0fcd50.field_0x0c = _8c0fcd50.field_0x18 * 3000;
    _8c0fcd50.field_0x20 = (float) _8c03bd90 / 3900;
}

void midiSetVol_8c010128() {
    int r13_8c226468_as_int = _8c226468.var0;

    if ((_8c0fcd50.field_0x00 & 2) == 2) {
        if (r13_8c226468_as_int >= 10.f && r13_8c226468_as_int < 3000.f) {
            sdMidiSetVol(
                midiHandles_8c0fcd28[7],
                _8c0fcd50.field_0x08 + (r13_8c226468_as_int - 10.f) * _8c0fcd50.field_0x18 - 127,
                0
            );
        /* 8c010192 */
        } else if (r13_8c226468_as_int >= 3000.f) {
            /* 8c01019a */
            sdMidiSetVol(
                midiHandles_8c0fcd28[7],
                _8c0fcd50.field_0x0c - (r13_8c226468_as_int - 3000) * _8c0fcd50.field_0x1c - 127,
                0
            );
        }
    }

    /* LAB_8c0101bc */
    if ((_8c0fcd50.field_0x00 & 4) == 4) {
        sdMidiSetVol(
            midiHandles_8c0fcd28[6],
            (r13_8c226468_as_int - 1000.f) * _8c0fcd50.field_0x20 - 127,
           0
        );

        if (r13_8c226468_as_int < 2100) {
            /* 8c0101e2 */
            _8c0fcd50.field_0x00 &= -5;

            sdMidiSetVol(
                midiHandles_8c0fcd28[6],
                -127,
                0
            );
        }
    }
}

/* Matched */
void midiSetPitch_8c01023c()
{
    int _8c226468_as_int = _8c226468.var0;

    if (_8c226468_as_int > 10.f && _8c226468_as_int < 3000.f) {
        sdMidiSetPitch(
            midiHandles_8c0fcd28[6],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
        sdMidiSetPitch(
            midiHandles_8c0fcd28[7],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
    } else if (_8c226468_as_int >= 3000.f && _8c226468_as_int < 4000.f) {
        sdMidiSetPitch(
            midiHandles_8c0fcd28[6],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
        sdMidiSetPitch(
            midiHandles_8c0fcd28[7],
            (_8c226468_as_int - 10.f) * 0.05,
            0
        );
    }
}

void FUN_8c0102d8()
{
    /*
     * r5 = _8c1bbcb0
     * r12 = __midi_handle_8c010348[6]
     * r14 = _8c0fcd50
     * r4 = _8c0fcd50 & 1
     */

    int bcb0 = _8c1bbcb0;
    int _8c226468_as_int = _8c226468.var0;
    // int _8c0fcd50_field_0x00_temp = _8c0fcd50.field_0x00 & 1;

    if ((_8c0fcd50.field_0x00 & 1) != 1 && bcb0 == 1) {
            /* 8c010312 */
            sdMidiSetPitch(midiHandles_8c0fcd28[6], -200, 0);
            sdMidiSetVol(midiHandles_8c0fcd28[6], _8c0fcd50.field_0x14 - 127, 0);
            sdMidiPlay(midiHandles_8c0fcd28[6], 1, 43, 0);

            _8c0fcd50.field_0x00 = 0;
            _8c0fcd50.field_0x00 |= 1;
        // }
    } else {
        if ((_8c0fcd50.field_0x00 & 1) == 1 && bcb0 != 1) {
            /* 8c010378 */
            sdMidiSetVol(midiHandles_8c0fcd28[6], -127, 2000);
            _8c0fcd50.field_0x00 &= (char) 0xfe;
        }
    }

    // _8c0fcd50_field_0x00_temp = _8c0fcd50.field_0x00 & 2;
    /* 8c010388 */
    if ((_8c0fcd50.field_0x00 & 2) != 2 && _8c226468_as_int >= 400.f) {
        sdMidiSetPitch(midiHandles_8c0fcd28[7], 0, 0);
        sdMidiSetVol(midiHandles_8c0fcd28[7], -127, 0);
        sdMidiPlay(midiHandles_8c0fcd28[7], 1, 44, 0);

        _8c0fcd50.field_0x00 |= 2;
    } else {
        if ((_8c0fcd50.field_0x00 & 2) == 2 && _8c226468_as_int < 400.f) {
            _8c0fcd50.field_0x00 &= (char) 0xfd;
        }
    }

    // _8c0fcd50_field_0x00_temp = _8c0fcd50.field_0x00 & 4;
    /* 8c0103de */
    if ((_8c0fcd50.field_0x00 & 4) != 4 && _8c226468_as_int >= 2100.f) {
        sdMidiSetPitch(midiHandles_8c0fcd28[6], 0, 0);
        sdMidiSetVol(midiHandles_8c0fcd28[6], -127, 0);
        sdMidiPlay(midiHandles_8c0fcd28[6], 1, 45, 0);

        _8c0fcd50.field_0x00 |= 4;
    }
}

/* Matched */
void createAdxHandles_8c010428()
{
    Sint8 i;
    for (i = 0; i < 2; i++)
    {
        adxtHandles_8c0fcd20[i] = ADXT_Create(2, &work_8c0fcd74[i * WKSIZE], WKSIZE);
    }
}

/* Matched */
void createMidiHandles_8c010468()
{
    int i;
    for (i = 0; i < 8; i++)
    {
        sdMidiOpenPort(&midiHandles_8c0fcd28[i]);
    }
}

/* Matched */
void createAdxAndMidiHandles_8c01048e()
{
    createAdxHandles_8c010428();
    createMidiHandles_8c010468();
}

/* Matched */
Sint32 unused_8c0104bc(Sint32 fsize)
{
    fsize += 2047;
    return (fsize / 2048) * 2048;
}

/* Matched */
void* FUN_8c0104d6(char* fname)
{
    void* dat;
    Sint32 fsize, nsct;
    GDFS gdfs = gdFsOpen(fname, 0);

    gdFsGetFileSize(gdfs, &fsize);

    nsct = (fsize+2047)/2048;
    if ( (dat=syMalloc(nsct*2048)) != NULL ) {
        gdFsRead(gdfs, nsct, dat);
    }
    gdFsClose(gdfs);

    return dat;
}

/* Matched */
void usr_adx_err_func_8c010532(void *obj, char *msg)
{
    char lmsg[9] = "E8101214";

    if (strncmp(msg, lmsg, strlen(lmsg)) == 0)
    {
        FUN_8c010ca6(0);
        FUN_8c010ca6(1);

        init_8c03bd80 = 0;
        init_8c03bd80 = 0;
    }
}

/* Matched */
void adxLoad_8c01057a()
{
    int j = 0;
    Sint8 i = 0;

    while (adxfPartitionInfo_8c03bd94[i].nfile_0x04 != 0)
    {
        ADXF_LoadPartition(
            i,
            adxfPartitionInfo_8c03bd94[i].fname_0x00,
            &adxf_work_8c156efc[j],
            adxfPartitionInfo_8c03bd94[i].nfile_0x04
        );
        j += ADXF_GetPtinfoSize(i);
        i++;
    }
}

/* Matched */
void finishSoundInit_8c010614()
{
    SDMEMBLK memblk;

    sdMemBlkCreate(&memblk);
    sdMemBlkSetPrm(memblk, memblkSource_8c0fcd4c, 0x119d00, SDD_MEMBLK_SYNC_FUNC, NULL);
    sdMultiUnitDownload(memblk);
    syFree(memblkSource_8c0fcd4c);
    sdMemBlkDestroy(memblk);
}

/* Matched */
void adxInit_8c01064c()
{
    ADXT_Init();
    ADXT_EntryErrFunc(usr_adx_err_func_8c010532, NULL);
}

/* Matched */
void soundInit_8c01065e()
{
    SDMEMBLK memblk = NULL;

    sdLibInit(NULL, 0, 0);
    sdMemBlkCreate(&memblk);
    sdMemBlkSetPrm(memblk, memblkSource_8c0fcd48, 0, SDD_MEMBLK_SYNC_FUNC, NULL);
    sdDrvInit(memblk);
    sdMemBlkDestroy(memblk);
    syFree(memblkSource_8c0fcd48);
    sdMemBlkSetTransferMode(SDE_MEMBLK_TRANSFER_MODE_DMA);
}

/* Matched */
void FUN_8c0106ac()
{
    int s = ADXT_GetStat(adxtHandles_8c0fcd20[1]);
    if (s == ADXT_STAT_STOP || s == ADXT_STAT_PLAYEND) {
        init_8c03bd80 &= 0xffffffef;
    }
}

/* Matched */
Bool FUN_8c0106d2(Sint32 param)
{
    if (param >= 7) {
        param += 2;
    }

    if (param >= 0 && param < 10) {
        midiResetFxAndPlay_8c010846(0, param);
        return TRUE;
    } else {
        if (param >= 10 && param <= 70) {
            sdMidiPlay(midiHandles_8c0fcd28[0], 1, param - 10, 0);
            return TRUE;
        }

        return FALSE;
    }
}

/* Matched */
Bool FUN_8c010720(Sint32 param)
{
    if (param >= 0 && param < 63) {
        snd_8c010cd6(1, param + 17);
        return TRUE;
    } else {
        if (param >= 63 && param <= 1388) {
            snd_8c010cd6(2, param - 63);
            return TRUE;
        }

        return FALSE;
    }
}

/* Matched */
int FUN_8c0107ac(Sint32 param)
{
    if (param >= 0 && param < 17) {
        snd_8c010cd6(0, param);
        return 1;
    }
    return 0;
}

/* Matched */
void controlAdxtWithOutVol_8c0107d2(Bool play)
{
    Uint32 i;

    if (play == TRUE) {
        ADXT_SetOutVol(adxtHandles_8c0fcd20[0], -990);
        ADXT_SetOutVol(adxtHandles_8c0fcd20[1], -990);

        for (i = 0; i < 8; i++)
            sdMidiPause(midiHandles_8c0fcd28[i]);
    } else if (play == FALSE) {
        ADXT_SetOutVol(adxtHandles_8c0fcd20[0], -990 + _8c03bd88.field_0x00);
        ADXT_SetOutVol(adxtHandles_8c0fcd20[1], -990 + _8c03bd88.field_0x04);

        for (i = 0; i < 8; i++)
            sdMidiContinue(midiHandles_8c0fcd28[i]);
    }
}

/* Matched */
void midiResetFxAndPlay_8c010846(int hld_idx, int data_num)
{
    Sint8 i;

    sdSndSetFxPrg(0, 0);

    for (i = 0; i < 6; i++)
        sdMidiSetFxLev(midiHandles_8c0fcd28[i], 0);

    sdMidiPlay(midiHandles_8c0fcd28[hld_idx], 0, data_num, 0);
}

/* Matched */
Bool setSoundMode_8c0108c0(Bool no_pan)
{
    void *dat;
    int r;

    if (no_pan == FALSE) {
        sdSndSetPanMode(SDE_PAN_MODE_ENABLE);
    } else if (no_pan == TRUE) {
        sdSndSetPanMode(SDE_PAN_MODE_DISABLE);
    }

    dat = syMalloc(0x4000);
    r = syCfgInit(dat);
    if (r != SYD_CFG_OK) {
        syFree(dat);
        return FALSE;
    }

    r = syCfgSetSoundMode(no_pan);
    if (r != SYD_CFG_OK) {
        syFree(dat);
        return FALSE;
    }

    syCfgExit();
    syFree(dat);

    return TRUE;
}

/* Matched */
FUN_8c010924() {
    void* dat;
    int r;
    Sint32 mode;

    dat = syMalloc(0x4000);
    r = syCfgInit(dat);
    if (r != SYD_CFG_OK) {
        syFree(dat);
        return -1;
    }

    r = syCfgGetSoundMode(&mode);
    if (r != SYD_CFG_OK) {
        syFree(dat);
        return -1;
    }

    syCfgExit();
    syFree(dat);

    return mode;
}

FUN_8c010972(int param1, int param2) {
    // Initialized data
    const int vols_8c0332b0[10] = {
        0,
        110,
        220,
        330,
        440,
        550,
        660,
        770,
        880,
        990
    };

    switch (param2)
    {
        case 0: {
            // int vol = vols_8c0332b0[param1];
            _8c03bd88.field_0x00 = vols_8c0332b0[param1];
            ADXT_SetOutVol(adxtHandles_8c0fcd20[param2], _8c03bd88.field_0x00 - 990);
            break;
        }
        case 1: {
            // int vol = vols_8c0332b0[param1];
            _8c03bd88.field_0x04 = vols_8c0332b0[param1];
            ADXT_SetOutVol(adxtHandles_8c0fcd20[param2], _8c03bd88.field_0x04 - 990);
            break;
        }
    }
}

/* Matched */
void FUN_8c0109f4(int param1) {
    // Initialized data
    int i;
    int vols_8c0332d8[10] = {
        0,
        25,
        51,
        76,
        102,
        127,
        153,
        178,
        204,
        229
    };

    _8c03bd90 = vols_8c0332d8[param1];

    for (i = 0; i < 8; i++)
        sdMidiSetVol(midiHandles_8c0fcd28[i], _8c03bd90 - 127, 0);
    
    FUN_sound_8c0100bc();
}

void FUN_adxVol_8c010a40() {
    /* 8c010a56 */
    if ((_8c157a34.flags_0x00 & 0xf) != 0)
    {
        /* 8c010a5c */
        if ((_8c157a34.flags_0x00 & 1) == 1)
        {
            _8c157a34.field_0x0c -= _8c157a34.field_0x04;
            ADXT_SetOutVol(adxtHandles_8c0fcd20[0], _8c157a34.field_0x0c);
        }

        /* 8c010a70 */
        if ((_8c157a34.flags_0x00 & 2) == 2)
        {
            _8c157a34.field_0x10 -= _8c157a34.field_0x08;
            ADXT_SetOutVol(adxtHandles_8c0fcd20[1], _8c157a34.field_0x10);
        }

        /* 8c010a86 */
        if (
            (_8c157a34.field_0x0c < -300)
            && (_8c157a34.flags_0x00 & 1) == 1
        ) 
        {
            ADXT_Stop(adxtHandles_8c0fcd20[0]);
            ADXT_SetOutVol(adxtHandles_8c0fcd20[0], _8c03bd88.field_0x00 - 990);

            _8c157a34.flags_0x00 &= 0xfffffffe;
            init_8c03bd80 &= 0xfffffffe;
        }

        /* 8c010abe */
        if (
            (_8c157a34.field_0x10 < -300)
            && (_8c157a34.flags_0x00 & 2) == 2
        )
        {
            ADXT_Stop(adxtHandles_8c0fcd20[1]);
            ADXT_SetOutVol(adxtHandles_8c0fcd20[1], _8c03bd88.field_0x04 - 990);
            _8c157a34.flags_0x00 &= 0xfffffffd;
            init_8c03bd80 &= 0xffffffef;
        }
    }
    else 
    {
        /* 8c010b38 */
        if ((_8c157a34.flags_0x00 & 0xf0) != 0) {
            if ((_8c157a34.flags_0x00 & 0x10) == 0x10) {
                _8c157a34.field_0x0c += _8c157a34.field_0x04;
                ADXT_SetOutVol(adxtHandles_8c0fcd20[0], _8c157a34.field_0x0c);
            }

            /* 8c010b4e */
            if ((_8c157a34.flags_0x00 & 0x20) == 0x20) {
                _8c157a34.field_0x10 += _8c157a34.field_0x08;
                ADXT_SetOutVol(adxtHandles_8c0fcd20[1], _8c157a34.field_0x10);
            }

            /* 8c010b64 */
            if (
                (_8c157a34.field_0x0c >= _8c03bd88.field_0x00)
                && ((_8c157a34.flags_0x00 & 0x10) == 0x10)
            ) {
                ADXT_SetOutVol(adxtHandles_8c0fcd20[0], _8c03bd88.field_0x00);
                _8c157a34.flags_0x00 &= 0xffffffef;
            }

            /* 8c010b82 */
            if (
                (_8c157a34.field_0x10 > _8c03bd88.field_0x04)
                && ((_8c157a34.flags_0x00 & 0x20) == 0x20)
            ) {
                ADXT_SetOutVol(adxtHandles_8c0fcd20[1], _8c03bd88.field_0x04);
                _8c157a34.flags_0x00 &= 0xffffffdf;
            }
        }
    }
}

void FUN_8c010bae(int param1) {
    if ((_8c157a34.flags_0x00 & 0xf0) == 0) {
        /* 8c010bba */
        if (param1 == 0 && (_8c157a34.flags_0x00 & 0xf) != 1) {
            _8c157a34.flags_0x00 |= 1;
            _8c157a34.field_0x04 = (_8c03bd88.field_0x00 - 300) / 90;
            _8c157a34.field_0x0c = _8c03bd88.field_0x00 - 990;
        }
        if (param1 == 1 && (_8c157a34.flags_0x00 & 0xf) != 2) {
            _8c157a34.flags_0x00 |= 2;
            _8c157a34.field_0x08 = (_8c03bd88.field_0x04 - 300) / 90;
            _8c157a34.field_0x10 = _8c03bd88.field_0x04 - 990;
        }
    }
}

void FUN_8c010c2c(Bool param1) {
    if ((_8c157a34.flags_0x00 & 0xf) == 0) {
        if (param1 == 1) {
            if ((_8c157a34.flags_0x00 & 0xf0) != 0x20) {
                _8c157a34.flags_0x00 |= 0x20; 
                _8c157a34.field_0x08 = 90 / _8c03bd88.field_0x04;
                _8c157a34.field_0x10 = -990;
                init_8c03bd80 &= 0xffffffef;
            }
        }
    }
}

/* Matched */
void FUN_8c010c6e() {
    midiSetVol_8c010128();
    midiSetPitch_8c01023c();
    FUN_8c0102d8();
}

/* Matched */
void FUN_8c010c7c() {
    int i;
    for (i=0; i<2; i++) {
        ADXT_Stop(adxtHandles_8c0fcd20[i]);
    }

    init_8c03bd80 = 0;
    return;
}

/* Matched */
void FUN_8c010ca6(Bool p1) {
    if (p1 == 0) {
        init_8c03bd80 &= 0xfffffffe;
    } else if (p1 == 1) {
        init_8c03bd80 &= 0xffffffef;
    }

    ADXT_Stop(adxtHandles_8c0fcd20[p1]);
    return;
}

/* wip */
int snd_8c010cd6(int p1, int p2) {
    switch (p1) {
        case 0: {
            ADXT_Stop(adxtHandles_8c0fcd20[p1]);
            ADXT_StartAfs(adxtHandles_8c0fcd20[p1], 0, p2);
            init_8c03bd80 |= 1;
            return 1;
        }

        case 1: {
            ADXT_Stop(adxtHandles_8c0fcd20[p1]);
            p2 == 0x7FFFFFFF;
            ADXT_StartAfs(adxtHandles_8c0fcd20[p1], 0, p2);
            init_8c03bd80 |= 0x10;
            return 1;
        }

        case 2: {
            ADXT_Stop(adxtHandles_8c0fcd20[p1]);
            ADXT_StartAfs(adxtHandles_8c0fcd20[p1], 1, p2);
            init_8c03bd80 |= 0x10;
            return 1;
        }
    }

    return 0;
}

/* Matched */
void FUN_8c010d8a() {
    ADXT_Stop(adxtHandles_8c0fcd20[0]);
    ADXT_SetOutVol(adxtHandles_8c0fcd20[0], _8c03bd88.field_0x00 - 990);
    _8c157a34.flags_0x00 &= 0xfffffffe;
    init_8c03bd80 &= 0xfffffffe;

    ADXT_Stop(adxtHandles_8c0fcd20[0]);
    ADXT_SetOutVol(adxtHandles_8c0fcd20[0], _8c03bd88.field_0x00 - 990);
    _8c157a34.flags_0x00 &= 0xfffffffe;
    init_8c03bd80 &= 0xfffffffe;
}

/* Matched */
void FUN_8c010de6() {
    sdMidiStopAll();
    ADXT_Stop(adxtHandles_8c0fcd20[0]);
    ADXT_Stop(adxtHandles_8c0fcd20[1]);
    init_8c03bd80 = 0;
    init_8c03bd80 = 1;
    memset(&_8c157a34, 0, sizeof(s_8c157a34));
    FUN_sound_8c0100bc();
}

/* Matched */
void FUN_8c010e18(char *dirname) {
    init_8c03bd80 = 0;
    init_8c03bd80 = 1;
    gdFsChangeDir(dirname);
    memset(&_8c157a34, 0, sizeof(s_8c157a34));
    FUN_sound_8c0100bc();
    init_8c03bd80 |= 0x11;
    soundInit_8c01065e();
    adxInit_8c01064c();
    createAdxAndMidiHandles_8c01048e();
    adxLoad_8c01057a();
    finishSoundInit_8c010614();
    init_8c03bd80 = 0;
}

