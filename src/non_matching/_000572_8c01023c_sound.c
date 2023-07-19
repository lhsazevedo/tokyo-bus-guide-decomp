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

extern s_8c0fcd50 _8c0fcd50;
extern SDMIDI midiHandles_8c0fcd28[7];

typedef struct _Test {
    float var0;
} Test;

typedef struct _Test2 {
    Uint32 var0;
} Test2;

extern Test _8c226468;
extern Uint32 _8c1bbcb0;

#define WKSIZE 184516
extern char work_8c0fcd74[WKSIZE * 2];
extern ADXT adxtHandles_8c0fcd20[2];
int _8c03bd80;
int _8c03bd84;

struct AdxfPartitionInfo {
    char* fname_0x00;
    int nfile_0x04;
}
typedef AdxfPartitionInfo;

extern AdxfPartitionInfo adxfPartitionInfo_8c03bd94[2];
extern char adxf_work_8c156efc[];
extern void* memblkSource_8c0fcd48;
extern void* memblkSource_8c0fcd4c;
extern int _8c03bd88[2];

/* Matched */
midiSetPitch_8c01023c()
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

FUN_8c0102d8()
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
createAdxHandles_8c010428()
{
    Sint8 i = 0;
    do
    {
        adxtHandles_8c0fcd20[i] = ADXT_Create(2, &work_8c0fcd74[i * WKSIZE], WKSIZE);
        i++;
    } while (i < 2);
}

/* Matched */
createMidiHandles_8c010468()
{
    SDMIDI* handle = &midiHandles_8c0fcd28[0];
    do {
        sdMidiOpenPort(handle);
        handle++;
    } while (handle < &midiHandles_8c0fcd28[8]);
}

/* Matched */
createAdxAndMidiHandles_8c01048e()
{
    createAdxHandles_8c010428();
    createMidiHandles_8c010468();
}

/* Matched */
Sint32 FUN_8c0104bc(Sint32 fsize)
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
    // TODO:
    char lmsg[9] = "E8101214";

    if (strncmp(msg, lmsg, strlen(lmsg)) == 0)
    {
        FUN_8c010ca6(0);
        FUN_8c010ca6(1);

        _8c03bd80 = 0;
        _8c03bd84 = 0;
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
    // TODO: Fix 1016 (W) Argument mismatch
    int s = ADXT_GetStat(adxtHandles_8c0fcd20[1]);
    if (s == ADXT_STAT_STOP || s == ADXT_STAT_PLAYEND) {
        _8c03bd80 &= 0xffffffef;
    }
}

/* Matched */
Bool FUN_8c0106d2(Sint32 param)
{
    if (param >= 7) {
        param += 2;
    }

    if (param >= 0 && param < 10) {
        FUN_8c010846(0, param);
        return 1;
    } else {
        if (param >= 10 && param <= 70) {
            sdMidiPlay(midiHandles_8c0fcd28[0], 1, param - 10, 0);
            return 1;
        }

        return 0;
    }
}

/* Matched */
Bool FUN_8c010720(Sint32 param)
{
    if (param >= 0 && param < 63) {
        snd_8c010cd6(1, param + 17);
        return 1;
    } else {
        if (param >= 63 && param <= 1388) {
            snd_8c010cd6(2, param - 63);
            return 1;
        }

        return 0;
    }
}

/* Matched */
FUN_8c0107ac(Sint32 param)
{
    if (param >= 0 && param < 17) {
        snd_8c010cd6(0, param);
        return 1;
    }
    return 0;
}


FUN_8c0107d2(int param)
{
    SDMIDI* handle = &midiHandles_8c0fcd28[0];

    if (param == 1) {
        ADXT_SetOutVol(adxtHandles_8c0fcd20[0], -990);
        ADXT_SetOutVol(adxtHandles_8c0fcd20[1], -990);

        do {
            sdMidiPause(*handle);
            handle++;
        } while (handle < &midiHandles_8c0fcd28[8]);
    } else if (param == 0) {
        ADXT_SetOutVol(adxtHandles_8c0fcd20[0], _8c03bd88[0] - 990);
        ADXT_SetOutVol(adxtHandles_8c0fcd20[1], _8c03bd88[1] - 990);
        do {
            sdMidiContinue(*handle);
            handle++;
        } while (handle < &midiHandles_8c0fcd28[8]);
    }
}

FUN_8c010ca6(Bool p1)
{
    
}

snd_8c010cd6()
{

}
