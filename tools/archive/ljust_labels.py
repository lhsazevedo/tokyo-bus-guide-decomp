#!/usr/bin/env python3

# TODO: Description

import sys
import re
import fileinput

if (len(sys.argv) > 2):
    print("ljust_labels.py inputfile")
    sys.exit(1)

labels = []
out = ""

with fileinput.input(openhook=fileinput.hook_encoded("shift_jis")) as f:
    for line in f:
        m = re.search(r'^(L\d+:) +', line)
        if m:
            labels.append(m.group(1))

        out += line

for l in labels:
    out = re.sub(r'' + l + r' +', l.ljust(34, ' '), out)

print(out)
