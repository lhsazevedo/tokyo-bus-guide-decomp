struct menuTextboxStruct {
    int field0_0x0;
    int field1_0x4;
    int field2_0x8;
    int field2_2_0xc;
    int field3_0x10;
    int field4_0x14;
    int field5_0x18;
    unsigned short typedChars_0x1c;
    unsigned short typedControls_0x1e;
    unsigned short totalChars_0x20;
    short totalControls_0x22;
    int field10_0x24;
    int field11_0x26;
    int field12_0x28;
    int field13_0x2a;
    short *field14_0x2c;
    int field15_0x30;
    int field16_0x34;
    char *string_0x38;
}
typedef menuTextboxStruct;

struct otherMenuTextboxStruct {
    short charIdx_0x00;
    int field_0x04;
    char *field_0x08;

    NJS_TEXNAME *texnames_0x10;

    short charsToDraw_0x14;

    void *field_0x24;
    void *field_0x28;
    char field_0x29;
    // field_0x2c;
    NJS_TEXINFO * texinfo_0x30;
};
typedef otherMenuTextboxStruct;

/* 
C8878C0
C00F330
 */

void menuTextboxTextSub_8c0155e0(menuTextboxStruct *txtStruct, int p_r5) {
    otherMenuTextboxStruct localStr;
    // int charsToDraw;
    int r9 = 0;
    int r8 = 0;

    /* 8c015600 */
    if (txtStruct->string_0x38 == NULL) {
        return 0;
    }

    /* 8c01560a */
    if (*txtStruct->string_0x38 == 0) {
        return 0;
    }

    /* 8c015610 */
    if (*txtStruct->totalChars_0x20 >= p_r5) {
        /* 8c01561a - Typed */
        localStr.charsToDraw_0x14 = txtStruct->totalChars_0x20 + txtStruct->totalControls_0x22;
    } else {
        /* 8c015648 - Typing */
        localStr.charsToDraw_0x14 = txtStruct->typedControls_0x1e + p_r5;
    }

    /* 8c01564c */
    // localStr.charsToDraw_0x14 = charsToDraw;

    localStr.charIdx_0x00 = 0;
    localStr.field_0x08 = &localStr.field_0x28;
    localStr.field_0x04 = &localStr.field_0x28 + 1;
    // fr15 = 24.f;

    /* 8c015912 */
    while (localStr.charIdx_0x00 < localStr.charsToDraw_0x14) {
        /* 8c015664 */
        int byteIdx_r11 = localStr.charIdx_0x00 * 2;

        if (localStr.charIdx_0x00 < txtStruct->typedChars_0x1c + txtStruct->typedControls_0x1e) {
            /* 8c015834 - Once per char, always */

            if (*(txtStruct->field_0x2c + localStr.charIdx_0x00) < 0xffed) {
                /* 8c015840 - Note: while line break isn't typed (command?) */
                _8c015840:
                /* 8c015864 */
                if () {
                    /* 8c015866 - Never hit in story box */
                }

                /* 8c01586a */
                if ((++r9 * 32) > txtStruct->field3_0x10) {
                    /* 8c01587a */
                    r0 = txtStruct->field15_0x30;

                    /* 8c015892 */
                    if () {
                        /* 8c015894 */
                    } else {
                        /* 8c0158ce */
                    }

                    /* 8c0158f2 */

                }

                /* 8c0158f8 */
                r8++;
            } else {
                /* 8c0158fc - Note: when line break is typed (command?) */

                /* 8c015906 */
                if () {
                    /* 8c015908 */
                }
            }

            
        } else {
            /* 8c015680 - Once per frame while typing, then skipped (loading texture?) */
            char* byteptr = txtStruct->string_0x38 + txtStruct->typedChars_0x1c * 2 + txtStruct->typedControls_0x1e * 3;

            /* 8c01569a */
            if (*byteptr == '<') {
                /* 8c01569c */
                byteptr++;

                switch (*byteptr) {
                    /* 0x45 */
                    case 'E':
                        /* 8c0156bc, 8c0156e4 */
                        /* TODO: review indirections */
                        txtStruct->field14_0x2c[byteIdx_r11] = _8c015718;
                        /* 8c015706 (shared) */
                        txtStruct->typedControls_0x1e++;

                        goto _8c015840;
                        // break;

                    /* 0x44 */
                    case 'D':
                        break;

                    /* 0x43 */
                    case 'C':
                        break;

                    /* 0x52 */
                    case 'R':
                        break;

                    /* 0x47, 0x42 */
                    case 'G':
                    case 'B':
                    default:
                        /* 8c015706 (shared) */
                        txtStruct->typedControls_0x1e++;
                        break;
                }
            } else {
                /* 8c015740 */
                r13 = r12;
                /* 8c015742 (fallthrough + ref) */
                if ( == -1)
            }
        }

        /* 8c01590c */
        localStr.charIdx_0x00++;
    }

    return 1;
}
