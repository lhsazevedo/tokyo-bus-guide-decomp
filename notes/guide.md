# Steps to compile, link and check a function

TODO: This needs to be automated using an script.

## 1. Compile the C source file using the compile.sh script
```
./compile.sh <func_name>
```

It will create an assembly file named `<func_name>.src`. 

## 2. Align the section
The section must be aligned to a 4 byte boundary, so now its the time to pad it using `.DATA.B 0,0,0...`, if needed.

```
          .EXPORT     _execTasks_8c014b42
          .SECTION    P,CODE,ALIGN=4

          ; Padding
          .DATA.B 0,0

_execTasks_8c014b42:             ; function: execTasks_8c014b42
                                 ; frame size=8
          MOV.L       R14,@-R15
          STS.L       PR,@-R15
          BRA         L988
          MOV         R4,R14
```

## 3. Assemble the .src file
Use the assemble.sh script to assemble the file:
```
./assemble.sh <func_name>
```

It will create an ELF file with an "_padded" suffix: `<func_name>_padded.elf`

## 4. Convert to binary file
Use the elf2bin.exe program:
```
wine Hitachi/elf2bin.exe <func_name>_padded.elf
```

It will create a binary file named `<func_name>_padded.bin`.

## 5. Remove padding
Remove the padding using `dd`:
```
dd if=<func_name>_padded.bin of=<func_name>.bin ibs=1 skip=<bytes>
```

## 6. Check the SHA1 hash
```
sha1sum --status -c <<<"<sha1_hash> *<func_name>.bin"
```

Note:
To obtain the original function hash, use `dd`:
```
dd if="1ST_READ.BIN" ibs=1 obs=1 skip=<func_address> count=<func_size> | sha1sum
```
