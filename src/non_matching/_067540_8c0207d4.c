struct Struct8c0207d4 {
    float field_0x00;
    float field_0x04;
    float field_0x08;
}
typedef Struct8c0207d4;

float FUN_8c0207d4(Struct8c0207d4 *param1, Struct8c0207d4 *param2, Struct8c0207d4 *param3)
{
    float fr0, fr3, fr4, fr5, fr7;
    float temp;

    // float fr6 = param1->field_0x00;
    // fr6 -= param2->field_0x00;

    // fr4 = param3->field_0x00;
    // fr4 -= param2->field_0x00;

    // fr7 = param2->field_0x08;
    // fr7 -= param1->field_0x08;

    // fr5 = param3->field_0x04;
    // fr5 -= param1->field_0x08;

    // fr0 = fr4;

    // fr7 *= fr5;

    // temp = (param2->field_0x08 - param1->field_0x08) * (param3->field_0x04 - param1->field_0x08);

    return (param2->field_0x08 - param1->field_0x08) * (param3->field_0x04 - param1->field_0x08)
         + (param3->field_0x00 - param2->field_0x00) * (param1->field_0x00 - param2->field_0x00);
}
