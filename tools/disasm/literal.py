import re
import sys

file = open('out.s', mode='r')
source = file.readlines()
file.close()

literals = []

pass1 = []

for line in source:
    if (line.startswith('          mov.l H\'') or line.startswith('          mov.w H\'') or line.startswith('          mova H\'')):
        # Capture addr
        result = re.search(r"H'([a-f0-9]{8})", line)
        addr = result.group(1)

        if not addr in literals:
            literals.append(addr)

        # Replace addr
        newline = re.sub(r"H'[a-f0-9]{8}", "DATA_" + addr, line, 1)

        pass1.append(newline)
    else:
        pass1.append(line)

pass2 = []

for line in pass1:
    print('.', file=sys.stderr, end='')
    # Capture addr
    result = re.search(r"; H'([a-f0-9]{8})\n", line)
    if not result:
        pass2.append(line)
        continue

    addr = result.group(1)

    try:
        idx = literals.index(addr)
    except ValueError:
        pass2.append(line)
        continue

    pass2.append('          DATA_' + addr + ':\n')
    pass2.append(line)

    literals.pop(idx)

for line in pass2:
    print(line, end='')

print('# Remaining literals:')
for lit in literals:
    print(lit + '\n')
