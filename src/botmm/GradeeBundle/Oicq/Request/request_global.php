<?php


namespace botmm\GradeeBundle\Oicq\Request;


 use botmm\BufferBundle\Buffer\Buffer;

 class request_global {
     /** byte[] */
     private static $_IMEI;
     /** byte[] */
     private static $_IMEI_KEY;
     /** SecureRandom */
     public static $_SR;
     /** account_sig_info_map */
     public static $_account_sig_info_map;
     /** byte[] */
     private static $_android_id;
     /** byte[] */
     private static $_apk_id;
     /** byte[] */
     private static $_apk_sig;
     /** byte[] */
     private static $_apk_v;
     /** byte[] */
     private static $_apn;
     /** int */
     private static $_app_client_version;
     /** TreeMap<Long, async_context> */
     public static $_async_data;
     /** Context */
     public static $_context;
     /** long */
     public static $_cur_seqence;
     /** int */
     private static $_dev_chg;
     /** int */
     private static $_dev_report;
     /** byte[] */
     private static $_device;
     /** int */
     private static $_guid_chg;
     /** int */
     private static $_guid_src;
     /** int */
     private static $_img_type;
     /** byte[] */
     private static $_ip_addr;
     /** int */
     private static $_isroot;
     /** byte[] */
     private static $_ksid;
     /** long */
     private static $_l_init_time;
     /** String */
     public static $_last_date;
     /** int */
     public static $_local_id;
     /** byte[] */
     private static $_mac;
     /** int */
     private static $_network_type;
     /** int */
     private static $_new_install;
     /** int */
     private static $_pic_type;
     /** int */
     private static $_read_guid;
     /** byte[] */
     private static $_real_imei;
     /** report_t1 */
     private static $_rt1;
     /** byte[] */
     private static $_sim_operator_name;
     /** long */
     private static $_time_difference;
     /** Boolean */
     private static $isUploading;
     /** int */
     public $_cancel = 0;
     /** int */
     public $_encrypt_type = 0;
     /** WFastLoginInfo */
     public $_fast_login_info;
     /** int */
     public $_msf_transport_flag = 0;
     /** String */
     public $_name = "";
     /** byte[] 16bytes */
     public $_pub_key = "";
     /** byte[] 16bytes */
     public $_rand_key = "";
     /** long */
     public $_seqence = 0;
     /** byte[] 16bytes */
     public $_share_key = "";
     /** Socket */
     public $_sk = null;
     /** int */
     public $_sso_seq = 0;
     /** tlv_t150 */
     public $_t150 = null;
     /** byte[] */
     public $_t172_data = "";
     /** byte[] */
     public $_tgt_key = null;
     /** int */
     public $_time_out = 10000;
     /** Socket */
     public $_transport_sk = null;
     /** long */
     public $_uin = 0;


    public function __construct(Context context) {

        self::$_SR                   = new SecureRandom();
        self::$isUploading           = false;
        self::$_context              = null;
        self::$_local_id             = 2052;
        self::$_last_date            = "";
        self::$_app_client_version   = 0;
        self::$_img_type             = 1;
        self::$_pic_type             = 0;
        self::$_IMEI                 = "";
        self::$_IMEI_KEY             = "";
        self::$_sim_operator_name    = "";
        self::$_network_type         = 0;
        self::$_apk_id               = "";
        self::$_apn                  = "";
        self::$_apk_v                = "";
        self::$_apk_sig              = "";
        self::$_device               = "";
        self::$_real_imei            = "";
        self::$_mac                  = "";
        self::$_android_id           = "";
        self::$_new_install          = 0;
        self::$_read_guid            = 0;
        self::$_guid_chg             = 0;
        self::$_guid_src             = 0;
        self::$_dev_chg              = 0;
        self::$_dev_report           = 0;
        self::$_isroot               = 0;
        self::$_ksid                 = "";
        self::$_time_difference      = 0;
        self::$_l_init_time          = 0;
        self::$_ip_addr              = new byte[4];
        self::$_account_sig_info_map = null;
        self::$_rt1                  = new report_t1();
        self::$_cur_seqence          = 0;
        self::$_async_data           = new TreeMap();

    }

    //    public static function allocSeqence() {
    //       synchronized (request_global.class) {
    //            long l2;
    //            if (_cur_seqence > 200) {
    //                _cur_seqence = 0;
    //            }
    //            _cur_seqence = l2 = _cur_seqence + 1;
    //            return l2;
    //        }
    //    }
    //
    //    public static void clear_async_data() {
    //                       _async_data.clear();
    //    }
    //
    //    public static void clear_sdk_log() {
    //                       String string2 = new SimpleDateFormat("yyyyMMdd").format(new Date());
    //        if (string2.compareTo(_last_date) != 0) {
    //            _last_date = string2;
    //            new delete_expire_log(_context).start();
    //        }
    //    }
    //
    //    public static void dev_compare() {
    //                       byte[] arrby;
    //        byte[] arrby2 = arrby = util.get_mac_addr(_context);
    //        if (arrby != null) {
    //            arrby2 = arrby;
    //            if (arrby.length > 0) {
    //                arrby2 = MD5.toMD5Byte(arrby);
    //            }
    //        }
    //        byte[] arrby3 = util.get_imei_id(_context);
    //        arrby = arrby3;
    //        if (arrby3 != null) {
    //            arrby = arrby3;
    //            if (arrby3.length > 0) {
    //                arrby = MD5.toMD5Byte(arrby3);
    //            }
    //        }
    //        byte[] arrby4 = util.get_IMEI(_context);
    //        arrby3 = arrby4;
    //        if (arrby4 != null) {
    //            arrby3 = arrby4;
    //            if (arrby4.length > 0) {
    //                arrby3 = MD5.toMD5Byte(arrby4);
    //            }
    //        }
    //        if (util.get_last_flag(_context) != 0) {
    //            arrby4 = util.get_last_mac(_context);
    //            byte[] arrby5 = util.get_last_imei(_context);
    //            byte[] arrby6 = util.get_last_guid(_context);
    //            if (!Arrays.equals(arrby2, arrby4)) {
    //                _dev_chg |= 1;
    //            }
    //            if (!Arrays.equals(arrby, arrby5)) {
    //                _dev_chg |= 2;
    //            }
    //            if (!Arrays.equals(arrby3, arrby6)) {
    //                _dev_chg |= 4;
    //            }
    //        }
    //        util.save_cur_flag(_context, 1);
    //        util.save_cur_mac(_context, arrby2);
    //        util.save_cur_imei(_context, arrby);
    //        util.save_cur_guid(_context, arrby3);
    //    }
    //
    //    public static async_context get_async_data(long l2) {
    //    async_context async_context2;
    //        Long l3 = l2;
    //        async_context async_context3 = async_context2 = _async_data.get(l3);
    //        if (async_context2 == null) {
    //            async_context3 = new async_context();
    //            _async_data.put(l3, async_context3);
    //        }
    //        return async_context3;
    //    }
    //
    //    public static long get_cur_time() {
    //        return System.currentTimeMillis() / 1000;
    //    }
    //
    //    public static long get_server_cur_time() {
    //        return System.currentTimeMillis() / 1000 + _l_init_time;
    //    }
    //
    //    /*
    //     * Enabled aggressive block sorting
    //     */
    //    public static void init() {
    //                       int n2 = util.get_saved_network_type(_context);
    //        byte[] arrby = util.get_file_imei(_context);
    //        Object object = util.get_IMEI(_context);
    //        if (arrby == null || arrby.length <= 0) {
    //            if (object == null || object.length <= 0) {
    //                object = new String("%4;7t>;28<fc.5*6").getBytes();
    //                _read_guid = 0;
    //                _guid_src = 20;
    //            } else {
    //                _read_guid = 1;
    //                _guid_src = 17;
    //            }
    //            util.save_file_imei(_context, (byte[])object);
    //            _guid_chg = 0;
    //            _new_install = 1;
    //        } else {
    //            byte[] arrby2;
    //            block13 : {
    //                if (object != null) {
    //                    arrby2 = object;
    //                    if (object.length > 0) break block13;
    //                }
    //                arrby2 = new String("%4;7t>;28<fc.5*6").getBytes();
    //            }
    //            _guid_chg = Arrays.equals(arrby2, arrby) ? 0 : 1;
    //            object = arrby;
    //            _read_guid = 1;
    //            _new_install = 0;
    //            _guid_src = 1;
    //        }
    //        request_global.dev_compare();
    //        _dev_report = _guid_src << 24 & -16777216;
    //        _dev_report |= _dev_chg << 8 & 65280;
    //        _IMEI = (byte[])object.clone();
    //        _IMEI_KEY = (byte[])object.clone();
    //        _real_imei = util.get_imei_id(_context);
    //        if (_real_imei != null && _real_imei.length > 0) {
    //            _real_imei = MD5.toMD5Byte(_real_imei);
    //        }
    //        if ((request_global._mac = util.get_mac_addr(_context)) != null && _mac.length > 0) {
    //            _mac = MD5.toMD5Byte(_mac);
    //        }
    //        if ((request_global._android_id = util.get_android_id(_context)) != null && _android_id.length > 0) {
    //            _android_id = MD5.toMD5Byte(_android_id);
    //        }
    //        _sim_operator_name = util.get_sim_operator_name(_context);
    //        _network_type = util.get_network_type(_context);
    //        if (n2 != _network_type) {
    //            util.set_net_retry_type(_context, 0);
    //            util.save_network_type(_context, _network_type);
    //        }
    //        _apn = util.get_apn_string(_context).getBytes();
    //        _ksid = util.get_ksid(_context);
    //        if (_ksid == null || _ksid.length <= 0) {
    //            util.LOGD("ksid=null");
    //        } else {
    //            util.LOGD("ksid=" + util.buf_to_string(_ksid));
    //        }
    //        _apk_id = util.get_apk_id(_context);
    //        _apk_v = util.get_apk_v(_context, new String(_apk_id));
    //        _apk_sig = util.getPkgSigFromApkName(_context, _context.getPackageName());
    //        object = Build.MODEL;
    //        _device = object == null ? new byte[0] : object.getBytes();
    //        n2 = util.isFileExist("/system/bin/su") || util.isFileExist("/system/xbin/su") || util.isFileExist("/sbin/su") ? 1 : 0;
    //        n2 = n2 == 1 ? 1 : 0;
    //        _isroot = n2;
    //        _rt1 = report_t.read_fromfile(_context);
    //        if (_rt1 == null) {
    //            _rt1 = new report_t1();
    //        }
    //    }
    //
    //    public static void remove_async_data(long l2) {
    //    _async_data.remove(l2);
    //}
    //
    //    public void clear_account(String string2) {
    //    synchronized (this) {
    //    _account_sig_info_map.clear_account(string2);
    //    return;
    //}
    //}
    //
    //    public void clear_sig(long l2, long l3) {
    //    synchronized (this) {
    //    _account_sig_info_map.clear_sig(l2, l3);
    //    return;
    //}
    //}
    //
    //    public void clear_time_ip() {
    //                _ip_addr = null;
    //        _time_difference = 0;
    //        _l_init_time = 0;
    //    }
    //
    //    /*
    //     * Enabled aggressive block sorting
    //     * Enabled aggressive exception aggregation
    //     */
    //    public void close_connect() {
    //                util.LOGD("close_connect", "close_connect");
    //        if (this._sk != null) {
    //            try {
    //                util.LOGD("close_connect", this._sk.toString());
    //                this._sk.close();
    //            }
    //            catch (Exception exception) {
    //                util.printException(exception, _context, "");
    //            }
    //            this._sk = null;
    //        }
    //    }
    //
    //    /*
    //     * Enabled aggressive block sorting
    //     * Enabled aggressive exception aggregation
    //     */
    //    public void close_transport_connect() {
    //                util.LOGD("close_transport_connect", "close_transport_connect");
    //        if (this._transport_sk != null) {
    //            try {
    //                util.LOGD("close_transport_connect", this._transport_sk.toString());
    //                this._transport_sk.close();
    //            }
    //            catch (Exception exception) {
    //                util.printException(exception, _context, "");
    //            }
    //            this._transport_sk = null;
    //        }
    //    }
    //
    //    public request_global getClone(long l2) {
    //    request_global request_global2 = new request_global(null);
    //        request_global2._msf_transport_flag = this._msf_transport_flag;
    //        request_global2._time_out = this._time_out;
    //        if (this._rand_key != null) {
    //            request_global2._rand_key = (byte[])this._rand_key.clone();
    //        }
    //        if (this._pub_key != null && this._share_key != null) {
    //            request_global2._pub_key = (byte[])this._pub_key.clone();
    //            request_global2._share_key = (byte[])this._share_key.clone();
    //        }
    //        if (l2 <= 0) {
    //            request_global2._seqence = request_global.allocSeqence();
    //            return request_global2;
    //        }
    //        request_global2._seqence = l2;
    //        return request_global2;
    //    }
    //
    //    /*
    //     * Enabled force condition propagation
    //     * Lifted jumps to return sites
    //     */
    //    public Long get_account(String object) {
    //    synchronized (this) {
    //    object = _account_sig_info_map.get_account((String)object, true);
    //    if (object == null) return null;
    //    if (object._uin == 0) return null;
    //    return object._uin;
    //}
    //}
    //
    //    public UinInfo get_accountMore(String object) {
    //    synchronized (this) {
    //    object = _account_sig_info_map.get_account((String)object, false);
    //    return object;
    //}
    //}
    //
    //    public List<WloginLoginInfo> get_all_logined_account() {
    //                                 synchronized (this) {
    //                                 new ArrayList();
    //            List<WloginLoginInfo> list = _account_sig_info_map.get_all_logined_account(true);
    //            return list;
    //        }
    //    }
    //
    //    public WloginSigInfo get_siginfo(long l2, long l3) {
    //    synchronized (this) {
    //    util.LOGD("get_siginfo", "uin=" + l2 + "appid=" + l3);
    //    WloginSigInfo wloginSigInfo = _account_sig_info_map.get_siginfo(l2, l3);
    //            if (wloginSigInfo != null) {
    //                // empty if block
    //            }
    //            return wloginSigInfo;
    //        }
    //    }
    //
    //    public WloginSimpleInfo get_simpleinfo(long l2) {
    //    synchronized (this) {
    //    WloginSimpleInfo wloginSimpleInfo = _account_sig_info_map.get_simpleinfo(l2);
    //            if (wloginSimpleInfo != null) {
    //                // empty if block
    //            }
    //            return wloginSimpleInfo;
    //        }
    //    }
    //
    //    public String get_userAccount(long l2) {
    //    synchronized (this) {
    //    String string2 = _account_sig_info_map.get_account(l2);
    //            return string2;
    //        }
    //    }
    //
    //    public boolean is_use_msf_transport() {
    //        if (this._msf_transport_flag == 0) {
    //            return false;
    //        }
    //        return true;
    //    }
    //
    //    public void put_account(String string2, Long l2) {
    //    synchronized (this) {
    //    _account_sig_info_map.put_account(string2, l2, true);
    //    return;
    //}
    //}
    //
    //    public void put_account(String string2, Long l2, boolean bl) {
    //    synchronized (this) {
    //    _account_sig_info_map.put_account(string2, l2, bl);
    //    return;
    //}
    //}
    //
    //    public int put_randseed(long l2, long l3, byte[] arrby) {
    //    synchronized (this) {
    //    int n2 = _account_sig_info_map.put_randseed(l2, l3, arrby);
    //            return n2;
    //        }
    //    }
    //
    //    public int put_siginfo(long l2, long l3, long l4, long l5, byte[] arrby, byte[] arrby2) {
    //    synchronized (this) {
    //    util.LOGD("put st sig:" + l2 + "," + l3 + "," + l4 + "," + l5 + "," + "," + util.buf_len(arrby) + "," + util.buf_len(arrby2));
    //    int n2 = _account_sig_info_map.put_siginfo(l2, l3, l4, l5, arrby, arrby2);
    //            return n2;
    //        }
    //    }
    //
    //    public int put_siginfo(long l2, long l3, byte[][] arrby, long l4, long l5, long l6, long l7, long l8, byte[] arrby2, byte[] arrby3, byte[] arrby4, byte[] arrby5, byte[][] arrby6, byte[] arrby7, byte[] arrby8, byte[] arrby9, byte[] arrby10, byte[] arrby11, byte[] arrby12, byte[] arrby13, byte[] arrby14, byte[] arrby15, byte[] arrby16, byte[] arrby17, byte[] arrby18, byte[][] arrby19, long[] arrl, int n2) {
    //    synchronized (this) {
    //    n2 = _account_sig_info_map.put_siginfo(l2, l3, arrby, l4, l5, l6, l7, l8, arrby2, arrby3, arrby4, arrby5, arrby6, arrby7, arrby8, arrby9, arrby10, arrby11, arrby12, arrby13, arrby14, arrby15, arrby16, arrby17, arrby18, arrby19, arrl, n2);
    //    return n2;
    //}
    //}
    //
    //    public void remove_account(String string2) {
    //    synchronized (this) {
    //    _account_sig_info_map.remove_account(string2);
    //    return;
    //}
    //}
    //
    //    public void set_context(Context arrby) {
    //    _context = arrby;
    //    _account_sig_info_map = new account_sig_info_map((Context)arrby);
    //        arrby = new Buffer(16);
    //        _SR.nextBytes(arrby);
    //        System.arraycopy(arrby, 0, this._rand_key, 0, arrby.length);
    //    }
    //
    //    public void set_time_ip(byte[] arrby, byte[] arrby2) {
    //    _l_init_time = request_global._time_difference = ((long)util.buf_to_int32(arrby, 0) & 0xFFFFFFFFL) - System.currentTimeMillis() / 1000;
    //        _ip_addr = arrby2;
    //    }
}

