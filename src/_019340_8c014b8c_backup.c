/*
 * Adjusted backup sample from SDK 155j
 */

#include <shinobi.h>
#include "_019340_8c014b8c_backup.h"

/*
 * Mamimum volume to use.
 */
#define MAX_CAPS BUD_CAPACITY_1MB

/*
 * Number of memory card to use.
 */
#define MAX_DRIVES 8
#define USE_DRIVES BUD_USE_DRIVE_ALL

/*
 * Structure to store the information of memory card.
 * (See backup.h)
 */
extern BACKUPINFO gBupInfo[8];



/*
 * Prototypes of static functions.
 */
static Sint32 BupComplete(Sint32 drive, Sint32 op, Sint32 stat, Uint32 param);
static Sint32 BupProgress(Sint32 drive, Sint32 op, Sint32 count, Sint32 max);
static void BupInitCallback(void);
static void ClearInfo(Sint32 drive);



void BupInit(void)
{
    memset(gBupInfo, 0, sizeof(gBupInfo));
    buInit(MAX_CAPS, USE_DRIVES, NULL, BupInitCallback);
}

void BupExit(void)
{
    do {} while (buExit() != BUD_ERR_OK);
}

const BACKUPINFO* BupGetInfo(Sint32 drive)
{
    return (const BACKUPINFO*)&gBupInfo[drive];
}

Sint32 BupLoad(Sint32 drive, const char* fname, void* buf)
{
    return buLoadFile(drive, fname, buf, 0);
}

enum {
	Sunday = 0,
	Monday,
	Tuesday,
	Wednesday,
	Thursday,
	Friday,
	Saturday
};

static SYS_RTC_DATE gBupTime_8c04411c = {
    1998, 12, 31,   /* year, month, day     */
    23, 59, 59,     /* hour, minute, second */
    Thursday, 0     /* day of week, age of moon */
};

Sint32 BupSave(Sint32 drive, const char* fname, void* buf, Sint32 nblock)
{
    syRtcGetDate(&gBupTime_8c04411c);
    return buSaveFile(drive, fname, buf, nblock, &gBupTime_8c04411c,
                            BUD_FLAG_VERIFY | BUD_FLAG_COPY(0));
}

Sint32 BupDelete(Sint32 drive, const char* fname)
{
    return buDeleteFile(drive, fname);
}

void BupMount(Sint32 drive)
{
    BACKUPINFO* info;

    info = &gBupInfo[drive];

    if (info->Work) return;

    info->Work = syMalloc(info->WorkSize);

    buMountDisk(drive, info->Work, info->WorkSize);
}

void BupUnmount(Sint32 drive)
{
    BACKUPINFO* info;
    Sint32 err;

    info = &gBupInfo[drive];

    if (info->Work == NULL) return;

    if (buStat(drive) == BUD_STAT_READY) {
        buUnmount(drive);
        syFree(info->Work);
        ClearInfo(drive);
    }
}

static void ClearInfo(Sint32 drive)
{
    BACKUPINFO* info;

    info = &gBupInfo[drive];
    info->ProgressCount = 0;
    info->ProgressMax = 0;
    info->Operation = 0;
    info->Ready = FALSE;
    info->IsFormat = FALSE;
    info->Work = NULL;
    memset(&info->DiskInfo, 0, sizeof(BUS_DISKINFO));
}

