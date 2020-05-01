<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use App\Models\StudentConsultation;
use App\Models\Teacher;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\TeacherSubject;
use Firebase\JWT\JWT;


class Utils
{

    public function getUserIdfromToken($request)
    {
        $authHeader = $request->getHeader('authorization');
        $str = json_encode($authHeader);
        $token = substr($str, 9, strlen($str) - 11);
        $settings = $this->container->get('settings');
        $key = $settings['jwt']['secret'];
        $decoded = JWT::decode($token, $key, array('HS256'));
        return $decoded->userId;
    }

    public function sendEmail(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        //$to=$data["student_email"];
        $to = 'no.replay.konsultacje@gmail.com';
        $userName = Teacher::select('name', 'surname')->where('id', $this->getUserIdfromToken($request))->first();
        $studentConsultation = StudentConsultation::select("start_time", "finish_time")->where('id', $data['id'])->first();

        $message = "Witaj. Termin konsultacji u " . $userName->name . " " . $userName->surname . " został przełożone na dzień " . $studentConsultation->date . " od godziny " . $studentConsultation->start_time . " do " . $studentConsultation->finish_time;

        mail($to, "Zmiana terminu konsultacji", $message, 'From: no.replay.konsultacje@gmail.com');
        return $response->withStatus(200)->getBody()->write("Email został wysłany");
    }

}