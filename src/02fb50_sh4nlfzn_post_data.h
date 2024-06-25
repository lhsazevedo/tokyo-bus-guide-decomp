#ifndef SH4NLFZN_POST_DATA_H_
#define SH4NLFZN_POST_DATA_H_

#define TEX_BUFSIZE     0x80800
// #define TEX_NUM         3072
#define CACHE_BUFSIZE   0x20000
#define SHAPE_BUFSIZE   0x200
// #define RENDER_X        256
// #define RENDER_Y        512
#define VERTEX_BUFSIZE  0x880

extern Sint8          var_cachebuf_8c235ca0[CACHE_BUFSIZE];
extern NJS_VERTEX_BUF var_vbuf_8c255ca0[VERTEX_BUFSIZE];
extern Sint8          var_texbuf_8c277ca0[TEX_BUFSIZE];
extern Float          var_shapebuf_8c2f84a0[SHAPE_BUFSIZE];
extern NJS_MATRIX     var_matrix_8c2f8ca0[16];

#endif // SH4NLFZN_POST_DATA_H_
