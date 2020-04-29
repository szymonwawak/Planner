<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
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
        $lesson = TeacherSubject::where('id', $id)->get();
        if ($lesson->isEmpty()) return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
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
        $userId = $this->getId($request);
        $items = array();
        $teacherSubject = TeacherSubject::where('teacher_id', $userId)->get();

        foreach ($teacherSubject as $c) {
            $items[] = $c->consultations;
        }
        $myJSON = json_encode($items);
        return $response->withStatus(201)->getBody()->write($myJSON);
    }

    public function getStudentConsultations(Request $request, Response $response, $args)
    {
        $userId = Utility::getId($request);
        $items = array();
        $items1 = array();
        $data = $request->getParsedBody();
        $teacherSubject = TeacherSubject::where('teacher_id', $userId)->whereHas('consultations', function ($query) use ($data) {
            $query->where('start_date', '>', $data['start_date'])->where('end_date', '<', $data['end_date']);
        })->get();

        foreach ($teacherSubject as $c) {
            $items[] = $c->consultations;
        }
        foreach ($items as $c) {
            $items1[] = $c->consultations->sstudentConsultations;
        }
        $myJSON = json_encode($items1);
        return $response->withStatus(201)->getBody()->write($myJSON);
    }
}


