<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize;


use Organize\Exceptions\OrganizeExceptions;

class Sha1Encrypt
{
    public static function encrypt($string)
    {
        if (!is_string($string)) {
            throw new OrganizeExceptions(ERR_PARAMS_CONTENT, ERR_PARAMS);
        }
        return sha1($string);
    }
}