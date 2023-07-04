/*
** sbinit.c Ver.0.70  1999/1/5
** Copyright (C) 1998 SEGA Enterprises Co.,Ltd
** All Rights Reserved
*/

#include <shinobi.h>      /* 忍ヘッダファイル                         */
                          /* Shinobi library header file              */
#include <sg_syhw.h>      /* ハードウェア初期化ライブラリ             */
                          /* Hardware initialization library          */

/* ワークRAMの先頭/終了アドレス                                       */
#define WORK_TOP 0x8c000000
#define WORK_END 0x8d000000

#define P1AREA   0x80000000

extern Uint8* _BSG_END;   /* BSG/BSG32セクションの終了アドレス        */
                          /* End address of BSG/BSG32 section         */


/* ここの記述は、ライブラリ使用者のシステムに合わせて                 */
/* 変更することができます。                                           */
/* 変更の際は関連ドキュメントを参照し、各項目を適切に修正してください */

/* You can change a description of this place according to a system   */
/* of library user.                                                   */
/* When change it, please refer to a document concerned and revise    */
/* each item adequately.                                              */


/***** GDファイルシステムを使うかどうか *******************************/
/***** Do you use GD filesystem ?                                     */
#define USE_GDFS 1        /* 0...使わない                             */
                          /* 0...Do not use.                          */
                          /* 1...使う(DEFALUT)                        */
                          /* 1...Use (default)                        */

/***** Bセクションの終わりをヒープの先頭とするか **********************/
/* Do you assign an end of B Section to the top op the heap area ?    */
#define USE_B_END 1       /* 0...しない                               */
                          /* 0...Do not assign.                       */
                          /* 1...する(DEFALUT)                        */
                          /* 1...Assign (default)                     */


/* Bセクションの終わりをヒープの先頭としない場合、                    */
/* HEAP_SIZE にヒープ容量を定義してください。                         */
/* When you do not assign an end of B section to the top of the heap  */
/* area, please define the size of heap area in HEAP_SIZE macro.      */


/* GD:同時に開くことのできる最大ファイル数                            */
/* GD:Maximum file number opening at the same time.                   */
#define FILES 8

/* GD:カレントディレクトリバッファ                                    */
/* GD:Current directory buffer                                        */
#define BUFFERS 2048

/* syMalloc()で確保できる合計容量(約4MB)                              */
/* (Bセクションの終わりをヒープの先頭としない場合のみ有効)            */
/* The total volume that can be secured with syMalloc() (about 4MB)   */
/* (This is effective whed does not assign an end of B section to the */
/* top of the heap area.                                              */
#if !USE_B_END
#define HEAP_SIZE 0x00400000
#endif









/* グローバルワークの宣言                                             */
/* Global work area                                                   */

// TODO: Remove extern
extern Uint8 gMapleRecvBuf[1024 * 24 * 2 + 32];
extern Uint8 gMapleSendBuf[1024 * 24 * 2 + 32];

#if USE_GDFS
// TODO: Remove extern (both)
extern Uint8 gdfswork[GDFS_WORK_SIZE(FILES) + 32];
extern Uint8 gdfscurdir[GDFS_DIRREC_SIZE(BUFFERS) + 32];
#endif

/* syMalloc()の管理下に置くヒープの先頭アドレス */
/* The top address of the heap area                                   */
#if USE_B_END
#define HEAP_AREA ((void*)((((Uint32)_BSG_END | P1AREA) & 0xffffffe0) + 0x20))
#define HEAP_SIZE (WORK_END - (Uint32)HEAP_AREA)
#else
#define HEAP_AREA ((void*)((Uint32)WORK_END - (Uint32)HEAP_SIZE))
#endif


/*
** アプリケーションの初期化関数 (引数はnjInitSystem()互換)
** Initialization function of the application.
**                  Arguments are compatible with njInitSystem().
*/

void sbInitSystem(Int mode, Int frame, Int count)
{
	/* 標準的な初期化処理を行います。                             */
	/* この設定で、多くのアプリケーションが最大のパフォーマンスを */
	/* 得ることができます。                                       */
	/* 特に理由のない限り、ここの記述を修正しないでください。     */
	/* 修正する場合は、各ライブラリの仕様を十分理解した上、       */
	/* ライブラリ使用者の責任において修正してください。           */

	/* Do standard initialization.                                */
	/* By this setting, many applications can get the greatest    */
	/* performance.                                               */
	/* Without the special reason, please do not change a         */
	/* desctiption of this place.                                 */
	/* When change it, please understand specification of each    */
	/* library enough, and revise it in responsibility of library */
	/* user.                                                      */

	/* 割り込み禁止       */
	/* Disable interrupt. */
	set_imask(15);

	/* ハードウェアの初期化 */
	/* Initialize hardware.  */
	syHwInit();

	/* メモリ管理の初期化            */
	/* Initialize memory management. */
	syMallocInit(HEAP_AREA, HEAP_SIZE);

	/* Ninja/Kamuiの初期化     */
	/* Initialize Ninja/Kamui. */
	njInitSystem(mode, frame, count);

	/* ハードウェアの初期化その２ */
	/* Initialize hardware 2.     */
	syHwInit2();

	/* コントローラライブラリの初期化 */
	/* Initialize controller library. */
	pdInitPeripheral(PDD_PLOGIC_ACTIVE, gMapleRecvBuf, gMapleSendBuf);

	/* 割り込み許可      */
	/* Enable interrupt. */
	set_imask(0);

#if USE_GDFS
	/* GDファイルシステムの初期化                                 */
    /* Initialize GD filesystem.                                */
	{
		Uint8* wk;
		Uint8* dir;

		wk  = (Uint8*)(((Uint32)gdfswork & 0xffffffe0) + 0x20);
		dir = (Uint8*)(((Uint32)gdfscurdir & 0xffffffe0) + 0x20);
		gdFsInit(FILES, wk, BUFFERS, dir);
	}
#endif

	/* その他の初期化                                           */
	/* 上にないその他のライブラリの初期化、および               */
	/* ユーザーで行うべき初期化がある場合、ここに記述できます。 */
	/* Other initializations.                                   */
	/* When there are initializations of the other libraries    */
	/* which there are not and the initializations that should  */
	/* be done by user aloft, please describe it here.          */
}


/*
** アプリケーションの終了関数
** Finalize application.
*/

void sbExitSystem(void)
{
    /* コントローラライブラリの終了処理 */
	/* Finalize controller library.     */
	pdExitPeripheral();

	/* Ninja/Kamuiの終了処理 */
	/* Finalize Ninja/Kamui.       */
	njExitSystem();

	/* メモリ管理の終了処理        */
	/* Finalize memory management. */
	syMallocFinish();

	/* ハードウェアの終了処理 */
	/* Finalize hardware.     */
	syHwFinish();

	/* 割り込み禁止       */
	/* Disable interrupt. */
	set_imask(15);

    // TODO
    _8c056358();
}


/******************************* end of file *******************************/

