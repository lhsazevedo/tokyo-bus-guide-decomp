set -e

ASMSH_FLAGS="-debug=d -cpu=sh4 -endian=little -sjis"

wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/asmsh.exe src\\_00188_8c0100bc.src -object=build\\_00188_8c0100bc.obj $ASMSH_FLAGS
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/shc.exe src\\_00128_8c010080_main.c -object=build\\_00128_8c010080_main.obj -sub=shc.sub
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/asmsh.exe src\\_00000_8c010000.src -object=build\\_00000_8c010000.obj $ASMSH_FLAGS
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/shc.exe src\\_19124_8c014ab4_tasks.c -object=build\\_19124_8c014ab4_tasks.obj -sub=shc.sub
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/asmsh.exe src\\_19340_8c014b8c.src -object=build\\_19340_8c014b8c.obj $ASMSH_FLAGS
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/asmsh.exe src\\_143996_8c03327c_strt1_sectionC.src -object=build\\_143996_8c03327c_strt1_sectionC.obj $ASMSH_FLAGS
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/asmsh.exe src\\_144036_8c0332a4_sectionC.src -object=build\\_144036_8c0332a4_sectionC.obj $ASMSH_FLAGS

wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/lnk.exe -sub=lnk.sub

rm build/tbg.bin
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/bin/elf2bin.exe -s 8c010000 build/tbg.elf

echo
echo Expected hash:
echo a6df9e0de39b2d11e9339aef915d20e35763ec81
echo
echo Actual hash:
sha1sum build/tbg.bin
