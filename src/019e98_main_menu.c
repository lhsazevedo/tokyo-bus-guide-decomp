#include "014a9c_tasks.h"
#include "015ab8_title.h"
#include "011120_asset_queues.h"

/* ====================
 * Compiler Definitions
 * ====================
 */

#ifdef SERIAL_DEBUG
char *DEBUG_mainMenuStateNames[] = {
    "INIT",
};
#endif

#define CHANGE_STATE(x) menuState_8c1bc7a8.state_0x18 = x; LOG_DEBUG(("[VM_MENU] State changed: %s\n", DEBUG_mainMenuStateNames[x]))


/* =================
 * Type Declarations
 * =================
 */

enum MAIN_MENU_STATE {
    MAIN_MENU_STATE_INIT = 0,
};

/* =====================
 * External Declarations
 * =====================
 */

extern void resetUknPvmBool_8c014322();
extern ResourceGroupInfo init_mainMenuResourceGroup_8c044264;

/* =======================
 * Non-initialized Globals
 * =======================
 */

/* ===================
 * Initialized Globals
 * ===================
 */

/* =========
 * Functions
 * =========
 */


void MainMenuTask_8c019e98();

void MainMenuSwitchFromTask_8c01a09a(Task* task) {
    setTaskAction_8c014b3e(task, MainMenuTask_8c019e98);
    menuState_8c1bc7a8.state_0x18 = MAIN_MENU_STATE_INIT;
    menuState_8c1bc7a8.field_0x38 = 0;
    menuState_8c1bc7a8.field_0x5c = 0;
    AsqInitQueues_11f36(8, 0, 0, 8);
    AsqResetQueues_11f6c();
    requestSysResgrp_8c018568(
        &menuState_8c1bc7a8.resourceGroupB_0x0c,
        &init_mainMenuResourceGroup_8c044264
    );
    setUknPvmBool_8c014330();
    AsqProcessQueues_11fe0(
        AsqNop_11120,
        0,
        0,
        0,
        resetUknPvmBool_8c014322
    );
}

void MainMenuTask_8c019e98() {

}
