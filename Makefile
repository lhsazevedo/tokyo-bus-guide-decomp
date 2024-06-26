# Initial Makefile for matching build
SHELL=/bin/bash
ASMSH_FLAGS=-debug=d -cpu=sh4 -endian=little -sjis
OUTPUT_DIR=build/output
SHA1_CHECKSUM=a6df9e0de39b2d11e9339aef915d20e35763ec81

ASM_SRCS = \
	src/asm/010fe8_unused.src \
	src/asm/012324.src \
	src/asm/012504.src \
	src/asm/0129cc.src \
	src/asm/013ae8_pre_data.src \
	src/asm/013ae8.src \
	src/asm/014f54.src \
	src/asm/01614c.src \
	src/asm/016bf4.src \
	src/asm/016d2c.src \
	src/asm/018644.src \
	src/asm/018784.src \
	src/asm/0193c8_pre_data.src \
	src/asm/019e98.src \
	src/asm/01a148.src \
	src/asm/01b19c.src \
	src/asm/01bb48.src \
	src/asm/01c980.src \
	src/asm/01d290.src \
	src/asm/01d7fc.src \
	src/asm/01e27c.src \
	src/asm/01f3c0.src \
	src/asm/01fa78.src \
	src/asm/020214.src \
	src/asm/020594.src \
	src/asm/0206f0.src \
	src/asm/02081c.src \
	src/asm/020914.src \
	src/asm/020b6c.src \
	src/asm/02171c.src \
	src/asm/021b9c.src \
	src/asm/0222dc.src \
	src/asm/022464.src \
	src/asm/022bdc.src \
	src/asm/023310.src \
	src/asm/023938.src \
	src/asm/02412c.src \
	src/asm/024280.src \
	src/asm/024b4c.src \
	src/asm/025870.src \
	src/asm/025b98.src \
	src/asm/026710.src \
	src/asm/02786c.src \
	src/asm/027958.src \
	src/asm/028258.src \
	src/asm/02af78.src \
	src/asm/02b2f0.src \
	src/asm/02b464.src \
	src/asm/02c884.src \
	src/asm/02d06c.src \
	src/asm/02d19c.src \
	src/asm/02d968.src \
	src/asm/02df3c.src \
	src/asm/02e2dc.src \
	src/asm/02e400.src \
	src/asm/02e51c.src \
	src/asm/02f0c8.src \
	src/asm/02f320.src \
	src/asm/0332a4_sectionC.src \
	src/asm/03bd80_sectionD.src \
	src/asm/0fcd20_sectionB.src

C_SRCS = \
	src/010080_main.c \
	src/0100bc_sound.c \
	src/010e90.c \
	src/011120_asset_queues.c \
	src/012f44.c \
	src/014934.c \
	src/0149b0_sbinit.c \
	src/014a9c_tasks.c \
	src/014b8c_backup.c \
	src/015ab8_title.c \
	src/016108.c \
	src/016c58_prompt.c \
	src/0193c8_vm_menu.c \
	src/020528.c \
	src/0207d4.c \
	src/02fb50_sh4nlfzn_post_data.c \
	src/scif.c \
	src/serial_debug.c

ASM_OBJS = $(patsubst src/asm/%.src,$(OUTPUT_DIR)/%.obj,$(ASM_SRCS))
C_OBJS = $(patsubst src/%.c,$(OUTPUT_DIR)/%.obj,$(C_SRCS))

all: $(OUTPUT_DIR)/tbg.bin

$(OUTPUT_DIR):
	mkdir -p $(OUTPUT_DIR)

$(OUTPUT_DIR)/%.obj: src/asm/%.src | $(OUTPUT_DIR)
	wine "$(SHC_BIN)/asmsh.exe" "$(subst /,\\,$<)" -object="$(subst /,\\,$@)" $(ASMSH_FLAGS)

$(OUTPUT_DIR)/%.obj: src/%.c | $(OUTPUT_DIR)
	wine "$(SHC_BIN)/shc.exe" "$(subst /,\\,$<)" -object="$(subst /,\\,$@)" -sub=build/shc.sub

$(OUTPUT_DIR)/tbg.elf: $(ASM_OBJS) $(C_OBJS) build/lnk.sub
	wine "$(SHC_BIN)/lnk.exe" -sub=build\\lnk.sub

build/lnk.sub:
	sed "s/@DC_SDK@/$$(printf %q "$(KATANA_SDK_DIR)")/g" build/lnk_template.sub > build/lnk.sub

$(OUTPUT_DIR)/tbg.bin: $(OUTPUT_DIR)/tbg.elf
	wine "$(KATANA_SDK_DIR)/bin/elf2bin.exe" -s 8c010000 "$(subst /,\\,$<)"
	@if ! echo "$(SHA1_CHECKSUM) *$(OUTPUT_DIR)/tbg.bin" | sha1sum --status -c -; then \
		echo "================" ;\
		echo "Project built :)" ;\
		echo "================" ;\
	else \
		echo "===========================" ;\
		echo "Matching project built! \o/" ;\
		echo "===========================" ;\
	fi

clean:
	rm -rf $(OUTPUT_DIR)

.PHONY: all clean
