#include "includes.h"

void execTasks_8c014b42(Task task[]) {
    for (; task->action != 0; task++) {
        if ((int) task->action != -1) {
            task->action(task, task->state);
        }
    }
}
