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
        $teacher = Teacher::select('id', 'name', 'surname', 'email')->get();
        return $response->withStatus(201)->getBody()->write($teacher->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Teacher::where('id', '=', $id)->count() > 0) {
            $teacher = Teacher::select('id', 'name', 'surname', 'email')->where('id', $id)->get();
            $response->withStatus(201)->getBody()->write($teacher->toJson());
            return $response;
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }


    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (Teacher::where('email', '=', $data['email'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Taki email jest zajęty");
        }

        $pass = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 10]);
        $teacher = new Teacher();
        $teacher->name = $data['name'];
        $teacher->surname = $data['surname'];
        $teacher->email = $data['email'];
        $teacher->password = $pass;
        $teacher->save();

        return $response->withStatus(201)->getBody()->write($teacher->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        if (Teacher::where('id', '=', $id)->count() > 0) {
            $teacher = Teacher::find($id);
            $teacher->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $teacher = Teacher::find($id);
        if ($teacher->email != $data["email"] && Teacher::where('email', '=', $data['email'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Taki email jest zajęty");
        }
        $teacher->name = $data['name'] ?: $teacher->name;
        $teacher->surname = $data['surname'] ?: $teacher->surname;
        $teacher->email = $data['email'] ?: $teacher->email;

        $teacher->save();

        return $response->withStatus(201)->getBody()->write($teacher->toJson());
    }
}