#include "includes.h"

extern void pushTask_8c014ae8();
extern void fadein_8c022a54();
extern Task tasks_8c1ba3c8[16];
extern int is_fading_8c226568;
extern int _8c227d80;

// MATCHING
void push_fadein_8c022a9c(int duration) {
    Task *task;
    void *state;
    int dur = duration;

    pushTask_8c014ae8(tasks_8c1ba3c8, fadein_8c022a54, &task, &state, 0);

    task->field_0x08 = dur;
    _8c227d80 = 0xff000000;
    is_fading_8c226568 = 1;
}
