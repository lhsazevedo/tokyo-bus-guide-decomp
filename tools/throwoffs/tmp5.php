<?php

declare(strict_types=1);

$validAddresses = [
    0x8c0e128c,
    0x8c0e1408,
    0x8c0e142c,
    0x8c0e154c,
    0x8c0e157c,
    0x8c0e15e8,
    0x8c0e1600,
    0x8c0e1618,
    0x8c0e162c,
    0x8c0e164a,
    0x8c0e1662,
    0x8c0e167a,
    0x8c0e1698,
    0x8c0e169a,
    0x8c0e16cc,
    0x8c0e16e2,
    0x8c0e16f8,
    0x8c0e170e,
    0x8c0e171c,
    0x8c0e174a,
    0x8c0e174e,
    0x8c0e1756,
    0x8c0e17c6,
    0x8c0e17f4,
    0x8c0e1820,
    0x8c0e1844,
    0x8c0e198e,
    0x8c0e19b4,
    0x8c0e19e4,
    0x8c0e1a50,
    0x8c0e1a68,
    0x8c0e1a80,
    0x8c0e1a94,
    0x8c0e1ab2,
    0x8c0e1aca,
    0x8c0e1ae2,
    0x8c0e1b00,
    0x8c0e1b02,
    0x8c0e1b34,
    0x8c0e1b4a,
    0x8c0e1b60,
    0x8c0e1b76,
    0x8c0e1b84,
    0x8c0e1bb2,
    0x8c0e1bb6,
    0x8c0e1bbe,
    0x8c0e1c2e,
    0x8c0e1c5c,
    0x8c0e1c88,
    0x8c0e1cae,
    0x8c0e1e1c,
    0x8c0e1e3c,
    0x8c0e1e4c,
    0x8c0e1e58,
    0x8c0e1e64,
    0x8c0e1e72,
    0x8c0e1efe,
    0x8c0e1f2c,
    0x8c0e1f30,
    0x8c0e1fa4,
    0x8c0e1fd2,
    0x8c0e1ffc,
    0x8c0e2022,
    0x8c0e2098,
    0x8c0e20e8,
    0x8c0e2138,
    0x8c0e21a8,
    0x8c0e21ae,
    0x8c0e21bc,
    0x8c0e2244,
    0x8c0e2270,
    0x8c0e2274,
    0x8c0e22e8,
    0x8c0e2316,
    0x8c0e2340,
    0x8c0e2364,
    0x8c0e24b4,
    0x8c0e24f4,
    0x8c0e2584,
    0x8c0e259c,
    0x8c0e25b8,
    0x8c0e25ba,
    0x8c0e25d2,
    0x8c0e25d4,
    0x8c0e25f2,
    0x8c0e260a,
    0x8c0e2622,
    0x8c0e2644,
    0x8c0e2648,
    0x8c0e267a,
    0x8c0e2690,
    0x8c0e26a6,
    0x8c0e26bc,
    0x8c0e26e6,
    0x8c0e26fe,
    0x8c0e2716,
    0x8c0e272a,
    0x8c0e2748,
    0x8c0e2760,
    0x8c0e2778,
    0x8c0e2798,
    0x8c0e279a,
    0x8c0e27cc,
    0x8c0e27e2,
    0x8c0e27f8,
    0x8c0e280e,
    0x8c0e281c,
    0x8c0e286c,
    0x8c0e2870,
    0x8c0e2878,
    0x8c0e2918,
    0x8c0e2956,
    0x8c0e2984,
    0x8c0e29a6,
    0x8c0e29d8,
    0x8c0e29dc,
    0x8c0e2b44,
    0x8c0e2b84,
    0x8c0e2c14,
    0x8c0e2c2c,
    0x8c0e2c48,
    0x8c0e2c4a,
    0x8c0e2c62,
    0x8c0e2c64,
    0x8c0e2c82,
    0x8c0e2c9a,
    0x8c0e2cb2,
    0x8c0e2cd4,
    0x8c0e2cd8,
    0x8c0e2d0a,
    0x8c0e2d20,
    0x8c0e2d36,
    0x8c0e2d4c,
    0x8c0e2d76,
    0x8c0e2d8e,
    0x8c0e2da6,
    0x8c0e2dba,
    0x8c0e2dd8,
    0x8c0e2df0,
    0x8c0e2e08,
    0x8c0e2e28,
    0x8c0e2e2a,
    0x8c0e2e5c,
    0x8c0e2e72,
    0x8c0e2e88,
    0x8c0e2e9e,
    0x8c0e2eac,
    0x8c0e2efc,
    0x8c0e2f00,
    0x8c0e2f08,
    0x8c0e2fa8,
    0x8c0e2fe6,
    0x8c0e3010,
    0x8c0e3032,
    0x8c0e3064,
    0x8c0e3068,
    0x8c0e3204,
    0x8c0e3220,
    0x8c0e3260,
    0x8c0e32f0,
    0x8c0e3308,
    0x8c0e3324,
    0x8c0e3326,
    0x8c0e333e,
    0x8c0e3340,
    0x8c0e335e,
    0x8c0e3376,
    0x8c0e338e,
    0x8c0e33b0,
    0x8c0e33b4,
    0x8c0e33e6,
    0x8c0e33fc,
    0x8c0e3412,
    0x8c0e3428,
    0x8c0e3452,
    0x8c0e346a,
    0x8c0e3482,
    0x8c0e3496,
    0x8c0e34b4,
    0x8c0e34cc,
    0x8c0e34e4,
    0x8c0e3504,
    0x8c0e3506,
    0x8c0e3538,
    0x8c0e354e,
    0x8c0e3564,
    0x8c0e357a,
    0x8c0e3588,
    0x8c0e35d8,
    0x8c0e35dc,
    0x8c0e35e4,
    0x8c0e3684,
    0x8c0e36c2,
    0x8c0e36ec,
    0x8c0e370e,
    0x8c0e3890,
    0x8c0e38b4,
    0x8c0e38bc,
    0x8c0e38fc,
    0x8c0e398c,
    0x8c0e39a4,
    0x8c0e39c0,
    0x8c0e39c2,
    0x8c0e39da,
    0x8c0e39dc,
    0x8c0e39fa,
    0x8c0e3a12,
    0x8c0e3a2a,
    0x8c0e3a48,
    0x8c0e3a4a,
    0x8c0e3a78,
    0x8c0e3a8e,
    0x8c0e3aa4,
    0x8c0e3aba,
    0x8c0e3ae4,
    0x8c0e3afc,
    0x8c0e3b14,
    0x8c0e3b28,
    0x8c0e3b46,
    0x8c0e3b5e,
    0x8c0e3b76,
    0x8c0e3b98,
    0x8c0e3b9a,
    0x8c0e3bc8,
    0x8c0e3bde,
    0x8c0e3bf4,
    0x8c0e3c0a,
    0x8c0e3c18,
    0x8c0e3c68,
    0x8c0e3c6c,
    0x8c0e3c74,
    0x8c0e3d14,
    0x8c0e3d52,
    0x8c0e3d7c,
    0x8c0e3d9e,
    0x8c0e3f3c,
    0x8c0e3f76,
    0x8c0e3fc2,
    0x8c0e3fce,
    0x8c0e3fda,
    0x8c0e3fe6,
    0x8c0e3ff4,
    0x8c0e40c0,
    0x8c0e4110,
    0x8c0e4114,
    0x8c0e411c,
    0x8c0e41bc,
    0x8c0e41fa,
    0x8c0e4220,
    0x8c0e4244,
    0x8c0e4278,
    0x8c0e427c,
    0x8c0e4440,
    0x8c0e4454,
    0x8c0e44a0,
    0x8c0e44ac,
    0x8c0e44b8,
    0x8c0e44c4,
    0x8c0e44d2,
    0x8c0e459e,
    0x8c0e45ee,
    0x8c0e45f2,
    0x8c0e45fa,
    0x8c0e469a,
    0x8c0e46d8,
    0x8c0e4700,
    0x8c0e4724,
    0x8c0e4758,
    0x8c0e475c,
    0x8c0e47d2,
    0x8c0e4842,
    0x8c0e48b4,
    0x8c0e490c,
    0x8c0e493c,
    0x8c0e4948,
    0x8c0e4a10,
    0x8c0e4a5e,
    0x8c0e4a62,
    0x8c0e4a6a,
    0x8c0e4b0a,
    0x8c0e4b48,
    0x8c0e4b70,
    0x8c0e4b92,
    0x8c0e4c0e,
    0x8c0e4c72,
    0x8c0e4cd8,
    0x8c0e4d1c,
    0x8c0e4d60,
    0x8c0e4d6e,
    0x8c0e4e3c,
    0x8c0e4e8c,
    0x8c0e4e90,
    0x8c0e4e98,
    0x8c0e4f38,
    0x8c0e4f76,
    0x8c0e4f9c,
    0x8c0e4fb2,
    0x8c0e4fb8,
    0x8c0e4fc2,
    0x8c0e4fc8,
    0x8c0e4fd2,
    0x8c0e4fd8,
    0x8c0e4fe2,
    0x8c0e4fe8,
    0x8c0e501e,
    0x8c0e503a,
    0x8c0e505a,
    0x8c0e507a,
    0x8c0e5094,
    0x8c0e509e,
    0x8c0e50ba,
    0x8c0e50da,
    0x8c0e50fa,
    0x8c0e5118,
    0x8c0e5138,
    0x8c0e5158,
    0x8c0e5178,
    0x8c0e5192,
    0x8c0e51a8,
    0x8c0e5202,
    0x8c0e5220,
    0x8c0e522e,
    0x8c0e5282,
    0x8c0e529a,
    0x8c0e52c0,
    0x8c0e5346,
    0x8c0e5368,
    0x8c0e537a,
    0x8c0e53fc,
    0x8c0e540c,
    0x8c0e546c,
    0x8c0e5478,
    0x8c0e54a0,
    0x8c0e54bc,
    0x8c0e54d0,
    0x8c0e54d6,
    0x8c0e54e2,
    0x8c0e54fc,
    0x8c0e54fc,
    0x8c0e54fc,
    0x8c0e5532,
    0x8c0e554c,
    0x8c0e5566,
    0x8c0e5570,
    0x8c0e559a,
    0x8c0e55be,
    0x8c0e55da,
    0x8c0e55e6,
    0x8c0e561c,
    0x8c0e5646,
    0x8c0e5650,
    0x8c0e565a,
    0x8c0e5694,
    0x8c0e569a,
    0x8c0e56a0,
    0x8c0e56a2,
    0x8c0e56ac,
    0x8c0e56c6,
    0x8c0e56ca,
    0x8c0e56e8,
    0x8c0e56ea,
    0x8c0e56ec,
    0x8c0e572c,
    0x8c0e572e,
    0x8c0e5730,
    0x8c0e573c,
    0x8c0e5758,
    0x8c0e578e,
    0x8c0e57b2,
    0x8c0e57c4,
    0x8c0e57cc,
    0x8c0e57e2,
    0x8c0e57e8,
    0x8c0e57ec,
    0x8c0e57fe,
    0x8c0e5800,
    0x8c0e5810,
    0x8c0e5812,
    0x8c0e5822,
    0x8c0e583c,
    0x8c0e583e,
    0x8c0e5858,
    0x8c0e586e,
    0x8c0e58a0,
    0x8c0e58a8,
    0x8c0e58e0,
    0x8c0e5902,
    0x8c0e5946,
    0x8c0e5964,
    0x8c0e5998,
    0x8c0e59c2,
    0x8c0e59ca,
    0x8c0e59e8,
    0x8c0e5a10,
    0x8c0e5a3c,
    0x8c0e5a48,
    0x8c0e5a92,
    0x8c0e5a94,
    0x8c0e5a9e,
    0x8c0e5aa2,
    0x8c0e5aa6,
    0x8c0e5ac4,
    0x8c0e5b54,
    0x8c0e5b7a,
    0x8c0e5b96,
    0x8c0e5b9c,
    0x8c0e5ba8,
    0x8c0e5c08,
    0x8c0e5c54,
    0x8c0e5c78,
    0x8c0e5c9e,
    0x8c0e5ca8,
    0x8c0e5cd0,
    0x8c0e5cdc,
    0x8c0e5dae,
    0x8c0e5db0,
    0x8c0e5db4,
    0x8c0e5dc0,
    0x8c0e5df0,
    0x8c0e5e14,
    0x8c0e5e1e,
    0x8c0e5e3c,
    0x8c0e5e56,
    0x8c0e5e5c,
    0x8c0e5e68,
    0x8c0e5ea4,
    0x8c0e5ece,
    0x8c0e5ed6,
    0x8c0e5edc,
    0x8c0e5f58,
    0x8c0e5f66,
    0x8c0e5fa4,
    0x8c0e5fae,
    0x8c0e5fc0,
    0x8c0e5fc6,
    0x8c0e5ff4,
    0x8c0e600a,
    0x8c0e6046,
    0x8c0e6052,
    0x8c0e6068,
    0x8c0e60bc,
    0x8c0e60d8,
    0x8c0e60e2,
    0x8c0e60ee,
    0x8c0e6152,
    0x8c0e615c,
    0x8c0e6168,
    0x8c0e616e,
    0x8c0e617a,
    0x8c0e61b8,
    0x8c0e61da,
    0x8c0e61e4,
    0x8c0e6256,
    0x8c0e6262,
    0x8c0e62a8,
    0x8c0e62c6,
    0x8c0e62d0,
    0x8c0e62e2,
    0x8c0e62e8,
    0x8c0e6306,
    0x8c0e6310,
    0x8c0e6364,
    0x8c0e636c,
    0x8c0e6378,
    0x8c0e637a,
    0x8c0e637e,
    0x8c0e638a,
    0x8c0e63bc,
    0x8c0e63e4,
    0x8c0e63ee,
    0x8c0e6408,
    0x8c0e6416,
    0x8c0e6436,
    0x8c0e6438,
    0x8c0e643e,
    0x8c0e644a,
    0x8c0e648c,
    0x8c0e64b0,
    0x8c0e64ba,
    0x8c0e64d4,
    0x8c0e64e0,
    0x8c0e64fa,
    0x8c0e64fc,
    0x8c0e6502,
    0x8c0e650e,
    0x8c0e654c,
    0x8c0e6576,
    0x8c0e6580,
    0x8c0e6592,
    0x8c0e659e,
    0x8c0e65cc,
    0x8c0e65d6,
    0x8c0e6634,
    0x8c0e6644,
    0x8c0e6654,
    0x8c0e6666,
    0x8c0e666e,
    0x8c0e667a,
    0x8c0e66a4,
    0x8c0e66ce,
    0x8c0e66d8,
    0x8c0e66e2,
    0x8c0e66f8,
    0x8c0e6704,
    0x8c0e6734,
    0x8c0e6794,
    0x8c0e67a4,
    0x8c0e67b4,
    0x8c0e67c6,
    0x8c0e67cc,
    0x8c0e67d8,
    0x8c0e6800,
    0x8c0e6816,
    0x8c0e6820,
    0x8c0e6844,
    0x8c0e684a,
    0x8c0e6854,
    0x8c0e6860,
    0x8c0e6888,
    0x8c0e68b2,
    0x8c0e68bc,
    0x8c0e68ce,
    0x8c0e68da,
    0x8c0e6908,
    0x8c0e6912,
    0x8c0e6970,
    0x8c0e6980,
    0x8c0e6990,
    0x8c0e69a2,
    0x8c0e69aa,
    0x8c0e69b6,
    0x8c0e69e0,
    0x8c0e6a04,
    0x8c0e6a0c,
    0x8c0e6a70,
    0x8c0e6a78,
    0x8c0e6a7e,
    0x8c0e6a84,
    0x8c0e6aa0,
    0x8c0e6af2,
    0x8c0e6b22,
    0x8c0e6b2a,
    0x8c0e6b32,
    0x8c0e6b36,
    0x8c0e6b4e,
    0x8c0e6b5e,
    0x8c0e6b64,
    0x8c0e6b9c,
    0x8c0e6bb4,
    0x8c0e6bc6,
    0x8c0e6bd2,
    0x8c0e6c00,
    0x8c0e6c1a,
    0x8c0e6c24,
    0x8c0e6c3e,
    0x8c0e6c64,
    0x8c0e6c66,
    0x8c0e6c84,
    0x8c0e6cb4,
    0x8c0e6cec,
    0x8c0e6cfe,
    0x8c0e6d04,
    0x8c0e6d10,
    0x8c0e6d1c,
    0x8c0e6d3c,
    0x8c0e6d54,
    0x8c0e6d5e,
    0x8c0e6da6,
    0x8c0e6dac,
    0x8c0e6db4,
    0x8c0e6db6,
    0x8c0e6dc0,
    0x8c0e6dc2,
    0x8c0e6dc4,
    0x8c0e6dd0,
    0x8c0e6e00,
    0x8c0e6e16,
    0x8c0e6e20,
    0x8c0e6e4e,
    0x8c0e6e5c,
    0x8c0e6e62,
    0x8c0e6e6e,
    0x8c0e6e94,
    0x8c0e6eaa,
    0x8c0e6eb4,
    0x8c0e6ec8,
    0x8c0e6ed6,
    0x8c0e6edc,
    0x8c0e6ee8,
    0x8c0e6f0c,
    0x8c0e6f30,
    0x8c0e6f3a,
    0x8c0e6f58,
    0x8c0e6fb8,
    0x8c0e6fee,
    0x8c0e6ffa,
    0x8c0e7006,
    0x8c0e700e,
    0x8c0e701a,
    0x8c0e7054,
    0x8c0e706c,
    0x8c0e7072,
    0x8c0e708c,
    0x8c0e7090,
    0x8c0e70a0,
    0x8c0e70c8,
    0x8c0e70ce,
    0x8c0e70e8,
    0x8c0e7106,
    0x8c0e710c,
    0x8c0e711a,
    0x8c0e7120,
    0x8c0e715c,
    0x8c0e7160,
    0x8c0e718c,
    0x8c0e719c,
    0x8c0e71a0,
    0x8c0e71c0,
    0x8c0e71ce,
    0x8c0e71d2,
    0x8c0e71e2,
    0x8c0e71e6,
    0x8c0e71f6,
    0x8c0e7208,
    0x8c0e720c,
    0x8c0e721c,
    0x8c0e7258,
    0x8c0e7262,
    0x8c0e7288,
    0x8c0e728c,
    0x8c0e7298,
    0x8c0e72a8,
    0x8c0e72bc,
    0x8c0e72be,
    0x8c0e72d4,
    0x8c0e72f2,
    0x8c0e730e,
    0x8c0e732c,
    0x8c0e7346,
    0x8c0e7352,
    0x8c0e7368,
    0x8c0e7386,
    0x8c0e7390,
    0x8c0e73f6,
    0x8c0e7402,
    0x8c0e744c,
    0x8c0e746c,
    0x8c0e7476,
    0x8c0e74a4,
    0x8c0e74b2,
    0x8c0e74bc,
    0x8c0e74dc,
    0x8c0e74e8,
    0x8c0e7524,
    0x8c0e7542,
    0x8c0e754c,
    0x8c0e7558,
    0x8c0e7590,
    0x8c0e75b8,
    0x8c0e75d2,
    0x8c0e75dc,
    0x8c0e75e8,
    0x8c0e75f2,
    0x8c0e75fe,
    0x8c0e7636,
    0x8c0e7642,
    0x8c0e767c,
    0x8c0e769a,
    0x8c0e76a4,
    0x8c0e76b0,
    0x8c0e76e8,
    0x8c0e76f4,
    0x8c0e7724,
    0x8c0e7742,
    0x8c0e774c,
    0x8c0e7758,
    0x8c0e7790,
    0x8c0e779c,
    0x8c0e77cc,
    0x8c0e77ea,
    0x8c0e77f4,
    0x8c0e7800,
    0x8c0e783a,
    0x8c0e7846,
    0x8c0e7878,
    0x8c0e7896,
    0x8c0e78a0,
    0x8c0e78ac,
    0x8c0e78e2,
    0x8c0e78ee,
    0x8c0e7920,
    0x8c0e793e,
    0x8c0e7948,
    0x8c0e7980,
    0x8c0e798c,
    0x8c0e79b8,
    0x8c0e79e4,
    0x8c0e79f4,
    0x8c0e7a2a,
    0x8c0e7a3c,
    0x8c0e7a4e,
    0x8c0e7a5c,
    0x8c0e7a5e,
    0x8c0e7a6a,
    0x8c0e7a84,
    0x8c0e7a9c,
    0x8c0e7aa6,
    0x8c0e7ac4,
    0x8c0e7ad0,
    0x8c0e7af4,
    0x8c0e7b0c,
    0x8c0e7b16,
    0x8c0e7b36,
    0x8c0e7b42,
    0x8c0e7b68,
    0x8c0e7b84,
    0x8c0e7b8e,
    0x8c0e7b9a,
    0x8c0e7ba6,
    0x8c0e7bca,
    0x8c0e7bd6,
    0x8c0e7c04,
    0x8c0e7c22,
    0x8c0e7c2c,
    0x8c0e7c58,
    0x8c0e7c60,
    0x8c0e7c70,
    0x8c0e7c78,
    0x8c0e7c88,
    0x8c0e7c90,
    0x8c0e7ca0,
    0x8c0e7ca8,
    0x8c0e7cb4,
    0x8c0e7cdc,
    0x8c0e7cf4,
    0x8c0e7cfe,
    0x8c0e7d1e,
    0x8c0e7d2a,
    0x8c0e7d50,
    0x8c0e7d68,
    0x8c0e7d72,
    0x8c0e7d92,
    0x8c0e7d9e,
    0x8c0e7dc4,
    0x8c0e7ddc,
    0x8c0e7de6,
    0x8c0e7e08,
    0x8c0e7e14,
    0x8c0e7e3c,
    0x8c0e7e54,
    0x8c0e7e5e,
    0x8c0e7e80,
    0x8c0e7e8c,
    0x8c0e7eb4,
    0x8c0e7ecc,
    0x8c0e7ed6,
    0x8c0e7ef4,
    0x8c0e7f00,
    0x8c0e7f24,
    0x8c0e7f3c,
    0x8c0e7f46,
    0x8c0e7f66,
    0x8c0e7f72,
];


