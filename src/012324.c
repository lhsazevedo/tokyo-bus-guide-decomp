#include <shinobi.h>

extern int var_8c157a78;
extern PDS_PERIPHERAL *var_peripheral_8c1ba358;
extern PDS_PERIPHERAL init_peripheral_8c033318;
extern Uint32 var_vibport_8c1ba354;
extern int var_8c157a70;
extern int var_8c157ad4[4];
extern int var_8c157ae4;
extern int var_8c157ae8;
extern PDS_PERIPHERAL var_peripheral_8c1ba35c[2];

#define DGT_ABXY (PDD_DGT_TA | PDD_DGT_TB | PDD_DGT_TX | PDD_DGT_TY)
#define DGT_UDLR (PDD_DGT_KU | PDD_DGT_KD | PDD_DGT_KL | PDD_DGT_KR)
#define DGT_AB (PDD_DGT_TA | PDD_DGT_TB)

void task_8c012324()
{
    int support;

    var_8c157a78 = 0;
    var_peripheral_8c1ba358 = pdGetPeripheral(0);

    support = var_peripheral_8c1ba358->support & 0xf06fe;
    if (
        (var_peripheral_8c1ba358->info->type & PDD_DEVTYPE_CONTROLLER) ||
        (support == 0xf06fe || support == 0x700fe)
    ) {
        var_peripheral_8c1ba35c[0] = *var_peripheral_8c1ba358;
        if (support == 0xf06fe) {
            if (var_peripheral_8c1ba35c[0].x1 < -64) {
                var_peripheral_8c1ba35c[0].on |= PDD_DGT_KL;
                if ((var_8c157ae4 & PDD_DGT_KL) == 0) {
                    var_peripheral_8c1ba35c[0].press |= PDD_DGT_KL;
                }
                var_8c157ae4 = PDD_DGT_KL;
            }
            else if (var_peripheral_8c1ba35c[0].x1 < 65) {
                var_8c157ae4 = 0;
            }
            else {
                var_peripheral_8c1ba35c[0].on |= PDD_DGT_KR;
                if ((var_8c157ae4 & PDD_DGT_KR) == 0) {
                    var_peripheral_8c1ba35c[0].press |= PDD_DGT_KR;
                }
                var_8c157ae4 = PDD_DGT_KR;
            }
            if (var_peripheral_8c1ba35c[0].y1 < -64) {
                int temp;
                var_peripheral_8c1ba35c[0].on |= PDD_DGT_KU;
                temp = var_8c157ae8 & PDD_DGT_KU;
                var_8c157ae8 = PDD_DGT_KU;
                if (!temp) {
                    var_peripheral_8c1ba35c[0].press |= PDD_DGT_KU;
                }
            }
            else if (var_peripheral_8c1ba35c[0].y1 < 65) {
                var_8c157ae8 = 0;
            }
            else {
                int temp;
                var_peripheral_8c1ba35c[0].on |= PDD_DGT_KD;
                temp = var_8c157ae8 & PDD_DGT_KD;
                var_8c157ae8 = PDD_DGT_KD;
                if (!temp) {
                    var_peripheral_8c1ba35c[0].press |= PDD_DGT_KD;
                }
            }
            if (
                (var_peripheral_8c1ba358->on & PDD_DGT_ST) &&
                (var_peripheral_8c1ba358->press & DGT_ABXY == DGT_ABXY)
            ) {
                var_8c157a78 = 1;
            }
        } else if (
            support == 0x700fe &&
            (
                (var_peripheral_8c1ba358->press & PDD_DGT_ST == 0) ||
                (var_peripheral_8c1ba358->on & DGT_AB != DGT_AB)
            )
        ) {
            var_8c157a78 = 1;
        }
    }
    // Unsupported controller
    else {
        *var_peripheral_8c1ba358 = init_peripheral_8c033318;
        var_vibport_8c1ba354 = -1;
        var_8c157a70 = -1;
    }

    if (var_8c157ad4[0] == 0) {
        if (var_peripheral_8c1ba35c[0].on & DGT_UDLR) {
            var_8c157ad4[0] = 1;
            var_8c157ad4[1] = 0;
            var_8c157ad4[2] = 15;
            var_8c157ad4[3] = 0;
        }
    } else if (var_8c157ad4[0] == 1) {
        if ((var_peripheral_8c1ba35c[0].on & DGT_UDLR)) {
            var_8c157ad4[0] = 0;
        } else {
            if (var_8c157ad4[2] <= ++var_8c157ad4[1]) {
                var_8c157ad4[1] = 0;
                var_8c157ad4[2] = 6;
                var_peripheral_8c1ba35c[0].press |=
                    var_peripheral_8c1ba35c[0].on & DGT_UDLR;
            }
            if (++var_8c157ad4[3] >= 30) {
                var_8c157ad4[2] = 1;
            }
        }
    }

    FUN_8c01c910();
    FUN_adxVol_8c010a40();
}
