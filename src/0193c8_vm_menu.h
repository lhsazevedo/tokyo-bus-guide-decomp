#ifndef _VM_MENU_H
#define _VM_MENU_H

#include "sg_xpt.h"
#include "014a9c_tasks.h"

void VmMenuMountVms_1940e();
void VmMenuUnmountVms_194de();
void VmMenuFreeAndClear_19504(void);
int VmMenuUpdateVmusStatus_19550(char **saveNames, Uint16 blocks);
void VmMenuUpdateVmuStatus_1967c(Sint32 drive, char *saveName, Uint16 blocks);
void VmMenuSwitchFromTask_19e44(Task *task);

#endif // _VM_MENU_H
