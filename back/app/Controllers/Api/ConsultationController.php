<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Consultation;


class ConsultationController extends Controller
{

    public function getAll(Request $request, Response $response)
    {
        return $response->getBody()->write(Consultation::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Consultation::where('id', '=', $id)->count() > 0) {
            $consult = Consultation::where('id', $id)->get();
            $response->getBody()->write($consult->toJson());
            return $response;
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $consult = new Consultation();
        $consult->day = $data['day'];
        $consult->consult_date = $data['consult_date'];
        $consult->start_time = $data['start_time'];
        $consult->finish_time = $data['finish_time'];
        $consult->idlesson = $data['idlesson'];
        $consult->save();

        return $response->withStatus(201)->getBody()->write($consult->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Consultation::where('id', '=', $id)->count() > 0) {
            $consult = Consultation::where('id', $id);
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
        $consult->consult_date = $data['consult_date'] ?: $consult->consult_date;
        $consult->start_time = $data['start_time'] ?: $consult->start_time;
        $consult->finish_time = $data['finish_time'] ?: $consult->finish_time;
        $consult->idlesson = $data['idlesson'] ?: $consult->idlesson;

        $consult->save();

        return $response->withStatus(201)->getBody()->write($consult->toJson());
    }
}
