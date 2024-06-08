#!/bin/bash

set -e

./scripts/build.sh
#./scripts/build_matching.sh

cp build/output/tbg.bin ../tbg_root/data/1ST_READ.BIN

../GDIbuilder/repo/buildgdi/bin/Release/net6.0/linux-x64/buildgdi -raw -data ../tbg_root/data/ -ip ../tbg_root/IP.BIN -output ../tbg_root/

mv ../tbg_root/track03.bin ~/Downloads/Roms/DC/Tokyo\ Bus\ Guide\ \(Japan\)/tbg_t3.bin

../flycast/build/flycast ~/Downloads/Roms/DC/Tokyo\ Bus\ Guide\ \(Japan\)/tbg.gdi

