#include <shinobi.h>
#include <string.h>
#include "_019100_8c014a9c_tasks.h"

/* struct QueuedDat {
    char *basedir;
    char *filename;
    void **dest;
    int field_0x0c;
}
typedef QueuedDat; */

struct QueuedNj {
    char *basedir;
    char *filename;
    void **dest_0x08;
    void **dest_0x0c;
    int field_0x10;
}
typedef QueuedNj;

/* TODO: Same struct as Task, but with QueuedNj. */
typedef struct {
    TaskAction action;
    void *state;
    int field_0x08;
    GDFS gdfs_0x0c;
    int field_0x10;
    int field_0x14;
    QueuedNj* queuedNj_0x18; /* Perhaps we should use a union or a void* to handle both cases? */
    int field_0x1c;
} TaskLoadQueuedNjs;

struct QueuedPvm {
    char *basedir;
    char *filename;
    void **field_0x08;
    int field_0x0c;
    int field_0x10;
    int field_0x14;
}
typedef QueuedPvm;

typedef struct {
    TaskAction action;
    void *state;
    int field_0x08;
    GDFS gdfs_0x0c;
    int field_0x10;
    int field_0x14;
    QueuedPvm* queuedPvm_0x18;
    int field_0x1c;
} TaskLoadQueuedPvms;

struct QueuedTexlist {
    char *basedir_0x00;
    NJS_TEXLIST *texlist_0x04;
}
typedef QueuedTexlist;


struct TaskProcessQueuesState {
    int queue_0x00;
    void (*func_0x04)();
    void (*afterDatCallback_0x08)();
    void (*afterNjCallback_0x0c)();
    void (*afterPvmCallback_0x10)();
    void (*afterTexlistCallback_0x14)();
}
typedef TaskProcessQueuesState;

extern int var_queuesAreInitialized_8c157a60;
extern char *var_queueBaseDir_8c157a80;
extern int var_8c157a88;

extern QueuedDat *var_datQueue_8c157a8c;
extern QueuedDat *var_datQueueRear_8c157a90;
extern QueuedDat *var_datQueueTail_8c157a94;
extern int var_datQueueIsIdle_8c157a98;

extern QueuedNj *var_njQueue_8c157a9c;
extern QueuedNj *var_njQueueRear_8c157aa0;
extern QueuedNj *var_njQueueTail_8c157aa4;
extern int var_njQueueIsIdle_8c157aa8;

extern QueuedTexlist *var_texlistQueue_8c157aac;
extern QueuedTexlist *var_texlistQueueRear_8c157ab0;
extern QueuedTexlist *var_texlistQueueTail_8c157ab4;
extern int var_texlistQueueIsIdle_8c157ab8;
extern int var_texlistQueueCount_8c157a68;

extern Sint8 *var_queueBuffer_8c157a84;

extern Task *var_tasks_8c1ba3c8;

extern int init_8c03be80[48];

extern int var_8c1ba1cc[];
extern QueuedPvm* var_pvmQueue_8c157abc;
extern QueuedPvm* var_pvmQueueRear_8c157ac0;
extern QueuedPvm* var_pvmQueueTail_8c157ac4;
extern int var_pvmQueueIsIdle_8c157ac8;

extern int var_8c157acc;
extern int var_8c157ad0;

/* TODO: DRY */
#define TEX_BUFSIZE     0x80800
extern Sint8 var_texbuf_8c277ca0[TEX_BUFSIZE];

typedef struct {
    TaskAction action;
    void *state;
    int field_0x08;
    GDFS gdfs_0x0c;
    int field_0x10;
    int field_0x14;
    QueuedDat* queuedDat_0x18;
    int field_0x1c;
} TaskLoadQueuedDats;

/* Matched :) */
void nop_8c011120() {
    /* Empty body */
}

/* Matched :) */
int initDatQueue_8c011124(int n) {
    if (n != 0) {
        if ((var_datQueue_8c157a8c = syMalloc(n * sizeof(QueuedDat))) == NULL) {
            return 0;
        }

        var_datQueueTail_8c157a94 = var_datQueue_8c157a8c + n;
    } else {
        var_datQueue_8c157a8c = var_datQueueTail_8c157a94 = ((void *) -1);
    }

    return 1;
}

/* Matched */
void resetDatQueue_8c01116a() {
    var_datQueueRear_8c157a90 = var_datQueue_8c157a8c;
    var_queueBaseDir_8c157a80 = "DATA EMPTY";
    var_datQueueIsIdle_8c157a98 = 1;
}

/* Matched */
int requestDat_8c011182(char* basedir, char* filename, void* dest) {
    if (*filename == 0) {
        return 0;
    }

    if (var_datQueueRear_8c157a90 >= var_datQueueTail_8c157a94) {
        return 0;
    }

    var_datQueueRear_8c157a90->basedir = basedir;
    var_datQueueRear_8c157a90->filename = filename;
    var_datQueueRear_8c157a90->dest = dest;
    var_datQueueRear_8c157a90->field_0x0c = 0;

    var_datQueueRear_8c157a90++;
    return 1;
}

