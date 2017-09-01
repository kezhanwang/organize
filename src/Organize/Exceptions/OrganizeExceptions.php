<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/1
 * Time: 下午5:36
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