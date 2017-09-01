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

}