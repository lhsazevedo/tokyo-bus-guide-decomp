set -e

sh4objtest=~/.config/composer/vendor/bin/sh4objtest

ASMSH_FLAGS="-define=UNIT_TESTING=1 -debug=d -cpu=sh4 -endian=little -sjis"

assemble() {
  local src_file="$1"
  local base_name=$(basename "$src_file" .src)
  local obj_file="build\\output\\${base_name}_src.obj"

  wine "$SHC_BIN/asmsh.exe" $(echo "$src_file"| tr / '\\') -object="$obj_file" $ASMSH_FLAGS
}

compile() {
  local src_file="$1"
  local base_name=$(basename "$src_file" .c)
  local obj_file="build\\output\\${base_name}_c.obj"
  local asm_file="build\\output\\${base_name}_c.src"

  wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -object="$obj_file" -sub=build/shc_testing.sub 

  # Generate ASM file, useful for debugging.
  # wine "$SHC_BIN/shc.exe" $(echo "$src_file" | tr / '\\') -code=asm -object="$asm_file" -sub=build/shc_testing.sub 
}

rm -rf build/output
mkdir build/output

# 014f44
assemble  src/asm/014f54.src
compile  src/incomplete/014f54.c

$sh4objtest "tests/014f54/14f54_drawSprite.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/14f54_drawSprite.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/15034_getGlyphDatOffset.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/15034_getGlyphDatOffset.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/15110_unpackGlyphTexture.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/15110_unpackGlyphTexture.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/1524c_FntInit.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/1524c_FntInit.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/1529c_FntDestroy.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/1529c_FntDestroy.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/152fc_FntCreateTextBox.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/152fc_FntCreateTextBox.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/1543a_FntPrepareTextBoxLayout.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/1543a_FntPrepareTextBoxLayout.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/155e0_FntDrawTextbox.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/155e0_FntDrawTextbox.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/1594c_FUN.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/1594c_FUN.php" "build/output/014f54_c.obj"

$sh4objtest "tests/014f54/159ac_FUN_demo.php" "build/output/014f54_src.obj"
$sh4objtest "tests/014f54/159ac_FUN_demo.php" "build/output/014f54_c.obj"

# 0100bc_sound
assemble  src/asm/decompiled/0100bc_sound.src
compile  src/0100bc_sound.c

$sh4objtest "tests/0100bc_sound/0100bc_initUknVol.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/0100bc_initUknVol.php" "build/output/0100bc_sound_c.obj"

$sh4objtest "tests/0100bc_sound/010128_midiSetVol.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/010128_midiSetVol.php" "build/output/0100bc_sound_c.obj"

$sh4objtest "tests/0100bc_sound/0102d8_FUN.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/0102d8_FUN.php" "build/output/0100bc_sound_c.obj"

$sh4objtest "tests/0100bc_sound/010972_setAdxVol.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/010972_setAdxVol.php" "build/output/0100bc_sound_c.obj"

$sh4objtest "tests/0100bc_sound/010a40_FUN_adxVol.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/010a40_FUN_adxVol.php" "build/output/0100bc_sound_c.obj"

$sh4objtest "tests/0100bc_sound/010bae_FUN.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/010bae_FUN.php" "build/output/0100bc_sound_c.obj"

$sh4objtest "tests/0100bc_sound/010c2c_FUN.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/010c2c_FUN.php" "build/output/0100bc_sound_c.obj"

$sh4objtest "tests/0100bc_sound/010cd6_snd.php" "build/output/0100bc_sound_src.obj"
$sh4objtest "tests/0100bc_sound/010cd6_snd.php" "build/output/0100bc_sound_c.obj"

# # 015ab8_title
assemble  src/asm/decompiled/015ab8_title.src
$sh4objtest "tests/015ab8_title.php" "build/output/015ab8_title_src.obj"
compile  src/015ab8_title.c
$sh4objtest "tests/015ab8_title.php" "build/output/015ab8_title_c.obj"

# 0193c8
assemble  src/asm/decompiled/0193c8_vm_menu.src
compile  src/0193c8_vm_menu.c

$sh4objtest "tests/0193c8_vm_menu/198a0_VmMenuTask.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/198a0_VmMenuTask.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/19852_drawVmuWarning.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/19852_drawVmuWarning.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/193c8_TaskWaitForVmsReady.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/193c8_TaskWaitForVmsReady.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/1940e_VmMenuMountVms.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/1940e_VmMenuMountVms.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/1946a_TaskUnmountVms.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/1946a_TaskUnmountVms.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/194de_VmMenuUnmountVms.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/194de_VmMenuUnmountVms.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/19504_VmMenuFreeAndClear.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/19504_VmMenuFreeAndClear.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/19550_fetchVmusStatus.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/19550_fetchVmusStatus.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/19e44_VmMenuSwitchFromTask.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/19e44_VmMenuSwitchFromTask.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/1967c_VmMenuUpdateVmuStatus.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/1967c_VmMenuUpdateVmuStatus.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/19730_saveFileExists.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/19730_saveFileExists.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/19788_initCursorLerp.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/19788_initCursorLerp.php" "build/output/0193c8_vm_menu_c.obj"

