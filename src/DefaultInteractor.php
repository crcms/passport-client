<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-15 07:17
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Client;

use CrCms\Foundation\MicroService\Client\Service;
use CrCms\Foundation\Passport\Client\Contracts\InteractionContract;

/**
 * Class DefaultInteractor
 * @package CrCms\Foundation\Passport\Client
 */
class DefaultInteractor implements InteractionContract
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * DefaultInteractor constructor.
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $token
     * @return object
     */
    public function refresh(string $token): object
    {
        return $this->service->method('post')->call('passport', config('passport-client.routes.refresh'), $this->requestParams(['token' => $token]));
    }

    /**
     * @param string $token
     * @return object
     */
    public function user(string $token): object
    {
        return $this->service->method('post')->call('passport', config('passport-client.routes.user'), $this->requestParams(['token' => $token]));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function check(string $token): bool
    {
        $this->service->method('post')->call(config('passport-client.routes.check'), $this->requestParams(['token' => $token]));
        return $this->service->getClient()->getStatusCode() === 204 || $this->service->getClient()->getStatusCode() === 200;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function logout(string $token): bool
    {
        $this->service->method('get')->call(config('passport-client.routes.logout'), $this->requestParams(['token' => $token]));
        return $this->service->getClient()->getStatusCode() === 204 || $this->service->getClient()->getStatusCode() === 200;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function requestParams(array $params): array
    {
        return array_merge(['app_key' => config('passport-client.key'), 'app_secret' => config('passport-client.secret')], $params);
    }
}