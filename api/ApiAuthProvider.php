<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 13.01.2017
 * Time: 08:33
 */
namespace Api;
use Lib\Models\User;
use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Http\InternalRequest;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class ApiAuthProvider
 * Authorizes X-Acces-Token requests from the Runners mobile app.
 * This can, and should be improved to be more modular, adding the possibilities to check other headers
 * @package App\Http\Auth
 */
class ApiAuthProvider extends Authorization
{
    protected $header = "X-Access-Token";
    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return strtolower($this->header);
    }
    public function validateAuthorizationHeader(Request $request)
    {
        if($request->headers->has($this->header))
            return true;
        if(parent::validateAuthorizationHeader($request))
            return true;
        throw new BadRequestHttpException;
    }
    /**
     * Authenticate the request and return the authenticated user instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        if($request instanceof InternalRequest)
            return true;
        //first get the token
        $token = $this->getToken($request);
        if(!$token)
            throw new UnauthorizedHttpException("Access-Token","Unable to authenticate, no token");
        if($this->validateTokenIntegrity($token))
        {
            return $this->getUserToken($token);
        }
        throw new UnauthorizedHttpException("Access-Token","Integrity of token was violated");
    }
    protected function getUserToken($token)
    {
        $user = User::where(User::getAccessTokenKey(),$token);
        if($user->count() != 1)//only 1 user can have the access token
            throw new UnauthorizedHttpException("User-Token","Unable to find any user with token={$token}");
        return $user->first();
    }
    private function getToken($request)
    {
        try {
            //check the headers first
            $this->validateAuthorizationHeader($request);
            $token = $this->parseAuthorizationHeader($request);
        } catch (\Exception $exception) {
            //maybe in the query?
            if ($request->query(strtolower($this->header), false))
                $token = $request->query(strtolower($this->header));
            else if ($request->query("token", false))
                $token = $request->query("token", false);
            else
                throw $exception;
        }
        return $token;
    }
    private function parseAuthorizationHeader(Request $request)
    {
        //get token either from X-Access-Token or Authorization header
        return $request->header($this->header,function() use($request){
            return trim(str_ireplace($this->getAuthorizationMethod(), '', $request->header('authorization')));
        });
    }
    /**
     * Dummy method, but could be useful
     * @param $token
     * @return bool
     */
    private function validateTokenIntegrity($token)
    {
        return true;
    }
}
