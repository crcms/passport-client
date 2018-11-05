<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-15 07:17
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Client;

use CrCms\Foundation\MicroService\Client\Exceptions\ServiceException;
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
     * @param array $data
     * @return object
     */
    public function login(array $data): object
    {
        return $this->service->method('post')->call(config('passport-client.service'), config('passport-client.routes.login'), $this->requestParams($data));
    }

    /**
     * @param array $data
     * @return object
     */
    public function register(array $data): object
    {
        return $this->service->method('post')->call(config('passport-client.service'), config('passport-client.routes.register'), $this->requestParams($data));
    }

    /**
     * @param string $token
     * @return object
     */
    public function refresh(string $token): object
    {
        return $this->service->method('post')->call(config('passport-client.service'), config('passport-client.routes.refresh'), $this->requestParams(['token' => $token]));
    }

    /**
     * @param string $token
     * @return object
     */
    public function user(string $token): object
    {
        return $this->service->method('post')->call(config('passport-client.service'), config('passport-client.routes.user'), $this->requestParams(['token' => $token]));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function check(string $token): bool
    {
        try {
            $this->service->method('post')->call(config('passport-client.service'), config('passport-client.routes.check'), $this->requestParams(['token' => $token]));
            return $this->service->getStatusCode() === 204 || $this->service->getStatusCode() === 200;
        } catch (ServiceException $exception) {
            if ($exception->getExceptionStatusCode() === 401) {
                return false;
            }
            throw $exception;
        }
    }

    /**
     * @param string $token
     * @return bool
     */
    public function logout(string $token): bool
    {
        $this->service->method('get')->call(config('passport-client.service'), config('passport-client.routes.logout'), $this->requestParams(['token' => $token]));
        return $this->service->getStatusCode() === 204 || $this->service->getStatusCode() === 200;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function requestParams(array $params): array
    {
        return array_merge(['app_key' => config('passport-client.key'), 'app_secret' => config('passport-client.secret')], $params);
    }

    /**
     * @param string $uri
     * @return string
     */
    protected function passportUrl(string $uri): string
    {
        return config('passport-client.host') . '/' . ltrim($uri, '/');
    }
}