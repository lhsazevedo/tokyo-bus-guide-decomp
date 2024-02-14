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
  local asm_file="build\\${base_name}_c.src"

  wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -object="$obj_file" -sub=shc.sub 
  wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -code=asm -object="$asm_file" -sub=shc.sub 
}

rm -rf build
mkdir build

# _023224_8c015ab8_title
assemble  src/asm/decompiled/_023224_8c015ab8_title.src
sh4objtest "tests/_023224_8c015ab8_title.php" "build/_023224_8c015ab8_title_src.obj"
compile  src/_023224_8c015ab8_title.c
sh4objtest "tests/_023224_8c015ab8_title.php" "build/_023224_8c015ab8_title_c.obj"

# _067540_8c0207d4
assemble  src/asm/decompiled/_067540_8c0207d4.src
sh4objtest "tests/_067540_8c0207d4.php" "build/_067540_8c0207d4_src.obj"
compile  src/_067540_8c0207d4.c
sh4objtest "tests/_067540_8c0207d4.php" "build/_067540_8c0207d4_c.obj"

# _027736_8c016c58
assemble  src/asm/decompiled/_027736_8c016c58.src
sh4objtest "tests/_027736_8c016c58.php" "build/_027736_8c016c58_src.obj"
compile  src/_027736_8c016c58.c
sh4objtest "tests/_027736_8c016c58.php" "build/_027736_8c016c58_c.obj"

# _012100_8c012f44
assemble  src/asm/decompiled/_012100_8c012f44.src
sh4objtest "tests/_012100_8c012f44.php" "build/_012100_8c012f44_src.obj"
compile  src/_012100_8c012f44.c
sh4objtest "tests/_012100_8c012f44.php" "build/_012100_8c012f44_c.obj"