function dd(...$args) {
    var_dump(...$args);
    exit;
}

$contents = file_get_contents('./1ST_READ.BIN');
$mapContents = file_get_contents('./sdk.map');

$addr = $initialAddr = 0x8c0c3954;
$checkLength = $initialCheckLength = 0x10;

while(true) {
    // if (!in_array($addr, $validAddresses)) {
    //     echo "Invalid addr " . dechex($addr) . "\n";
    //     exit;
    // }
    $offset = $addr - 0x8c010000;

    $bytes = substr($contents, $offset, $checkLength);
    $hexBytes = bin2hex($bytes);

    unset($result);
    // echo "bgrepping $hexBytes...\n";
    exec("./bgrep $hexBytes ./sdk_obj/*", $result, $code);

    if ($code !== 0) {
        echo "Error while bgrepping...\n";
        exit;
    }

    $lineCount = count($result);
    if ($lineCount > 2) {
        // echo "Multiple objects ($lineCount), expanding...\n";
        $checkLength += 0x2;
        continue;
    } else if ($lineCount < 1) {
        echo "No results, stopping...\n";
        exit;
    }

    $checkLength = $initialCheckLength;

    $result = $result[0];   

    if (!preg_match('/(\w+)\.obj/', $result, $matches)) {
        echo "Couldn't get result obj name...\n";
        exit;
    }
    $obj = $matches[1];

    $hexAddr = dechex($addr);
    echo "; $hexAddr\r\ninput sdk_obj\\$obj.obj\r\n";

    if (!preg_match("/H'[0-9A-F]{8}  -  H'[0-9A-F]{8}  H'([0-9A-F]{8})\r\n\s+$obj\s+/", $mapContents, $matches)) {
        echo "Couldn't query obj length...\n";
        exit;
    }
    
    $addr += hexdec($matches[1]);

    echo "; +0x" . $matches[1] . "\r\n";

    $rem = $addr % 4;
    if ($rem) {
        $addr += (4 - $rem);
    }
}
