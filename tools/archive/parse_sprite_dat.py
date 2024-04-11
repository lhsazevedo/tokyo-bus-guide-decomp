# Parse DAT files (sprite ones)

import sys
import os
import struct

if (len(sys.argv) != 2):
    print("parse_dat.py <dat_file>")
    sys.exit(1)

dat_handle = open(sys.argv[1], "rb")
r = dat_handle.read()
dat_handle.close()

print("Size:", len(r), "bytes")

i = 0

while True:
    offset = int.from_bytes(r[i:i+4], 'little')

    if offset == 0:
        break

    print("Offset at " + hex(i) + ":", offset)

    current = offset * 4

    while True:
        if (struct.unpack('<i', r[current:current+4])[0] == -1):
            break

        s = struct.unpack('<iff', r[current:current+12])

        print("Sprite ID:", s[0])
        print("X:", s[1])
        print("Y:", s[2])

        current = current + 12

    i = i+4