$sh4objtest "tests/0193c8_vm_menu/197c0_drawVmMenu.php" "build/output/0193c8_vm_menu_src.obj"
$sh4objtest "tests/0193c8_vm_menu/197c0_drawVmMenu.php" "build/output/0193c8_vm_menu_c.obj"

# 0207d4
assemble  src/asm/decompiled/0207d4.src
$sh4objtest "tests/0207d4.php" "build/output/0207d4_src.obj"
compile  src/0207d4.c
$sh4objtest "tests/0207d4.php" "build/output/0207d4_c.obj"

# 016c58_prompt
assemble  src/asm/decompiled/016c58_prompt.src
$sh4objtest "tests/016c58.php" "build/output/016c58_prompt_src.obj"
compile  src/016c58_prompt.c
$sh4objtest "tests/016c58.php" "build/output/016c58_prompt_c.obj"

# 012f44
assemble  src/asm/decompiled/012f44.src
$sh4objtest "tests/012f44.php" "build/output/012f44_src.obj"
compile  src/012f44.c
$sh4objtest "tests/012f44.php" "build/output/012f44_c.obj"

# 011120
assemble  src/asm/decompiled/011120_asset_queues.src
compile  src/011120_asset_queues.c

$sh4objtest "tests/011120/4338_initDatQueue_8c011124.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4338_initDatQueue_8c011124.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4384_AsqNop_11120.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4384_AsqNop_11120.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4458_resetDatQueue_8c01116a.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4458_resetDatQueue_8c01116a.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4532_task_loadQueuedDats_8c0111b4.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4532_task_loadQueuedDats_8c0111b4.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/4880_sortAndLoadDatQueue_8c011310.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/4880_sortAndLoadDatQueue_8c011310.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/5324_task_loadQueuedNjs_8c0114cc.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/5324_task_loadQueuedNjs_8c0114cc.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/5814_sortAndLoadNjQueue_8c0116b6.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/5814_sortAndLoadNjQueue_8c0116b6.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6052_freeNjQueue_8c0117a4.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6052_freeNjQueue_8c0117a4.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6072_initTexlistQueue_8c0117b8.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6072_initTexlistQueue_8c0117b8.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6142_resetTexlistQueue_8c0117fe.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6142_resetTexlistQueue_8c0117fe.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6172_AsqRequestTexlist_1181c.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6172_AsqRequestTexlist_1181c.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6206_task_loadQueuedTexlists_8c01183e.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6206_task_loadQueuedTexlists_8c01183e.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6648_loadTexlistQueue_8c0119f8.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6648_loadTexlistQueue_8c0119f8.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6722_texlistQueueIsIdle_8c011a42.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6722_texlistQueueIsIdle_8c011a42.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6728_freeTexlistQueue_8c011a48.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6728_freeTexlistQueue_8c011a48.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6748_initPvmQueue_8c011a5c.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6748_initPvmQueue_8c011a5c.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6848_AsqRequestPvm_11ac0.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6848_AsqRequestPvm_11ac0.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/6912_task_loadQueuedPvms_8c011b00.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/6912_task_loadQueuedPvms_8c011b00.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7460_sortAndLoadPvmQueue_8c011d24.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7460_sortAndLoadPvmQueue_8c011d24.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7714_pvmQueueIsIdle_8c011e22.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7714_pvmQueueIsIdle_8c011e22.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7720_freePvmQueue_8c011e28.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7720_freePvmQueue_8c011e28.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7740_AsqReleaseAndFreeTexlist_11e3c.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7740_AsqReleaseAndFreeTexlist_11e3c.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7776_AsqFreeTexlist_11e60.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7776_AsqFreeTexlist_11e60.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7808_task_processQueues_8c011e80.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7808_task_processQueues_8c011e80.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/7990_AsqInitQueues_11f36.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/7990_AsqInitQueues_11f36.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8044_AsqResetQueues_11f6c.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8044_AsqResetQueues_11f6c.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8062_AsqFreeQueues_11f7e.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8062_AsqFreeQueues_11f7e.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8160_AsqProcessQueues_11fe0.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8160_AsqProcessQueues_11fe0.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8240_AsqRequestNjPvmPairs_12030.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8240_AsqRequestNjPvmPairs_12030.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8446_AsqFreeNjPvmPairs_120fe.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8446_AsqFreeNjPvmPairs_120fe.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8544_AsqSetSeedA_12160.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8544_AsqSetSeedA_12160.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8550_AsqGetRandomA_12166.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8550_AsqGetRandomA_12166.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8568_AsqGetRandomInRangeA_12178.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8568_AsqGetRandomInRangeA_12178.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8610_AsqSetSeedB_121a2.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8610_AsqSetSeedB_121a2.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8616_AsqGetRandomB_121a8.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8616_AsqGetRandomB_121a8.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8638_AsqGetRandomInRangeB_121be.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8638_AsqGetRandomInRangeB_121be.php" "build/output/011120_asset_queues_c.obj"

$sh4objtest "tests/011120/8680_AsqFUN_121e8.php" "build/output/011120_asset_queues_src.obj"
$sh4objtest "tests/011120/8680_AsqFUN_121e8.php" "build/output/011120_asset_queues_c.obj"
