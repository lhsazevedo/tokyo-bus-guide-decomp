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

offset = int.from_bytes(r[0:4], 'little')
print("Offset at 0x0:", offset)

i = 0
current = offset * 4
while True:
    s = struct.unpack('<iff', r[current:current+12])
    if s[0] == -1:
        break

    print("Sprite ID:", s[0])
    print("X:", s[1])
    print("Y:", s[2])

    current = current + 12
