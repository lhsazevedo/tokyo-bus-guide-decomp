#include <stdarg.h>
#include "scif.h"

#if defined(SERIAL_DEBUG)
void serialprintf(const char *fmt, ...) {
    char buf[256];

    va_list args;
    va_start(args, fmt);
    vsprintf(buf, fmt, args);
    scif_puts(buf);
    va_end(args);
}
#endif
