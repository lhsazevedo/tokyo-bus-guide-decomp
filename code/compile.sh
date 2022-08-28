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
-section=p=P,c=C,d=D,b=B \
-show=obj,source,expansion,w=80,l=0 \
-include="Include, Include\SHC" \
$1.c

if test $? -ne 0 ; then
    exit 1
fi

echo "Compiled successfuly"

# diff -y --color $1_original.src <(python3 prepare.py $1.src) > diff
