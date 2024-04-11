# Ghidra script to export SH4 instructions

if not currentSelection:
    ghidra.util.Msg.showWarn(None, None, 'Ops', 'Plase select some instructions')
    exit()

if currentSelection.getNumAddressRanges() != 1:
    ghidra.util.Msg.showWarn(None, None, 'Ops', 'Only a single selection is supported!')
    exit()

listing = currentProgram.getListing()
codeUnits = listing.getCodeUnits(currentSelection, True) # true means 'forward'

for cu in codeUnits:
    if cu.getLabel():
        print(cu.getLabel() + ":")

    if issubclass(type(cu), ghidra.program.model.listing.Instruction):
        out = cu.getMnemonicString().upper()

        nOp = cu.getNumOperands()
        sep = cu.getSeparator(0)
        if sep != None or nOp != 0:
            out = out.ljust(12)
        
        if sep != None:
            out += sep

        for i in range(nOp):
            out += cu.getDefaultOperandRepresentation(i)
            sep = cu.getSeparator(i+1)
            if sep != None:
                out += sep

        print('          ' + out)
    elif issubclass(type(cu), ghidra.program.model.listing.Data):
        print(type(cu.getComponent(0).getValue()))
        print(cu)
    else:
        print("Unknown type " + type(cu))
        print(cu)

    # cu = currentProgram.getListing().getCodeUnitAt(a)
    # print(cu.toString())
