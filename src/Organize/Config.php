<?php
/**
 * User: wangyi@kezhanwang.cn
 */

namespace Organize;


class Config
{
    const USER_AGENT = 'KEZHANWANG-ORGAINZE-API-PHP-Client';
    const CONNECT_TIMEOUT = 20;
    const READ_TIMEOUT = 120;
    const DEFAULT_MAX_RETRY_TIMES = 3;
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_DELETE = 'DELETE';
    const HTTP_PUT = 'PUT';

    const SERVER_ONLINE = 1;
    const SERVER_UAT = 2;
    const SERVER_TEST = 3;

    /**
     * API接口
     */
    const API_MAPPING_ORG10001 = 'ORG10001';    //获取分期列表，含分页
    const API_MAPPING_ORG10002 = 'ORG10002';    //获取分期订单还款计划表

    /**
     * 最新API接口版本号
     * @var array
     */
    public static $apiMappingVersion = array(
        self::API_MAPPING_ORG10001 => '1.0.0',
        self::API_MAPPING_ORG10002 => '1.0.0',
    );

}