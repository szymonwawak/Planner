<?php

namespace App\Controllers\Api;


use App\Controllers\Controller;
use App\Models\Consultation;
use App\Models\StudentConsultation;
use App\Models\Subject;
use App\Models\TeacherSubject;
use DateTime;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Teacher;


class TeacherController extends Controller
{

    public function getAll(Request $request, Response $response)
    {
        $teachers = Teacher::with('subjects')->get();
        return $response->withStatus(201)->withJson($teachers);
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $teacher = Teacher::find($args['id']);
        if ($teacher)
            return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
        return $response->withStatus(201)->withJson($teacher);
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        if (Teacher::where('email', '=', $data['email'])->count() > 0)
            return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Taki email jest już zajęty!']);
        $teacher = new Teacher();
        $teacher->name = $data['name'];
        $teacher->surname = $data['surname'];
        $teacher->email = $data['email'];
        $teacher->password = password_hash('Pa$$word1', PASSWORD_DEFAULT, ['cost' => 10]);
        $teacher->first_login = '1';
        $teacher->save();
        $this->assignDefaultSubject($teacher);

        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Pomyślnie stworzono użytkownika']);
    }

    private function assignDefaultSubject($teacher)
    {
        $undeterminedSubject = Subject::find(1);
        $teacher->subjects()->attach($undeterminedSubject);
        $teacher->save();
    }

    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $teacher = Teacher::find($args["id"]);
        if ($teacher && $teacher->email != $data["email"] && Teacher::where('email', '=', $data['email'])->count() > 0)
            return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Taki email jest już zajęty!']);
        $teacher->name = $data['name'] ?: $teacher->name;
        $teacher->surname = $data['surname'] ?: $teacher->surname;
        $teacher->email = $data['email'] ?: $teacher->email;
        $teacher->save();

        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Pomyślnie zapisano dane!']);
    }

    public function getUserConsultations(Request $request, Response $response, $args)
    {
        $userId = Utils::getUserIdFromToken($request);
        $consultations = Consultation::where('teacher_id', $userId)->get();
        return $response->withStatus(200)->withJson($consultations);
    }

    public function getStudentConsultations(Request $request, Response $response)
    {
        $userId = Utils::getUserIdFromToken($request);
        $data = $request->getParsedBody();
        $dateFrom = new DateTime($data['start_date']);
        $dateTo = new DateTime($data['end_date']);
        $consultations = StudentConsultation::where('teacher_id', $userId)
            ->where('date', '>=', $dateFrom->format('Y-m-d'))
            ->where('date', '<=', $dateTo->format('Y-m-d'))->with('subject')->get();
        return $response->withStatus(201)->withJson($consultations);
    }

    public function getCurrentUser(Request $request, Response $response)
    {
        $userId = Utils::getUserIdFromToken($request);
        $user = Teacher::find($userId);
        if (!$user)
            return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Nie znaleziono użytkownika']);
        return $response->withStatus(200)->withJson($user);
    }

    public function changePassword(Request $request, Response $response)
    {
        $userId = Utils::getUserIdFromToken($request);
        $data = $request->getParsedBody();
        $oldPassword = $data['oldPassword'];
        if ($data['newPassword'] != ($data['passwordConfirmation'])) {
            return $response->withStatus(401)->withJson(['error' => true, 'message' => 'Błędne potwierdzenie hasła']);
        }
        $teacher = Teacher::find($userId);
        if (!password_verify($oldPassword, $teacher->password)) {
            return $response->withStatus(401)->withJson(['error' => true, 'message' => 'Poprzednie hasło jest niepoprawne']);
        }
        $newPassword = password_hash($data['newPassword'], PASSWORD_DEFAULT, ['cost' => 10]);
        $teacher->password = $newPassword;
        $teacher->first_login = '0';
        $teacher->save();
        return $response->withStatus(200)->withJson(['success' => true, 'message' => 'Hasło zostało zmienione!']);
    }

    public function removeAccount(Request $request, Response $response)
    {
        $userId = $this->getUserIdfromToken($request);
        $teacher = Teacher::find($userId);
        if ($teacher) {
            $teacher->delete();
            return $response->withStatus(200);
        }
        return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Takie konto nie istnieje!']);
    }
}