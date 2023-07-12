set -e

ASMSH_FLAGS="-debug=d -cpu=sh4 -endian=little -sjis"

wine $SHC_BIN/asmsh.exe src\\_000000_8c010000.src -object=build\\_000000_8c010000.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_000128_8c010080_main.c -object=build\\_000128_8c010080_main.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_000188_8c0100bc_sound.c -object=build\\_000188_8c0100bc_sound.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_000572_8c01023c_sound.src -object=build\\_000572_8c01023c_sound.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_003728_8c010e90.c -object=build\\_003728_8c010e90.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_004072_8c010fe8.src -object=build\\_004072_8c010fe8.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_004384_8c011120.src -object=build\\_004384_8c011120.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_005168_8c011430.src -object=build\\_005168_8c011430.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_018740_8c014934.c -object=build\\_018740_8c014934.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_018864_8c0149b0_sbinit.c -object=build\\_018864_8c0149b0_sbinit.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_019100_8c014a9c_tasks.c -object=build\\_019100_8c014a9c_tasks.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_019340_8c014b8c.src -object=build\\_019340_8c014b8c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_023224_8c015ab8_title.src -object=build\\_023224_8c015ab8_title.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_024840_8c016108.src -object=build\\_024840_8c016108.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_143996_8c03327c_strt1_sectionC.src -object=build\\_143996_8c03327c_strt1_sectionC.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_144036_8c0332a4_sectionC.src -object=build\\_144036_8c0332a4_sectionC.obj $ASMSH_FLAGS

wine $SHC_BIN/lnk.exe -sub=lnk.sub

rm -f build/tbg.bin
wine $KATANA_SDK_DIR/bin/elf2bin.exe -s 8c010000 build/tbg.elf

echo

if ! sha1sum --status -c <<<"a6df9e0de39b2d11e9339aef915d20e35763ec81 *build/tbg.bin"; then
    echo "======================"
    echo "Oops, build differs :/"
    echo "======================"
    exit 1
fi

echo "======================"
echo "Yay! Build matches :)"
echo "======================"
