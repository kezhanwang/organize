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
            throw new OrganizeExceptions(ERR_PARAMS_CONTENT, ERR_PARAMS);
        }

        if (!file_exists($rsaPublicFilePath)) {
            throw new OrganizeExceptions(ERR_FILE_NOT_EXISTS_CONTENT, ERR_FILE_NOT_EXISTS);
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