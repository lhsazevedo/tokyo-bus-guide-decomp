wine /media/lhsazevedo/hdstorage/dc_sdk/155j/shc/bin/asmsh.exe \
$1.c \
-object=build\\$1.obj \
-sub=shc.sub

if test $? -ne 0 ; then
    echo "Failed compilation."
    exit 1
fi

echo "Compiled successfuly."

# diff -y --color $1_original.src <(python3 prepare.py $1.src) > diff
