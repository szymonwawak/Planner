<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use DateTime;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\TeacherSubject;

use Firebase\JWT\JWT;


class TeacherSubjectController extends Controller
{


    public function getAll(Request $request, Response $response)
    {
        return $response->getBody()->write(TeacherSubject::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $lesson = TeacherSubject::where('id', $id)->with('subject')->get();
        if ($lesson->isEmpty())
            return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
        return $response->getBody()->write($lesson->toJson());
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (TeacherSubject::where('teacher_id', '=', $data['teacher_id'])->where('subject_id', '=', $data['subject_id'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Takie zajęcia już istnieją");
        }
        $lesson = new TeacherSubject();
        $lesson->teacher_id = $data['teacher_id'];
        $lesson->subject_id = $data['subject_id'];
        $lesson->save();

        return $response->withStatus(201)->getBody()->write($lesson->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $lesson = TeacherSubject::where('id', $id)->first();
        if ($lesson != null) {
            $lesson->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $lesson = TeacherSubject::where('id', $id);
        $lesson->teacher_id = $data['teacher_id'] ?: $lesson->teacher_id;
        $lesson->subject_id = $data['subject_id'] ?: $lesson->subject_id;

        $lesson->save();

        return $response->withStatus(201)->getBody()->write($lesson->toJson());
    }

    public function getUserConsultations(Request $request, Response $response, $args)
    {
        $userId = Utils::getUserIdFromToken($request);
        $consultationArray = array();
        $teacherSubjects = TeacherSubject::where('teacher_id', $userId)->get();

        foreach ($teacherSubjects as $teacherSubject) {
            $consultationArray[] = $teacherSubject->consultations;
        }
        $userConsultations = json_encode($consultationArray);
        return $response->withStatus(201)->getBody()->write($userConsultations);
    }


    public function getStudentConsultations(Request $request, Response $response, $args)
    {
        $userId = Utils::getUserIdFromToken($request);
        $consultationArray = array();
        $studentConsultationArray = array();
        $data = $request->getParsedBody();
        $dateFrom = new DateTime($data['start_date']);
        $dateTo = new DateTime($data['end_date']);
        $teacherSubjects = TeacherSubject::where('teacher_id', $userId)->get();
        foreach ($teacherSubjects as $teacherSubject) {
            $consultationArray[] = $teacherSubject->consultation;
            $consultationScheme = $teacherSubject->consultation;
            $subject = $teacherSubject->subject;
            foreach ($consultationScheme as $scheme) {
                $studentConsultation = $scheme->studentConsultation
                    ->where('date', '>', $dateFrom->format('Y-m-d'))
                    ->where('date', '<', $dateTo->format('Y-m-d'));
                foreach ($studentConsultation as $consultation) {
                    $consultation->setAttribute('subject', $subject);
                    $studentConsultationArray[] = $consultation;
                }
            }
        }
        $studentConsultations = json_encode($studentConsultationArray);

        return $response->withStatus(201)->getBody()->write($studentConsultations);
    }

    public function assignSubjectToCurrentlyLoggedTeacher(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $teacherId = Utils::getUserIdFromToken($request);
        if (TeacherSubject::where('teacher_id', '=', $teacherId)->where('subject_id', '=', $data['subject_id'])->count() > 0) {
            return $response->withStatus(400)->getBody()->write("Takie zajęcia już istnieją");
        }
        $lesson = new TeacherSubject();
        $lesson->teacher_id = $teacherId;
        $lesson->subject_id = $data['subject_id'];
        $lesson->save();

        return $response->withStatus(201)->getBody()->write($lesson->toJson());
    }
}


