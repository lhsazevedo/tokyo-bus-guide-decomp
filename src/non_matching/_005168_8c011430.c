#include <shinobi.h>
#include <string.h>
#include "_019100_8c014a9c_tasks.h"

struct QueuedNj {
    char* basedir;
    char* filename;
    void* dest;
    int field_0x0c;
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

extern char* _8c157a80_basedir;
extern int _8c157a88;
extern QueuedNj* queuedNjFiles_8c157a9c;
extern QueuedNj* queuedNjFilesCursor_8c157aa0;
extern QueuedNj* queuedNjFilesEnd_8c157aa4;
extern int _8c157aa8;
extern const char* ptr_str_DATA_EMPTY_8c03be7c;

/* Matched */
int initNjQueue(int param) {
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
    _8c157aa8 = 1;
}

/* Matched */
int requestNj_8c011492(char* basedir, char* filename, void* dest, int r7) {
    if (*filename == 0) {
        return 0;
    }

    if (queuedNjFilesCursor_8c157aa0 >= queuedNjFilesEnd_8c157aa4) {
        return 0;
    }

    queuedNjFilesCursor_8c157aa0->basedir = basedir;
    queuedNjFilesCursor_8c157aa0->filename = filename;
    queuedNjFilesCursor_8c157aa0->dest = dest;
    queuedNjFilesCursor_8c157aa0->field_0x0c = r7;
    queuedNjFilesCursor_8c157aa0->field_0x10 = 0;

    queuedNjFilesCursor_8c157aa0++;
    return 1;
}

/*  */
void task_8c0114cc(_8c0114cc_Task* task, void* state) {
    
}

/* Matched */
int FUN_8c01179e() {
    return _8c157aa8;
}

/* Matched? */
FUN_8c0117a4() {
    if (queuedNjFiles_8c157a9c != (QueuedNj*) -1) {
        syFree(queuedNjFiles_8c157a9c);
    }
}
