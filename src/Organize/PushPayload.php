<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize;


use Organize\Exceptions\OrganizeExceptions;

class PushPayload
{
    private $client;

    private $data;
    private $timestamp;
    private $request;

    private $url;

    public function __construct($client)
    {
        $this->client = $client;
        $this->timestamp = time();
        $this->data = $this->client->getParams('data');
    }

    private function createRSAData()
    {
        if (empty($this->data['api'])) {
            throw new OrganizeExceptions(ERR_PARAMS_CONTENT, ERR_PARAMS);
        }

        if (empty($this->data['version'])) {
            throw new OrganizeExceptions(ERR_PARAMS_CONTENT, ERR_PARAMS);
        }

        if (empty($this->data['child_merchant'])) {
            throw new OrganizeExceptions(ERR_PARAMS_CONTENT, ERR_PARAMS);
        }

        $jsonData = json_encode($this->data);
        return RSAEncrypt::encrypt($jsonData, $this->client->getPatams('rsaPublicFile'));
    }

    private function createSignature()
    {
        ksort($this->request);
        $sha1String = implode("|", $this->request) . '|' . $this->client->getParams('signature');
        return Sha1Encrypt::encrypt($sha1String);
    }

    public function setProduction($production = Config::SERVER_ONLINE)
    {
        switch ($production) {
            case Config::SERVER_ONLINE:
                $this->url = 'http://pay.kezhanwang.cn/organize/service/index';
                break;
            case Config::SERVER_UAT:
            case Config::SERVER_TEST:
                $this->url = 'http://open.pay.kezhanwang.cn/organize/service/index';
                break;
            default:
                $this->url = 'http://open.pay.kezhanwang.cn/organize/service/index';
                break;
        }
    }

    public function send()
    {
        $this->request = array(
            'data' => $this->createRSAData(),
            'timestamp' => $this->timestamp,
            'merchant' => $this->client->getParams('merchant'),
        );

        $this->request['signature'] = $this->createSignature();

        if (is_null($this->url)) {
            $this->setProduction();
        }
        $result = HttpRequest::sendRequest($this->url, Config::HTTP_POST, json_encode($this->request));
        return $result;
    }
}