# Tokyo Bus Guide Decompilation

![Decompiled](https://img.shields.io/badge/decompiled-12.6%25-teal)
[![Test](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/test.yml/badge.svg)](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/test.yml)
[![Build](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build.yml/badge.svg)](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build.yml)
[![Build Matching](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build_matching.yml/badge.svg)](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/actions/workflows/build_matching.yml)

![Main function hero](./tbg.png)

_Yup, [this is a real file](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/blob/88fb8f87500f9474780cd9a0f7dafa00b14b0be7/src/010080_main.c)!_

## Introduction
Welcome to the first-ever public Dreamcast game decompilation project, for the classic title Tokyo
Bus Guide! The goal is to fully decompile the code, focusing on functional equivalence rather than
byte-level matching. This project is a collaborative effort to advance Dreamcast reverse
engineering.

> [!WARNING]
> It is important to note that it is not possible to build a playable ROM from this decompilation
> project without a legitimate backup of the original game. This project is intended for educational
> and research purposes only, and users must ensure they have the legal right to use any game assets
> in their possession. Unauthorized distribution or use of game data is strictly prohibited.

## Approach
Unlike traditional byte-level matching, we are using a custom [SH4 object simulator and testing
framework](https://github.com/lhsazevedo/sh4objtest) to test decompiled functions against their
original counterparts, ensuring they behave exactly the same.

## Project Status
#### Decompilation progress: 12.6%
![Progress Bar](https://progress-bar.dev/12/?width=300)

This project is ongoing and is being updated regularly. It is in a shiftable state, which means the
original code can be shifted around in memory, allowing for edits such as data modifications without
worrying about length changes. It is also possible to recompile the binary using the decompiled
functions that are available.

### Current Achivements:
- Rebuilding the binary with decompiled functions alongside original code.
- Custom logs from decompiled C files, written to the Dreamcast serial interface and on-screen debug
  text:
   - [Watch capture](https://twitter.com/lhs_azevedo/status/1777558619480867048)
   - [View code](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/blob/7cbc8608b7a7568db8e26e9c9302b8a6f983460e/src/011120_asset_queues.c#L1186-L1197)
- CI workflows with matching builds, non-matching builds and unit tests checks.

## How to Contribute
Contributions are welcome! To get started, please refer to the project setup instructions in
[Project Setup](docs/setup.md). Detailed contribution guidelines will be available soon, providing
you with all the information you need to contribute effectively to this project. For now, you can
look the [CI workflows](https://github.com/lhsazevedo/tokyo-bus-guide-decomp/tree/main/.github/workflows)
to see how tests are being executed.

## Useful resources
- [Dreamcast Programming](https://mc.pp.se/dc/) by Marcus Comstedt
- [Flycast source code](https://github.com/flyinghead/flycast)
- [My trashy Flycast debugger](https://github.com/lhsazevedo/flycast/tree/dbgnet)
- Dreamcast SDKs
