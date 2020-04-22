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
        if (Consultation::where('idconsult', '=', $id)->count() > 0) {
        $consult = Consultation::where('idconsult', $id)->get();
        $response->getBody()->write($consult->toJson());
        return $response;
        }else{
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $consult = new Consultation();
        $consult->consultdate = $data['consultdate'];
        $consult->starttime=$data['starttime'];
        $consult->finishtime=$data['finishtime'];
        $consult->idlesson=$data['idlesson'];
        $consult->save();

        return $response->withStatus(201)->getBody()->write($consult->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Consultation::where('idconsult', '=', $id)->count() > 0) {
        $consult = Consultation::where('idconsult', $id);

        $consult->delete();

        return $response->withStatus(200);

        }else{
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $consult = Consultation::where('idconsult', $id);

        $consult->consultdate = $data['consultdate'] ?:   $consult->consultdate;
        $consult->starttime=$data['starttime'] ?:   $consult->starttime;
        $consult->finishtime=$data['finishtime'] ?:  $consult->finishtime;
        $consult->idlesson=$data['idlesson'] ?:  $consult->idlesson;


        $consult->save();

        return $response->withStatus(201)->getBody()->write($consult->toJson());

    }
}
