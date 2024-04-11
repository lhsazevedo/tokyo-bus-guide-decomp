import itertools
import subprocess
import sys

pers = list(itertools.permutations([
    "float fadd;",
    "float xa;",
    "float ya;",
    "float xadd;",
    "float yadd;",
    "float pri = priority;"
]))

file = open('drawSprite.tpl', mode='r')
org_tpl = file.read()
file.close()

for idx, per in enumerate(pers):
    perstr = '\n'.join(per)
    print(perstr)

    # cur_tpl = org_tpl.replace('@@HERE@@', perstr)

    # file = open('drawSprite_8c014f54.c', mode='w')
    # file.write(cur_tpl)
    # file.close()

    # # If your shell script has shebang, 
    # # you can omit shell=True argument.
    # process = subprocess.run([
    #     "bash",
    #     "./all.sh",
    #     "drawSprite_8c014f54",
    #     "0",
    #     "8c014f54",
    #     "64bdf39c2417c269b5d994ab860dd83282535229"
    # ], capture_output=True, encoding='utf8')

    # print(process.stdout.split('\n')[-2])
