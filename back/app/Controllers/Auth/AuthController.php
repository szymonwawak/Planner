<?php


namespace App\Controllers\Auth;

use App\Models\Teacher;
use App\Controllers\Controller;
use Firebase\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $email = $data['email'];
        $password = $data['password'];
        $teacher = Teacher::where('email', $email)->first();
        $userData = array(
            "email" => $teacher->email,
            "userId" => $teacher->id
        );
        if (!$teacher)
            return $response->withStatus(403)->withJson(['error' => true, 'message' => 'Podano niepoprawne dane!']);
        if (!password_verify($password, $teacher->password))
            return $response->withStatus(403)->withJson(['error' => true, 'message' => 'Podano niepoprawne dane']);
        $settings = $this->container->get('settings');
        $key = $settings['jwt']['secret'];
        $token = JWT::encode($userData, $key, "HS256");
        return $response->withStatus(200)->withJson(['succes' => true, 'token' => $token]);
    }
}
