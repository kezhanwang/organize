<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize;

use Organize\Exceptions\OrganizeExceptions;

class HttpRequest
{
    public static function sendRequest($client, $url, $method, $body = null, $times = 1)
    {
        if (!defined('CURL_HTTP_VERSION_2_0')) {
            define('CURL_HTTP_VERSION_2_0', 3);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, Config::USER_AGENT);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Config::CONNECT_TIMEOUT);  // 连接建立最长耗时
        curl_setopt($ch, CURLOPT_TIMEOUT, Config::READ_TIMEOUT);  // 请求最长耗时
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 设置Post参数
        if ($method === Config::HTTP_POST) {
            curl_setopt($ch, CURLOPT_POST, true);
        } else if ($method === Config::HTTP_DELETE || $method === Config::HTTP_PUT) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        if (!is_null($body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive'
        ));

        $output = curl_exec($ch);
        $response = array();
        $errorCode = curl_errno($ch);

        $msg = '';
        if (isset($body['options']['sendno'])) {
            $sendno = $body['options']['sendno'];
            $msg = 'sendno: ' . $sendno;
        }


        if ($errorCode) {
            $retries = 10;
            if ($times < $retries) {
                return self::sendRequest($client, $url, $method, $body, ++$times);
            } else {
                if ($errorCode === 28) {
                    throw new OrganizeExceptions($msg . "Response timeout. Your request has probably be received by JPush Server,please check that whether need to be pushed again.");
                } elseif ($errorCode === 56) {
                    // resolve error[56 Problem (2) in the Chunked-Encoded data]
                    throw new OrganizeExceptions($msg . "Response timeout, maybe cause by old CURL version. Your request has probably be received by JPush Server, please check that whether need to be pushed again.");
                } else {
                    throw new OrganizeExceptions("$msg . Connect timeout. Please retry later. Error:" . $errorCode . " " . curl_error($ch));
                }
            }
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header_text = substr($output, 0, $header_size);
            $body = substr($output, $header_size);
            $headers = array();
            foreach (explode("\r\n", $header_text) as $i => $line) {
                if (!empty($line)) {
                    if ($i === 0) {
                        $headers[0] = $line;
                    } else if (strpos($line, ": ")) {
                        list ($key, $value) = explode(': ', $line);
                        $headers[$key] = $value;
                    }
                }
            }
            $response['headers'] = $headers;
            $response['body'] = $body;
            $response['http_code'] = $httpCode;
        }
        curl_close($ch);
        return $response;
    }
}