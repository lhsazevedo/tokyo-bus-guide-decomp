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

struct DrawDatStruct1 {
    NJS_TEXLIST *tlist_0x00;
    NJS_TEXANIM *tanim_0x04;
    void *contents_0x08;
    int field_0x0c;
}
typedef DrawDatStruct1;
