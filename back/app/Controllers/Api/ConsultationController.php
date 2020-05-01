<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\TeacherSubject;
use DateTime;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Consultation;
use Firebase\JWT\JWT;
use function MongoDB\BSON\toJSON;

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
        if ($consult->isEmpty())
            return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
        return $response->getBody()->write($consult->toJson());

    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if ($data['start_time'] >= $data['finish_time'])
            return $response->withStatus(400)->getBody()->write("Błędnie podany czas konsultacji");

        $startTime = new DateTime($data['start_time']);
        $endTime = new DateTime($data['finish_time']);
        $timeDifference = $endTime->getTimestamp() - $startTime->getTimestamp();
        if ($timeDifference > 3600)
            return $response->withStatus(400)->getBody()->write("Czas konsultacji nie może przekraczać jednej godziny.");

        if (Consultation::where('day', '=', $data['day'])->count() > 0) {
            if (Consultation::where('day', '=', $data['day'])->where('start_time', '<=', $data['start_time'])->where("finish_time", ">", $data['start_time'])->count() > 0) {
                return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");
            }
            if (Consultation::where('day', '=', $data['day'])->where('finish_time', '>=', $data['finish_time'])->where("start_time", "<", $data['finish_time'])->count() > 0) {
                return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");
            }

        }

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
        $consultationsArray = array();
        $userId = Utils::getUserIdfromToken($request);
        if (!$data["teacher_id"] == null) {
            $userId = $data["teacher_id"];
        }
        $consultations = Consultation::where('start_date', '>', $data['start_date'])->where('end_date', '<', $data['end_date'])->whereHas('teacherSubject', function ($query) use ($userId) {
            $query->where("teacher_subject_id", $userId);
        })->get();

        foreach ($consultations as $consultation) {
            $consultationsArray[] = $consultation;
        }
        $userConsultations = json_encode($consultationsArray);
        return $response->withStatus(201)->getBody()->write($userConsultations);
    }


    public function getStudentConsultations(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $studentConsultationsArray = array();
        $userId = Utils::getUserIdfromToken($request);
        if (!$data["teacher_id"] == null) {
            $userId = $data["teacher_id"];
        }

        $consultations = Consultation::where('start_date', '>', $data['start_date'])->where('end_date', '<', $data['end_date'])->whereHas('teacherSubject', function ($query) use ($userId) {
            $query->where("teacher_subject_id", $userId);
        })->get();


        foreach ($consultations as $consultation) {
            $studentConsultationsArray[] = $consultation->studentConsultations;
        }

        $studentConsultations = json_encode($studentConsultationsArray);
        return $response->withStatus(201)->getBody()->write($studentConsultations);
    }
}
