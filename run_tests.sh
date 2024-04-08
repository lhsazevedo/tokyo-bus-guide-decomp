set -e

sh4objtest=sh4objtest

ASMSH_FLAGS="-define=UNIT_TESTING=1 -debug=d -cpu=sh4 -endian=little -sjis"

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

  wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -object="$obj_file" -sub=shc_testing.sub 

  # Generate ASM file, useful for debugging.
  # wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -code=asm -object="$asm_file" -sub=shc_testing.sub 
}

rm -rf build
mkdir build

# 015ab8_title
assemble  src/asm/decompiled/015ab8_title.src
$sh4objtest "tests/015ab8_title.php" "build/015ab8_title_src.obj"
compile  src/015ab8_title.c
$sh4objtest "tests/015ab8_title.php" "build/015ab8_title_c.obj"

# 0207d4
assemble  src/asm/decompiled/0207d4.src
$sh4objtest "tests/0207d4.php" "build/0207d4_src.obj"
compile  src/0207d4.c
$sh4objtest "tests/0207d4.php" "build/0207d4_c.obj"

# 016c58
assemble  src/asm/decompiled/016c58.src
$sh4objtest "tests/016c58.php" "build/016c58_src.obj"
compile  src/016c58.c
$sh4objtest "tests/016c58.php" "build/016c58_c.obj"

# 012f44
assemble  src/asm/decompiled/012f44.src
$sh4objtest "tests/012f44.php" "build/012f44_src.obj"
compile  src/012f44.c
$sh4objtest "tests/012f44.php" "build/012f44_c.obj"

# 011120
# TODO: Integrate
assemble  src/asm/decompiled/011120_asset_queues.src
compile  src/011120_asset_queues.c

$sh4objtest "tests/011120/4338_initDatQueue_8c011124.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4338_initDatQueue_8c011124.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4384_nop_8c011120.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4384_nop_8c011120.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4458_resetDatQueue_8c01116a.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4458_resetDatQueue_8c01116a.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4532_task_loadQueuedDats_8c0111b4.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4532_task_loadQueuedDats_8c0111b4.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4880_sortAndLoadDatQueue_8c011310.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4880_sortAndLoadDatQueue_8c011310.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/5324_task_loadQueuedNjs_8c0114cc.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/5324_task_loadQueuedNjs_8c0114cc.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/5814_sortAndLoadNjQueue_8c0116b6.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/5814_sortAndLoadNjQueue_8c0116b6.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6052_freeNjQueue_8c0117a4.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6052_freeNjQueue_8c0117a4.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6072_initTexlistQueue_8c0117b8.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6072_initTexlistQueue_8c0117b8.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6142_resetTexlistQueue_8c0117fe.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6142_resetTexlistQueue_8c0117fe.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6172_requestTexlist_8c01181c.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6172_requestTexlist_8c01181c.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6206_task_loadQueuedTexlists_8c01183e.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6206_task_loadQueuedTexlists_8c01183e.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6648_loadTexlistQueue_8c0119f8.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6648_loadTexlistQueue_8c0119f8.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6722_texlistQueueIsIdle_8c011a42.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6722_texlistQueueIsIdle_8c011a42.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6728_freeTexlistQueue_8c011a48.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6728_freeTexlistQueue_8c011a48.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6748_initPvmQueue_8c011a5c.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6748_initPvmQueue_8c011a5c.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6848_requestPvm_8c011ac0.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6848_requestPvm_8c011ac0.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6912_task_loadQueuedPvms_8c011b00.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6912_task_loadQueuedPvms_8c011b00.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7460_sortAndLoadPvmQueue_8c011d24.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7460_sortAndLoadPvmQueue_8c011d24.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7714_pvmQueueIsIdle_8c011e22.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7714_pvmQueueIsIdle_8c011e22.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7720_freePvmQueue_8c011e28.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7720_freePvmQueue_8c011e28.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7740_releaseAndFreeTexlist_8c011e3c.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7740_releaseAndFreeTexlist_8c011e3c.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7776_freeTexlist_8c011e60.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7776_freeTexlist_8c011e60.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7808_task_processQueues_8c011e80.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7808_task_processQueues_8c011e80.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7990_initQueues_8c011f36.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7990_initQueues_8c011f36.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8044_resetQueues_8c011f6c.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8044_resetQueues_8c011f6c.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8062_freeQueues_8c011f7e.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8062_freeQueues_8c011f7e.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8160_processQueues_8c011fe0.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8160_processQueues_8c011fe0.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8240_requestNjPvmPairs_8c012030.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8240_requestNjPvmPairs_8c012030.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8446_freeNjPvmPairs_8c0120fe.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8446_freeNjPvmPairs_8c0120fe.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8544_FUN_8c012160.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8544_FUN_8c012160.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8550_FUN_8c012166.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8550_FUN_8c012166.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8568_FUN_8c012178.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8568_FUN_8c012178.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8610_FUN_8c0121a2.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8610_FUN_8c0121a2.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8616_FUN_8c0121a8.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8616_FUN_8c0121a8.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8638_FUN_8c0121be.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8638_FUN_8c0121be.php" "build/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8680_FUN_8c0121e8.php" "build/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8680_FUN_8c0121e8.php" "build/011120_asset_queues_c.obj"
