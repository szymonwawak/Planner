<?php


$app->post('/auth/login', 'AuthController:login');


$app->group('/api', function () use ($app) {
    $app->group('/teachers', function () use ($app) {
        $app->get('/currentUser', 'TeacherController:getCurrentUser');
        $app->get('', "TeacherController:getAll");
        $app->get('/{id}', "TeacherController:getSingle");
        $app->post('', "TeacherController:create");
        $app->put('/{id}', "TeacherController:update");
        $app->post('/studentConsultations', 'TeacherController:getStudentConsultations');
        $app->get('consultations', 'TeacherController:getUserConsultations');

        $app->post('changePassword', "TeacherController:changePassword");
        $app->delete('removeAccount', "TeacherController:removeAccount");
    });

    $app->group('/subjects', function () use ($app) {
        $app->group('/userSubjects', function () use ($app) {
            $app->get('', 'SubjectController:getUserSubjects');
        });
        $app->get('', 'SubjectController:getAll');
        $app->get('/{id}', "SubjectController:getSingle");
        $app->post('', "SubjectController:create");
        $app->delete('/{id}', "SubjectController:delete");
        $app->put('/{id}', "SubjectController:update");
    });

    $app->group('/teacherSubjects', function () use ($app) {
        $app->get('/{id}', "TeacherSubjectController:getSingle");
        $app->post('', "TeacherSubjectController:create");
        $app->post('/addToCurrent', "TeacherSubjectController:assignSubjectToCurrentlyLoggedTeacher");
        $app->delete('/{id}', "TeacherSubjectController:delete");
        $app->put('/{id}', "TeacherSubjectController:update");

    });

    $app->group('/consultations', function () use ($app) {
        $app->group('/studentConsultations', function () use ($app) {
            $app->get('', 'ConsultationController:getStudentConsultations');
        });

        $app->get('', 'ConsultationController:getConsultations');
        $app->get('/{id}', "ConsultationController:getSingle");
        $app->post('', "ConsultationController:create");
        $app->delete('/{id}', "ConsultationController:delete");
        $app->put('/{id}', "ConsultationController:update");

    });

    $app->group('/consultationStudents', function () use ($app) {
        $app->get('', 'ConsultationStudentController:getAll');
        $app->get('/{id}', "ConsultationStudentController:getSingle");
        $app->post('', "ConsultationStudentController:create");
        $app->delete('/{id}', "ConsultationStudentController:delete");
        $app->put('/{id}', "ConsultationStudentController:update");

    });
});

