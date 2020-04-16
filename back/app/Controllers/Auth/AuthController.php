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


        if (!$teacher) {
            return $response->withJson(['error' => true, 'message' => 'Email jest niepoprawny']);
        }


        if (!password_verify($password, $teacher->password)) {
            return $response->withJson(['error' => true, 'message' => 'Hasło jest niepoprawne']);
        }

        $settings = $this->container->get('settings');
        $token = JWT::encode(['email' => $teacher->email], $settings['jwt']['secret'], "HS256");

        return $response->withJson(['succes' => true, 'token' => $token]);

    }
}
