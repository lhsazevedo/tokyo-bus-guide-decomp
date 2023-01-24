#include "shinobi.h"
#include "_19124_8c014ab4_tasks.h"

void FUN_8c014ab4(Task *tasks)
{
  for (; tasks->action != NULL; tasks++) {
    if ((Uint32) tasks->action != -1) {
      if (tasks->state != NULL) {
        syFree(tasks->state);
      }
      tasks->action = (void *) -1;
    }
  }
}

int pushTask_8c014ae8(Task *tasks, TaskAction action, Task **created_task, void **create_state, size_t alloc_size)
{
  void *state;

  for (; (Uint32) tasks->action != -1; tasks++) {
    if (tasks->action == NULL) {
      return 0;
    }
  }

  if (alloc_size) {
    if ((tasks->state = syMalloc(alloc_size)) == NULL)
      return 0;
  }
  else {
    tasks->state = NULL;
  }

  tasks->action = action;
  *created_task = tasks;
  *create_state = tasks->state;

  return 1;
}

/* TODO */
void FUN_8c014b3e(Uint32 *param_1, Uint32 param_2)
{
  *param_1 = param_2;
}

void execTasks_8c014b42(Task task[]) {
    for (; task->action != NULL; task++) {
        if ((Uint32) task->action != -1) {
            task->action(task, task->state);
        }
    }
}

void freeTask_8c014b66(Task *task)
{
  if (task->state != NULL) {
    syFree(task->state);
  }

  task->action = (void *) -1;
  return;
}
