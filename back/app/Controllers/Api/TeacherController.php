<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Teacher;


class TeacherController extends Controller
{

    public function getAll(Request $request, Response $response)
    {
        $teacher = Teacher::all();
        return $response->withStatus(201)->getBody()->write($teacher->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $teacher = Teacher::where('id', $id)->get();
        if ($teacher->isEmpty())
            return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
        return $response->withStatus(201)->getBody()->write($teacher->toJson());
    }


    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (Teacher::where('email', '=', $data['email'])->count() > 0)
            return $response->withStatus(400)->getBody()->write("Taki email jest zajęty");


        $teacher = new Teacher();
        $teacher->name = $data['name'];
        $teacher->surname = $data['surname'];
        $teacher->email = $data['email'];
        $teacher->password = password_hash('Pa$$word1', PASSWORD_DEFAULT, ['cost' => 10]);
        $teacher->first_login= '1' ;
        $teacher->save();

        return $response->withStatus(201)->getBody()->write($teacher->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $teacher = Teacher::where('id', $id)->first();
        if ($teacher != null) {
            $teacher->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }


    public function update(Request $request, Response $response, $args)
    {
        $id = Utils::getUserIdfromToken($request);
        $data = $request->getParsedBody();
        $teacher = Teacher::find($id);
        if ($teacher->email != $data["email"] && Teacher::where('email', '=', $data['email'])->count() > 0)
            return $response->withStatus(400)->getBody()->write("Taki email jest zajęty");

        $teacher->name = $data['name'] ?: $teacher->name;
        $teacher->surname = $data['surname'] ?: $teacher->surname;
        $teacher->email = $data['email'] ?: $teacher->email;

        $teacher->save();

        return $response->withStatus(201)->getBody()->write($teacher->toJson());
    }

    public function changePassword(Request $request, Response $response, $args)
    {
        $userId = Utils::getUserIdfromToken($request);
        $data = $request->getParsedBody();
        $password = $data['oldPassword'];
        $teacher = Teacher::where('id', $userId)->first();

        if (!password_verify( $password, $teacher->password)) {
            return $response->withStatus(400)->getBody()->write("Stare hasło jest niepoprawne");
        }
        if ($data['newPassword'] !=( $data['passwordCheck'])) {
            return $response->withStatus(400)->getBody()->write("Błędnie powtórzone hasło");
        }
        $newPassword = password_hash($data['newPassword'], PASSWORD_DEFAULT, ['cost' => 10]);

        $teacher->password = $newPassword ;
        $teacher->first_login= '0' ;
        $teacher->save();
        return $response->withStatus(200)->write("Hasło zmienione");
    }
}