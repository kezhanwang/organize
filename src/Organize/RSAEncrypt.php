<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize;


use Organize\Exceptions\OrganizeExceptions;

class RSAEncrypt
{
    public static function encrypt($string, $rsaPublicFilePath)
    {
        if (!is_string($string)) {
            throw new OrganizeExceptions();
        }

        if (!file_exists($rsaPublicFilePath)) {
            throw new OrganizeExceptions();
        }

        $maxlength = 117;
        $encrypted = "";
        $publicKey = openssl_pkey_get_public(file_get_contents($rsaPublicFilePath));
        while ($string) {
            $input = substr($string, 0, $maxlength);
            $string = substr($string, $maxlength);
            openssl_public_encrypt($input, $out, $publicKey);
            $encrypted .= $out;
        }
        $encrypted = base64_encode($encrypted);
        $encrypted = str_replace('+', '%2B', $encrypted);
        return $encrypted;
    }
}