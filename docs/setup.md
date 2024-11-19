# Project setup

## 1. General requirements
- Linux Mint or similar Ubuntu-based distributions (additional steps may be required for other distributions).
- Dreamcast SDK (Sega Library) Ver.1.55J (Google is your friend)

## 2. SDK Setup
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

## 3. Choose your environment
You can either use the provided Docker image or setup your own environment.

### 3.1 Using the provided Docker image
1. Duplicate the `.env.example` file to create `.env` using the command:  
   ```bash
   cp .env.example .env
   ```  
2. Open the `.env` file with your favorite text editor, update the `SDK_PATH` variable with the absolute path location of the SDK files mentioned in the SDK Setup section, and save the changes.

3. (Optional, only needed for rebuild the disc image) Open .env, uncomment and
update the TBG_DISC_PATH variable with the absolute path location of the
extracted disc image files.

4. Run docker_shell.sh. you should be inside a bash shell inside /app (your current folder)
   ```
   $ ./docker_shell.sh
   ```

5. Build the binary using the provided Makefile.
   ```
   $ make

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

4. Build the binary using the provided Makefile.
   ```
   $ make

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
