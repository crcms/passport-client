<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2018-07-09 06:47
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Middleware;

use Closure;
use CrCms\Foundation\ConnectionPool\Exceptions\RequestException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class AuthMiddleware
 * @package CrCms\Foundation\Passport\Middleware\Passport
 */
class AuthMiddleware extends AbstractPassportMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response|mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $this->token($request);

        try {
            $result = $this->passport->check($token);
            if ($result === false) {
                try {
                    $rpcResponse = $this->passport->refresh($token);
                    /* @var Response $response */
                    $response = $next($request);
                    return $response->header('Authorization', $rpcResponse->data('data.token'));
                } catch (Exception $exception) {
                    if ($exception instanceof RequestException) {
                        $statusCode = $exception->getConnection()->getStatusCode();
                        $result = (bool)($statusCode >= 200 && $statusCode < 400);
                    } else {
                        throw $exception;
                    }
                }
            }
        } catch (Exception $exception) {
            $result = false;
            if ($exception instanceof RequestException) {
                $statusCode = $exception->getConnection()->getStatusCode();
                $result = (bool)($statusCode >= 200 && $statusCode < 400);
            } else {
                throw $exception;
            }
        }

        if ($result === true) {
            return $next($request);
        } else if (isset($statusCode) && $statusCode === 401) {
            throw new UnauthorizedHttpException($token);
        }
    }
}