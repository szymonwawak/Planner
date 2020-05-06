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
        return $response->withStatus(200)->withJson(Consultation::all());
    }

    public function getSingle(Request $request, Response $response, $args)
    {
        $consultation = Consultation::find($args['id']);
        if (!$consultation)
            return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
        return $response->withStatus(200)->withJson($consultation);
    }

    public function getByTeacherId(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        return $response->withStatus(200)->withJson(Consultation::where('teacher_id', $data['teacher_id'])->get());
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $startDate = new DateTime($data['start_date']);
        $startDate = date('Y-m-d', $startDate->getTimestamp());
        $endDate = new DateTime($data['end_date']);
        $endDate = date('Y-m-d', $endDate->getTimestamp());
        if ($startDate >= $endDate)
            return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Błędnie podana data konsultacji']);
        $startTime = new DateTime($data['start_time']);
        $endTime = new DateTime($data['finish_time']);
        if ($startTime >= $endTime)
            return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Błędnie podany czas konsultacji']);
        $timeDifference = $endTime->getTimestamp() - $startTime->getTimestamp();
        if ($timeDifference > 3600)
            return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Czas konsultacji nie może przekraczać jednej godziny.']);
        $teacherId = $data['teacher_id'] ?: Utils::getUserIdfromToken($request);
        if (!$this->checkIfMatchesLowerTimeLimit($data, $teacherId) || !$this->checkIfMatchesUpperTimeLimit($data, $teacherId)) {
            return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Termin konsultacji jest niedostępny']);
        }
        $consultation = new Consultation();
        $consultation->day = $data['day'];
        $consultation->end_date = $data['end_date'];
        $consultation->start_date = $data['start_date'];
        $consultation->start_time = $data['start_time'];
        $consultation->finish_time = $data['finish_time'];
        $consultation->teacher_id = $teacherId;
        $consultation->save();
        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Pomyślnie utworzono schemat konsultacji']);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $consultation = Consultation::find($args['id']);
        if ($consultation) {
            $consultation->delete();
            return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Usunięto schemat konsultacji']);
        }
        return $response->withStatus(404)->withJson(['error' => true, 'message' => 'Brak rekordu o podanym id']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $consultation = Consultation::find($args['id']);
        $startTime = new DateTime($data['start_time']);
        $endTime = new DateTime($data['finish_time']);

        if (!($consultation->start_time == $startTime && !$consultation->finish_time == $endTime)) {
            if ($startTime >= $endTime)
                return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Błędnie podany czas konsultacji']);
            $timeDifference = $endTime->getTimestamp() - $startTime->getTimestamp();
            if ($timeDifference > 3600)
                return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Czas konsultacji nie może przekraczać jednej godziny.']);
            $teacherId = $data['teacher_id'] ?: Utils::getUserIdfromToken($request);
            if (!$this->checkIfMatchesLowerTimeLimitAmendOriginal($consultation, $data, $teacherId)) {
                return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Termin konsultacji jest niedostępny']);
            }
            if (!$this->checkIfMatcherUpperTimeLimitAmendOriginal($consultation, $data, $teacherId)) {
                return $response->withStatus(400)->withJson(['error' => true, 'message' => 'Termin konsultacji jest niedostępny']);
            }
        }
        $consultation->day = $data['day'] ?: $consultation->day;
        $consultation->start_date = $data['start_date'] ?: $consultation->start_date;
        $consultation->end_date = $data['end_date'] ?: $consultation->end_date;
        $consultation->start_time = $data['start_time'] ?: $consultation->start_time;
        $consultation->finish_time = $data['finish_time'] ?: $consultation->finish_time;
        $consultation->teacher_id = $data['teacher_id'] ?: $consultation->teacher_id;
        $consultation->save();
        return $response->withStatus(201)->withJson(['success' => true, 'message' => 'Pomyślnie zaktualizowano schemat konsultacji']);
    }

    private function checkIfMatchesLowerTimeLimit($data, $teacherId): bool
    {
        return Consultation::where('day', '=', $data['day'])
                ->where('start_time', '<=', $data['start_time'])
                ->where("finish_time", ">", $data['start_time'])
                ->where('teacher_id', $teacherId)->count() == 0;
    }

    private function checkIfMatchesUpperTimeLimit($data, $teacherId): bool
    {
        return Consultation::where('day', '=', $data['day'])
                ->where('finish_time', '>=', $data['finish_time'])
                ->where("start_time", "<", $data['finish_time'])
                ->where('teacher_id', $teacherId)->count() == 0;
    }

    private function checkIfMatchesLowerTimeLimitAmendOriginal($consultation, $data, $teacherId): bool
    {
        return Consultation::where('start_time', '!=', $consultation->start_time)
                ->where('finish_time', '!=', $consultation->finish_time)
                ->where('day', '=', $data['day'])
                ->where('start_time', '<=', $data['start_time'])
                ->where("finish_time", ">", $data['start_time'])
                ->where('teacher_id', $teacherId)->count() == 0;
    }

    private function checkIfMatcherUpperTimeLimitAmendOriginal($consultation, $data, $teacherId): bool
    {
        return Consultation::where('start_time', '!=', $consultation->start_time)
                ->where('finish_time', '!=', $consultation->finish_time)
                ->where('day', '=', $data['day'])
                ->where('finish_time', '>=', $data['finish_time'])
                ->where("start_time", "<", $data['finish_time'])
                ->where('teacher_id', $teacherId)->count() == 0;
    }
}
