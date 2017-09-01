<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize;


class PushPayload
{
    private $client;

    private $data;
    private $timestamp;
    private $request;

    public function __construct($client)
    {
        $this->client = $client;
        $this->timestamp = time();
        $this->data = $this->client->getParams('data');
    }

    private function createRSAData()
    {
        if (empty($this->data['api'])) {
            throw new OrganizeExceptions();
        }

        if (empty($this->data['version'])) {
            throw new OrganizeExceptions();
        }

        if (empty($this->data['child_merchant'])) {
            throw new OrganizeExceptions();
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

    public function send()
    {
        $this->request = array(
            'data' => $this->createRSAData(),
            'timestamp' => $this->timestamp,
            'merchant' => $this->client->getParams('merchant'),
        );

        $this->request['signature'] = $this->createSignature();
    }
}