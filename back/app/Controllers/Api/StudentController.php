<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Student;


class StudentController extends Controller
{

    public function getAll(Request $request, Response $response)
    {

        return $response->getBody()->write(Student::all()->toJson());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Student::where('idstudent', '=', $id)->count() > 0) {
            $student = Student::where('idstudent', $id)->get();
            $response->getBody()->write($student->toJson());
            return $response;
        } else {
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $student = new Student();

        $student->studentname = $data['studentname'];
        $student->studentsurname = $data['studentsurname'];
        $student->studentemail = $data['studentemail'];
        $student->starttime = $data['starttime'];
        $student->finishtime = $data['finishtime'];
        $student->accepted = $data['accepted'];

        $student->save();

        return $response->withStatus(201)->getBody()->write($student->toJson());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if (Student::where('idstudent', '=', $id)->count() > 0) {
            $student = Student::where('idstudent', $id);

            $student->delete();

            return $response->withStatus(200);
        } else {
            return $response->withStatus(403)->getBody()->write("Brak rekordu o podanym id");
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $student = Student::where('idstudent', $id);

        $student->studentname = $data['studentname'] ?: $student->studentname;
        $student->studentsurname = $data['studentsurname'] ?: $student->studentsurname;
        $student->studentemail = $data['studentemail'] ?: $student->studentemail = $data;
        $student->starttime = $data['starttime'] ?: $student->starttime = $data;
        $student->finishtime = $data['finishtime'] ?: $student->finishtime = $data;
        $student->accepted = $data['accepted'] ?: $student->accepted = $data;


        $student->save();

        return $response->withStatus(201)->getBody()->write($student->toJson());

    }
}

