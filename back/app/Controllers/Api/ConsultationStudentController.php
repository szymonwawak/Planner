<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Student;


class ConsultationStudentController extends Controller
{

    public function getAll(Request $request, Response $response)
    {

        return $response->getBody()->write(Student::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Student::where('id', '=', $id)->count() > 0) {
            $student = Student::where('id', $id)->get();
            $response->getBody()->write($student->toJson());
            return $response;
        }
            return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $student = new Student();

        $student->idconsult = $data['idconsult'];
        $student->student_name = $data['student_name'];
        $student->student_surname = $data['student_surname'];
        $student->student_email = $data['student_email'];
        $student->start_time = $data['start_time'];
        $student->finish_time = $data['finish_time'];
        $student->accepted = $data['accepted'];

        $student->save();

        return $response->withStatus(201)->getBody()->write($student->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Student::where('id', '=', $id)->count() > 0) {
            $student = Student::where('id', $id);
            $student->delete();

            return $response->withStatus(200);
        }
        return $response->withStatus(404)->getBody()->write("Brak rekordu o podanym id");

    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $student = Student::where('id', $id);

        $student->student_name = $data['student_name'] ?: $student->student_name;
        $student->student_surname = $data['student_surname'] ?: $student->student_surname;
        $student->student_email = $data['student_email'] ?: $student->student_email = $data;
        $student->start_time = $data['start_time'] ?: $student->start_time = $data;
        $student->finish_time = $data['finish_time'] ?: $student->finish_time = $data;
        $student->accepted = $data['accepted'] ?: $student->accepted = $data;
        $student->idconsult = $data['idconsult'] ?: $student->idconsult = $data;

        $student->save();

        return $response->withStatus(201)->getBody()->write($student->toJson());
    }
}

