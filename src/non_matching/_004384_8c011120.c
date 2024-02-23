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
    char* basedir;
    char* filename;
    void** dest_0x08;
    void** dest_0x0c;
    int field_0x10;
}
typedef QueuedNj;

/* TODO: Same struct as Task, but with QueuedNj.
Perhaps we should use a union or a void* to handle both cases? */
typedef struct {
    TaskAction action;
    void *state;
    int field_0x08;
    GDFS gdfs_0x0c;
    int field_0x10;
    int field_0x14;
    QueuedNj* queuedNj_0x18;
    int field_0x1c;
} _8c0114cc_Task;

struct UnknownStructA {
    int basedir_0x00;
    int field_0x04;
}
typedef UnknownStructA;

extern char* var_datQueueBaseDir_8c157a80;
extern int var_8c157a88;
extern QueuedDat* var_datQueue_8c157a8c;
extern QueuedDat* var_datQueueRear_8c157a90;
extern QueuedDat* var_datQueueTail_8c157a94;
extern int var_8c157a98;

extern QueuedNj* var_njQueue_8c157a9c;
extern QueuedNj* var_njQueueRear_8c157aa0;
extern QueuedNj* var_njQueueTail_8c157aa4;
extern int var_8c157aa8;

extern Task* var_tasks_8c1ba3c8;

extern UnknownStructA* var_uknQueue_8c157aac;
extern UnknownStructA* var_uknQueueCursor_8c157ab0;
extern UnknownStructA* var_uknQueueTail_8c157ab4;
extern int var_8c157a68;
extern int var_8c157ab8;

