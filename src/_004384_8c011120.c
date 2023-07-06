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

// struct s_ukn_00 {
//     QueuedDat* field_0x00;
//     QueuedDat* field_0x04;
//     QueuedDat* field_0x08;
//     int field_0x0c;
// }
// typedef s_ukn_00;

// extern s_ukn_00 _8c157a8c;

extern char* _8c157a80_basedir;
extern void* _8c157a8c_start;
extern QueuedDat* _8c157a90_current;
extern void* _8c157a94_end;
extern int _8c157a98;

extern const char* DATA_EMPTY_8c03334c;

/* Matched :) */
void nop_8c011120() {
    /* Empty body */
}

int FUN_8c011124(Uint32 param) {
    if (param != 0) {
        _8c157a8c_start = syMalloc(param * 16);

        if (_8c157a8c_start == NULL) {
            return 0;
        }

        _8c157a94_end = (Uint8*) _8c157a8c_start + param * 16;
    } else {
        _8c157a94_end = (void *) -1;
        _8c157a8c_start = (void *) -1;
    }

    return 1;
}

/* Matched */
FUN_8c01116a() {
      _8c157a90_current = _8c157a8c_start;
      _8c157a80_basedir = DATA_EMPTY_8c03334c;
      _8c157a98 = 1;
}

int request_dat_8c011182(char* basedir, char* filename, void* dest) {
    if (*filename == 0 || _8c157a90_current >= (QueuedDat *) _8c157a94_end) {
        return 0;
    }

    _8c157a90_current->basedir = basedir;
    _8c157a90_current->filename = filename;
    _8c157a90_current->dest = dest;
    _8c157a90_current->field_0x0c = 0;

    _8c157a90_current++;

    return 1;
}

void task_8c0111b4(Task* task, void* state) {
    QueuedDat* qd = (QueuedDat*) task->field_0x18;
    int size;

    if (task->field_0x08 == 0) {
        for (; qd < _8c157a90_current; qd++) {
            if (qd->field_0x0c == 0) {
                if (*qd->basedir != 0 && strcmp(_8c157a80_basedir, qd->basedir)) {
                    _8c157a80_basedir = qd->basedir;
                    gdFsChangeDir(qd->basedir);
                }
            }

            task->field_0x0c = gdFsOpen(qd->filename, 0);

            if (task->field_0x0c) {
                if (gdFsGetFileSize((GDFS) task->field_0x0c, &size)) {
                    qd->dest = syMalloc(size * 2048);

                    gdFsRead(task->field_0x0c, size, qd->dest);
                }
            }
        }
    } else if (task->field_0x08 == 1) {
        gdFsGetStat((GDFS) task->field_0x0c);
    }
}

FUN_8c011310() {

}

FUN_8c0113d2() {

}

FUN_8c0113d8() {

}
