00000D9E  00 00 01 59 00 00 00 0a  02 00 00 00 04 00 00 00   ...Y.... ........
00000DAE  00 0b 32 38 36 37 33 30  31
                                      64 03 dd a9 df 80 82   ..286730 1d......
00000DBE  7c ec e8 b0 80 69 69 e9  81 42 55 ca 09 bd 0c a0   |....ii. .BU.....
00000DCE  17 13 cc 58 e0 bf 3c 7f  e3 7e e8 a3 a9 16 fa 85   ...X..<. .~......
00000DDE  8c 0d bd cd e9 00 14 0f  80 26 14 9b 6a 45 65 c1   ........ .&..jEe.
00000DEE  51 29 4c 4a ac 50 8d 59  b1 a2 d6 2f 65 c7 84 35   Q)LJ.P.Y .../e..5
00000DFE  d2 0c e6 2a 87 0d 5f cf  bf ac 6f c6 3b 59 43 18   ...*.._. ..o.;YC.
00000E0E  6c f4 17 a3 93 23 dc b5  10 f5 8a 65 65 e4 df 60   l....#.. ...ee..`
00000E1E  b5 cd 02 13 9c b9 f1 ea  69 52 0f 5f c3 17 71 85   ........ iR._..q.
00000E2E  41 b2 45 b5 8c af 78 0a  cd ce 72 fc b6 1f df 2e   A.E...x. ..r.....
00000E3E  4a 6a 9d f7 a5 13 99 0f  d1 56 df 72 a5 0b 8e 38   Jj...... .V.r...8
00000E4E  da a1 8c 50 41 12 c7 b9  d9 70 7f 63 91 90 93 67   ...PA... .p.c...g
00000E5E  a6 a7 d9 1c b2 ec df f9  15 e4 e5 e7 e0 48 19 89   ........ .....H..
00000E6E  c7 17 c5 f6 c6 c2 7e 69  8a a3 51 2e c8 b0 cb 81   ......~i ..Q.....
00000E7E  f1 83 c5 e0 85 fb f4 11  99 79 3d f0 e2 e3 b2 04   ........ .y=.....
00000E8E  65 ee ce 87 8b 86 7d ac  f4 97 b4 bf ab d3 cf 61   e.....}. .......a
00000E9E  a6 02 ab f0 d5 fb b1 0a  d3 e6 71 05 81 aa b4 ec   ........ ..q.....
00000EAE  dc 96 f8 cf 32 bd 8f b9  16 45 5a cf 80 f7 3b 6e   ....2... .EZ...;n
00000EBE  ab ce a9 74 b0 dd 9d 52  17 1f 1b b8 75 5b 27 8b   ...t...R ....u['.
00000ECE  c0 d9 ec 6d 16 6a a3 07  a9 39 c7 07 da a1 07 5c   ...m.j.. .9.....\
00000EDE  4f 03 a9 7b 5d 1b e2 52  0e 85 1b 85 48 40 30 24   O..{]..R ....H@0$
00000EEE  82 ae 12 4f 37 ee 3b f9  9f                        ...O7.;. .

00 00 00 cf //head len
00 01 85 4e
20 02 ba 7a //subappid
05 4c 4d 8a
01 00 00 00 00 00 00 00 00 00 00 00
00 00 00 4c //extbin
6f 1c d0 30 01 ab 25 01 dd b2 02 a3 80 4b 02 f2
09 93 00 ab bc 12 2d 0a d9 b4 05 b5 47 0d e2 32
bf 39 71 6d 35 c7 f0 d7 60 86 f5 e9 02 46 3a 30
08 a7 21 09 9e ad 06 eb e6 33 02 46 53 e1 7a 57
35 e5 62 94 09 62 90 dd

00 00 00 14 [GrayUinPro.Check]
47 72 61 79 55 69 6e 50 72 6f 2e 43 68 65 63 6b

00 00 00 08
5a 74 58 df

00 00 00 13 [imei 864394010160994]
38 36 34 33 39 34 30 31 30 31 36 30 39 39 34

00 00 00 14
9f 26 8a 6b 52 1b 52 33 da bf f5 af 8b e5 19 45

00 20 [|460071609915509|A6.6.9.257295]
7c 34 36 30 30 37 31 36 30 39 39 31 35 35 30 39 7c 41 36 2e 36 2e 39 2e 32 35 37 32 39 35

00 00 00 04
00 00 00 65 //len

>
> BYTE = 0;
> SHORT = 1;
> INT = 2;
> LONG = 3;
> FLOAT = 4;
> DOUBLE = 5;
> STRING1 = 6;
> STRING4 = 7;
> MAP = 8;
> LIST = 9;
> STRUCT_BEGIN = 10;
> STRUCT_END = 11;
> ZERO_TAG = 12;
> SIMPLE_LIST = 13;
>


10 [序号1|BYTE] //iVersion
  03
2c [序号2|ZERO_TAG] //cPacketType
3c [序号3|ZERO_TAG] //iMessageType
42 [序号4|INT]      //iRequestId
  00 01 85 4d
56 [序号5|STRING1]  //sServantName
  22 //len [KQQ.ConfigService.ConfigServantObj]
  4b 51 51 2e 43 6f 6e 66 69 67 53 65 72 76 69 63 65 2e 43 6f 6e 66 69 67 53 65 72 76 61 6e 74 4f 62 6a
66 [序号6|STRING1]  //sFuncName
  09 //len
  43 6c 69 65 6e 74 52 65 71 [ClientReq]
7d [序号7|SIMPLE_LIST] //sBuffer
  00 [子序0|BYTE]
    00 [0|BYTE]
    20 [长度]
      08 00 01 06 03 72 65 71 1d 00 00 14 0a 12 05 4c
      4d 8a 26 07 32 38 36 37 33 30 31 36 00 46 00 0b
8c [序号8|ZERO_TAG]空  //iTimeout
98 [序号8|MAP]        //context
  0c [0|ZERO_TAG]空
a8 [序号10|MAP]       //status
  0c [0|ZERO_TAG]空
