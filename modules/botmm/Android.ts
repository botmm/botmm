
export class Android {

    private qq: qq_info;
    private global: qq_global;
    private tlf: Tlv_;
    private RequestId: number;
    private pc_sub_cmd: number;
    private tcp: any;

    private last_error: string;
    private m_friends: JceStruc_FriendInfo;
    private m_Neighbor: RespEncounterInfo;
    private m_bin: ArrayBuffer;

    constructor() {
    }

    /**
     *
     * @param bin
     * @param type 0登录, 1上线, 2上线之后
     * @constructor
     */
    Pack(bin, type) {
    }
}