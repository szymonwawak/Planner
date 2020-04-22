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
        if (Lesson::where('idlesson', '=', $id)->count() > 0) {
            $lesson = Lesson::where('idlesson', $id)->get();
            $response->getBody()->write($lesson->toJson());
            return $response;
        } else {
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (Lesson::where('id', '=', $data['id'])->where('idsubject', '=', $data['idsubject'])->count() > 0) {
            return $response->withStatus(403)->getBody()->write("Takie zajęcia już istnieją");
        } else {
            $lesson = new Lesson();
            $lesson->id = $data['id'];
            $lesson->idsubject = $data['idsubject'];
            $lesson->save();

            return $response->withStatus(201)->getBody()->write($lesson->toJson());
        }
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Lesson::where('idlesson', '=', $id)->count() > 0) {
            $lesson = Lesson::where('idlesson', $id);

            $lesson->forceDelete();

            return $response->withStatus(200);

        } else {
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $lesson = Lesson::where('idlesson', $id);
        $lesson->id = $data['id'] ?: $lesson->id;
        $lesson->idsubject = $data['idsubject'] ?: $lesson->idsubject;


        $lesson->save();

        return $response->withStatus(201)->getBody()->write($lesson->toJson());

    }
}
