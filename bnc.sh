# Build and compare

wine $SHC_BIN/shc.exe src\\_027736_8c016c58.c \
 -object=build\\_027736_8c016c58.src \
 -code=asmcode \
 -sub=shc.sub && \
 delta -s \
 <(cat src/asm/_027736_8c016c58.src) \
 <(cat build/_027736_8c016c58.src | sed '/.LINE/d' | ./tools/rename_labels.py | ./tools/ljust_labels.py )

#  <(cat src/_004384_8c011120.src | sed '0,/^_requestDat_8c011182/d') \
#  <(cat build/_004384_8c011120.src | sed '/.LINE/d' | ./tools/rename_labels.py | sed '0,/^_requestDat_8c011182/d')

# wine $SHC_BIN/shc.exe src\\_004384_8c011120_freeDatQueue_8c0113d8.c \
#  -object=build\\_004384_8c011120_freeDatQueue_8c0113d8.src \
#  -code=asmcode \
#  -sub=shc.sub && \
#  delta -s \
#  <(cat src/_004384_8c011120_freeDatQueue_8c0113d8.src) \
#  <(cat build/_004384_8c011120_freeDatQueue_8c0113d8.src | sed '/.LINE/d' | ./tools/rename_labels.py)
