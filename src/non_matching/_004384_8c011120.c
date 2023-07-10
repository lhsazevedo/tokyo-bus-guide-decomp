#include <shinobi.h>
#include <string.h>
#include "_019100_8c014a9c_tasks.h"

struct QueuedDat {
    char* basedir;
    char* filename;
    void* dest;
    int field_0x0c;
}
typedef QueuedDat;

extern char* _8c157a80_basedir;
extern int _8c157a88;
extern QueuedDat* _8c157a8c_start;
extern QueuedDat* _8c157a8c_start_test;
extern QueuedDat* _8c157a90_current;
extern QueuedDat* _8c157a94_end;
extern int _8c157a98;
extern const char* str_DATA_EMPTY_8c03334c;

extern Task* tasks_8c1ba3c8;

/* Matched :) */
void nop_8c011120() {
    /* Empty body */
}

/* regswap */
int FUN_8c011124(int param) {
    int r;
    if (param != 0) {
        _8c157a8c_start = syMalloc(param * sizeof(QueuedDat));
        if (_8c157a8c_start == NULL) {
            r = 0;
        } else {
            _8c157a94_end = _8c157a8c_start + param;
            r = 1;
        }
    } else {
        _8c157a94_end = (void *) -1;
        _8c157a8c_start = (void *) -1;
        r = 1;
    }

    return r;
}

/* Matched */
FUN_8c01116a() {
      _8c157a90_current = _8c157a8c_start;
      _8c157a80_basedir = str_DATA_EMPTY_8c03334c;
      _8c157a98 = 1;
}

/* Functionally matching, wrong register allocation */
int request_dat_8c011182(char* basedir, char* filename, void* dest) {
    if (*filename == 0) {
        return 0;
    }

    if (_8c157a90_current >= _8c157a94_end) {
        return 0;
    }

    _8c157a90_current->basedir = basedir;
    _8c157a94_end->filename = filename;
    _8c157a94_end->dest = dest;
    _8c157a94_end->field_0x0c = 0;

    _8c157a94_end++;
    return 1;
}

/*
 * Non matching. Depends on the correct number of preceding instructions because
 * of the literal pool placement.
 * Also, there could be some gotos in here.
 */
void task_8c0111b4(Task* task, void* state) {
    /*
     * r13 = Task* task
     * r10 = 1
     */

    /* r14 */
    QueuedDat* qd = (QueuedDat*) task->field_0x18;

    /* stack (r15) */
    Sint32 size;

    switch (task->field_0x08)
    {
    /* 8c0111cc */
    case 0:
        /* 8c0111da
         * r2 = _8c157a90_current
         * r12 = 8c157a80_basedir
         */
        for (; qd < _8c157a90_current; qd++) {
            /* 8c0111e4 */
            if (qd->field_0x0c != 0) {
                continue;
            }

            if (
                *qd->basedir != 0 /* 8c0111ee */
                && !strcmp(_8c157a80_basedir, qd->basedir) /* 8c0111f6 */
            ) {
                /* 8c011202 */
                _8c157a80_basedir = qd->basedir;
                gdFsChangeDir(qd->basedir);
            }

            /* 8c01120c */
            if (! (task->field_0x0c = gdFsOpen(qd->filename, 0))) {
                /* 8c0112e6 */
                gdFsClose(task->field_0x0c);
                syFree(qd->dest);

                /* 8c0112f4 (shared) */
                _8c157a88 = 1;

                /* 8c0112f6 (shared) */
                task->field_0x18 = 16;
                task->field_0x08 = 0;
                return;
            }

            /* 8c01121a */
            if (!gdFsGetFileSize(task->field_0x0c, &size)) {
                /* 8c0112f4 (shared) */
                _8c157a88 = 1;

                /* 8c0112f6 (shared) */
                task->field_0x18 = 16;
                task->field_0x08 = 0;
            }

            /* 8c011230 */
            qd->dest = syMalloc(size * 2014);

            /* 8c01123e */
            if (gdFsRead(task->field_0x0c, size, qd->dest) != GDD_ERR_OK) {
                /* 8c0112f4 (shared) */
                _8c157a88 = 1;

                /* 8c0112f6 (shared) */
                task->field_0x18 = 16;
                task->field_0x08 = 0;
            }

            /* 8c011282 (shared) */
            gdFsClose(task->field_0x0c);
            qd->field_0x0c = 1;

            /* 8c0112f6 (shared) */
            task->field_0x18 = 16;
            task->field_0x08 = 0;
            return;
        }

        /* 8c01124a */
        if (_8c157a88 != 0) {
            /* 8c011250 */
            (void *) task->field_0x18 = _8c157a8c_start;
            _8c157a88 = 0;
            _8c157a80_basedir = str_DATA_EMPTY_8c03334c;
        } else {
            /* 8c011262 */
            _8c157a98 = 1;
            freeTask_8c014b66(task);
        }
        break;
    
    /* 8c0111d2 */
    case 1:
        /* 8c011270 */
        if (gdFsGetStat(task->field_0x0c) == GDD_STAT_COMPLETE) {
            /* 8c011282 (shared) */
            gdFsClose(task->field_0x0c);
            qd->field_0x0c = 1;

            /* 8c0112f6 (shared) */
            task->field_0x18 = 16;
            task->field_0x08 = 0;
            return;
        } else if (gdFsGetStat(task->field_0x0c) == GDD_STAT_READ) { /* 8c01127a */
            /* 8c0112cc */
            if (gdFsGetTransStat(task->field_0x0c)) {
                /* 8c0112d6 */
                gdFsTrans32(task->field_0x0c, 2048, qd->dest);
            }
        }
        break;

    default:
        return;
    }
}

FUN_8c011310() {
    /*
     * r12 = _8c157a8c_start
     * r8 = _= _8c157a90_current
     */
    int r9;
    void* temp_r11;
    Task* created_task;
    void* created_state;

    if (_8c157a8c_start == _8c157a90_current) {
        return 0;
    }

    /* 8c01132e
     * r10 = 0
     */
    _8c157a98 = 0;
    temp_r11 = syMalloc(_8c157a90_current - _8c157a8c_start);

    /* 8c011340
     * r9 = 0
     * r13 = r14 = _8c157a8c
     */
    do {
        QueuedDat* r13 = _8c157a8c_start;
        QueuedDat* r14 = _8c157a8c_start;
        r9 = 0;

        /* 8c011376 */
        while (++r14 >= _8c157a90_current) {
            /* 8c011348 */
            if (strcmp(r13->filename, r14->filename) > 0) {
                /* 8c011354 */
                memcpy(temp_r11, r13, sizeof(QueuedDat));
                memcpy(r13, r14, sizeof(QueuedDat));
                memcpy(r14, temp_r11, sizeof(QueuedDat));
                r9 = 1;
            }

            /* 8c011374 */
            r13++;
        }
    } while (r9 != 0); /* 8c011374 */

    /* 8c011382
     * r4 = _8c1ba3c8
     */
    syFree(temp_r11);

    if (pushTask_8c014ae8(tasks_8c1ba3c8, task_8c0111b4, &created_task, &created_state, 0)) {
        return 0;
    }

    created_task->field_0x18 = (int) _8c157a8c_start;
    created_task->field_0x08 = 0;
    _8c157a88 = 0;
    _8c157a80_basedir = str_DATA_EMPTY_8c03334c;

    return 1;
}

/* Matched */
int FUN_8c0113d2() {
    return _8c157a98;
}

/* Matched */
FUN_8c0113d8() {
    if (_8c157a8c_start != (QueuedDat*) -1) {
        syFree((void*) _8c157a8c_start);
    }
}
