#include "includes.h"

extern void *_8c012030();
extern void request_nj_8c011492();
extern void AsqRequestDat_11182();
extern void request_some_files_8c013ae8();
extern char *strcpy_8c03011c();

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
    char *nj_0x1c;
    char *nj_0x20;
    char *ptr_0x24;
    char *nj_0x28;
    char *nj_0x2c;
    char *nj_0x30;
    char *nj_0x34;
    char *nj_0x38;
    char *dat_0x3c;
    char *nj_0x40;
    char *nj_0x44;
    char *dat_0x48;
    char *dat_0x4c;
    char *dat_0x50;
    char *nj_0x54;
    char *nj_0x58;
    char *nj_0x5c;
    char *nj_0x60;
    char *nj_0x64;
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

void *_8c1bb86c;
void *_8c1bb870;
void *_8c1bb878;
void *_8c1bb87c;
void *_8c1bb880;
void *_8c1bb884;
void *_8c1bb888;
void *_8c1bb890;
void *_8c1bb894;
void *_8c1bb8a4;
void *_8c1bb8a8;
void *_8c1bb8ac;
void *_8c1bb8b0;
void *_8c1bb8b4;


void *_8c1bb874;

void *_8c1bc3ec;


void load_route_models_8c014088() {
    char *pvr_dir;
    Route *route;
    int location;
    TimeOfDay time_of_day;

    route_8c18ad18 = *(_8c043ca4 + *_8c1bb868);
    // route = *(_8c043ca4 + *_8c1bb868);
    // location = route->location_0x04;
    // time_of_day = route->time_of_day_0x04;

    // route_8c18ad18 = *(_8c043ca4 + *_8c1bb868);
    // *route_location_8c18ad1c = route_8c18ad18->location_0x04;
    // *route_time_of_day_8c18ad20 = route_8c18ad18->time_of_day_0x04;

    route_8c18ad18 = route;
    *route_location_8c18ad1c = location;
    *route_time_of_day_8c18ad20 = route->time_of_day_0x04;

    if (location == 0) {
        if ((time_of_day == Noon) || (time_of_day == Afternoon)) {
            strcpy_8c03011c(route_common_dir_8c18ad6c, "\\SD_COMMON");
            pvr_dir = "\\SD_PVR";
        } else if (time_of_day == Evening) {
            strcpy_8c03011c(route_common_dir_8c18ad6c, "\\SN_COMMON");
            pvr_dir = "\\SN_PVR";
        }
        strcpy_8c03011c(route_pvr_dir_8c18ad4c, pvr_dir);
    }
    else if (location == 1) {
        if ((time_of_day == Noon) || (time_of_day == Afternoon)) {
            strcpy_8c03011c(route_common_dir_8c18ad6c, "\\WD_COMMON");
            pvr_dir = "\\WD_PVR";
        } else if (time_of_day == Evening) {
            strcpy_8c03011c(route_common_dir_8c18ad6c, "\\WN_COMMON");
            pvr_dir = "\\WN_PVR";
        }
        strcpy_8c03011c(route_pvr_dir_8c18ad4c, pvr_dir);
    }
    else if (location == 2) {
        if ((time_of_day == Noon) || (time_of_day == Afternoon)) {
            strcpy_8c03011c(route_common_dir_8c18ad6c, "\\OD_COMMON");
            pvr_dir = "\\OD_PVR";
        } else if (time_of_day == Evening) {
            strcpy_8c03011c(route_common_dir_8c18ad6c, "\\ON_COMMON");
            pvr_dir = "\\ON_PVR";
        }
        strcpy_8c03011c(route_pvr_dir_8c18ad4c, pvr_dir);
    }

    strcpy_8c03011c(route_common_dir_copy_8c18ad8c, route_common_dir_8c18ad6c);
    strcpy_8c03011c(route_common_dir_copy_8c18ad2c, route_common_dir_8c18ad6c);

    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x1c, &_8c1bb86c, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x20, &_8c1bb870, 0);
    _8c1bb874 = route->ptr_0x24;
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x28, &_8c1bb878, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x2c, &_8c1bb87c, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x30, &_8c1bb880, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x34, &_8c1bb884, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x38, &_8c1bb888, 0);

    AsqRequestDat_11182(route_common_dir_8c18ad6c, route->dat_0x3c, 0x8c, 0);

    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x40, &_8c1bb890, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x44, 0,&_8c1bb894);

    AsqRequestDat_11182(route_common_dir_8c18ad6c, route->dat_0x48, 0x98, 0x94);
    AsqRequestDat_11182(route_common_dir_8c18ad6c, route->dat_0x4c, 0x9c, 0x94);
    AsqRequestDat_11182(route_common_dir_8c18ad6c, route->dat_0x50, 0xa0, 0x94);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x54, &_8c1bb8a4, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x58, &_8c1bb8a8, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x5c, &_8c1bb8ac, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x60, &_8c1bb8b0, 0);
    request_nj_8c011492(route_common_dir_8c18ad6c, route->nj_0x64, &_8c1bb8b4, 0);

    request_some_files_8c013ae8();
    _8c1bc3ec = _8c012030(route_common_dir_8c18ad6c, "signal00.njd", 0x10);
}