/* Almost matching */
void task_loadQueuedDats_8c0111b4(TaskLoadQueuedDats* task, void* state) {
    QueuedDat* item = task->queuedDat_0x18;
    Sint32 size;

    switch (task->field_0x08) {
        /* 8c0111cc */
        case 0: {
            /* 8c0111da */
            while (1) {
                /* TODO: Test this condition */
                if (item >= var_datQueueRear_8c157a90) {
                    break;
                }

                if (item->field_0x0c == 0) {
                    /* TODO: Test this update */
                    if (*item->basedir != 0 && /* 8c0111ee */
                        strcmp(var_queueBaseDir_8c157a80, item->basedir) != 0 /* 8c0111f6 */
                    ) {
                            var_queueBaseDir_8c157a80 = item->basedir;
                            gdFsChangeDir(item->basedir);
                        // }
                    }

                    /* 8c01120c */
                    task->gdfs_0x0c = gdFsOpen(item->filename, 0);
                    if (task->gdfs_0x0c == NULL) {
                        /* 8c0112f4 (shared) */
                        /* TODO: Write test for this */
                        var_8c157a88 = 1;
                        task->queuedDat_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    /* 8c01121a */
                    if (!gdFsGetFileSctSize(task->gdfs_0x0c, &size)) {
                        /* 8c0112f4 (shared) */
                        /* TODO: Write test for this */
                        var_8c157a88 = 1;
                        task->queuedDat_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    /* 8c011226 */
                    *item->dest = syMalloc(size * 2048);

                    /* 8c011234 */
                    if (gdFsRead(task->gdfs_0x0c, size, *item->dest) != GDD_ERR_OK) {
                        /* 8c0112f4 (shared) */
                        /* TODO: Write test for this */
                        var_8c157a88 = 1;
                        task->queuedDat_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    /* 8c011282 (shared) */
                    gdFsClose(task->gdfs_0x0c);
                    item->field_0x0c = 1;
                    task->queuedDat_0x18 = ++item;
                    task->field_0x08 = 0;
                    return;
                }

                item++;
            }

            /* 8c01124a */
            if (var_8c157a88 != 0) {
                /* 8c011250 */
                task->queuedDat_0x18 = var_datQueue_8c157a8c;
                var_8c157a88 = 0;
                var_queueBaseDir_8c157a80 = "DATA EMPTY";
                /* return */;
            } else {
                /* 8c011262 */
                var_datQueueIsIdle_8c157a98 = 1;
                freeTask_8c014b66((Task*) task);
                /* return; */
            }
            break;
        }

        /* 8c0111d2 */
        case 1: {
            /* 8c011270 */
            switch (gdFsGetStat(task->gdfs_0x0c)) {
                case GDD_STAT_COMPLETE: {
                    /* 8c011282 (shared) */
                    gdFsClose(task->gdfs_0x0c);
                    item->field_0x0c = 1;
                    task->queuedDat_0x18++;
                    task->field_0x08 = 0;
                    return;
                } 
                case GDD_STAT_READ: { /* 8c01127a */
                    /* 8c0112cc */
                    if (gdFsGetTransStat(task->gdfs_0x0c) == GDD_FS_TRANS_READY) {
                        /* 8c0112d6 */
                        gdFsTrans32(task->gdfs_0x0c, 2048, *item->dest);
                    }
                    break;
                } 
                default: {
                    gdFsClose(task->gdfs_0x0c);
                    syFree(item->dest);
                    /* 8c0112f4 (shared) */
                    var_8c157a88 = 1;
                    task->queuedDat_0x18++;
                    task->field_0x08 = 0;
                    break;
                }
            }
            break;
        }
    }
}

/* Tested */
int sortAndLoadDatQueue_8c011310() {
    int r9;
    Task *created_task;
    void* created_state;
    QueuedDat *temp_r11;

    if ((int) var_datQueue_8c157a8c == (int) var_datQueueRear_8c157a90) {
        return 0;
    }

    /* 8c01132e */
    var_datQueueIsIdle_8c157a98 = 0;

    temp_r11 = syMalloc((int) var_datQueueRear_8c157a90 - (int) var_datQueue_8c157a8c);

    /* 8c011340 */
    while (1) {
        int r9 = 0;
        QueuedDat *a_r13 = var_datQueue_8c157a8c;
        QueuedDat *b_r14 = var_datQueue_8c157a8c;

        /* 8c011376 */
        while (++b_r14 < var_datQueueRear_8c157a90) {
            /* 8c011348 */
            if (strcmp(a_r13->filename, b_r14->filename) > 0) {
                /* 8c011354 */
                *temp_r11 = *a_r13;
                *a_r13 = *b_r14;
                *b_r14 = *temp_r11;
                r9 = 1;
            }

            /* 8c011374 */
            a_r13++;
        }

        if (r9 == 0) { /* 8c011374 */
            break;
        }
    }

    syFree(temp_r11);

    if (!pushTask_8c014ae8(&var_tasks_8c1ba3c8, &task_loadQueuedDats_8c0111b4, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = var_datQueue_8c157a8c;
    created_task->field_0x08 = 0;
    var_8c157a88 = 0;
    var_queueBaseDir_8c157a80 = "DATA EMPTY";

    return 1;
}

/* Matched */
int datQueueIsIdle_8c0113d2() {
    return var_datQueueIsIdle_8c157a98;
}

/* Matched */
void freeDatQueue_8c0113d8() {
    if (var_datQueue_8c157a8c != (QueuedDat*) -1) {
        syFree((void*) var_datQueue_8c157a8c);
    }
}

/* Matched */
int initNjQueue_8c011430(int param) {
    if (param != 0) {
        if ((var_njQueue_8c157a9c = syMalloc(param * sizeof(QueuedNj))) == NULL) {
            return 0;
        }

        var_njQueueTail_8c157aa4 = var_njQueue_8c157a9c + param;
    } else {
        var_njQueue_8c157a9c = var_njQueueTail_8c157aa4 = ((void *) -1);
    }

    return 1;
}

/* Matched */
void resetNjQueue_8c01147a() {
    var_njQueueRear_8c157aa0 = var_njQueue_8c157a9c;
    var_queueBaseDir_8c157a80 = "DATA EMPTY";
    var_njQueueIsIdle_8c157aa8 = 1;
}

/* Matched */
int requestNj_8c011492(char* basedir, char* filename, void* dest, void* dest2) {
    if (*filename == 0) {
        return 0;
    }

    if (var_njQueueRear_8c157aa0 >= var_njQueueTail_8c157aa4) {
        return 0;
    }

    var_njQueueRear_8c157aa0->basedir = basedir;
    var_njQueueRear_8c157aa0->filename = filename;
    var_njQueueRear_8c157aa0->dest_0x08 = dest;
    var_njQueueRear_8c157aa0->dest_0x0c = dest2;
    var_njQueueRear_8c157aa0->field_0x10 = 0;

    var_njQueueRear_8c157aa0++;
    return 1;
}

/* Tested */
void task_loadQueuedNjs_8c0114cc(TaskLoadQueuedNjs* task, void* state) {
    QueuedNj* qnj = task->queuedNj_0x18;
    Sint32 size;
    Uint32 fpos, rtype;

    switch (task->field_0x08)
    {
        case 0:
            while (1)
            {
                if (qnj >= var_njQueueRear_8c157aa0) {
                    break;
                }

                if (qnj->field_0x10 == 0) {
                    if (
                        *qnj->basedir != 0 &&
                        strcmp(var_queueBaseDir_8c157a80, qnj->basedir) != 0
                    ) {
                        var_queueBaseDir_8c157a80 = qnj->basedir;
                        gdFsChangeDir(qnj->basedir);
                    }

                    task->gdfs_0x0c = gdFsOpen(qnj->filename, 0);

                    if (task->gdfs_0x0c == NULL) {
                        /* 8c01168c (shared) */
                        if (var_queueBuffer_8c157a84 != &var_texbuf_8c277ca0) {
                            syFree(var_queueBuffer_8c157a84);
                        }
                        var_8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (!gdFsGetFileSctSize(task->gdfs_0x0c, &size)) {
                        /* 8c01168c (shared) */
                        if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                            syFree(var_queueBuffer_8c157a84);
                        }
                        var_8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (size > 0x100) {
                        var_queueBuffer_8c157a84 = syMalloc(size * 2048);
                    } else {
                        var_queueBuffer_8c157a84 = var_texbuf_8c277ca0;
                    }

                    if (gdFsRead(task->gdfs_0x0c, size, var_queueBuffer_8c157a84) != GDD_ERR_OK) {
                        /* 8c01168c (shared) */
                        if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                            syFree(var_queueBuffer_8c157a84);
                        }
                        var_8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return; 
                    }

                    gdFsClose(task->gdfs_0x0c);
                    qnj->field_0x10 = 1;

                    if (qnj->dest_0x08 != 0) {
                        *qnj->dest_0x08 = njReadBinary(var_queueBuffer_8c157a84, &fpos, &rtype);
                    }

                    if (qnj->dest_0x0c != 0) {
                        *qnj->dest_0x0c = njReadBinary(var_queueBuffer_8c157a84, &fpos, &rtype);
                    }

                    if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_queueBuffer_8c157a84);
                    }
                    task->queuedNj_0x18 = ++qnj;
                    task->field_0x08 = 0;
                    return;
                }

                qnj++;
            }

            if (var_8c157a88 != 0) {
                task->queuedNj_0x18 = var_njQueue_8c157a9c;
                var_8c157a88 = 0;
                var_queueBaseDir_8c157a80 = "DATA EMPTY";
            } else {
                var_8c157a88 = 1;
                freeTask_8c014b66((Task*) task);
            }

            break;

        case 1:
            switch (gdFsGetStat(task->gdfs_0x0c)) {
                /* 8c011614 */
                case GDD_STAT_COMPLETE: {
                    gdFsClose(task->gdfs_0x0c);
                    qnj->field_0x10 = 1;

                    if (qnj->dest_0x08) {
                        *qnj->dest_0x08 = njReadBinary(var_queueBuffer_8c157a84, &fpos, &rtype);
                    }

                    if (qnj->dest_0x0c) {
                        *qnj->dest_0x0c = njReadBinary(var_queueBuffer_8c157a84, &fpos, &rtype);
                    }

                    if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_queueBuffer_8c157a84);
                    }

                    task->queuedNj_0x18 = ++qnj;
                    task->field_0x08 = 0;

                    break;
                }
                case GDD_STAT_READ: {
                    if (gdFsGetTransStat(task->gdfs_0x0c) != GDD_FS_TRANS_READY) {
                        /* TODO: Test this return */
                        return;
                    }

                    gdFsTrans32(task->gdfs_0x0c, 2048, var_queueBuffer_8c157a84);
                    break;
                }
                default: {
                    gdFsClose(task->gdfs_0x0c);
                    if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_queueBuffer_8c157a84);
                    }

                    var_8c157a88 = 1;
                    /* TODO: Test this with other item indexes */
                    task->queuedNj_0x18 = ++qnj;
                    task->field_0x08 = 0;
                    break;
                }
            }
            break;
        }
}

