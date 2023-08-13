#include <shinobi.h>
#include <string.h>
#include "_019100_8c014a9c_tasks.h"

extern char* _8c157a80_basedir;
extern int _8c157a88;
extern QueuedDat* _8c157a8c_start;
extern QueuedDat* _8c157a90_current;
extern QueuedDat* _8c157a94_end;
extern int _8c157a98;
extern const char* ptr_str_DATA_EMPTY_8c03be7c;

extern Task* tasks_8c1ba3c8;

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

/* Mathed :) */
int initDatQueue_8c011124(int param) {
    if (param != 0) {
        if ((_8c157a8c_start = syMalloc(param * sizeof(QueuedDat))) == NULL) {
            return 0;
        }

        _8c157a94_end = _8c157a8c_start + param;
    } else {
        _8c157a8c_start = _8c157a94_end = ((void *) -1);
    }

    return 1;
}

/* Matched */
FUN_8c01116a() {
      _8c157a90_current = _8c157a8c_start;
      _8c157a80_basedir = ptr_str_DATA_EMPTY_8c03be7c;
      _8c157a98 = 1;
}

/* Matched */
int request_dat_8c011182(char* basedir, char* filename, void* dest) {
    if (*filename == 0) {
        return 0;
    }

    if (_8c157a90_current >= _8c157a94_end) {
        return 0;
    }

    _8c157a90_current->basedir = basedir;
    _8c157a90_current->filename = filename;
    _8c157a90_current->dest = dest;
    _8c157a90_current->field_0x0c = 0;

    _8c157a90_current++;
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

    switch (task->field_0x08)
    {
    /* 8c0111cc */
    case 0:
        /* 8c0111da */
        while (1) {
            if (qd_r14 >= _8c157a90_current) {
                break;
            }

            if (qd_r14->field_0x0c == 0) {
                if (*qd_r14->basedir != 0 && /* 8c0111ee */
                    strcmp(_8c157a80_basedir, qd_r14->basedir) != 0 /* 8c0111f6 */
                ) {
                        _8c157a80_basedir = qd_r14->basedir;
                        gdFsChangeDir(qd_r14->basedir);
                    // }
                }

                /* 8c01120c */
                task->gdfs_0x0c = gdFsOpen(qd_r14->filename, 0);
                if (task->gdfs_0x0c == NULL) {
                    /* 8c0112f4 (shared) */
                    _8c157a88 = 1;
                    task->queuedDat_0x18++;
                    task->field_0x08 = 0;
                    return;
                }

                /* 8c01121a */
                if (!gdFsGetFileSctSize(task->gdfs_0x0c, &size)) {
                    /* 8c0112f4 (shared) */
                    _8c157a88 = 1;
                    task->queuedDat_0x18++;
                    task->field_0x08 = 0;
                    return;
                }

                /* 8c011226 */
                qd_r14->dest = syMalloc(size * 2048);

                /* 8c011234 */
                if (!gdFsRead(task->gdfs_0x0c, size, qd_r14->dest)) {
                    /* 8c0112f4 (shared) */
                    _8c157a88 = 1;
                    task->queuedDat_0x18++;
                    task->field_0x08 = 0;
                    return;
                }

                /* 8c011282 (shared) */
                gdFsClose(task->gdfs_0x0c);
                qd_r14->field_0x0c = 1;
                task->queuedDat_0x18++;
                task->field_0x08 = 0;
                return;
            }
            qd_r14++;
        }

        /* 8c01124a */
        if (_8c157a88 != 0) {
            /* 8c011250 */
            task->queuedDat_0x18 = _8c157a8c_start;
            _8c157a88 = 0;
            // _8c157a80_basedir = "DATA EMPTY";
            _8c157a80_basedir = ptr_str_DATA_EMPTY_8c03be7c;
            return;
        } else {
            /* 8c011262 */
            _8c157a98 = 1;
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
                    if (gdFsGetTransStat(task->gdfs_0x0c)) {
                        /* 8c0112d6 */
                        gdFsTrans32(task->gdfs_0x0c, 2048, qd_r14->dest);
                    }
                    break;
                } 
                default: {
                    gdFsClose(task->gdfs_0x0c);
                    syFree(qd_r14->dest);
                    /* 8c0112f4 (shared) */
                    _8c157a88 = 1;
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

    if ((int) _8c157a8c_start == (int) _8c157a90_current) {
        return 0;
    }

    /* 8c01132e */
    _8c157a98 = 0;

    temp_r11 = syMalloc((int) _8c157a90_current - (int) _8c157a8c_start);

    /* 8c011340 */
    while (1) {
        int r9 = 0;
        QueuedDat *a_r13 = _8c157a8c_start;
        QueuedDat *b_r14 = _8c157a8c_start;

        /* 8c011376 */
        while (++b_r14 < _8c157a90_current) {
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

    if (!pushTask_8c014ae8(&tasks_8c1ba3c8, &task_8c0111b4, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = _8c157a8c_start;
    created_task->field_0x08 = 0;
    _8c157a88 = 0;
    // _8c157a80_basedir = "DATA EMPTY";
    _8c157a80_basedir = ptr_str_DATA_EMPTY_8c03be7c;

    return 1;
}

/* Matched */
int get_8c157a98_8c0113d2() {
    return _8c157a98;
}

/* Matched */
freeDatQueue_8c0113d8() {
    if (_8c157a8c_start != (QueuedDat*) -1) {
        syFree((void*) _8c157a8c_start);
    }
}
