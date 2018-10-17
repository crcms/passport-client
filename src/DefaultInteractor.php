<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-15 07:17
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Client;

use CrCms\Foundation\Rpc\Client\Rpc;
use CrCms\Foundation\Rpc\Contracts\ResponseContract;
use CrCms\Foundation\Rpc\Contracts\RpcContract;
use CrCms\Foundation\Passport\Client\Contracts\InteractionContract;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use Exception;

/**
 * Class DefaultInteractor
 * @package CrCms\Foundation\Passport\Client
 */
class DefaultInteractor implements InteractionContract
{
    /**
     * @var RpcContract
     */
    protected $rpc;

    /**
     * DefaultInteractor constructor.
     * @param RpcContract $rpc
     */
    public function __construct(Rpc $rpc)
    {
        $this->rpc = $rpc;
    }

    /**
     * @param string $token
     * @return object
     */
    public function refresh(string $token): object
    {
        return $this->rpc->call('passport', config('foundation.passport.routes.refresh'), $this->requestParams(['token' => $token]));
    }

    /**
     * @param string $token
     * @return object
     */
    public function user(string $token): object
    {
        return $this->rpc->call('passport', config('foundation.passport.routes.user'), $this->requestParams(['token' => $token]));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function check(string $token): bool
    {
        $this->rpc->call(config('foundation.passport.routes.check'), $this->requestParams(['token' => $token]));
        return $this->rpc->getClient()->getStatusCode() === 204 || $this->rpc->getClient()->getStatusCode() === 200;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function logout(string $token): bool
    {
        $this->rpc->method('get')->call(config('foundation.passport.routes.logout'), $this->requestParams(['token' => $token]));
        return $this->rpc->getClient()->getStatusCode() === 204 || $this->rpc->getClient()->getStatusCode() === 200;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function requestParams(array $params): array
    {
        return array_merge(['app_key' => config('foundation.passport.key'), 'app_secret' => config('foundation.passport.secret')], $params);
    }
}