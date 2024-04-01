set -e

sh4objtest=sh4objtest

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
$sh4objtest "tests/_023224_8c015ab8_title.php" "build/_023224_8c015ab8_title_src.obj"
compile  src/_023224_8c015ab8_title.c
$sh4objtest "tests/_023224_8c015ab8_title.php" "build/_023224_8c015ab8_title_c.obj"

# _067540_8c0207d4
assemble  src/asm/decompiled/_067540_8c0207d4.src
$sh4objtest "tests/_067540_8c0207d4.php" "build/_067540_8c0207d4_src.obj"
compile  src/_067540_8c0207d4.c
$sh4objtest "tests/_067540_8c0207d4.php" "build/_067540_8c0207d4_c.obj"

# _027736_8c016c58
assemble  src/asm/decompiled/_027736_8c016c58.src
$sh4objtest "tests/_027736_8c016c58.php" "build/_027736_8c016c58_src.obj"
compile  src/_027736_8c016c58.c
$sh4objtest "tests/_027736_8c016c58.php" "build/_027736_8c016c58_c.obj"

# _012100_8c012f44
assemble  src/asm/decompiled/_012100_8c012f44.src
$sh4objtest "tests/_012100_8c012f44.php" "build/_012100_8c012f44_src.obj"
compile  src/_012100_8c012f44.c
$sh4objtest "tests/_012100_8c012f44.php" "build/_012100_8c012f44_c.obj"

# _004384_8c011120
# TODO: Integrate
assemble  src/asm/_004384_8c011120.src
compile  src/non_matching/_004384_8c011120.c

$sh4objtest "tests/004384_8c011120/4338_initDatQueue_8c011124.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/4338_initDatQueue_8c011124.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/4384_nop_8c011120.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/4384_nop_8c011120.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/4458_resetDatQueue_8c01116a.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/4458_resetDatQueue_8c01116a.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/4532_task_loadQueuedDats_8c0111b4.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/4532_task_loadQueuedDats_8c0111b4.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/4880_sortAndLoadDatQueue_8c011310.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/4880_sortAndLoadDatQueue_8c011310.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/5324_task_loadQueuedNjs_8c0114cc.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/5324_task_loadQueuedNjs_8c0114cc.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/5814_sortAndLoadNjQueue_8c0116b6.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/5814_sortAndLoadNjQueue_8c0116b6.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6052_freeNjQueue_8c0117a4.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6052_freeNjQueue_8c0117a4.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6072_initTexlistQueue_8c0117b8.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6072_initTexlistQueue_8c0117b8.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6142_resetTexlistQueue_8c0117fe.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6142_resetTexlistQueue_8c0117fe.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6172_requestTexlist_8c01181c.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6172_requestTexlist_8c01181c.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6206_task_loadQueuedTexlists_8c01183e.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6206_task_loadQueuedTexlists_8c01183e.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6648_loadTexlistQueue_8c0119f8.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6648_loadTexlistQueue_8c0119f8.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6722_texlistQueueIsIdle_8c011a42.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6722_texlistQueueIsIdle_8c011a42.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6728_freeTexlistQueue_8c011a48.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6728_freeTexlistQueue_8c011a48.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6748_initPvmQueue_8c011a5c.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6748_initPvmQueue_8c011a5c.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6848_requestPvm_8c011ac0.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6848_requestPvm_8c011ac0.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/6912_task_loadQueuedPvms_8c011b00.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/6912_task_loadQueuedPvms_8c011b00.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/7460_sortAndLoadPvmQueue_8c011d24.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/7460_sortAndLoadPvmQueue_8c011d24.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/7714_pvmQueueIsIdle_8c011e22.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/7714_pvmQueueIsIdle_8c011e22.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/7720_freePvmQueue_8c011e28.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/7720_freePvmQueue_8c011e28.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/7740_releaseAndFreeTexlist_8c011e3c.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/7740_releaseAndFreeTexlist_8c011e3c.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/7776_freeTexlist_8c011e60.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/7776_freeTexlist_8c011e60.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/7808_task_processQueues_8c011e80.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/7808_task_processQueues_8c011e80.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/7990_initQueues_8c011f36.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/7990_initQueues_8c011f36.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8044_resetQueues_8c011f6c.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8044_resetQueues_8c011f6c.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8062_freeQueues_8c011f7e.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8062_freeQueues_8c011f7e.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8160_processQueues_8c011fe0.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8160_processQueues_8c011fe0.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8240_requestNjPvmPairs_8c012030.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8240_requestNjPvmPairs_8c012030.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8446_freeNjPvmPairs_8c0120fe.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8446_freeNjPvmPairs_8c0120fe.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8544_FUN_8c012160.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8544_FUN_8c012160.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8550_FUN_8c012166.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8550_FUN_8c012166.php" "build/_004384_8c011120_c.obj"

$sh4objtest "tests/004384_8c011120/8568_FUN_8c012178.php" "build/_004384_8c011120_src.obj"
$sh4objtest "tests/004384_8c011120/8568_FUN_8c012178.php" "build/_004384_8c011120_c.obj"
