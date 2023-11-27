#include <shinobi.h>
#include "_023224_8c015ab8_title.h"

extern void* var_8c225fb0;
extern ResourceGroup* var_8c2263a8;
extern freeResourceGroup_8c0185c4(ResourceGroup* dds);

/* Matched */
void freeResourceGroups_8c016108()
{
    freeResourceGroup_8c0185c4(&menuState_8c1bc7a8.resourceGroupA_0x00);
    freeResourceGroup_8c0185c4(&menuState_8c1bc7a8.resourceGroupB_0x0c);
    freeResourceGroup_8c0185c4(&var_8c2263a8);

    FUN_8c02af32();
    var_8c225fb0 = (void *) -1;
}
