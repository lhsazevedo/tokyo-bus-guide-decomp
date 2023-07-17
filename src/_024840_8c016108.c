#include <shinobi.h>
#include "_023224_8c015ab8_title.h"

extern ResourceGroup* _8c2263a8;
extern freeResourceGroup_8c0185c4(ResourceGroup* dds);

/* Matched */
void freeResourceGroups_8c016108()
{
    freeResourceGroup_8c0185c4(&menuState_8c1bc7a8.field_0x00);
    freeResourceGroup_8c0185c4(&menuState_8c1bc7a8.drawDatStruct1_0x0c);
    freeResourceGroup_8c0185c4(&_8c2263a8);

    _8c02af32();
    _8c225fb0 = (void *) -1;
}
