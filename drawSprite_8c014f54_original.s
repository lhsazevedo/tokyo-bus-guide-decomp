
drawSprite_8c014f54:
    MOV.L     R14,@-R15
    MOV.L     R13,@-R15
    MOV.L     R12,@-R15
    MOV.L     R11,@-R15
    FMOV.S    FR15,@-R15
    FMOV.S    FR14,@-R15
    FMOV.S    FR13,@-R15
    FMOV.S    FR12,@-R15
    STS.L     PR,@-R15
    ADD       #-H'20,R15
    MOV.W     SHORT_8c015028,R3
    FMOV      FR4,FR12
    CMP/EQ    R3,R5
    FMOV      FR5,FR13
    BF/S      reads_title_dat_LAB_8c014f78
    FMOV     FR6,FR15
    BRA       LAB_8c014f86
    MOV.L    @(H'8,R4),R13

reads_title_dat_LAB_8c014f78:
    MOV       R5,R13
    MOV.L     @(H'8,R4),R6
    SHLL2     R13
    ADD       R6,R13
    MOV.L     @R13,R13
    SHLL2     R13
    ADD       R6,R13

LAB_8c014f86:
    FLDI1     FR4
    MOV       #H'c,R0
    MOV.L     @R4,R3
    MOV       #H'0,R14
    MOV.L     PTR_njDrawSprite2D_8c01502c,R11 ; 8c074c08
    MOV.L     R3,@(H'18,R15)
    MOV.L     @(H'4,R4),R2
    MOV       #H'0,R4
    MOV       R4,R12
    MOV.L     R2,@(H'1c,R15)
    MOV.L     R4,@(H'14,R15)
    FMOV      FR4,@(R0,R15)
    MOV       #H'10,R0
    FMOV      FR4,@(R0,R15)
    MOVA      FLOAT_8c015030,R0 ; 1.0E-4
    FMOV.S    @R0,fr14
    BRA       LAB_8c014fd0
    ADD      R13,R14

LAB_8c014faa:
    MOV       #H'4,R0
    FMOV      FR12,FR2
    FMOV.S    @(R0,R14),FR3
    MOV       #H'8,R0
    FMOV      FR15,FR4
    MOV       #H'20,R6
    FADD      FR3,FR2
    FMOV.S    FR2,@R15
    FMOV.S    @(R0,R14),FR3
    MOV       #H'4,R0
    FMOV      FR13,FR2
    FADD      FR3,FR2
    FMOV      FR2,@(R0,R15)
    MOV.L     @R14,R5
    JSR       @R11
    MOV       R12,R0
    SHLL      R0
    MOV       R12,R3
    ADD       R3,R0
    SHLL2     R0
    MOV.L     @(R0,R13),R0
    CMP/EQ    #-H'1,R0
    BF        LAB_8c014faa
    ADD       #H'20,R15
    LDS.L     @R15+,PR
    FMOV.S    @R15+,FR12
    FMOV.S    @R15+,FR13
    FMOV.S    @R15+,FR14
    FMOV.S    @R15+,FR15
    MOV.L     @R15+,R11
    MOV.L     @R15+,R12
    MOV.L     @R15+,R13
    RTS
    MOV.L    @R15+,R14

SHORT_8c015028:
    .DATA.W H'7D0
    ; 5028 d0 07         short     7D0h
    ; 502A 00            ??        00h
    ; 502B 00            ??        00h

PTR_njDrawSprite2D_8c01502c:
    NJDRAWSPRITE2D_8C074C08

FLOAT_8c015030:
    FDATA.S     F'0.0001
