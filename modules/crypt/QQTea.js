'use strict';
var delta = 0x9E3779B9;
function encrypt(k, v) {
    k = stringToLongArray(k);
    var vl = v.length;
    var FILL_N_OR = 0xF8;
    var filln = (8 - (vl + 2)) % 8;
    filln += 2 + (filln < 0 ? 8 : 0);
    var fills = (new Array(filln + 1)).join(',').replace(/,/g, function () {
        return String.fromCharCode(parseInt(Math.random() * 0x100));
    });
    var v = String.fromCharCode((filln - 2) | FILL_N_OR) +
        fills +
        v +
        String.fromCharCode.apply(String, [0, 0, 0, 0, 0, 0, 0]); //尾部填充的 7 字节的 \0
    var tr = '\x00\x00\x00\x00\x00\x00\x00\x00', to = tr, r = '', o = tr;
    vl = v.length;
    for (var i = 0; i < vl; i += 8) {
        o = xor(v.substr(i, 8), tr);
        tr = xor(encipher(o, k), to);
        to = o;
        r += tr;
    }
    return r;
}
exports.encrypt = encrypt;
function decrypt(k, v) {
    var l = v.length;
    k = stringToLongArray(k);
    var preCrypt = v.substr(0, 8);
    var prePlain = decipher(preCrypt, k);
    var pos = (prePlain.charCodeAt(0) & 0x7) + 2;
    var r = prePlain, x;
    for (var i = 8; i < l; i += 8) {
        x = xor(decipher(xor(v.substr(i, 8), prePlain), k), preCrypt);
        prePlain = xor(x, preCrypt);
        preCrypt = v.substr(i, 8);
        r += x;
    }
    if (parseInt(bin2hex(r.substr(r.length - 7)), 16) !== 0) {
        return '';
    }
    pos++;
    return r.substr(pos, r.length - 7 - pos);
}
exports.decrypt = decrypt;
/*
 v	binary string
 key array
 return binay string
 */
function decipher(v, key) {
    var sum = (delta << 4) & 0xffffffff, n = 0x10; //16轮加密
    var data = stringToLongArray(v);
    while (n-- > 0) {
        data[1] -= (((data[0] << 4 & 0xFFFFFFF0) + key[2]) ^ (data[0] + sum) ^ ((data[0] >> 5 & 0x07ffffff) + key[3]));
        data[1] &= 0xffffffff;
        data[0] -= (((data[1] << 4 & 0xFFFFFFF0) + key[0]) ^ (data[1] + sum) ^ ((data[1] >> 5 & 0x07ffffff) + key[1]));
        data[0] &= 0xffffffff;
        sum -= delta;
    }
    return longArrayToString(data);
}
function encipher(v, key) {
    var sum = delta, n = 0x10; //16轮加密
    var data = stringToLongArray(v);
    while (n-- > 0) {
        data[0] += ((data[1] << 4 & 0xFFFFFFF0) + key[0]) ^ (data[1] + sum) ^ ((data[1] >> 5 & 0x07ffffff) + key[1]);
        data[1] += ((data[0] << 4 & 0xFFFFFFF0) + key[2]) ^ (data[0] + sum) ^ ((data[0] >> 5 & 0x07ffffff) + key[3]);
        sum += delta;
    }
    return longArrayToString(data);
}
function xor(a, b) {
    a = bin2hex(a);
    b = bin2hex(b);
    var l = a.length, t, ret = [];
    for (var i = 0; i < l; i += 4) {
        t = '0000' + (parseInt(a.substr(i, 4), 16) ^ parseInt(b.substr(i, 4), 16)).toString(16);
        ret.push(t.substr(t.length - 4));
    }
    return hex2bin(ret.join(''));
}
function hex2bin(data) {
    return data.replace(/\s/g, '').replace(/(..)/g, function (a, b) {
        return String.fromCharCode(parseInt(b, 16));
    });
}
exports.hex2bin = hex2bin;
;
function bin2hex(data) {
    var ret = [];
    for (var i = data.length; i--;) {
        var c = '00' + data.charCodeAt(i).toString(16);
        ret.push(c.substr(c.length - 2));
    }
    return ret.reverse().join('');
}
exports.bin2hex = bin2hex;
function stringToLongArray(string) {
    var result = [];
    for (var i = 0, length = string.length; i < length; i += 4) {
        result.push((string.charCodeAt(i + 0) << 24 |
            string.charCodeAt(i + 1) << 16 |
            string.charCodeAt(i + 2) << 8 |
            string.charCodeAt(i + 3)));
    }
    return result;
}
function longArrayToString(data) {
    for (var i = 0, length = data.length; i < length; i++) {
        data[i] = String.fromCharCode(data[i] >>> 24 & 0xff, data[i] >>> 16 & 0xff, data[i] >>> 8 & 0xff, data[i] & 0xff);
    }
    return data.join('');
}
