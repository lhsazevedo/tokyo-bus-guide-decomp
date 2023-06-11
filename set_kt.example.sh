DC_SDK=/path/to/dc_sdk

export SHINOBI_DIR=$(winepath -w $DC_SDK/shinobi)
export KATANA_SDK_DIR=$(winepath -w $DC_SDK)
export SHC_BIN=$(winepath -w $DC_SDK/shc/bin)
export SHC_TMP=$(winepath -w /tmp)
export SHC_LIB=$(winepath -w $DC_SDK/shc/bin)
export SHC_INC=$(winepath -w $DC_SDK/shc/include),$(winepath -w $DC_SDK/shinobi/include)

# export HLNK_LIBRARY1=$(winepath -w $DC_SDK/shinobi/lib/shinobi.lib)
# export HLNK_LIBRARY2=$(winepath -w $DC_SDK/shinobi/lib/ninja.lib)
# export HLNK_LIBRARY3=$(winepath -w $DC_SDK/shc/lib/sh4nlfzn.lib)

# unset HLNK_LIBRARY1
# unset HLNK_LIBRARY2
# unset HLNK_LIBRARY3
