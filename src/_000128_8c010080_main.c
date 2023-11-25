/*---------------------------------------------------------------------------
  Tokyo Bus Guide
---------------------------------------------------------------------------*/

#include <shinobi.h>

int main(void)
{
    njUserInit_8c0134ec();

    while (1) {
        if (njUserMain_8c01392e() < NJD_USER_CONTINUE) break;
        njWaitVSync();
    }

    njUserExit_8c0139d4();
}
