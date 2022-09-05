wine dc_sdk/shc/bin/asmsh.exe \
$1.src \
-cpu=sh4 \
-endian=little \
-sjis \
-private \
-debug=d \
-O="$1.o"

if test $? -ne 0 ; then
    exit 1
fi

echo "Compiled successfuly"
