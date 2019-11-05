<?php

namespace sillydong\signrequest;

use Yii;

class Sign {
    /**
     * 生成随机字符串
     * @param int $length
     * @return string
     */
    public static function nonce($length = 32){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    /**
     * 生成校验签名
     * 注: params不能包含secret字段，建议设置随机字符串避免重放攻击
     * @param array $params 参加校验的数组，文件参数不参与校验
     * @param string $secret 密钥
     * @return string
     */
    public static function sign($params,$secret){
        ksort($params);

        $sparams = array();
        foreach ($params as $k => $v) {
            if ("@" != substr($v, 0, 1)) {
                $sparams[] = "$k=$v";
            }
        }
        $sparams[] = "secret=" . $secret;
        return strtoupper(md5(implode("&", $sparams)));
    }

    /**
     * 检查请求签名
     * @param array $params 完整的请求参数
     * @param string $signname 参数中签名的字段名
     * @param string $secret 密钥 
     * @return bool
     */
    public static function check($params,$signname,$secret){
        $tmpparams = $params;
        $requestsign = $params[$signname];
        if (isset($tmpparams[$signname])) {
            unset($tmpparams[$signname]);
            $sign = self::sign($tmpparams, $secret);

            return $sign === $requestsign;
        }
        else {
            return false;
        }
    }
}
