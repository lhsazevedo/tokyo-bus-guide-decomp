typedef enum {FALSE, TRUE} boolean;

struct Task {
    void (*callback_0x00) (void);
    void *allocated_0x04;
    // Size: 0x20
}
typedef Task;

struct QueuedDat {
    char *basepath;
    char *filename;
    void *dest;
    boolean *complete;
}
typedef QueuedDat;

struct UknDatStruct {
    void *func_0x00;
    void *funcparam_0x04;
    void field_0x08;
    GDFS *gdfs_0x0c;
    // ...
    void queued_dat_0x18;
};
typedef UknDatStruct;

struct UknDatStruct2 {
    void *field_0x00;
    void *field_0x04;
    char *contents;
};
typedef UknDatStruct2;

struct DatFileUknStruct1 {
    int *field_0x00;
    float float_1;
    float float_2;
}
typedef DatFileUknStruct1;

struct ResourceGroup
{
    char *parts;
    char *dat;
    char *pvm;
    size_t text_count;
};
typedef ResourceGroup;