int sortAndLoadNjQueue_8c0116b6() {
    Task *created_task;
    void* created_state;
    QueuedNj *temp;

    if ((int) var_njQueue_8c157a9c == (int) var_njQueueRear_8c157aa0) {
        return 0;
    }

    /* 8c01132e */
    var_njQueueIsIdle_8c157aa8 = 0;

    temp = syMalloc((int) var_njQueueRear_8c157aa0 - (int) var_njQueue_8c157a9c);

    /* 8c011340 */
    while (1) {
        int swapped = 0;
        QueuedNj *a = var_njQueue_8c157a9c;
        QueuedNj *b = var_njQueue_8c157a9c;

        /* 8c011376 */
        while (++b < var_njQueueRear_8c157aa0) {
            /* 8c011348 */
            if (strcmp(a->filename, b->filename) > 0) {
                /* 8c011354 */
                *temp = *a;
                *a = *b;
                *b = *temp;
                swapped = 1;
            }

            /* 8c011374 */
            a++;
        }

        if (!swapped) { /* 8c011374 */
            break;
        }
    }

    syFree(temp);

    if (!pushTask_8c014ae8(&var_tasks_8c1ba3c8, &task_loadQueuedNjs_8c0114cc, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = var_njQueue_8c157a9c;
    created_task->field_0x08 = 0;
    var_8c157a88 = 0;
    var_queueBaseDir_8c157a80 = "DATA EMPTY";

    return 1;
}

/* Matched */
int njQueueIsIdle_8c01179e() {
    return var_njQueueIsIdle_8c157aa8;
}

/* Matched? */
void freeNjQueue_8c0117a4() {
    if (var_njQueue_8c157a9c != (QueuedNj*) -1) {
        syFree(var_njQueue_8c157a9c);
    }
}

/* Tested */
int initTexlistQueue_8c0117b8(int n) {
  if (n != 0) {
    var_texlistQueue_8c157aac = syMalloc(n * sizeof(QueuedTexlist));
    if (var_texlistQueue_8c157aac == NULL) {
      return 0;
    }
    var_texlistQueueTail_8c157ab4 = (void *) ((char*) var_texlistQueue_8c157aac + n * sizeof(QueuedTexlist));
  } else {
    var_texlistQueueTail_8c157ab4 = (void *) -1;
    var_texlistQueue_8c157aac = (void *) -1;
  }
  return 1;
}

/* Tested */
void resetTexlistQueue_8c0117fe() {
    var_texlistQueueRear_8c157ab0 = var_texlistQueue_8c157aac;
    var_queueBaseDir_8c157a80 = "DATA EMPTY";
    var_texlistQueueCount_8c157a68 = 0;
    var_texlistQueueIsIdle_8c157ab8 = 1;
    return;
}

/* Tested */
int requestTexlist_8c01181c(char *basedir, NJS_TEXLIST *texlist) {
  if (var_texlistQueueRear_8c157ab0 >= var_texlistQueueTail_8c157ab4) {
    return 0;
  }

  var_texlistQueueRear_8c157ab0->basedir_0x00 = basedir;
  var_texlistQueueRear_8c157ab0->texlist_0x04 = texlist;
  var_texlistQueueRear_8c157ab0++;
  return 1;
}

/* Tested */
void task_loadQueuedTexlists_8c01183e(Task *task, void *state) {
    QueuedTexlist *item = task->field_0x18;
    NJS_TEXLIST *texlist = item->texlist_0x04;

    while (true) {
        int i;

        /* Assume that the current texlist is already loaded */
        bool alreadyLoaded = true;

        for (i = 0; i < texlist->nbTexture; i++)
        {
            int queueIdx;
            NJS_TEXNAME *currentTexture = &texlist->textures[i];

            for (queueIdx = 0; queueIdx < var_texlistQueueCount_8c157a68; queueIdx++)
            {
                QueuedTexlist *comparedItem = &var_texlistQueue_8c157aac[queueIdx];
                int comparedIndex;
                int comparedTextureCount;
                NJS_TEXNAME *comparedTextures;

                if (!comparedItem->texlist_0x04) {
                    continue;
                }

                comparedTextureCount = comparedItem->texlist_0x04->nbTexture;
                comparedTextures = comparedItem->texlist_0x04->textures;

                if (comparedTextureCount) {
                    for (comparedIndex = 0; comparedIndex < comparedTextureCount; comparedIndex++)
                    {
                        if (!strcmp(currentTexture->filename, comparedTextures[comparedIndex].filename)) {
                            currentTexture->texaddr = comparedTextures[comparedIndex].texaddr;
                            break;
                        }
                    }
                }

                /* If we the current texture is already loaded,
                   we can sdvance to next one in the current texlist.
                   Note that breaking prevents the loop counter increment. */
                if (comparedIndex != comparedTextureCount) break;

                /* Refactor: */
                /* if (currentTexture->texaddr) break */
            }

            /* If the current texture was not found in any of
               the compared texlists, then it should be loaded. */
            if (queueIdx == var_texlistQueueCount_8c157a68) {
                alreadyLoaded = false;
            }
        }

        if (alreadyLoaded) {
            /* TODO: Test this path */
            item->texlist_0x04 = NULL;
        } else {
            if (*item->basedir_0x00 && strcmp(var_queueBaseDir_8c157a80, item->basedir_0x00)) {
                var_queueBaseDir_8c157a80 = item->basedir_0x00;
                gdFsChangeDir(item->basedir_0x00);
            }

            njSetTexture(item->texlist_0x04);

            if (texlist->nbTexture) {
                int i;
                /* TODO: Test this skip */
                for (i = 0; i < texlist->nbTexture; i++) {
                    if (!texlist->textures[i].texaddr) {
                        njLoadTextureNum(i);
                    }
                }
            }
        }

        item++;
        var_texlistQueueCount_8c157a68++;
        if (item >= var_texlistQueueRear_8c157ab0) {
            var_texlistQueueIsIdle_8c157ab8 = 1;
            freeTask_8c014b66(task);
            return;
        }

        /* TODO: Test this path */
        if (!alreadyLoaded) {
            task->field_0x18 = item;
            return;
        }
    }
}

/* Tested */
int loadTexlistQueue_8c0119f8() {
    Task *created_task;
    void *created_state;

    if (var_texlistQueue_8c157aac == var_texlistQueueRear_8c157ab0) {
        return 0;
    }

    var_texlistQueueIsIdle_8c157ab8 = 0;
    if (!pushTask_8c014ae8(&var_tasks_8c1ba3c8, task_loadQueuedTexlists_8c01183e, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = var_texlistQueue_8c157aac;
    return 1;
}

/* TODO: Write tests for this */
int texlistQueueIsIdle_8c011a42() {
  return var_texlistQueueIsIdle_8c157ab8;
}

/* TODO: Write tests for this */
void freeTexlistQueue_8c011a48() {
    if (var_texlistQueue_8c157aac != (void *) -1) {
        syFree(var_texlistQueue_8c157aac);
    }
}

/* TODO: Write tests for this */
int initPvmQueue_8c011a5c(int count) {
    if (count) {
        var_pvmQueue_8c157abc = syMalloc(count * sizeof(QueuedPvm));
        if (var_pvmQueue_8c157abc == NULL) {
            return 0;
        }

        var_pvmQueueTail_8c157ac4 = var_pvmQueue_8c157abc + count * 0x18;
    } else {
        var_pvmQueueTail_8c157ac4 = (void*) -1;
        var_pvmQueue_8c157abc = (void*) -1;
    }

    return 1;
}

/* TODO: Write tests for this */
int requestPvm_8c011ac0(char *basedir, char *filename, void *p3, int p4, int p5) {
    if (!*filename || var_pvmQueueRear_8c157ac0 >= var_pvmQueueTail_8c157ac4) {
        return 0;
    }

    var_pvmQueueRear_8c157ac0->basedir = basedir;
    var_pvmQueueRear_8c157ac0->filename = filename;
    var_pvmQueueRear_8c157ac0->field_0x08 = p3;
    var_pvmQueueRear_8c157ac0->field_0x0c = p4;
    var_pvmQueueRear_8c157ac0->field_0x10 = p5;
    var_pvmQueueRear_8c157ac0->field_0x14 = 0;

    var_pvmQueueRear_8c157ac0++;

    return 1;
}

/* TODO: Write tests for this */
void task_loadQueuedPvms_8c011b00(TaskLoadQueuedPvms* task, void* state) {
    QueuedPvm *pvm = (QueuedPvm*) task->queuedPvm_0x18;
    int size;

    switch (task->field_0x08) {
        case 0: {
            for (; pvm < var_pvmQueueRear_8c157ac0; pvm++)
            {
                if (pvm->field_0x14 == 0) {
                    int i;
                    int *temp;
                    char *filename;
                    NJS_TEXLIST *texlist;
                    NJS_TEXNAME *texname;

                    if (*pvm->basedir && strcmp(var_queueBaseDir_8c157a80, pvm->basedir)) {
                        var_queueBaseDir_8c157a80 = pvm->basedir;
                        gdFsChangeDir(pvm->basedir);
                    }

                    task->gdfs_0x0c = gdFsOpen(pvm->filename, 0);
                    if (!task->gdfs_0x0c) {
                        var_8c157a88 = 1;
                        task->queuedPvm_0x18 = ++pvm;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (!gsFsGetFileSctSize(task->gdfs_0x0c, &size)) {
                        var_8c157a88 = 1;
                        task->queuedPvm_0x18 = ++pvm;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (size > 0x100) {
                        var_queueBuffer_8c157a84 = syMalloc(size * 2048);
                    } else {
                        var_queueBuffer_8c157a84 = var_texbuf_8c277ca0;
                    }

                    if (gdFsRead(task->gdfs_0x0c, size, var_queueBuffer_8c157a84)) {
                        var_8c157a88 = 1;
                        task->queuedPvm_0x18 = ++pvm;
                        task->field_0x08 = 0;
                        return;
                    }

                    gdFsClose(task->gdfs_0x0c);
                    pvm->field_0x14 = 1;

                    *pvm->field_0x08 = syMalloc(8);

                    texname = syMalloc(pvm->field_0x0c * 0xc);
                    for (i = 0; i < pvm->field_0x0c; i++) {
                        texname[i].attr = pvm->field_0x10;
                    }

                    /* Huh? */
                    filename = syMalloc(pvm->field_0x0c * 0x1c);

                    njSetPvmTextureList(texlist, texname, filename, pvm->field_0x0c);
                    njLoadTexturePvmMemory(var_queueBuffer_8c157a84, texlist);

                    if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_queueBuffer_8c157a84);
                    }

                    task->queuedPvm_0x18 = ++pvm;
                    task->field_0x08 = 0;
                    return;
                }
            }

            if (var_8c157a88) {
                task->queuedPvm_0x18 = var_pvmQueue_8c157abc;
                var_8c157a88 = 0;
                var_queueBaseDir_8c157a80 = "DATA EMPTY";
            } else {
                var_8c157a88 = 1;
                freeTask_8c014b66(task);
            }
            
            break;
        }

        case 1: {
            switch (gdFsGetStat(task->gdfs_0x0c)) {
                case GDD_STAT_COMPLETE: {
                    int i;
                    NJS_TEXLIST *texlist;
                    NJS_TEXNAME *texname;
                    char *filename;

                    gdFsClose(task->gdfs_0x0c);
                    pvm->field_0x14 = 1;

                    *pvm->field_0x08 = syMalloc(8);

                    texname = syMalloc(pvm->field_0x0c * 0xc);
                    for (i = 0; i < pvm->field_0x0c; i++) {
                        texname[i].attr = pvm->field_0x10;
                    }

                    /* Huh? */
                    filename = syMalloc(pvm->field_0x0c * 0x1c);

                    njSetPvmTextureList(texlist, texname, filename, pvm->field_0x0c);
                    njLoadTexturePvmMemory(var_queueBuffer_8c157a84, texlist);

                    if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_queueBuffer_8c157a84);
                    }

                    task->queuedPvm_0x18 = ++pvm;
                    task->field_0x08 = 0;
                    return;
                }

                case GDD_STAT_READ: {
                    if (gdFsGetTransStat(task->gdfs_0x0c) != GDD_FS_TRANS_COMPLETE) {
                        return;
                    }
                    
                    gdFsTrans32(task->gdfs_0x0c, 2048, var_queueBuffer_8c157a84);
                    return;
                }

                default: {
                    gdFsClose(task->gdfs_0x0c);
                    if (var_queueBuffer_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_queueBuffer_8c157a84);
                    }

                    var_8c157a88 = 1;
                    task->queuedPvm_0x18 = ++pvm;
                    task->field_0x08 = 0;
                    return;
                }
            }
        }
    }
}

/* TODO: Write tests for this */
int sortAndLoadPvmQueue_8c011d24() {
    Task *created_task;
    void* created_state;
    QueuedPvm *temp;

    if ((int) var_pvmQueue_8c157abc == (int) var_pvmQueueRear_8c157ac0) {
        return 0;
    }

    /* 8c01132e */
    var_pvmQueueIsIdle_8c157ac8 = 0;

    temp = syMalloc((int) var_pvmQueueRear_8c157ac0 - (int) var_pvmQueue_8c157abc);

    /* 8c011340 */
    while (1) {
        int swapped = 0;
        QueuedPvm *a = var_pvmQueue_8c157abc;
        QueuedPvm *b = var_pvmQueue_8c157abc;

        /* 8c011376 */
        while (++b < var_pvmQueueRear_8c157ac0) {
            /* 8c011348 */
            if (strcmp(a->filename, b->filename) > 0) {
                /* 8c011354 */
                *temp = *a;
                *a = *b;
                *b = *temp;
                swapped = 1;
            }

            /* 8c011374 */
            a++;
        }

        if (!swapped) { /* 8c011374 */
            break;
        }
    }

    syFree(temp);

    if (!pushTask_8c014ae8(&var_tasks_8c1ba3c8, &task_loadQueuedPvms_8c011b00, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = var_pvmQueue_8c157abc;
    created_task->field_0x08 = 0;
    var_8c157a88 = 0;
    var_queueBaseDir_8c157a80 = "DATA EMPTY";

    return 1;
}

/* TODO: Write tests for this */
int pvmQueueIsIdle_8c011e22() {
  return var_pvmQueueIsIdle_8c157ac8;
}

/* TODO: Write tests for this */
void freePvmQueue_8c011e28() {
  if (var_pvmQueue_8c157abc != (void *) -1) {
    syFree(var_pvmQueue_8c157abc);
  }
}

/* TODO: Write tests for this */
void releaseAndFreeTexlist_8c011e3c(NJS_TEXLIST *texlist) {
  njReleaseTexture(texlist);
  syFree(texlist->textures->filename);
  syFree(texlist->textures);
  syFree(texlist);
}

/* TODO: Write tests for this */
void unusedFunction_8c011e60(void ***p1) {
  syFree(**p1);
  syFree(*p1);
  syFree(p1);
}

/* TODO: Write tests for this */
void task_processQueues_8c011e80(Task *task, TaskProcessQueuesState *state) {
    switch (state->queue_0x00) {
        /* TODO: Use enum */
        case 0: {
            if (datQueueIsIdle_8c0113d2()) {
                if (state->afterDatCallback_0x08) {
                    state->afterDatCallback_0x08();
                }

                state->queue_0x00++;
                sortAndLoadNjQueue_8c0116b6();
            }
            break;
        }

        case 1: {
            if (njQueueIsIdle_8c01179e()) {
                if (state->afterNjCallback_0x0c) {
                    state->afterNjCallback_0x0c();
                }

                state->queue_0x00++;
                sortAndLoadPvmQueue_8c011d24();
            }
            break;
        }

        case 2: {
            if (pvmQueueIsIdle_8c011e22()) {
                if (state->afterPvmCallback_0x10) {
                    state->afterPvmCallback_0x10();
                }

                state->queue_0x00++;
                loadTexlistQueue_8c0119f8();
            }
            break;
        }

        case 3: {
            if (texlistQueueIsIdle_8c011a42()) {
                freeTask_8c014b66(task);
                if (state->afterTexlistCallback_0x14) {
                    state->afterTexlistCallback_0x14();
                }

                return;
            }

            break;
        }
    }

    if (state->func_0x04) {
        state->func_0x04();
    }
}

/* TODO: Write tests for this */
void initQueues_8c011f36(int datCount,int njCount,int texlistCount,int uknCount)
{
  initDatQueue_8c011124(datCount);
  initNjQueue_8c011430(njCount);
  initTexlistQueue_8c0117b8(texlistCount);
  initPvmQueue_8c011a5c(uknCount);
  FUN_8c01c8fc(2);
  FUN_8c01c910();
  var_queuesAreInitialized_8c157a60 = 1;
}

/* TODO: Write tests for this */
void resetQueues_8c011f6c() {
    resetDatQueue_8c01116a();
    resetNjQueue_8c01147a();
    resetTexlistQueue_8c0117fe();
    var_pvmQueueRear_8c157ac0 = var_pvmQueue_8c157abc;
    var_queueBaseDir_8c157a80 = "DATA EMPTY";
    var_pvmQueueIsIdle_8c157ac8 = 1;
}

/* TODO: Write tests for this */
void freeQueues_8c011f7e() {
    freeDatQueue_8c0113d8();
    freeNjQueue_8c0117a4();
    freeTexlistQueue_8c011a48();
    freePvmQueue_8c011e28();
    FUN_8c01c8fc(0);
    var_queuesAreInitialized_8c157a60 = 0;
}

/* TODO: Write tests for this */
void processQueues_8c011fe0(void *func, void *afterDatCallback, void *afterNjCallback, void *afterPvmCallback, void *afterTexlistCallback) {
    Task* created_task;
    TaskProcessQueuesState* created_state;

    pushTask_8c014ae8(&var_tasks_8c1ba3c8, &task_processQueues_8c011e80, created_task, created_state, 0x18);
    created_state->queue_0x00 = 0;
    created_state->afterDatCallback_0x08 = afterDatCallback;
    created_state->afterNjCallback_0x0c = afterNjCallback;
    created_state->afterPvmCallback_0x10 = afterPvmCallback;
    created_state->afterTexlistCallback_0x14 = afterTexlistCallback;
    created_state->func_0x04 = func;

    sortAndLoadDatQueue_8c011310();
}   

/* TODO: Write tests for this */
void* requestNjPvmPairs_8c012030(char *basedir, char **filenames, int p3) {
    int i = 0;
    char *mem;
    int j;
    char **k;
    char *l;
    char *m;

    while (*filenames[i * 2] || *filenames[i * 2 + 1]) {
        i++;
    }

    mem = syMalloc(++i * 8);

    if (i > 0) {
        for (j = 0; j < i; j++) {
            if (!requestNj_8c011492(basedir, filenames[j * 2], 0, (void *) mem[j * 2 + 1])) {
                *(int *) (mem + j * 2 + 1) = -1;
            }

            if (!requestPvm_8c011ac0(basedir, filenames[j * 2 + 1], (void *) mem[j * 2], p3, 0)) {
                *(int *) (mem + j * 2) = -1;
            }
        }
    }

    mem[i * 2] = 0;
    return mem;
}

/* TODO: Write tests for this */
int FUN_8c0120fe(void **p1) {
    int i;
    NJS_TEXLIST **ptr = *p1;

    if (ptr != (void*) -1) {
        for (i = 0; ptr[i * 2] != 0; i++) {
            if (ptr[i * 2] != (void*) -1) {
                releaseAndFreeTexlist_8c011e3c(ptr[i * 2]);
            }

            if (ptr[i * 2 + 1] != (void*) -1) {
                syFree(ptr[i * 2 + 1]);
            }
        }

        syFree(ptr);
        *p1 = (void *) -1;
    }
}

/* TODO: Write tests for this */
void FUN_8c012160(int p1) {
    var_8c157acc = p1;
}

/* TODO: Write tests for this */
int FUN_8c012166() {
    var_8c157acc = var_8c157acc * 5 + 0xd;
    return var_8c157acc;
}

/* TODO: Write tests for this */
int FUN_8c012178(int p1) {
    if (p1) {
        return FUN_8c012166() % p1;
    }

    return 0;
}

/* TODO: Write tests for this */
void FUN_8c0121a2(int p1) {
    var_8c157ad0 = p1;
}

/* TODO: Write tests for this */
int FUN_8c0121a8() {
    var_8c157ad0 = (var_8c157ad0 >> 1) * 7 + 0xb;
    return var_8c157ad0;
}

/* TODO: Write tests for this */
int FUN_8c0121be(int p1) {
    if (p1) {
        return FUN_8c0121a8() % p1;
    }

    return 0;
}

/* TODO: Write tests for this */
void FUN_8c0121e8() {
    int i;

    for (i = 0; i < 14; i += 2) {
        init_8c03be80[i] = init_8c03be80[i+1];
    }

    // for (i = &init_8c03be80; i < &init_8c03be80[14]; i +=2) {
    //     *i = *(i + 1)
    // }

    if (var_8c1ba1cc[0xcc] != 0) {
        if (var_8c1ba1cc[0xcc] == 1) {
            init_8c03be80[0] = 4;
            init_8c03be80[6] = 0x400; /* init_8c03be98 */
        } else if (var_8c1ba1cc[0xcc] == 2) {
            init_8c03be80[0] = 4;
            init_8c03be80[6] = 2; /* init_8c03be98 */
        }
    }

    for (i = 14; i < 28; i += 2) {
        init_8c03be80[i] = init_8c03be80[i + 1];
    }

    init_8c03be80[22] = 0x40;
    init_8c03be80[24] = 0x80;

    if (var_8c1ba1cc[0xcd] != 0) {
        if (var_8c1ba1cc[0xcd] == 1) {
            init_8c03be80[14] = 4; /* init_8c03beb8 */
            init_8c03be80[20] = 0x400; /* init_8c03bed0 */
        } else if (var_8c1ba1cc[0xcd] == 2) {
            init_8c03be80[14] = 4; /* init_8c03beb8 */
            init_8c03be80[20] = 2; /* init_8c03bed0 */
        }
    }

    if (var_8c1ba1cc[0xce] == 0 || var_8c1ba1cc[0xce] != 1) {
        init_8c03be80[28] = 0x20; /* init_8c03bef0 */
        init_8c03be80[30] = 0x10; /* init_8c03bef8 */
        init_8c03be80[32] = 0x02; /* init_8c03bf00 */
        init_8c03be80[34] = 0x04; /* init_8c03bf08 */
    } else {
        init_8c03be80[28] = 0x02; /* init_8c03bef0 */
        init_8c03be80[30] = 0x04; /* init_8c03bef8 */
        init_8c03be80[32] = 0x20; /* init_8c03bf00 */
        init_8c03be80[34] = 0x30; /* init_8c03bf08 */
    }

    init_8c03be80[36] = 8;

    if (var_8c1ba1cc[0xcf] != 0) {
        init_8c03be80[38] = 0x20;
        init_8c03be80[40] = 0x10;
        init_8c03be80[42] = 2;
        init_8c03be80[46] = 4;
    } else {
        if (var_8c1ba1cc[0xcf] == 1) {
            init_8c03be80[38] = 2;
            init_8c03be80[40] = 4;
        } else {
            if (var_8c1ba1cc[0xcf] != 2) {
                init_8c03be80[38] = 0x20;
                init_8c03be80[40] = 0x10;
                init_8c03be80[42] = 2;
                init_8c03be80[46] = 4;
            } else {
                init_8c03be80[38] = 0x40;
                init_8c03be80[40] = 0x80;
            }
        }
        init_8c03be80[42] = 0x20;
        init_8c03be80[46] = 0x10;
    }

    init_8c03be80[48] = 8;
}
