<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize\Exceptions;


use Throwable;

class OrganizeExceptions extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

define('ERR_PARAMS', 10001);
define('ERR_PARAMS_CONTENT', '参数异常');
define('ERR_FORMAT', 10002);
define('ERR_FORMAT_CONTENT', '数据结构异常');
define('ERR_FILE_NOT_EXISTS', 10003);
define('ERR_FILE_NOT_EXISTS_CONTENT', '文件不存在');