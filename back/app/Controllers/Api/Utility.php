<?php
namespace App\Controllers\Api;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\TeacherSubject;
use Firebase\JWT\JWT;


class Utility
{

    public function getId($request)
    {
        $authHeader = $request->getHeader('authorization');
        $str = json_encode($authHeader);
        $token = substr($str, 9, strlen($str) - 11);
        $settings = $this->container->get('settings');
        $key = $settings['jwt']['secret'];
        $decoded = JWT::decode($token, $key, array('HS256'));
        return $decoded->userId;
    }
}