extern Sint8 *var_8c157a84;
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
} _8c0111b4_Task;

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
void FUN_8c01116a() {
    var_datQueueRear_8c157a90 = var_datQueue_8c157a8c;
    var_datQueueBaseDir_8c157a80 = "DATA EMPTY";
    var_8c157a98 = 1;
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
void task_8c0111b4(_8c0111b4_Task* task, void* state) {
    /*
     * r13 = Task* task
     * r10 = 1
     */

    /* r14 */
    QueuedDat* qd_r14 = task->queuedDat_0x18;

    /* stack (r15) */
    Sint32 size;

    // Sint32 stat;

    switch (task->field_0x08) {
        /* 8c0111cc */
        case 0:
            /* 8c0111da */
            while (1) {
                /* TODO: Test this condition */
                if (qd_r14 >= var_datQueueRear_8c157a90) {
                    break;
                }

                if (qd_r14->field_0x0c == 0) {
                    /* TODO: Test this update */
                    if (*qd_r14->basedir != 0 && /* 8c0111ee */
                        strcmp(var_datQueueBaseDir_8c157a80, qd_r14->basedir) != 0 /* 8c0111f6 */
                    ) {
                            var_datQueueBaseDir_8c157a80 = qd_r14->basedir;
                            gdFsChangeDir(qd_r14->basedir);
                        // }
                    }

                    /* 8c01120c */
                    task->gdfs_0x0c = gdFsOpen(qd_r14->filename, 0);
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
                    *qd_r14->dest = syMalloc(size * 2048);

                    /* 8c011234 */
                    if (gdFsRead(task->gdfs_0x0c, size, *qd_r14->dest) != GDD_ERR_OK) {
                        /* 8c0112f4 (shared) */
                        /* TODO: Write test for this */
                        var_8c157a88 = 1;
                        task->queuedDat_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    /* 8c011282 (shared) */
                    gdFsClose(task->gdfs_0x0c);
                    qd_r14->field_0x0c = 1;
                    task->queuedDat_0x18 = ++qd_r14;
                    task->field_0x08 = 0;
                    return;
                }
                qd_r14++;
            }

            /* 8c01124a */
            if (var_8c157a88 != 0) {
                /* 8c011250 */
                task->queuedDat_0x18 = var_datQueue_8c157a8c;
                var_8c157a88 = 0;
                var_datQueueBaseDir_8c157a80 = "DATA EMPTY";
                /* return */;
            } else {
                /* 8c011262 */
                var_8c157a98 = 1;
                freeTask_8c014b66((Task*) task);
                /* return; */
            }
            break;

        /* 8c0111d2 */
        case 1:
            /* 8c011270 */
            switch (gdFsGetStat(task->gdfs_0x0c)) {
                case GDD_STAT_COMPLETE: {
                    /* 8c011282 (shared) */
                    gdFsClose(task->gdfs_0x0c);
                    qd_r14->field_0x0c = 1;
                    task->queuedDat_0x18++;
                    task->field_0x08 = 0;
                    return;
                } 
                case GDD_STAT_READ: { /* 8c01127a */
                    /* 8c0112cc */
                    if (gdFsGetTransStat(task->gdfs_0x0c) == GDD_FS_TRANS_READY) {
                        /* 8c0112d6 */
                        gdFsTrans32(task->gdfs_0x0c, 2048, *qd_r14->dest);
                    }
                    break;
                } 
                default: {
                    gdFsClose(task->gdfs_0x0c);
                    syFree(qd_r14->dest);
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

/* Tested */
int sortDatQueueAndPushUnknownTask_8c011310() {
    int r9;
    Task *created_task;
    void* created_state;
    QueuedDat *temp_r11;

    if ((int) var_datQueue_8c157a8c == (int) var_datQueueRear_8c157a90) {
        return 0;
    }

    /* 8c01132e */
    var_8c157a98 = 0;

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

    if (!pushTask_8c014ae8(&var_tasks_8c1ba3c8, &task_8c0111b4, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = var_datQueue_8c157a8c;
    created_task->field_0x08 = 0;
    var_8c157a88 = 0;
    var_datQueueBaseDir_8c157a80 = "DATA EMPTY";

    return 1;
}

/* Matched */
int get_8c157a98_8c0113d2() {
    return var_8c157a98;
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
void FUN_8c01147a() {
    var_njQueueRear_8c157aa0 = var_njQueue_8c157a9c;
    var_datQueueBaseDir_8c157a80 = "DATA EMPTY";
    var_8c157aa8 = 1;
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
void task_8c0114cc(_8c0114cc_Task* task, void* state) {
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
                        strcmp(var_datQueueBaseDir_8c157a80, qnj->basedir) != 0
                    ) {
                        var_datQueueBaseDir_8c157a80 = qnj->basedir;
                        gdFsChangeDir(qnj->basedir);
                    }

                    task->gdfs_0x0c = gdFsOpen(qnj->filename, 0);

                    if (task->gdfs_0x0c == NULL) {
                        /* 8c01168c (shared) */
                        if (var_8c157a84 != &var_texbuf_8c277ca0) {
                            syFree(var_8c157a84);
                        }
                        var_8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (!gdFsGetFileSctSize(task->gdfs_0x0c, &size)) {
                        /* 8c01168c (shared) */
                        if (var_8c157a84 != var_texbuf_8c277ca0) {
                            syFree(var_8c157a84);
                        }
                        var_8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (size > 0x100) {
                        var_8c157a84 = syMalloc(size * 2048);
                    } else {
                        var_8c157a84 = var_texbuf_8c277ca0;
                    }

                    if (gdFsRead(task->gdfs_0x0c, size, var_8c157a84) != GDD_ERR_OK) {
                        /* 8c01168c (shared) */
                        if (var_8c157a84 != var_texbuf_8c277ca0) {
                            syFree(var_8c157a84);
                        }
                        var_8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return; 
                    }

                    gdFsClose(task->gdfs_0x0c);
                    qnj->field_0x10 = 1;

                    if (qnj->dest_0x08 != 0) {
                        *qnj->dest_0x08 = njReadBinary(var_8c157a84, &fpos, &rtype);
                    }

                    if (qnj->dest_0x0c != 0) {
                        *qnj->dest_0x0c = njReadBinary(var_8c157a84, &fpos, &rtype);
                    }

                    if (var_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_8c157a84);
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
                var_datQueueBaseDir_8c157a80 = "DATA EMPTY";
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
                        *qnj->dest_0x08 = njReadBinary(var_8c157a84, &fpos, &rtype);
                    }

                    if (qnj->dest_0x0c) {
                        *qnj->dest_0x0c = njReadBinary(var_8c157a84, &fpos, &rtype);
                    }

                    if (var_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_8c157a84);
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

                    gdFsTrans32(task->gdfs_0x0c, 2048, var_8c157a84);
                    break;
                }
                default: {
                    gdFsClose(task->gdfs_0x0c);
                    if (var_8c157a84 != var_texbuf_8c277ca0) {
                        syFree(var_8c157a84);
                    }

                    var_8c157a88 = 1;
                    // TODO: Test this with other item indexes
                    task->queuedNj_0x18 = ++qnj;
                    task->field_0x08 = 0;
                    break;
                }
            }
            break;
        }
}

int sortNjQueueAndPushUnknownTask_8c0116b6() {
    Task *created_task;
    void* created_state;
    QueuedNj *temp;

    if ((int) var_njQueue_8c157a9c == (int) var_njQueueRear_8c157aa0) {
        return 0;
    }

    /* 8c01132e */
    var_8c157aa8 = 0;

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

    if (!pushTask_8c014ae8(&var_tasks_8c1ba3c8, &task_8c0114cc, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = var_njQueue_8c157a9c;
    created_task->field_0x08 = 0;
    var_8c157a88 = 0;
    var_datQueueBaseDir_8c157a80 = "DATA EMPTY";

    return 1;
}

/* Matched */
int get8c157aa8_8c01179e() {
    return var_8c157aa8;
}

/* Matched? */
freeNjQueue_8c0117a4() {
    if (var_njQueue_8c157a9c != (QueuedNj*) -1) {
        syFree(var_njQueue_8c157a9c);
    }
}

/* Tested */
int alloc8c157aac_8c0117b8(int n) {
  if (n != 0) {
    var_uknQueue_8c157aac = syMalloc(n * sizeof(UnknownStructA));
    if (var_uknQueue_8c157aac == NULL) {
      return 0;
    }
    var_uknQueueTail_8c157ab4 = (void *) ((char*) var_uknQueue_8c157aac + n * sizeof(UnknownStructA));
  } else {
    var_uknQueueTail_8c157ab4 = (void *) -1;
    var_uknQueue_8c157aac = (void *) -1;
  }
  return 1;
}

/* Tested */
void FUN_8c0117fe() {
    var_uknQueueCursor_8c157ab0 = var_uknQueue_8c157aac;
    var_datQueueBaseDir_8c157a80 = "DATA EMPTY";
    var_8c157a68 = 0;
    var_8c157ab8 = 1;
    return;
}

/* Tested */
/* Param 2 looks like a struct */
int requestUnknownStruct_8c01181c(int basedir, int param_2) {
  if (var_uknQueueCursor_8c157ab0 >= var_uknQueueTail_8c157ab4) {
    return 0;
  }

  var_uknQueueCursor_8c157ab0->basedir_0x00 = basedir;
  var_uknQueueCursor_8c157ab0->field_0x04 = param_2;
  var_uknQueueCursor_8c157ab0++;
  return 1;
}
