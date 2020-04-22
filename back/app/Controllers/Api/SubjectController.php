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
        if (Subject::where('idsubject', '=', $id)->count() > 0) {
        $subject = Subject::select('idsubject', 'subjectname')->where('idsubject', $id)->get();
        $response->getBody()->write($subject->toJson());
        return $response;
        }else{
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (Subject::where('subjectname', '=', $data['subjectname'])->count() > 0) {
            return $response->withStatus(403)->getBody()->write("Taki nazwa już istnieje");
        } else {
            $subject = new Subject();
            $subject->subjectname = $data['subjectname'];
            $subject->save();

            return $response->withStatus(201)->getBody()->write($subject->toJson());
        }
    }
    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Subject::where('idsubject', '=', $id)->count() > 0) {
        $subject = Subject::where('idsubject', $id);

        $subject->delete();

        return $response->withStatus(200);

        }else{
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $subject = Subject::where('idsubject', $id);
        $subject->subjectname = $data['subjectname'] ?:  $subject->subjectname;


        $subject->save();

        return $response->withStatus(201)->getBody()->write($subject->toJson());

    }
}
