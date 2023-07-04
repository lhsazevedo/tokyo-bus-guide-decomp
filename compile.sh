set -e

ASMSH_FLAGS="-debug=d -cpu=sh4 -endian=little -sjis"

wine $SHC_BIN/asmsh.exe src\\_00000_8c010000.src -object=build\\_00000_8c010000.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_00128_8c010080_main.c -object=build\\_00128_8c010080_main.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_00188_8c0100bc.c -object=build\\_00188_8c0100bc.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_00572_8c01023c.src -object=build\\_00572_8c01023c.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_03728_8c010e90.c -object=build\\_03728_8c010e90.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_04068_8c010fe4.src -object=build\\_04068_8c010fe4.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_04384_8c011120.src -object=build\\_04384_8c011120.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_05168_8c011430.src -object=build\\_05168_8c011430.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_18740_8c014934.c -object=build\\_18740_8c014934.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_18864_8c0149b0_sbinit.c -object=build\\_18864_8c0149b0_sbinit.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_19100_8c014a9c_tasks.c -object=build\\_19100_8c014a9c_tasks.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_19340_8c014b8c.src -object=build\\_19340_8c014b8c.obj $ASMSH_FLAGS
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
