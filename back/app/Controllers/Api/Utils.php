<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use App\Models\Consultation;
use App\Models\StudentConsultation;
use App\Models\Teacher;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\TeacherSubject;
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

    public function sendEmail(Request $request)
    {
        $data = $request->getParsedBody();
        $consultation = Consultation::find($data['consultation_id']);
        $teacher_subject = $consultation->teacher_subject_id;
        $email = Teacher::select("email")->whereHas('teacherSubjects', function ($query) use ($teacher_subject) {
            $query->where("id", $teacher_subject);
        })->first();

        $to = $email->email;
        $studentConsultation = StudentConsultation::select("start_time", "finish_time", "data")->where('id', $data['id'])->first();

        $message = "Witaj. Masz nową prośbę o zaakceptowanie terminu konsultacji dnia " . $studentConsultation->data . " od godziny " . $studentConsultation->start_time . " do " . $studentConsultation->finish_time;

        mail($to, "Zmiana terminu konsultacji", $message, 'From: no.replay.konsultacje@gmail.com');

    }

}