<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Teacher;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\StudentConsultation;


class ConsultationStudentController extends Controller
{

    public function getAll(Request $request, Response $response)
    {

        return $response->getBody()->write(StudentConsultation::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $student = StudentConsultation::where('id', $id)->get();
        if ($student->isEmpty())
            return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
        return $response->getBody()->write($student->toJson());
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if ($data['start_time'] >= $data['finish_time'])
            return $response->withStatus(400)->getBody()->write("Błędnie podany czas konsultacji");
        if (StudentConsultation::where('start_time', '<=', $data['start_time'])->where("finish_time", ">", $data['start_time'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny1");
        }
        if (StudentConsultation::where('finish_time', '>=', $data['finish_time'])->where("start_time", "<", $data['finish_time'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny2");
        }

        $student = new StudentConsultation();
        $student->data = $data['data'];
        $student->consultation_id = $data['consultation_id'];
        $student->student_name = $data['student_name'];
        $student->student_surname = $data['student_surname'];
        $student->student_email = $data['student_email'];
        $student->start_time = $data['start_time'];
        $student->finish_time = $data['finish_time'];
        $student->accepted =0;

        $student->save();

        return $response->withStatus(201)->getBody()->write($student->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
            $userId=$this->getUserIdfromToken($request);
        $student = StudentConsultation::where('id', $userId)->first();
        if ($student != null) {
            $student->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $student = StudentConsultation::where('id', $id);
        $startTimeTemp = $student->start_time;
        $finishTimeTemp = $student->finish_time;
        if (!($student->start_time == $data['start_time'] && $student->finish_time == $data['finish_time'])) {

        }
        if ($data['start_time'] >= $data['finish_time'])
            return $response->withStatus(400)->getBody()->write("Błędnie podany czas konsultacji");
        $student->start_time = '00:00:00';
        $student->finish_time = '00:00:00';
        $student->save();
        if (StudentConsultation::where('start_time', '<=', $data['start_time'])->where("finish_time", ">", $data['start_time'])->count() > 0) {
            $student->start_time = $startTimeTemp;
            $student->finish_time = $finishTimeTemp;
            $student->save();
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny1");
        }
        if (StudentConsultation::where('finish_time', '>=', $data['finish_time'])->where("start_time", "<", $data['finish_time'])->count() > 0) {
            $student->start_time = $startTimeTemp;
            $student->finish_time = $finishTimeTemp;
            $student->save();
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny2");
        }

        $student->student_name = $data['student_name'] ?: $student->student_name;
        $student->student_surname = $data['student_surname'] ?: $student->student_surname;
        $student->student_email = $data['student_email'] ?: $student->student_email ;
        $student->start_time = $data['start_time'] ?: $student->start_time ;
        $student->finish_time = $data['finish_time'] ?: $student->finish_time ;
        $student->accepted = $data['accepted'] ?: $student->accepted = $data;
        $student->consultation_id = $data['consultation_id'] ?: $student->consultation_id ;
        $student->data = $data['data'] ?: $student->data;

        $student->save();

        return $response->withStatus(201)->getBody()->write($student->toJson());
    }



}

