<?php
return [
    $app->add(new \Tuupola\Middleware\JwtAuthentication([
        "path" => "/panel",
        "attribute" => "decoded_token_data",
        "secret" => "secretpass",
        "algorithm" => ["HS256"],
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ]))
];

