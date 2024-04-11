#!/usr/bin/env python3

# TODO: Description

import sys
import re
import fileinput
import random

if (len(sys.argv) > 2):
    print("order_labels.py inputfile")
    sys.exit(1)

labels = []
out = ""

with fileinput.input(openhook=fileinput.hook_encoded("shift_jis")) as f:
    for line in f:
        m = re.search(r'^(L[A-Fa-f0-9]+):', line)
        if m:
            labels.append(m.group(1))

        out += line

for l in reversed(labels):
    nl = "L" + str(random.randint(100000, 999999))
    out = re.sub(r'\b' + l + r'\b', nl, out)

print(out)
