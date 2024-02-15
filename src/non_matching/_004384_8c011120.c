#include <shinobi.h>
#include <string.h>
#include "_019100_8c014a9c_tasks.h"

extern char* var_datQueueBaseDir_8c157a80;
extern int var_8c157a88;
extern QueuedDat* var_datQueue_8c157a8c;
extern QueuedDat* var_datQueueCurrent_8c157a90;
extern QueuedDat* var_datQueueEnd_8c157a94;
extern int var_8c157a98;

extern Task* var_tasks_8c1ba3c8;

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

        var_datQueueEnd_8c157a94 = var_datQueue_8c157a8c + n;
    } else {
        var_datQueue_8c157a8c = var_datQueueEnd_8c157a94 = ((void *) -1);
    }

    return 1;
}

/* Matched */
FUN_8c01116a() {
      var_datQueueCurrent_8c157a90 = var_datQueue_8c157a8c;
      var_datQueueBaseDir_8c157a80 = "DATA EMPTY";
      var_8c157a98 = 1;
}

/* Matched */
int requestDat_8c011182(char* basedir, char* filename, void* dest) {
    if (*filename == 0) {
        return 0;
    }

    if (var_datQueueCurrent_8c157a90 >= var_datQueueEnd_8c157a94) {
        return 0;
    }

    var_datQueueCurrent_8c157a90->basedir = basedir;
    var_datQueueCurrent_8c157a90->filename = filename;
    var_datQueueCurrent_8c157a90->dest = dest;
    var_datQueueCurrent_8c157a90->field_0x0c = 0;

    var_datQueueCurrent_8c157a90++;
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
                // TODO: Test this condition
                if (qd_r14 >= var_datQueueCurrent_8c157a90) {
                    break;
                }

                if (qd_r14->field_0x0c == 0) {
                    // TODO: Test this update
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
                        // TODO: Write test for this
                        var_8c157a88 = 1;
                        task->queuedDat_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    /* 8c01121a */
                    if (!gdFsGetFileSctSize(task->gdfs_0x0c, &size)) {
                        /* 8c0112f4 (shared) */
                        // TODO: Write test for this
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
                        // TODO: Write test for this
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
                return;
            } else {
                /* 8c011262 */
                var_8c157a98 = 1;
                freeTask_8c014b66((Task*) task);
                return;
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

/* Almost matching */
FUN_8c011310() {
    int r9;
    Task *created_task;
    void* created_state;
    QueuedDat *temp_r11;

    if ((int) var_datQueue_8c157a8c == (int) var_datQueueCurrent_8c157a90) {
        return 0;
    }

    /* 8c01132e */
    var_8c157a98 = 0;

    temp_r11 = syMalloc((int) var_datQueueCurrent_8c157a90 - (int) var_datQueue_8c157a8c);

    /* 8c011340 */
    while (1) {
        int r9 = 0;
        QueuedDat *a_r13 = var_datQueue_8c157a8c;
        QueuedDat *b_r14 = var_datQueue_8c157a8c;

        /* 8c011376 */
        while (++b_r14 < var_datQueueCurrent_8c157a90) {
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
freeDatQueue_8c0113d8() {
    if (var_datQueue_8c157a8c != (QueuedDat*) -1) {
        syFree((void*) var_datQueue_8c157a8c);
    }
}
