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

compile  src/010080_main.c
assemble src/asm/0100bc_sound.src
compile  src/010e90.c
assemble src/asm/010fe8_unused.src
compile  src/011120.c
assemble src/asm/012324.src
assemble src/asm/012504.src
assemble src/asm/0129cc.src
compile  src/012f44.c
assemble src/asm/_012101_data.src
assemble src/asm/013ae8.src
compile  src/014934.c
compile  src/0149b0_sbinit.c
compile  src/014a9c_tasks.c
compile  src/014b8c_backup.c
assemble src/asm/014f54.src
compile  src/015ab8_title.c
compile  src/016108.c
assemble src/asm/01614c.src
assemble src/asm/016bf4.src
compile  src/016c58.c
assemble src/asm/016d2c.src
assemble src/asm/018644.src
assemble src/asm/018784.src
assemble src/asm/0193c8.src
assemble src/asm/019e98.src
assemble src/asm/01a148.src
assemble src/asm/01b19c.src
assemble src/asm/01bb48.src
assemble src/asm/01c980.src
assemble src/asm/01d290.src
assemble src/asm/01d7fc.src
assemble src/asm/01e27c.src
assemble src/asm/01f3c0.src
assemble src/asm/01fa78.src
assemble src/asm/020214.src
compile  src/020528.c
assemble src/asm/020594.src
assemble src/asm/0206f0.src
compile  src/0207d4.c
assemble src/asm/02081c.src
assemble src/asm/020914.src
assemble src/asm/020b6c.src
assemble src/asm/02171c.src
assemble src/asm/021b9c.src
assemble src/asm/0222dc.src
assemble src/asm/022464.src
assemble src/asm/022bdc.src
assemble src/asm/023310.src
assemble src/asm/023938.src
assemble src/asm/02412c.src
assemble src/asm/024280.src
assemble src/asm/024b4c.src
assemble src/asm/025870.src
assemble src/asm/025b98.src
assemble src/asm/026710.src
assemble src/asm/02786c.src
assemble src/asm/027958.src
assemble src/asm/028258.src
assemble src/asm/02af78.src
assemble src/asm/02b2f0.src
assemble src/asm/02b464.src
assemble src/asm/02c884.src
assemble src/asm/02d06c.src
assemble src/asm/02d19c.src
assemble src/asm/02d968.src
assemble src/asm/02df3c.src
assemble src/asm/02e2dc.src
assemble src/asm/02e400.src
assemble src/asm/02e51c.src
assemble src/asm/02f0c8.src
assemble src/asm/02f320.src
assemble src/asm/0332a4_sectionC.src
assemble src/asm/03bd80_sectionD.src
assemble src/asm/0fcd20_sectionB.src

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
