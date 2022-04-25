SHC_LIB="$(winepath -w Hitachi)" SHC_TMP="$(winepath -w /tmp)" wine Hitachi/shc.exe \
-code=asmcode \
-cpu=sh4 \
-division=cpu \
-endian=little \
-fpu=single \
-round=nearest \
-pic=0 \
-macsave=0 \
-string=const \
-comment=nonest \
-sjis \
-section=p=P \
-show=obj,source,expansion,w=80,l=0 \
-la=c \
-include="Include, Include\SHC" \
$1
