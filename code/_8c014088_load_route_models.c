#include "includes.h"

typedef enum {
    Noon,
    Afternoon,
    Evening
} TimeOfDay;

struct Route {
    int location_0x04;
    TimeOfDay time_of_day_0x04;
    void *ptr_0x08;
    void *ptr_0x0c;
    void *ptr_0x10;
    int int_0x14;
    int int_0x18;
    void *nj_0x1c;
    void *nj_0x20;
    void *ptr_0x24;
    void *nj_0x28;
    void *nj_0x2c;
    void *nj_0x30;
    void *nj_0x34;
    void *nj_0x38;
    void *dat_0x3c;
    void *nj_0x40;
    void *nj_0x44;
    void *dat_0x48;
    void *dat_0x4c;
    void *dat_0x50;
    void *nj_0x54;
    void *nj_0x58;
    void *nj_0x5c;
    void *nj_0x60;
    void *nj_0x64;
}
typedef Route; 

int *_8c1bb868;
Route **_8c043ca4;
Route *route_8c18ad18;
int *route_location_8c18ad1c;
int *route_time_of_day_8c18ad20;

char route_common_dir_copy_8c18ad2c[32];
char route_pvr_dir_8c18ad4c[32];
char route_common_dir_8c18ad6c[32];
char route_common_dir_copy_8c18ad8c[32];


void *_8c1bb874;


void load_route_models_8c014088() {
    Route *route = *(_8c043ca4 + *_8c1bb868);
    route_8c18ad18 = route;
    int location = route->location_0x04;
    TimeOfDay time_of_day = route->time_of_day_0x04;
    *route_location_8c18ad1c = location;
    *route_time_of_day_8c18ad20 = route->time_of_day_0x04;
    char *pvr_dir;

    if (location == 0) {
        if ((time_of_day == Noon) || (time_of_day == Afternoon)) {
            prob_strcpy_8c03011c(route_common_dir_8c18ad6c, "\\SD_COMMON");
            pvr_dir = "\\SD_PVR";
        } else if (time_of_day == Evening) {
            prob_strcpy_8c03011c(route_common_dir_8c18ad6c, "\\SN_COMMON");
            pvr_dir = "\\SN_PVR";
        }
        prob_strcpy_8c03011c(route_pvr_dir_8c18ad4c, pvr_dir);
    } else if (location == 1) {
        if ((time_of_day == Noon) || (time_of_day == Afternoon)) {
            prob_strcpy_8c03011c(route_common_dir_8c18ad6c, "\\WD_COMMON");
            pvr_dir = "\\WD_PVR";
        } else if (time_of_day == Evening) {
            prob_strcpy_8c03011c(route_common_dir_8c18ad6c, "\\WN_COMMON");
            pvr_dir = "\\WN_PVR";
        }
        prob_strcpy_8c03011c(route_pvr_dir_8c18ad4c, pvr_dir);
    } else if (location == 2) {
        if ((time_of_day == Noon) || (time_of_day == Afternoon)) {
            prob_strcpy_8c03011c(route_common_dir_8c18ad6c, "\\OD_COMMON");
            pvr_dir = "\\OD_PVR";
        } else if (time_of_day == Evening) {
            prob_strcpy_8c03011c(route_common_dir_8c18ad6c, "\\ON_COMMON");
            pvr_dir = "\\ON_PVR";
        }
        prob_strcpy_8c03011c(route_pvr_dir_8c18ad4c, pvr_dir);
    }

    prob_strcpy_8c03011c(route_common_dir_copy_8c18ad8c, route_common_dir_8c18ad6c);
    prob_strcpy_8c03011c(route_common_dir_copy_8c18ad2c, route_common_dir_8c18ad6c);

    request_nj(route_common_dir_8c18ad6c, route->nj_0x1c, , 0);
    request_nj(route_common_dir_8c18ad6c, route->nj_0x20, , 0);
    _8c1bb874 = route->ptr_0x24;
    request_nj(route_common_dir_8c18ad6c, route->nj_0x28, , 0);
    request_nj(route_common_dir_8c18ad6c, route->nj_0x2c, , 0);
    request_nj(route_common_dir_8c18ad6c, route->nj_0x30, , 0);
    request_nj(route_common_dir_8c18ad6c, route->nj_0x34, , 0);
    request_nj(route_common_dir_8c18ad6c, route->nj_0x38, , 0);

    // ...

    request_some_files_8c013ae8();


}
