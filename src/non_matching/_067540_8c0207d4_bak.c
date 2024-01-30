struct Struct8c0207d4 {
    float field_0x00;
    float field_0x04;
    float field_0x08;
}
typedef Struct8c0207d4;

float FUN_8c0207d4(Struct8c0207d4 *param1, Struct8c0207d4 *param2, Struct8c0207d4 *param3)
{
    float fr0, fr3, fr4, fr7;

    // FMOV.S      @R5,FR6
    // FMOV.S      @R4,FR4
    // float fr4 = param2->field_0x00;
    float fr6 = param1->field_0x00;

    // MOV         #H'8,R0
    // FMOV.S      @(R0,R4),FR5
    float fr5 = param1->field_0x08;

    // FMOV        FR4,FR3
    // float fr3 = fr4;

    // FSUB        FR4,FR6
    fr6 -= param2->field_0x00;

    // FMOV.S      @R6,FR4
    fr4 = param3->field_0x00;

    // FMOV.S      @(R0,R5),FR7
    fr7 = param2->field_0x08;

    // MOV         #H'4,R0

    // FSUB        FR3,FR4
    fr4 -= param2->field_0x00;

    // FMOV        FR5,FR3
    fr3 = fr5;

    // FSUB        FR5,FR7
    fr7 -= fr5;

    // FMOV.S      @(R0,R6),FR5
    fr5 = param3->field_0x04;

    // FSUB        FR3,FR5
    fr3 -= fr5;

    // FMOV        FR4,FR0
    fr0 = fr4;

    // FMUL        FR5,FR7
    fr7 *= fr5;

    // FMAC        FR0,FR6,FR7
    fr7 += fr0 * fr6;

    // RTS
    // FMOV        FR7,FR0
    return fr7;
}
