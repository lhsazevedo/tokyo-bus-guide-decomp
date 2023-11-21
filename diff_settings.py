def apply(config, args):
    config["baseimg"] = "1ST_READ.BIN"
    config["myimg"] = "build/tbg.bin"
    # config["mapfile"] = "build.map"
    # config["source_directories"] = ["."]
    # config["show_line_numbers_default"] = True
    config["arch"] = "sh4"
    # config["map_format"] = "gnu" # gnu, mw, ms
    # config["build_dir"] = "build/" # only needed for mw and ms map format
    # config["expected_dir"] = "expected/" # needed for -o
    # config["makeflags"] = []
    # config["objdump_executable"] = ""
