<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Consultation;
use Firebase\JWT\JWT;

class ConsultationController extends Controller
{

    public function getAll(Request $request, Response $response)
    {
        return $response->getBody()->write(Consultation::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $consult = Consultation::where('id', $id)->get();
        if ($consult->isEmpty()) return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
        return $response->getBody()->write($consult->toJson());

    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $consult = new Consultation();
        $consult->day = $data['day'];
        $consult->end_date = $data['end_date'];
        $consult->start_date = $data['start_date'];
        $consult->start_time = $data['start_time'];
        $consult->finish_time = $data['finish_time'];
        $consult->teacher_subject_id = $data['teacher_subject_id'];
        $consult->save();

        return $response->withStatus(201)->getBody()->write($consult->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $consult = Consultation::where('id', $id)->first();
        if ($consult != null) {
            $consult->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $consult = Consultation::where('id', $id);

        $consult->day = $data['day'] ?: $consult->day;
        $consult->start_date = $data['start_date'] ?: $consult->start_date;
        $consult->end_date = $data['end_date'] ?: $consult->end_date;
        $consult->start_time = $data['start_time'] ?: $consult->start_time;
        $consult->finish_time = $data['finish_time'] ?: $consult->finish_time;
        $consult->teacher_subject_id = $data['teacher_subject_id'] ?: $consult->teacher_subject_id;

        $consult->save();

        return $response->withStatus(201)->getBody()->write($consult->toJson());
    }

    public function getConsultations(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $items = array();
        $consult = Consultation::where('start_date', '>' ,$data['start_date'] )->where('end_date','<',$data['end_date'])->where('teacher_subject_id',$data['teacher_subject_id'])->get();

        foreach ($consult as $c) {
            $items[] = $c;
        }
        $myJSON = json_encode($items);
        return $response->withStatus(201)->getBody()->write($myJSON);
    }



    public function getStudentConsultations(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $items = array();
        $consult = Consultation::where('start_date', '>' ,$data['start_date'] )->where('end_date','<',$data['end_date'])->where('teacher_subject_id',$data['teacher_subject_id'])->get();

        foreach ($consult as $c) {
            $items[] = $c->studentConsultations;
        }
        $myJSON = json_encode($items);
        return $response->withStatus(201)->getBody()->write($myJSON);
    }
}
