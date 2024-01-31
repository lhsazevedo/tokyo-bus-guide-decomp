set -e

ASMSH_FLAGS="-debug=d -cpu=sh4 -endian=little -sjis"

assemble() {
  local src_file="$1"
  local base_name=$(basename "$src_file" .src)
  local obj_file="build\\${base_name}_src.obj"

  wine "$SHC_BIN/asmsh.exe" $(echo "$src_file"| tr / '\\') -object="$obj_file" $ASMSH_FLAGS
}

compile() {
  local src_file="$1"
  local base_name=$(basename "$src_file" .c)
  local obj_file="build\\${base_name}_c.obj"

  wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -object="$obj_file" -sub=shc.sub
}

rm -rf build
mkdir build

assemble  src/asm/_023224_8c015ab8_title.src
sh4objtest "tests/_023224_8c015ab8_title.php" "build/_023224_8c015ab8_title_src.obj"

compile  src/_023224_8c015ab8_title.c
sh4objtest "tests/_023224_8c015ab8_title.php" "build/_023224_8c015ab8_title_c.obj"

