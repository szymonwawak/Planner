<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Lesson;


class LessonController extends Controller
{

    public function getAll(Request $request, Response $response)
    {
        return $response->getBody()->write(Lesson::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Lesson::where('id', '=', $id)->count() > 0) {
            $lesson = Lesson::where('id', $id)->get();
            $response->getBody()->write($lesson->toJson());
            return $response;
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (Lesson::where('idteacher', '=', $data['idteacher'])->where('idsubject', '=', $data['idsubject'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Takie zajęcia już istnieją");
        }
        $lesson = new Lesson();
        $lesson->idteacher = $data['idteacher'];
        $lesson->idsubject = $data['idsubject'];
        $lesson->save();

        return $response->withStatus(201)->getBody()->write($lesson->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Lesson::where('id', '=', $id)->count() > 0) {
            $lesson = Lesson::where('id', $id);
            $lesson->delete();

            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $lesson = Lesson::where('id', $id);
        $lesson->idteacher = $data['idteacher'] ?: $lesson->idteacher;
        $lesson->idsubject = $data['idsubject'] ?: $lesson->idsubject;

        $lesson->save();

        return $response->withStatus(201)->getBody()->write($lesson->toJson());
    }
}
