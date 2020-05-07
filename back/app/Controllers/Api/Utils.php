<?php

namespace App\Controllers\Api;

use App\Models\StudentConsultation;
use App\Models\Teacher;
use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;


class Utils
{

    public function getUserIdFromToken($request)
    {
        $authHeader = $request->getHeader('authorization');
        $str = json_encode($authHeader);
        $token = substr($str, 9, strlen($str) - 11);
        $settings = $this->container->get('settings');
        $key = $settings['jwt']['secret'];
        $decoded = JWT::decode($token, $key, array('HS256'));
        return $decoded->userId;
    }

    public function sendEmail($consultationId, $teacherId)
    {
        $teacher = Teacher::find($teacherId);
        $to = $teacher->email;
        $studentConsultation = StudentConsultation::find($consultationId);
        $message = "Masz nową prośbę o zaakceptowanie terminu konsultacji dnia " .
            $studentConsultation->date . " od godziny " . $studentConsultation->start_time .
            " do " . $studentConsultation->finish_time;
        mail($to, "Nowa konsultacja", $message, 'From: no.replay.konsultacje@gmail.com');

    }

    public function sendEmailToStudent($consultationId, $email)
    {
        $to = $email;
        $studentConsultation = StudentConsultation::find($consultationId);
        $message = "Twoja konsultacja została zmodyfikowana. Nowy termin to: " .
            $studentConsultation->date . " od godziny " . $studentConsultation->start_time .
            " do " . $studentConsultation->finish_time;
        mail($to, "Zmiana terminu konsultacji", $message, 'From: no.replay.konsultacje@gmail.com');

    }

}