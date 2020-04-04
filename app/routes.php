<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {

        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
    $app->post('/login', function (Request $request, Response $response, array $args) {

        $input = $request->getParsedBody();
        $sql = "SELECT * FROM teacher WHERE email= :email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject();

        // verify email address.
        if(!$user) {
            return $this->response->withJson(['error' => true, 'message' => 'Adres email jest niepoprawny']);
        }

        // verify password.
        if (!password_verify($input['password'],$user->password)) {
            return $this->response->withJson(['error' => true, 'message' => 'Hasło jest niepoprawne']);
        }

        $settings = $this->get('settings'); // get settings array.

        $token = JWT::encode(['surname' => $user->surname, 'email' => $user->email], $settings['jwt']['secret'], "HS256");

        return $this->response->withJson(['token' => $token]);

    });
    $app->group('/api', function(\Slim\App $app) {

        $app->get('/user',function(Request $request, Response $response, array $args) {
            print_r($request->getAttribute('decoded_token_data'));

            /*output
            stdClass Object
                (
                    [id] => 2
                    [email] => arjunphp@gmail.com
                )

            */
        });

    });
};
