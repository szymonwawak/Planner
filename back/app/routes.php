<?php


$app->get('/home', 'HomeController:index')->setName('home');

$app->post('/auth/login', 'AuthController:login');


$app->group('/api', function () use ($app) {
    $app->group('/teachers', function () use ($app) {
        $app->get('', "TeacherController:getAll");
        $app->get('/{id}', "TeacherController:getSingle");
        $app->post('', "TeacherController:create");
        $app->delete('/{id}', "TeacherController:delete");
        $app->put('/{id}', "TeacherController:update");
    });

    $app->group('/subjects', function () use ($app) {
        $app->get('', 'SubjectController:getAll');
        $app->get('/{id}', "SubjectController:getSingle");
        $app->post('', "SubjectController:create");
        $app->delete('/{id}', "SubjectController:delete");
        $app->put('/{id}', "SubjectController:update");

    });

    $app->group('/lessons', function () use ($app) {
        $app->get('', 'LessonController:getAll');
        $app->get('/{id}', "LessonController:getSingle");
        $app->post('', "LessonController:create");
        $app->delete('/{id}', "LessonController:delete");
        $app->put('/{id}', "LessonController:update");

    });

    $app->group('/consultations', function () use ($app) {
        $app->get('', 'ConsultationController:getAll');
        $app->get('/{id}', "ConsultationController:getSingle");
        $app->post('', "ConsultationController:create");
        $app->delete('/{id}', "ConsultationController:delete");
        $app->put('/{id}', "ConsultationController:update");

    });

    $app->group('/students', function () use ($app) {
        $app->get('', 'ConsultationStudentController:getAll');
        $app->get('/{id}', "ConsultationStudentController:getSingle");
        $app->post('', "ConsultationStudentController:create");
        $app->delete('/{id}', "ConsultationStudentController:delete");
        $app->put('/{id}', "ConsultationStudentController:update");

    });

});