const char* BupGetErrorString(Sint32 err)
{
    switch (err) {
        // TODO: Fix as soon as we catch up with the constant integration
        case BUD_ERR_OK:				return (char*) 0x8c035dd4; /* "OK\0" */
        case BUD_ERR_BUSY:				return (char*) 0x8c035dd8; /* "BUSY\0" */
        case BUD_ERR_INVALID_PARAM:		return (char*) 0x8c035de0; /* "INVALID PARAMETER\0" */
        case BUD_ERR_ILLEGAL_DISK:		return (char*) 0x8c035df4; /* "ILLEGAL DISK\0" */
        case BUD_ERR_UNKNOWN_DISK:		return (char*) 0x8c035e04; /* "UNKNOWN DISK\0" */
        case BUD_ERR_NO_DISK:			return (char*) 0x8c035e14; /* "NO DISK\0" */
        case BUD_ERR_UNFORMAT:			return (char*) 0x8c035e20; /* "UNFORMAT\0" */
        case BUD_ERR_DISK_FULL:			return (char*) 0x8c035e2c; /* "DISK FULL\0" */
        case BUD_ERR_FILE_NOT_FOUND:	return (char*) 0x8c035e38; /* "FILE NOT FOUND\0" */
        case BUD_ERR_FILE_EXIST:		return (char*) 0x8c035e48; /* "FILE EXIST\0" */
        case BUD_ERR_CANNOT_OPEN:		return (char*) 0x8c035e54; /* "CANNOT OPEN\0" */
        case BUD_ERR_CANNOT_CREATE:		return (char*) 0x8c035e64; /* "CANNOT CREATE\0" */
        case BUD_ERR_EXECFILE_EXIST:	return (char*) 0x8c035e74; /* "EXECUTABLE FILE EXIST\0" */
        case BUD_ERR_ACCESS_DENIED:		return (char*) 0x8c035e8c; /* "ACCESS DENIED\0" */
        case BUD_ERR_VERIFY:			return (char*) 0x8c035e9c; /* "VERIFY ERROR\0" */
        default:						return (char*) 0x8c035eac; /* "GENERIC ERROR\0" */
    }
}

const char* BupGetOperationString(Sint32 op)
{
    switch (op) {
        // TODO: Fix as soon as we catch up with the constant integration
        case BUD_OP_CONNECT:		return (char *) 0x8c035ebc; /* "CONNECTED\0" */
        case BUD_OP_MOUNT:			return (char *) 0x8c035ec8; /* "MOUNTED\0" */
        case BUD_OP_UNMOUNT:		return (char *) 0x8c035ed4; /* "UNMOUNTED\0" */
        case BUD_OP_FORMATDISK:		return (char *) 0x8c035ee0; /* "FORMATDISK\0" */
        case BUD_OP_DELETEFILE:		return (char *) 0x8c035eec; /* "DELETEFILE\0" */
        case BUD_OP_LOADFILE:		return (char *) 0x8c035ef8; /* "LOADFILE\0" */
        case BUD_OP_SAVEFILE:		return (char *) 0x8c035f04; /* "SAVEFILE\0" */
        default:					return (char *) 0x8c035f10; /* "UNKNOWN OPERATION\0" */
    }
}


/*
 * Callback functions.
 */

static void BupInitCallback(void)
{
    Sint32 i;

    buSetCompleteCallback(BupComplete);
    buSetProgressCallback(BupProgress);
}

static Sint32 BupComplete(Sint32 drive, Sint32 op, Sint32 stat, Uint32 param)
{
    BACKUPINFO* info;
    Sint32 ret;


    info = &gBupInfo[drive];

    switch (op) {
        case BUD_OP_CONNECT:
            info->Connect = TRUE;
            info->WorkSize = BUM_WORK_SIZE(stat, 1);
            info->Capacity = stat;
            break;
        case BUD_OP_MOUNT:
            if (stat == BUD_ERR_OK) {
                info->Ready = TRUE;
                ret = buGetDiskInfo(drive, &info->DiskInfo);
                if (ret == BUD_ERR_OK) {
                    info->IsFormat = TRUE;
                }
                info->LastError = BUD_ERR_OK;
            }
            break;
        case BUD_OP_UNMOUNT:
            if (info->Work) syFree(info->Work);
            ClearInfo(drive);
            info->Connect = FALSE;
            break;
        default:
            info->LastError = stat;

            buGetDiskInfo(drive, &info->DiskInfo);
    }

    info->Operation = 0;

    return BUD_CBRET_OK;
}

static Sint32 BupProgress(Sint32 drive, Sint32 op, Sint32 count, Sint32 max)
{
    BACKUPINFO* info;

    info = &gBupInfo[drive];

    info->ProgressCount = count;
    info->ProgressMax = max;
    info->Operation = op;

    return BUD_CBRET_OK;
}
