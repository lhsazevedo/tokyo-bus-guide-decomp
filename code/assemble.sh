wine Hitachi/asmsh.exe \
$1.src \
-cpu=sh4 \
-endian=little \
-sjis \
-private \
-O="$1.obj"

if test $? -ne 0 ; then
    exit 1
fi

echo "Compiled successfuly"
