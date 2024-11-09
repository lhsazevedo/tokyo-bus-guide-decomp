#!/bin/bash

DC_SDK_NOT_FOUND=""

check_sdk_dir() {
    if [ ! -d $1 ]; then
        DC_SDK_NOT_FOUND="$DC_SDK_NOT_FOUND $1"
    fi
}

check_sdk_file() {
    if [ ! -f $1 ]; then
        DC_SDK_NOT_FOUND="$DC_SDK_NOT_FOUND $1"
    fi
}

if [ -z "$DC_SDK" ]; then
    echo "============"
    echo " SDK: ERROR"
    echo "============"
    echo "Please set the DC_SDK environment variable."
    exit 1
fi

if [ ! -d $DC_SDK/ ]; then
    echo "============"
    echo " SDK: ERROR"
    echo "============"
    echo "$DC_SDK/ not found."
    echo "Please check if the SDK volume is mounted correctly."
    exit 1
fi
check_sdk_dir "$DC_SDK/bin/"
check_sdk_file "$DC_SDK/bin/elf2bin.exe"
check_sdk_dir "$DC_SDK/shc/"
check_sdk_file "$DC_SDK/shc/bin/SHC.EXE"
check_sdk_file "$DC_SDK/shc/bin/asmsh.exe"
check_sdk_dir "$DC_SDK/shinobi/include"

if [ ! -z "$DC_SDK_NOT_FOUND" ]; then
    echo "There are missing files or directories in the SDK volume."
    echo "The following files or directories were not found:" 
    echo $DC_SDK_NOT_FOUND
    echo "Tip: If using docker, ensure the volume is mounted correctly at $DC_SDK."
    exit 1
fi

echo "=========="
echo " SDK: OK"
echo "=========="

# TODO Move disc root check to the build gdi script

# echo ""

