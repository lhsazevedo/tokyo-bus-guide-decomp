# TODO: Extract address from file name (caution with padding)

if [ $# -ne 4 ]; then
    echo 'Usage: all.sh <func_name> <padding> <address_hex> <sha1>'
    echo 'Note: address_hex should be aligned'
    exit 1
fi;

echo -n 'Compiling... '
./compile.sh $1

if test $? -ne 0 ; then
    exit 1
fi

echo -n 'Aligning... '
if [ "$2" -eq '0' ]; then
    # Noop
    :
elif [ "$2" -eq '1' ]; then
    sed -i '/.SECTION    P.*/a\          .DATA.B 0' $1.src
elif [ "$2" -eq '2' ]; then
    sed -i '/.SECTION    P.*/a\          .DATA.B 0,0' $1.src
elif [ "$2" -eq '3' ]; then
    sed -i '/.SECTION    P.*/a\          .DATA.B 0,0,0' $1.src
else
    echo 'Invalid alignment value';
    exit 1;
fi;

echo -n 'Assembling... '
./assemble.sh $1

if test $? -ne 0 ; then
    echo 'Failed'
    exit 1
fi;

echo -n 'Linking... '
echo elf > link_decomp.sub
echo "input src\\$1" >> link_decomp.sub
echo "output build\\$1_padded.elf" >> link_decomp.sub
echo "start P($3)" >> link_decomp.sub
echo debug >> link_decomp.sub
echo 'exit' >> link_decomp.sub
./link.sh

if test $? -ne 0 ; then
    echo 'Failed'
    exit 1
fi;

echo -n 'elf2bin... '
wine /media/lhsazevedo/hdstorage/dc_sdk/155j/bin/elf2bin.exe $1_padded.elf

if test $? -ne 0 ; then
    echo 'Failed'
    exit 1
fi;

echo -n 'Unpad... '
dd if=$1_padded.bin of=$1.bin ibs=1 skip=$2

if test $? -ne 0 ; then
    echo 'Failed'
    exit 1
fi;

echo 'Checking... '
if ! sha1sum --status -c <<< "$4 *$1.bin"; then
    echo "$1 diff :/"
else
    echo "$1 Ok!"
    exit 0
fi;

if [ ! -f "$1_original.bin" ]; then
    echo 'Cannot diff, original function binary not found...'
    echo 'Suggestion:'
    echo "dd if=1ST_READ.bin of=$1_original.bin ibs=1 skip=<address - 0x8c010000> count=<len>"
    exit 1
fi;

echo 'Diffing... '
dcdis -b 0x$3 $1_original.bin | cut -d ' ' -f 6- > $1_original.dis
dcdis -b 0x$3 $1.bin | cut -d ' ' -f 6- > $1.dis

# TODO: Handle missing delta
delta -s $1_original.dis $1.dis
