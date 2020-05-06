<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Consultation;
use DateTime;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\StudentConsultation;


class StudentConsultationController extends Controller
{

    public function getAll(Request $request, Response $response)
    {
        return $response->withStaus(200)->withJson(StudentConsultation::all());
    }

    public function getByTeacherId(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        return $response->withStatus(200)
            ->withJson(StudentConsultation::where('teacher_id', $data['teacher_id'])
                ->where('date', '>=', date('Y-m-d'))
                ->with('subject')->get());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $studentConsultation = StudentConsultation::find($args['id']);
        if (!$studentConsultation)
            return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
        return $response->withStatus(200)->withJson($studentConsultation);
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $date = new DateTime($data['date']);
        $dateAsString = date('Y-m-d', $date->getTimestamp());
        if ($data['start_time'] >= $data['finish_time'])
            return $response->withStatus(400)->getBody()->write("Błędnie podany czas konsultacji");
        if ($this->checkIfConsultationFitsInTimeRange($data, $dateAsString, $date))
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");

        $studentConsultation = new StudentConsultation();
        $studentConsultation->date = $data['date'];
        $studentConsultation->student_name = $data['student_name'];
        $studentConsultation->student_surname = $data['student_surname'];
        $studentConsultation->student_email = $data['student_email'];
        $studentConsultation->start_time = $data['start_time'];
        $studentConsultation->finish_time = $data['finish_time'];
        $studentConsultation->teacher_id = $data['teacher_id'];
        $studentConsultation->subject_id = $data['subject_id'];
        $studentConsultation->accepted = false;
        $studentConsultation->save();
        return $response->withStatus(201)->getBody()->write($studentConsultation->toJson());
    }

    private function checkIfConsultationFitsInTimeRange($data, string $dateAsString, DateTime $date): bool
    {
        return (StudentConsultation::where('teacher_id', $data['teacher_id'])
                    ->where('start_time', '<=', $data['start_time'])
                    ->where("finish_time", ">", $data['start_time'])
                    ->where('date', '=', $dateAsString)->count() > 0
                || StudentConsultation::where('teacher_id', $data['teacher_id'])
                    ->where('finish_time', '>=', $data['finish_time'])
                    ->where("start_time", "<", $data['finish_time'])
                    ->where('date', '=', $dateAsString)->count() > 0) ||
            Consultation::where('teacher_id', $data['teacher_id'])
                ->where('finish_time', '>=', $data['finish_time'])
                ->where("start_time", "<=", $data['start_time'])
                ->where('day', date('w', $date->getTimestamp()))->count() == 0;
    }

    public function delete(Request $request, Response $response, $args)
    {
        $studentConsultation = StudentConsultation::find($args['id']);
        if ($studentConsultation) {
            $studentConsultation->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $studentConsultation = StudentConsultation::find($args['id']);
        if ($data['start_time'] >= $data['finish_time'])
            return $response->withStatus(400)->getBody()->write("Błędnie podany czas konsultacji");

        if ($this->checkIfEditedConsultationFitsInTimeRange($studentConsultation, $data)) {
            return $response->withStatus(400)->getBody()->write("Termin konsultacji niedostępny");
        }
        $studentConsultation->student_name = $data['student_name'] ?: $studentConsultation->student_name;
        $studentConsultation->student_surname = $data['student_surname'] ?: $studentConsultation->student_surname;
        $studentConsultation->student_email = $data['student_email'] ?: $studentConsultation->student_email;
        $studentConsultation->start_time = $data['start_time'] ?: $studentConsultation->start_time;
        $studentConsultation->finish_time = $data['finish_time'] ?: $studentConsultation->finish_time;
        $studentConsultation->accepted = true;
        $studentConsultation->date = $data['date'] ?: $studentConsultation->date;
        $studentConsultation->save();
        return $response->withStatus(201)->getBody()->write($studentConsultation->toJson());
    }

    private function checkIfEditedConsultationFitsInTimeRange($studentConsultation, $data): bool
    {
        return StudentConsultation::where('start_time', '!=', $studentConsultation->start_time)
                ->where('teacher_id', '=', $studentConsultation->teacher_id)
                ->where('finish_time', '!=', $studentConsultation->finish_time)
                ->where('start_time', '<=', $data['start_time'])
                ->where("finish_time", ">", $data['start_time'])->count() > 0 ||
            StudentConsultation::where('start_time', '!=', $studentConsultation->start_time)
                ->where('teacher_id', '=', $studentConsultation->teacher_id)
                ->where('finish_time', '!=', $studentConsultation->finish_time)
                ->where('finish_time', '>=', $data['finish_time'])
                ->where("start_time", "<", $data['finish_time'])->count() > 0;
    }
}

