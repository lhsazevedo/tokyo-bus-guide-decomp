# Filters and masks the SHC assembly output for comparing against
# decompiled assembly code. This helps function matching.

import sys
import re

if (len(sys.argv) != 2):
    print("prepare.py inputfile")
    sys.exit(1)

inh = open(sys.argv[1], "r")
intext = inh.read()
inh.close()

for i, line in enumerate(intext.splitlines()):
    if "frame size" in line:
        firstline = i + 1

for i, line in enumerate(intext.splitlines()):
    if ".DATA" in line:
        lastline = i - 3

# Remove comments
intext = re.sub(r' *;.*', '', intext)

# ?
# intext = re.sub(r'^ +[\w./]', 'MASKED', intext)

# Mask labels
intext = re.sub(r'L\d\d\d+(?:\+\d+)?', 'MASKED', intext)

# Remove trailing whitespaces from labels
intext = re.sub(r'MASKED: *', 'MASKED:', intext)

# Fix FMOV
intext = re.sub(r'FMOV\.S( +FR\d+,FR\d+)', r'FMOV  \1', intext)

def literalHexReplace(m):
    return '#' + m.group(1) + hex(int(m.group(2))) + ','

intext = re.sub(r'\#(-?)(\d+),', literalHexReplace, intext)

def dispHexReplace(m):
    return '@(' + hex(int(m.group(1)))

intext = re.sub(r'@\((\d+)', dispHexReplace, intext)

# while True:
#     m = re.search('\#(-?)(\d+),', intext)

#     if not m:
#         break

#     intext = intext[:m.start(2)] + hex(int(m.group(2))) + intext[m.end(2):]

# intext = re.sub('L\d\d\d+', 'MASKED', intext)
print('\n'.join(intext.splitlines()[firstline:lastline]))
