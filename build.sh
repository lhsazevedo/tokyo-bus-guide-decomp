set -e

ASMSH_FLAGS="-debug=d -cpu=sh4 -endian=little -sjis"

assemble() {
  local src_file="$1"
  local base_name=$(basename "$src_file" .src)
  local obj_file="build\\$base_name.obj"

  wine "$SHC_BIN/asmsh.exe" $(echo "$src_file"| tr / '\\') -object="$obj_file" $ASMSH_FLAGS
}

compile() {
  local src_file="$1"
  local base_name=$(basename "$src_file" .c)
  local obj_file="build\\$base_name.obj"

  wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -object="$obj_file" -sub=shc.sub
}

sed "s/@DC_SDK@/$(printf %q "$KATANA_SDK_DIR")/g" lnk_template.sub > lnk.sub

rm -rf build
mkdir build

compile  src/_000128_8c010080_main.c
assemble src/asm/_000188_8c0100bc_sound.src
compile  src/_003728_8c010e90.c
assemble src/asm/_004072_8c010fe8.src
assemble src/asm/_004384_8c011120.src
assemble src/asm/_008160_data.src
assemble src/asm/_008996_8c012324.src
assemble src/asm/_009476_8c012504.src
assemble src/asm/_010700_8c0129cc.src
assemble src/asm/_012100_8c012f44.src
assemble src/asm/_015080_8c013ae8.src
compile  src/_018740_8c014934.c
compile  src/_018864_8c0149b0_sbinit.c
compile  src/_019100_8c014a9c_tasks.c
compile  src/_019340_8c014b8c_backup.c
assemble src/asm/_020308_8c014f54.src
compile  src/_023224_8c015ab8_title.c
compile  src/_024840_8c016108.c
assemble src/asm/_024908_8c01614c.src
assemble src/asm/_027636_8c016bf4.src
assemble src/asm/_027736_8c016c58.src
assemble src/asm/_027948_8c016d2c.src
assemble src/asm/_034372_8c018644.src
assemble src/asm/_034692_8c018784.src
assemble src/asm/_037832_8c0193c8.src
assemble src/asm/_040600_8c019e98.src
assemble src/asm/_041288_8c01a148.src
assemble src/asm/_045468_8c01b19c.src
assemble src/asm/_047944_8c01bb48.src
assemble src/asm/_051584_8c01c980.src
assemble src/asm/_053904_8c01d290.src
assemble src/asm/_055292_8c01d7fc.src
assemble src/asm/_057980_8c01e27c.src
assemble src/asm/_062400_8c01f3c0.src
assemble src/asm/_064120_8c01fa78.src
assemble src/asm/_066068_8c020214.src
compile  src/_066856_8c020528.c
assemble src/asm/_066964_8c020594.src
assemble src/asm/_067312_8c0206f0.src
compile  src/_067540_8c0207d4.c
assemble src/asm/_067612_8c02081c.src
assemble src/asm/_067860_8c020914.src
assemble src/asm/_068460_8c020b6c.src
assemble src/asm/_071452_8c02171c.src
assemble src/asm/_072604_8c021b9c.src
assemble src/asm/_074460_8c0222dc.src
assemble src/asm/_074852_8c022464.src
assemble src/asm/_076764_8c022bdc.src
assemble src/asm/_078608_8c023310.src
assemble src/asm/_080184_8c023938.src
assemble src/asm/_082220_8c02412c.src
assemble src/asm/_082560_8c024280.src
assemble src/asm/_084812_8c024b4c.src
assemble src/asm/_088176_8c025870.src
assemble src/asm/_088984_8c025b98.src
assemble src/asm/_091920_8c026710.src
assemble src/asm/_096364_8c02786c.src
assemble src/asm/_096600_8c027958.src
assemble src/asm/_098904_8c028258.src
assemble src/asm/_110456_8c02af78.src
assemble src/asm/_111344_8c02b2f0.src
assemble src/asm/_111716_8c02b464.src
assemble src/asm/_116868_8c02c884.src
assemble src/asm/_118892_8c02d06c.src
assemble src/asm/_119196_8c02d19c.src
assemble src/asm/_121192_8c02d968.src
assemble src/asm/_122684_8c02df3c.src
assemble src/asm/_123612_8c02e2dc.src
assemble src/asm/_123904_8c02e400.src
assemble src/asm/_124188_8c02e51c.src
assemble src/asm/_127176_8c02f0c8.src
assemble src/asm/_127776_8c02f320.src
assemble src/asm/_144036_8c0332a4_sectionC.src
assemble src/asm/_179584_8c03bd80_sectionD.src
assemble src/asm/_970016_8c0fcd20_sectionB.src

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
