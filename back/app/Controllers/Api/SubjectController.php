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
        return $response->withJson(Subject::all());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $subject = Subject::find($args['id']);
        if (!$subject)
            return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
        return $response->withStatus(201)->withJson($subject);
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $name = $data['name'];
        if (Subject::where('name', '=', $name)->count() > 0)
            return $response->withStatus(400)->getBody()->write("Taki nazwa już istnieje");
        $subject = new Subject();
        $subject->name = $name;
        $subject->save();
        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Pomyślnie stworzono przedmiot']);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $subject = Subject::find($args['id']);
        if ($subject) {
            $subject->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $subject = Subject::find($args['id']);
        $subject->name = $data['name'] ?: $subject->name;
        $subject->save();
        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Pomyślnie zaktualizowano przedmiot']);
    }

    public function getUserSubjects(Request $request, Response $response)
    {
        $userId = Utils::getUserIdFromToken($request);
        $teacher = Teacher::find($userId);
        return $response->withStatus(201)->withJson($teacher->subjects);
    }
}

