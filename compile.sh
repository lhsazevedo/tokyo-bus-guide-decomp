set -e

ASMSH_FLAGS="-debug=d -cpu=sh4 -endian=little -sjis"

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
wine $SHC_BIN/shc.exe src\\non_matching\\_023224_8c015ab8_title.c -object=build\\_023224_8c015ab8_title.obj -sub=shc.sub
wine $SHC_BIN/shc.exe src\\_024840_8c016108.c -object=build\\_024840_8c016108.obj -sub=shc.sub
wine $SHC_BIN/asmsh.exe src\\_024908_8c01614c.src -object=build\\_024908_8c01614c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_024908_8c01614c.src -object=build\\_024908_8c01614c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_027636_8c016bf4.src -object=build\\_027636_8c016bf4.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_027736_8c016c58.src -object=build\\_027736_8c016c58.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_027948_8c016d2c.src -object=build\\_027948_8c016d2c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_034372_8c018644.src -object=build\\_034372_8c018644.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_034692_8c018784.src -object=build\\_034692_8c018784.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_037832_8c0193c8.src -object=build\\_037832_8c0193c8.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_040600_8c019e98.src -object=build\\_040600_8c019e98.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_041288_8c01a148.src -object=build\\_041288_8c01a148.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_045468_8c01b19c.src -object=build\\_045468_8c01b19c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_047944_8c01bb48.src -object=build\\_047944_8c01bb48.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_051584_8c01c980.src -object=build\\_051584_8c01c980.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_053904_8c01d290.src -object=build\\_053904_8c01d290.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_055292_8c01d7fc.src -object=build\\_055292_8c01d7fc.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_057980_8c01e27c.src -object=build\\_057980_8c01e27c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_062400_8c01f3c0.src -object=build\\_062400_8c01f3c0.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_064120_8c01fa78.src -object=build\\_064120_8c01fa78.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_066068_8c020214.src -object=build\\_066068_8c020214.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_066856_8c020528.src -object=build\\_066856_8c020528.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_066964_8c020594.src -object=build\\_066964_8c020594.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_067312_8c0206f0.src -object=build\\_067312_8c0206f0.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_067540_8c0207d4.src -object=build\\_067540_8c0207d4.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_067612_8c02081c.src -object=build\\_067612_8c02081c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_067860_8c020914.src -object=build\\_067860_8c020914.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_068460_8c020b6c.src -object=build\\_068460_8c020b6c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_071452_8c02171c.src -object=build\\_071452_8c02171c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_072604_8c021b9c.src -object=build\\_072604_8c021b9c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_074460_8c0222dc.src -object=build\\_074460_8c0222dc.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_074852_8c022464.src -object=build\\_074852_8c022464.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_076764_8c022bdc.src -object=build\\_076764_8c022bdc.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_078608_8c023310.src -object=build\\_078608_8c023310.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_080184_8c023938.src -object=build\\_080184_8c023938.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_082220_8c02412c.src -object=build\\_082220_8c02412c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_082560_8c024280.src -object=build\\_082560_8c024280.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_084812_8c024b4c.src -object=build\\_084812_8c024b4c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_088176_8c025870.src -object=build\\_088176_8c025870.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_088984_8c025b98.src -object=build\\_088984_8c025b98.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_091920_8c026710.src -object=build\\_091920_8c026710.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_096364_8c02786c.src -object=build\\_096364_8c02786c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_096600_8c027958.src -object=build\\_096600_8c027958.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_098904_8c028258.src -object=build\\_098904_8c028258.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_110456_8c02af78.src -object=build\\_110456_8c02af78.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_111344_8c02b2f0.src -object=build\\_111344_8c02b2f0.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_111716_8c02b464.src -object=build\\_111716_8c02b464.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_116868_8c02c884.src -object=build\\_116868_8c02c884.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_118892_8c02d06c.src -object=build\\_118892_8c02d06c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_119196_8c02d19c.src -object=build\\_119196_8c02d19c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_121192_8c02d968.src -object=build\\_121192_8c02d968.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_122684_8c02df3c.src -object=build\\_122684_8c02df3c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_123612_8c02e2dc.src -object=build\\_123612_8c02e2dc.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_123904_8c02e400.src -object=build\\_123904_8c02e400.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_124188_8c02e51c.src -object=build\\_124188_8c02e51c.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_127176_8c02f0c8.src -object=build\\_127176_8c02f0c8.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_127776_8c02f320.src -object=build\\_127776_8c02f320.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_144036_8c0332a4_sectionC.src -object=build\\_144036_8c0332a4_sectionC.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_179584_8c03bd80_sectionD.src -object=build\\_179584_8c03bd80_sectionD.obj $ASMSH_FLAGS
wine $SHC_BIN/asmsh.exe src\\_970016_8c0fcd20_sectionB.src -object=build\\_970016_8c0fcd20_sectionB.obj $ASMSH_FLAGS

wine $SHC_BIN/lnk.exe -sub=lnk.sub

rm -f build/tbg.bin
wine $KATANA_SDK_DIR/bin/elf2bin.exe -s 8c010000 build/tbg.elf

echo

if ! sha1sum --status -c <<<"a6df9e0de39b2d11e9339aef915d20e35763ec81 *build/tbg.bin"; then
    echo "================"
    echo "Project built :)"
    echo "================"
    exit
fi

echo "==========================="
echo "Matching project built! \o/"
echo "==========================="
