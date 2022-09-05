#include <std/mem.pat>

#pragma endian big

using NString;

fn formatNStr(NString nStr) {
	return nStr.value;
};

fn formatNameMember(auto st) {
	return st.name.value;
};

struct NString {
	u8 length;
	char value[this.length];
} [[format("formatNStr")]];

struct ModuleHeader {
	u8 type;
	char date[12];
	u16 unitCount;
	u8 ukn01;
	char version[4];
	u8 ukn02[8];
	NString name;
	NString arch;
};

struct UnitHeader {
	u8 format;
	u16 sectionCount;
	u16 externSymbolsCount;
	u16 symbolsCount;

	NString name;
	NString tool;
	char date[12];
	
	padding[parent.len - ($ - addressof(parent))];
};

struct SectionChunk {
	u8 ukn01[16];
	NString name;
};

struct ExternSymbol {
	u8 ukn;
	NString name;
} [[format("formatNameMember")]];

struct ExternSymbolsChunk {
	ExternSymbol entries[while(($ - addressof(parent)) < parent.len)] [[inline]];;
};

struct Symbol {
	u16 section;
	u8 type;
	u32 offset;
	NString name;
} [[format("formatNameMember")]];;

struct SymbolsChunk {
	Symbol entries[while(($ - addressof(parent)) < parent.len)] [[inline]];
};

struct SectionSelection {
	// Unit appearence number (?)
	u16 uan;
	// Section appearence number (?)
	u16 san;
};

struct ObjectData {
	u8 flags;
	u32 addr;
	u8 length;
	u8 data[length];
};

struct RelocationEntry {
	// TODO

	u8 flags;
	u32 int;
	u8 bitloc;
	u8 flen;
	u8 bcount;
	u8 operator;
	
	// FIX	
	u16 section;
	u8 opcode;
	u8 addend_len;

	u8 len;
	u8 data[len];
	// u8 operator2;
	
	//u16 sectOrSym;// TODO
	
	//u8 plus_opcode;	
};

struct RelocationChunk {
	RelocationEntry entries[while(($ - addressof(parent)) < parent.len)];
};

struct Chunk {	
	u8 ukn;
	u8 type;
	u8 len;
	
	if (type == 0x84) {
		ModuleHeader data;
	} else if (type == 0x86) {
		UnitHeader data;
	} else if (type == 0x88) {
		SectionChunk data;
	} else if (type & 0x7f == 0x0c) {
		ExternSymbolsChunk data;
	} else if (type & 0x7f == 0x14) {
		SymbolsChunk data;
	} else if (type & 0x7f == 0x1a) {
		SectionSelection data;
	} else if (type & 0x7f == 0x1c) {
		ObjectData data;
	} else if (type & 0x7f == 0x20) {
		RelocationChunk data;
	}  else {
		u8 data[this.len - 3];
	}
	
	if ((this.len - ($ - addressof(this))) > 0) {
		//u8 p[this.len - ($ - addressof(this))];
	}
		
} [[single_color]];

struct ShcObject {
	u8 magic[0x20];
	
	// Chunk chunks[10];
	Chunk chunks[while(std::mem::read_unsigned($+1, 1) != 0xFF)];
};

ShcObject obj @ 0;
