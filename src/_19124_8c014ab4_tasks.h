typedef void (*TaskAction)(struct Task *task, void *state);

struct Task {
    TaskAction action;
    void *state;
    int field_0x08;
    int field_0x0c;
    int field_0x10;
    int field_0x14;
    int field_0x18;
    int field_0x1c;
}
typedef Task;

int pushTask_8c014ae8(Task *tasks, TaskAction action, Task **created_task, void **create_state, size_t alloc_size);
