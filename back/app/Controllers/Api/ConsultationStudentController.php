<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Teacher;
use DateTime;
use Illuminate\Support\Facades\Date;
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
        $studentConsultation = StudentConsultation::where('id', $id)->get();
        if ($studentConsultation->isEmpty())
            return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
        return $response->getBody()->write($studentConsultation->toJson());
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        if ($data['start_time'] >= $data['finish_time'])
            return $response->withStatus(400)->getBody()->write("Błędnie podany czas konsultacji");
        if (StudentConsultation::where('consultation_id', $data['consultation_id'])->where('start_time', '<=', $data['start_time'])->where("finish_time", ">", $data['start_time'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");
        }
        if (StudentConsultation::where('consultation_id', $data['consultation_id'])->where('finish_time', '>=', $data['finish_time'])->where("start_time", "<", $data['finish_time'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");
        }
        $studentConsultation = new StudentConsultation();
        $studentConsultation->date = $data['date'];
        $studentConsultation->consultation_id = $data['consultation_id'];
        $studentConsultation->student_name = $data['student_name'];
        $studentConsultation->student_surname = $data['student_surname'];
        $studentConsultation->student_email = $data['student_email'];
        $studentConsultation->start_time = $data['start_time'];
        $studentConsultation->finish_time = $data['finish_time'];
        $studentConsultation->accepted = 0;
        $studentConsultation->save();
        return $response->withStatus(201)->getBody()->write($studentConsultation->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $studentConsultation = StudentConsultation::find($id);
        if ($studentConsultation) {
            $studentConsultation->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $studentConsultation = StudentConsultation::find($id);
        if ($data['start_time'] >= $data['finish_time'])
            return $response->withStatus(400)->getBody()->write("Błędnie podany czas konsultacji");

        if (StudentConsultation::where('start_time', '!=', $studentConsultation->start_time)->where('consultation_id', '=', $studentConsultation->consultation_id)->where('finish_time', '!=', $studentConsultation->finish_time)->where('start_time', '<=', $data['start_time'])->where("finish_time", ">", $data['start_time'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");
        }
        if (StudentConsultation::where('start_time', '!=', $studentConsultation->start_time)->where('consultation_id', '=', $studentConsultation->consultation_id)->where('finish_time', '!=', $studentConsultation->finish_time)->where('finish_time', '>=', $data['finish_time'])->where("start_time", "<", $data['finish_time'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");
        }
        $studentConsultation->student_name = $data['student_name'] ?: $studentConsultation->student_name;
        $studentConsultation->student_surname = $data['student_surname'] ?: $studentConsultation->student_surname;
        $studentConsultation->student_email = $data['student_email'] ?: $studentConsultation->student_email;
        $studentConsultation->start_time = $data['start_time'] ?: $studentConsultation->start_time;
        $studentConsultation->finish_time = $data['finish_time'] ?: $studentConsultation->finish_time;
        $studentConsultation->accepted = true;
        $studentConsultation->consultation_id = $data['consultation_id'] ?: $studentConsultation->consultation_id;
        $studentConsultation->date = $data['date'] ?: $studentConsultation->date;
        $studentConsultation->save();

        return $response->withStatus(201)->getBody()->write($studentConsultation->toJson());
    }


}

