<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
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
        if (Subject::where('id', '=', $id)->count() > 0) {
            $subject = Subject::select('id', 'subject_name')->where('id', $id)->get();
            $response->getBody()->write($subject->toJson());
            return $response;
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (Subject::where('subject_name', '=', $data['subject_name'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Taki nazwa już istnieje");
        }
        $subject = new Subject();
        $subject->subject_name = $data['subject_name'];
        $subject->save();

        return $response->withStatus(201)->getBody()->write($subject->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Subject::where('id', '=', $id)->count() > 0) {
            $subject = Subject::where('id', $id);
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
        $subject->subject_name = $data['subject_name'] ?: $subject->subject_name;

        $subject->save();

        return $response->withStatus(201)->getBody()->write($subject->toJson());
    }
}
