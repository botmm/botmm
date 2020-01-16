<?php


namespace botmm\common;


class qq_info
{


public $Account;    // 文本型, , , qq
public $QQ;        // 长整数型, , , qq 10
public $user;        // 字节集, , , qq_hex
public $caption;        // 字节集, , , qq_utf-8
public $pass;        // 文本型
public $md5;        // 字节集
public $md52;        // 字节集
public $time;        // 字节集
public $key;        // 字节集
public $nick;        // 文本型
public $Token002C;        // 字节集
public $Token004C;        // 字节集, , , A2
public $Token0058;        // 字节集
public $TGTKey;        // 字节集
public $shareKey;        // 字节集
public $pub_key;        // 字节集
public $_ksid;        // 字节集
public $randKey;        // 字节集
public $mST1Key;        // 字节集, , , transport秘药
public $stweb;        // 文本型
public $skey;        // 字节集
public $pskey;        // 字节集, , , 01 6C 暂时没返回
public $superkey;        // 字节集, , , 01 6D 暂时没返回
public $vkey;        // 字节集
public $sid;        // 字节集
public $sessionKey;        // 字节集
public $loginState;        // 整数型, , , 登陆是否验证成功
public $VieryToken1;        // 字节集, , , 验证码token
public $VieryToken2;        // 字节集, , , 验证码token
public $Viery;        // 字节集, , , y验证码
}
//
//.数据类型 HeadData
//.成员 type, 字节型
//.成员 tag, 整数型, , , 1-10
//
//.数据类型 JceMap
//.成员 key_type, 字节型
//.成员 key, 字节集
//.成员 val_type, 字节型
//.成员 val, 字节集
//
//.数据类型 JceStruct_RequestPacket
//.成员 iversion, 短整数型
//.成员 cPacketType, 短整数型
//.成员 iMessageType, 短整数型
//.成员 iRequestId, 整数型
//.成员 sServantName, 文本型
//.成员 sFuncName, 文本型
//.成员 sBuffer, 字节集
//.成员 iTimeout, 整数型
//.成员 context, JceMap, , "1", 重定义下
//.成员 status, JceMap, , "1", 重定义下
//
//.数据类型 JceStruct_SvcReqRegister
//.成员 lUin, 长整数型, , , 0
//.成员 lBid, 长整数型, , , 1
//.成员 cConnType, 字节型, , , 2
//.成员 sOther, 文本型, , , 3
//.成员 iStatus, 整数型, , , 4
//.成员 bOnlinePush, 字节型, , , 5
//.成员 bIsOnline, 字节型, , , 6
//.成员 bIsShowOnline, 字节型, , , 7
//.成员 bKikPC, 字节型, , , 8
//.成员 bKikWeak, 字节型, , , 9
//.成员 timeStamp, 长整数型, , , 10
//.成员 _11, 字节型, , , 11
//.成员 _12, 字节型
//.成员 _13, 文本型
//.成员 _14, 字节型
//.成员 _imei_, 字节集
//.成员 _17, 短整数型
//.成员 _18, 字节型
//.成员 _19_device, 文本型
//.成员 _20_device, 文本型
//.成员 _21_sys_ver, 文本型
//
//.数据类型 JceStruct_FSOLREQ
//.成员 luin, 长整数型
//.成员 _1, 短整数型
//.成员 _2, 短整数型
//.成员 _3, 短整数型
//.成员 _4, 短整数型
//.成员 _5, 短整数型
//.成员 _6, 短整数型
//
//.数据类型 JceStruct_FriendListResp
//.成员 reqtype, , , , 0
//.成员 ifReflush, , , , 1
//.成员 uin, 长整数型, , , 2
//.成员 startIndex, , , , 3
//.成员 getfriendCount, , , , 4
//.成员 totoal_friend_count, , , , 5
//.成员 friend_count, , , , 6
//.成员 vecFriendInfo
//.成员 groupid
//.成员 ifGetGroupInfo
//.成员 groupstartIndex
//.成员 getgroupCount
//.成员 totoal_group_count
//.成员 group_count
//.成员 vecGroupInfo
//.成员 result
//.成员 errorCode
//.成员 online_friend_count
//.成员 serverTime
//.成员 sqqOnLine_count
//.成员 cache_vecFriendInfo, 字节集
//.成员 cache_vecGroupInfo, 字节集
//
//.数据类型 JceStruct_GroupListResp
//.成员 a, 整数型
//.成员 b, 整数型
//.成员 c, 文本型
//.成员 d, 长整数型
//.成员 e, 整数型
//
//.数据类型 JceStruct_FriendInfo
//.成员 friendUin, 长整数型
//.成员 groupId
//.成员 faceId
//.成员 name, 文本型
//.成员 online, 文本型, , , 在线方式
//.成员 sqqtype, 整数型
//.成员 status
//.成员 memberLevel
//.成员 isMqqOnLine
//.成员 sqqOnLineState
//.成员 isIphoneOnline
//.成员 detalStatusFlag
//.成员 sqqOnLineStateV2
//.成员 sShowName, 文本型
//.成员 isRemark
//.成员 nick, 文本型
//.成员 cSpecialFlag
//.成员 VecIMGroupID, 字节集
//.成员 VecMSFGroupID, 字节集
//
//.数据类型 JceStruct_GroupInfo
//.成员 groupId
//.成员 groupname, 文本型
//.成员 friend_count, 整数型
//.成员 groupqm, 文本型
//.成员 online_friend_count
//.成员 seqid
//.成员 sqqOnLine_count
//
//.数据类型 JceStruct_FL
//.成员 _0_reqtype, 短整数型
//.成员 _1_ifReflush, 短整数型
//.成员 luin, 长整数型
//.成员 _3_startIndex, 短整数型
//.成员 _4_getfriendCount, 短整数型
//.成员 _5_totoal_friend_count, 短整数型
//.成员 _6_friend_count, 短整数型
//.成员 _7, 短整数型
//.成员 _8, 短整数型
//.成员 _9, 短整数型
//.成员 _10, 短整数型
//.成员 _11, 短整数型
//.成员 _12, 短整数型
//.成员 _13, 短整数型
//.成员 _14, 文本型
//
//.数据类型 JceStruct_ReqHeader
//.成员 _0_shVersion, 短整数型
//.成员 _1_lMID, 长整数型, , , qq
//.成员 _2_appid, 整数型
//.成员 _3_eBusiType, 短整数型
//.成员 _4_eMqqSysType, 短整数型
//.成员 _5, 短整数型
//.成员 _6, 短整数型
//
//.数据类型 RespEncounterInfo
//.成员 lEctID, 长整数型
//.成员 iDistance, 整数型
//.成员 lTime, 整数型
//.成员 strDescription, 文本型
//.成员 wFace, 短整数型
//.成员 cSex, 字节型
//.成员 cAge, 字节型
//.成员 strNick, 文本型
//.成员 num, 长整数型
//.成员 gender, 整数型
//.成员 age, 文本型
//.成员 province, 文本型
//.成员 cGroupId, 字节型
//.成员 strPYFaceUrl, 文本型
//.成员 strSchoolName, 文本型
//.成员 strCompanyName, 文本型
//.成员 strPYName, 文本型
//.成员 nFaceNum, 整数型
//.成员 strCertification, 文本型
//.成员 shIntroType, 短整数型
//.成员 vIntroContent, 字节集
//.成员 vFaceID, 字节集
//.成员 eMerchantType, 整数型
//.成员 iVoteIncrement, 整数型
//.成员 bIsSingle, 字节型
//.成员 iLat, 整数型
//.成员 iLon, 整数型
//.成员 iRank, 整数型
//.成员 lTotalVisitorsNum, 整数型
//.成员 cSpecialFlag, 字节型
//
//.数据类型 JceStruct_ReqUserInfo
//.成员 _0_vCells, 短整数型, , "4"
//.成员 _3_strAuthName, 文本型
//.成员 _4_strAuthPassword, 文本型
//.成员 _5_eListType, 短整数型
//.成员 _6, 短整数型
//
//.数据类型 JceStruct_GpsInfo
//.成员 lat, 整数型
//.成员 lon, 整数型
//.成员 alt
//.成员 eType
//.成员 accuracy, 小数型, , "1"
//
//.数据类型 JceStruct_GPS
//.成员 _0_time, 整数型, , , time
//.成员 _1_luin, 长整数型, , , qq
//.成员 _2, 整数型, , , 114372142
//.成员 _3, 长整数型, , , 4738116111738333504
//.成员 _4, 长整数型, , , 126427945827296800
//.成员 _5, 文本型, , , 湖北省
//.成员 _6
//
//.数据类型 数据类型1
//.成员 _0
//.成员 _1, 短整数型
//.成员 _2, 长整数型, , , 126431811297864200
//.成员 _3, 短整数型
//.成员 _4, 短整数型
//.成员 _5, 整数型, , , 1007531172
//.成员 _6, 整数型, , , 1506
//
//.数据类型 struct_msg
//.成员 type, 整数型
//.成员 text, 文本型
//
//.数据类型 struct_group_msg
//.成员 groupUin, 整数型
//.成员 sendUin, 长整数型
//.成员 sendName, 字节型, , "20"
//.成员 arr, struct_msg_type, , "20"
//
//.数据类型 struct_msg_type
//.成员 type, 整数型
//.成员 msg_len, 整数型
//.成员 msg, 字节型, , "1000"
//
//.数据类型 CardData
//.成员 qq, 长整数型
//.成员 name, 文本型
//.成员 zanNum, 整数型
//
//.数据类型 JceStruct_Group_MemberList
//.成员 a, 长整数型
//.成员 b, 长整数型
//.成员 c, 长整数型
//
//.数据类型 SYSTEMTIME, 公开, 系统时间
//.成员 年, 短整数型, , , wYear
//.成员 月, 短整数型, , , wMonth
//.成员 星期, 短整数型, , , wDayOfWeek(0~6,0=星期天,1=星期一,…)
//.成员 日, 短整数型, , , wDay
//.成员 时, 短整数型, , , wHour
//.成员 分, 短整数型, , , wMinute
//.成员 秒, 短整数型, , , wSecond
//.成员 毫秒, 短整数型, , , wMilliseconds
//
//.数据类型 FILETIME, , 文件时间
//.成员 time, 长整数型
//
