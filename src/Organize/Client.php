<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize;


use Organize\Exceptions\OrganizeExceptions;

class Client
{
    private $merchant;
    private $signature;
    private $data;
    private $rsaPublicFile;
    private $retryTimes;

    public function __construct($merchant, $signature, $data, $rsaPublicFile, $retryTimes = Config::DEFAULT_MAX_RETRY_TIMES)
    {
        if (!is_string($merchant) || !is_string($signature) || !is_string($rsaPublicFile) || !is_array($data) || !is_numeric($retryTimes)) {
            throw new OrganizeExceptions(ERR_PARAMS, ERR_PARAMS);
        }
        $this->merchant = $merchant;
        $this->signature = $signature;
        $this->data = $data;

        if (!is_null($rsaPublicFile) && file_exists($rsaPublicFile)) {
            $this->rsaPublicFile = $rsaPublicFile;
        } else {
            throw new OrganizeExceptions(ERR_FILE_NOT_EXISTS_CONTENT, ERR_FILE_NOT_EXISTS);
        }

        if (!is_null($retryTimes)) {
            $this->retryTimes = $retryTimes;
        } else {
            $this->retryTimes = Config::DEFAULT_MAX_RETRY_TIMES;
        }
    }

    public function getParams($key)
    {
        return $this->$key;
    }

    public function push()
    {
        return new PushPayload($this);
    }
}