<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\TeacherSubject;


class TeacherSubjectController extends Controller
{
    public function getAll(Request $request, Response $response)
    {
        return $response->withStatus(200)->withJson(TeacherSubject::all());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $lesson = TeacherSubject::where('id', $id)->with('subject')->get();
        if (!$lesson)
            return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
        return $response->withStatus(200)->withJson($lesson);
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $teacherId = $data['teacher_id'];
        $subjectId = $data['subject_id'];
        if (TeacherSubject::where('teacher_id', '=', $teacherId)->where('subject_id', '=', $subjectId)->count() > 0)
            return $response->withStatus(400)->withJson(['success' => true, 'message' => 'Takie zajęcia już istnieją']);
        $lesson = new TeacherSubject();
        $lesson->teacher_id = $teacherId;
        $lesson->subject_id = $subjectId;
        $lesson->save();
        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Zajęcia zostały stworzone']);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $lesson = TeacherSubject::find($id);
        if ($lesson) {
            $lesson->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $lesson = TeacherSubject::find($args['id']);
        if (!$lesson)
            return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
        $lesson->teacher_id = $data['teacher_id'] ?: $lesson->teacher_id;
        $lesson->subject_id = $data['subject_id'] ?: $lesson->subject_id;
        $lesson->save();
        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Pomyślnie zaktualizowano zajęcia']);
    }

    public function assignSubjectToCurrentlyLoggedTeacher(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $subjectId = $data['subject_id'];
        $teacherId = Utils::getUserIdFromToken($request);
        if (TeacherSubject::where('teacher_id', '=', $teacherId)
                ->where('subject_id', '=', $subjectId)
                ->count() > 0) {
            return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Takie zajęcia już istnieją']);
        }
        $lesson = new TeacherSubject();
        $lesson->teacher_id = $teacherId;
        $lesson->subject_id = $subjectId;
        $lesson->save();
        return $response->withStatus(201)->getBody()->write($lesson->toJson());
    }
}


