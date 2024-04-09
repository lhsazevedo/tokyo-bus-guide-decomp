# Tokyo Bus Guide Decompilation

[![Test](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/test.yml/badge.svg)](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/test.yml)
[![Build](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build.yml/badge.svg)](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build.yml)
[![Build Matching](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build_matching.yml/badge.svg)](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build_matching.yml)

![Main function hero](./tbg.png)


## Introduction
This project focuses on decompiling the Sega Dreamcast game Tokyo Bus Guide. It prioritizes achieving identical behavior between the original and decompiled code, rather than traditional methods targeting byte-level matching. Key objectives include functional equivalence, scalable decompilation methods, and community collaboration in Dreamcast reverse engineering.

To the best of the author's knowledge, this is the first public Dreamcast game decompilation project.


## Approach
Unlike traditional byte-level matching, this project uses a custom [SH4 object simulator and testing framework](https://github.com/lhsazevedo/sh4objtest). This tool tests decompiled functions against their original counterparts, ensuring exact behavioral replication.


## Project Status
This is an ongoing project, the decompilation process will be regularly updated. While under development, the project allows building the game using the available decompiled functions.


### Current Achivements:
- Rebuilding the game binary with decompiled functions alongside original code.
- Custom logs from decompiled C files, written to the Dreamcast serial interface and on-screen debug text: [watch video](https://twitter.com/lhs_azevedo/status/1777558619480867048), [view code](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/blob/7cbc8608b7a7568db8e26e9c9302b8a6f983460e/src/011120_asset_queues.c#L1186-L1197).
- CI workflows with matching builds, non-matching builds and unit tests checks.

## How to Contribute
Contributions to this project are encouraged and welcomed! Your expertise in code, testing, or documentation can significantly advance this decompilation effort. Detailed contribution guidelines will be available shortly.

## Requirements
- Operating System: Linux Mint or similar Ubuntu-based distributions (additional steps may be required for other distributions).
- [Wine](https://www.winehq.org/) 32.
- Dreamcast SDK (Sega Library) Ver.1.55J (Google is your friend)

## Project Setup
1. Ensure your SDK is organized as follows.
   ```
   ├── bin (From disc Vol.1 dc_sdk/bin)
   │   ├── binadj.exe
   │   └── ...
   ├── shc (From disc Vol.2)
   │   ├── bin
   │   ├── include
   │   └── lib
   └── shinobi (From disc Vol.2)
      ├── driver
      ├── include
      ├── lib
      └── sample
   ```

2. The Hitachi compiler suite expects some environments variables to be set. Create a copy of `set_kt.example.sh` named `set_kt.sh` and update the `DK_SDK` environment variable with your SDK location.

3. Source your `set_kt.sh` script to make the environment variables available in the current shell:
   ```
   $ source set_kt.sh
   ```

4. Build the binary using the provided `build.sh` script.
   ```
   $ ./build.sh

   (...)

   LINKAGE EDITOR COMPLETED
   ELF2BIN: ELF -> binary converter Ver. 1.04
   Copyright (c) 1998, Hitachi, Ltd.  All rights reserved.
   Module  address: 8c008000 - 8c0fde20
   Convert address: 8c010000 - 8c0fde20  size: 000ede20 (974368)

   ================
   Project built :)
   ================
   ```

A successful build will display "Project built :)".


## Acknowledgements
Acknowledgements and contributors will be listed soon.


## Useful resources
- [Dreamcast Programming](https://mc.pp.se/dc/) by Marcus Comstedt
- [Flycast source code](https://github.com/flyinghead/flycast)
- [My trashy Flycast debugger](https://github.com/lhsazevedo/flycast/tree/dbgnet)
- Dreamcast SDKs
