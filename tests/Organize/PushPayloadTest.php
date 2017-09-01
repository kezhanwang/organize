<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/1
 * Time: 下午9:39
 */

namespace Organize\Tests;


use PHPUnit\Framework\TestCase;

class PushPayloadTest extends TestCase
{
    protected function setUp()
    {
        global $client;
        $this->payload = $client->push()
            ->setProduction();
        
    }
}