/*---------------------------------------------------------------------------
  Tokyo Bus Guide
---------------------------------------------------------------------------*/

#include <shinobi.h>

int main(void)
{
    njUserInit();

    while (1) {
        if (njUserMain() < NJD_USER_CONTINUE) break;
        njWaitVSync();
    }

    njUserExit();
}
