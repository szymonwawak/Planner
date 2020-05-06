<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Teacher;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Subject;


class SubjectController extends Controller
{

    public function getAll(Request $request, Response $response)
    {
        return $response->getBody()->write(Subject::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $subject = Subject::find($id);
        if (!$subject)
            return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
        return $response->withStatus(201)->getBody()->write($subject->toJson());
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (Subject::where('name', '=', $data['name'])->count() > 0)
            return $response->withStatus(400)->getBody()->write("Taki nazwa już istnieje");

        $subject = new Subject();
        $subject->name = $data['name'];
        $subject->save();

        return $response->withStatus(201)->getBody()->write($subject->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $subject = Subject::where('id', $id)->first();
        if ($subject != null) {
            $subject->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $subject = Subject::where('id', $id);
        $subject->name = $data['name'] ?: $subject->name;

        $subject->save();

        return $response->withStatus(201)->getBody()->write($subject->toJson());
    }

    public function getUserSubjects(Request $request, Response $response, $args)
    {
        $userId = Utils::getUserIdFromToken($request);
        $teacher = Teacher::find($userId);
        $teacherSubjects = json_encode($teacher->subjects);
        return $response->withStatus(201)->getBody()->write($teacherSubjects);
    }
}

