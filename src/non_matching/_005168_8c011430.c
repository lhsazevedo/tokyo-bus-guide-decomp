#include <shinobi.h>
#include <string.h>
#include "_019100_8c014a9c_tasks.h"

struct QueuedNj {
    char* basedir;
    char* filename;
    void** dest_0x08;
    void** dest_0x0c;
    int field_0x10;
}
typedef QueuedNj;

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

extern char *_8c157a80_basedir;
extern void *_8c157a84;
extern int _8c157a88;

extern QueuedNj* queuedNjFiles_8c157a9c;
extern QueuedNj* queuedNjFilesCursor_8c157aa0;
extern QueuedNj* queuedNjFilesEnd_8c157aa4;
extern int var_8c157aa8;
extern void *_8c227ca0;

extern const char* ptr_str_DATA_EMPTY_8c03be7c;

/* Matched */
int initNjQueue_8c011430(int param) {
    if (param != 0) {
        if ((queuedNjFiles_8c157a9c = syMalloc(param * sizeof(QueuedNj))) == NULL) {
            return 0;
        }

        queuedNjFilesEnd_8c157aa4 = queuedNjFiles_8c157a9c + param;
    } else {
        queuedNjFiles_8c157a9c = queuedNjFilesEnd_8c157aa4 = ((void *) -1);
    }

    return 1;
}

/* Matched */
FUN_8c01147a() {
    queuedNjFilesCursor_8c157aa0 = queuedNjFiles_8c157a9c;
    _8c157a80_basedir = ptr_str_DATA_EMPTY_8c03be7c;
    var_8c157aa8 = 1;
}

/* Matched */
int requestNj_8c011492(char* basedir, char* filename, void* dest, void* dest2) {
    if (*filename == 0) {
        return 0;
    }

    if (queuedNjFilesCursor_8c157aa0 >= queuedNjFilesEnd_8c157aa4) {
        return 0;
    }

    queuedNjFilesCursor_8c157aa0->basedir = basedir;
    queuedNjFilesCursor_8c157aa0->filename = filename;
    queuedNjFilesCursor_8c157aa0->dest_0x08 = dest;
    queuedNjFilesCursor_8c157aa0->dest_0x0c = dest2;
    queuedNjFilesCursor_8c157aa0->field_0x10 = 0;

    queuedNjFilesCursor_8c157aa0++;
    return 1;
}

/* wip */
void task_8c0114cc(_8c0114cc_Task* task, void* state) {
    QueuedNj* qnj = task->queuedNj_0x18;
    Sint32 size;
    Uint32 fpos, rtype;

    switch (task->field_0x08)
    {
    case 0:
        while (1)
        {
            if (qnj < queuedNjFilesCursor_8c157aa0) {
                if (qnj->field_0x10 == 0) {
                    if (*qnj->basedir != 0 &&
                    strcmp(_8c157a80_basedir, qnj->basedir) != 0
                    ) {
                        _8c157a80_basedir = qnj->basedir;
                        gdFsChangeDir(qnj->basedir);
                    }

                    task->gdfs_0x0c = gdFsOpen(qnj->filename, 0);
                    if (task->gdfs_0x0c == NULL) {
                        /* 8c01168c (shared) */
                        if (_8c157a84 != _8c227ca0) {
                            syFree(_8c157a84);
                        }
                        _8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (!gdFsGetFileSctSize(task->gdfs_0x0c, &size)) {
                        /* 8c01168c (shared) */
                        if (_8c157a84 != _8c227ca0) {
                            syFree(_8c157a84);
                        }
                        _8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return;
                    }

                    if (size > 0x100) {
                        _8c157a84 = syMalloc(size * 2048);
                    } else {
                        _8c157a84 = _8c227ca0;
                    }

                    if (!gdFsRead(task->gdfs_0x0c, size, _8c157a84)) {
                        /* 8c01168c (shared) */
                        if (_8c157a84 != _8c227ca0) {
                            syFree(_8c157a84);
                        }
                        _8c157a88 = 1;
                        task->queuedNj_0x18++;
                        task->field_0x08 = 0;
                        return; 
                    }

                    gdFsClose(task->gdfs_0x0c);
                    qnj->field_0x10 = 1;
                    task->queuedNj_0x18++;

                    if (qnj->dest_0x08 != 0) {
                        *qnj->dest_0x08 = njReadBinary(_8c157a84, &fpos, &rtype);
                    }

                    if (qnj->dest_0x0c != 0) {
                        *qnj->dest_0x0c = njReadBinary(_8c157a84, &fpos, &rtype);
                    }

                    if (_8c157a84 != _8c227ca0) {
                        syFree(_8c157a84);
                    }
                    task->queuedNj_0x18++;
                    task->field_0x08 = 0;
                    return;
                }
            }

            qnj++;
        }
        
        break;
    
    default:
        break;
    }
}

/* Matched */
int get8c157aa8_8c01179e() {
    return var_8c157aa8;
}

/* Matched? */
freeNjQueue_8c0117a4() {
    if (queuedNjFiles_8c157a9c != (QueuedNj*) -1) {
        syFree(queuedNjFiles_8c157a9c);
    }
}
