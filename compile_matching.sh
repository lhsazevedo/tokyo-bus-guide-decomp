set -e

ASMSH_FLAGS="-debug=d -cpu=sh4 -endian=little -sjis"

wine $SHC_BIN/asmsh.exe src\\_000000_8c010000.src -object=build\\_000000_8c010000.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_000128_8c010080_main.c -object=build\\_000128_8c010080_main.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_000188_8c0100bc_sound.src -object=build\\_000188_8c0100bc_sound.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_003728_8c010e90.c -object=build\\_003728_8c010e90.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_004072_8c010fe8.src -object=build\\_004072_8c010fe8.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_004384_8c011120.src -object=build\\_004384_8c011120.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_005168_8c011430.src -object=build\\_005168_8c011430.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_008160_8c011fe0.src -object=build\\_008160_8c011fe0.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_018740_8c014934.c -object=build\\_018740_8c014934.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_018864_8c0149b0_sbinit.c -object=build\\_018864_8c0149b0_sbinit.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_019100_8c014a9c_tasks.c -object=build\\_019100_8c014a9c_tasks.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_019340_8c014b8c_backup.c -object=build\\_019340_8c014b8c_backup.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_020308_8c014f54.src -object=build\\_020308_8c014f54.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_023224_8c015ab8_title.src -object=build\\_023224_8c015ab8_title.obj $ASMSH_FLAGS
wine $SHC_BIN/shc.exe src\\_024840_8c016108.c -object=build\\_024840_8c016108.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_024908_8c01614c.src -object=build\\_024908_8c01614c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_128156_8c02f49c.src -object=build\\_128156_8c02f49c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_129872_8c02fb50_sh4nlfzn.src -object=build\\_129872_8c02fb50_sh4nlfzn.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_143996_8c03327c_strt1_sectionC.src -object=build\\_143996_8c03327c_strt1_sectionC.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_144036_8c0332a4_sectionC.src -object=build\\_144036_8c0332a4_sectionC.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_179584_8c03bd80_sectionD.src -object=build\\_179584_8c03bd80_sectionD.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_259776_8c04f6c0_SDK.src -object=build\\_259776_8c04f6c0_SDK.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_970016_8c0fcd20_sectionB.src -object=build\\_970016_8c0fcd20_sectionB.obj $ASMSH_FLAGS

wine $SHC_BIN/lnk.exe -sub=lnk_matching.sub

rm -f build/tbg.bin
wine $KATANA_SDK_DIR/bin/elf2bin.exe -s 8c010000 build/tbg.elf

echo

if ! sha1sum --status -c <<<"a6df9e0de39b2d11e9339aef915d20e35763ec81 *build/tbg.bin"; then
    echo "======================"
    echo "Oops, build differs :/"
    echo "======================"
    exit 1
fi

echo "====================="
echo "Yay! Build matches :)"
echo "====================="
