<?php
/**
 * Created by PhpStorm.
 * User: https://pingxonline.com/
 * Date: 2018-09-21
 * Time: 8:49
 */

require_once "config.php";

class detectFace
{
    // getReqSign ：根据 接口请求参数 和 应用密钥 计算 请求签名
    // 参数说明
    //   - $params：接口请求参数（特别注意：不同的接口，参数对一般不一样，请以具体接口要求为准）
    //   - $appkey：应用密钥
    // 返回数据
    //   - 签名结果
    private static function getReqSign($params){
        $appkey = config::$detectFace['APPKEY'];
        // 字典升序
        ksort($params);
        // 拼接url
        $str = '';
        foreach ($params as $key => $value){
            if ($value !== ""){
                $str .= $key.'='.urlencode($value).'&';
            }
        }
        // 拼接app_key
        $str .= 'app_key'. $appkey;
        // MD5
        $sign = strtoupper(md5($str));
        return $sign;
    }

    // doHttpPost ：执行POST请求，并取回响应结果
    // 参数说明
    //   - $url   ：接口请求地址
    //   - $params：完整接口请求参数（特别注意：不同的接口，参数对一般不一样，请以具体接口要求为准）
    // 返回数据
    //   - 返回false表示失败，否则表示API成功返回的HTTP BODY部分
    private static function doHttpPost($url, $params)
    {
        $curl = curl_init();

        $response = false;
        do
        {
            // 1. 设置HTTP URL (API地址)
            curl_setopt($curl, CURLOPT_URL, $url);

            // 2. 设置HTTP HEADER (表单POST)
            $head = array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $head);

            // 3. 设置HTTP BODY (URL键值对)
            $body = http_build_query($params);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

            // 4. 调用API，获取响应结果
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_NOBODY, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            if ($response === false)
            {
                $response = false;
                break;
            }

            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($code != 200)
            {
                $response = false;
                break;
            }
        } while (0);

        curl_close($curl);
        return $response;
    }


    public static function detect($img_path){
        // 获取图片base64的编码,原始图片的base64编码数据（原图大小上限1MB，支持JPG、PNG、BMP格式）
        $data   = file_get_contents($img_path);
        $base64 = base64_encode($data);

        $params = array(
            'app_id'     => config::$detectFace['APPID'],
            'image'      => $base64,
            'mode'       => '0',
            'time_stamp' => strval(time()),
            'nonce_str'  => strval(rand()),
            'sign'       => '',
        );
        $params['sign'] = self::getReqSign($params);

        // 执行API调用
        $url = config::$detectFace['api'];
        $response = self::doHttpPost($url, $params);
        echo $response;
        return $response;
    }

}