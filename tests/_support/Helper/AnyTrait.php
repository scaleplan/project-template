<?php

namespace App\tests\_support\Helper;

use App\Models\User;
use App\Services\UserService;
use Codeception\Module\REST;
use Codeception\Util\HttpCode;
use Lmc\HttpConstants\Header;

/**
 * Trait AnyTrait
 *
 * @package App\tests\_support\Helper
 */
trait AnyTrait
{
    /**
     * @return REST
     */
    public function getRestModule() : REST
    {
        return $this->getModule('REST');
    }

    /**
     * @return array
     */
    public function registerAndAuth() : array
    {
        $rest = $this->getRestModule();
        $rest->haveHttpHeader(Header::X_REQUESTED_WITH, 'xmlhttprequest');

        $login = uniqid(time(), false);
        $password = uniqid(time(), false);
        $userData = [
            'login'        => $login,
            'password'     => $password,
            'hash'         => md5($login . $password),
            'email'        => "$login@qooiz.me",
            'phone_number' => '',
        ];
        $rest->sendPOST('/user/reg-user', $userData);
        $rest->seeResponseCodeIs(HttpCode::TEMPORARY_REDIRECT);

        return $userData;
    }

    /**
     * @param array $userData
     *
     * @return string
     *
     * @throws \Scaleplan\Helpers\Exceptions\EnvNotFoundException
     * @throws \SodiumException
     */
    public function getUserToken(array $userData) : string
    {
        return (new UserService)->getUserToken(new User($userData));
    }

    /**
     * @param int $length
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getRandomString($length = 10) : string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
