typedef enum {FALSE, TRUE} boolean;

#include "ninja.h"

struct Task {
    void (*action)(struct Task *task, void *state);
    void *state;
    int field_0x08;
    int field_0x0c;
    int field_0x10;
    int field_0x14;
    int field_0x18;
    int field_0x1c;
}
typedef Task;
