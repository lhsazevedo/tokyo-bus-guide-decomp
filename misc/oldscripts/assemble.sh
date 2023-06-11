wine dc_sdk/shc/bin/asmsh.exe \
$1 \
-cpu=sh4 \
-endian=little \
-sjis \
-private

if test $? -ne 0 ; then
    exit 1
fi

echo "Compiled successfuly"
