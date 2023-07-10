#include "shinobi.h"

#ifndef _TASKS_H_
#define _TASKS_H_

typedef void (*TaskAction)(struct Task *task, void *state);

struct Task {
    TaskAction action;
    void *state;
    int field_0x08;
    void* field_0x0c;
    int field_0x10;
    int field_0x14;
    int field_0x18;
    int field_0x1c;
}
typedef Task;

/**
 * @todo Should action be typed?
 */
int pushTask_8c014ae8(Task *tasks, void *action, Task **created_task, void **create_state, size_t alloc_size);

void freeTask_8c014b66(Task *task);

#endif /* _TASKS_H_ */
