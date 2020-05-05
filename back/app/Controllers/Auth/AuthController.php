<?php


namespace App\Controllers\Auth;

use App\Models\Teacher;
use App\Controllers\Controller;
use Firebase\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{

    public function login(Request $request, Response $response, $args)
    {
        $input = $request->getParsedBody();
        $email = $input['email'];
        $password = $input['password'];
        $teacher = Teacher::where('email', $email)->first();

        $payload = array(
            "email" => $teacher->email,
            "userId" => $teacher->id


        );

        if (!$teacher) {
            return $response->withStatus(403)->withJson(['error' => true, 'message' => 'Email jest niepoprawny']);
        }


        if (!password_verify($password, $teacher->password)) {
            return $response->withStatus(403)->withJson(['error' => true, 'message' => 'Hasło jest niepoprawne']);
        }


        $settings = $this->container->get('settings');
        $key=$settings['jwt']['secret'];
        $token = JWT::encode($payload, $key , "HS256");


        $array=(['succes' => true, 'token' => $token]);

        if ($teacher->first_login == 1) {
            $array=(['succes' => true, 'token' => $token, 'forcePasswordChange' => true]);
        }


        return $response->withJson($array);

    }
}
