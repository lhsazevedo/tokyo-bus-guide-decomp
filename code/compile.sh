SHC_LIB="$(winepath -w dc_sdk/shc/bin)" SHC_TMP="$(winepath -w /tmp)" wine dc_sdk/shc/bin/SHC.EXE \
-code=m \
-cpu=sh4 \
-division=cpu \
-endian=little \
-fpu=single \
-round=nearest \
-pic=1 \
-macsave=0 \
-string=const \
-comment=nonest \
-sjis \
-section=p=P,c=C,d=D,b=B \
-show=obj,source,expansion,w=80,l=0 \
-include="dc_sdk/shc/include,dc_sdk/shinobi/include" \
-EXTRA=a=400 \
$1.c

if test $? -ne 0 ; then
    exit 1
fi

echo "Compiled successfuly"

# diff -y --color $1_original.src <(python3 prepare.py $1.src) > diff
