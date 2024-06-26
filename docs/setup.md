# Project setup

## 1. General requirements
- Linux Mint or similar Ubuntu-based distributions (additional steps may be required for other distributions).
- Dreamcast SDK (Sega Library) Ver.1.55J (Google is your friend)

## 2. SDK Setup
1. Ensure your SDK is organized as follows.
   ```
   „¥„Ÿ„Ÿ bin (From disc Vol.1 dc_sdk/bin)
   „    „¥„Ÿ„Ÿ binadj.exe
   „    „¤„Ÿ„Ÿ ...
   „¥„Ÿ„Ÿ shc (From disc Vol.2)
   „    „¥„Ÿ„Ÿ bin
   „    „¥„Ÿ„Ÿ include
   „    „¤„Ÿ„Ÿ lib
   „¤„Ÿ„Ÿ shinobi (From disc Vol.2)
      „¥„Ÿ„Ÿ driver
      „¥„Ÿ„Ÿ include
      „¥„Ÿ„Ÿ lib
      „¤„Ÿ„Ÿ sample
   ```

## 3. Choose your environment
You can either use the provided Docker image or setup your own environment.

### 3.1 Using the provided Docker image
1. Open run_container.sh with your favorite text editor and update the SDK_PATH variable with the absolute path location of the SDK Files mentioned in the Project Setup

2. Run run_container.sh. you should be inside a bash shell inside /app (your current folder)
   ```
   $ ./run_container.sh
   ```

3. Source your `set_kt.docker.sh` script to make the environment variables available in the current shell:

   ```
   $ source ./scripts/set_kt.docker.sh
   ```

4. Build the binary using the provided `build.sh` script.
   ```
   $ ./scripts/build.sh

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

### 3.2 Setting up your own environment

1. Setup additional requirements:
    - [Wine](https://www.winehq.org/) 32.

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
