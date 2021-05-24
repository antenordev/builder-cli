#!/usr/bin/env php
<?php
error_reporting(0);
unset($argv[0]);
if(isset($argv[1])) { $param = $argv[1]; }
if(isset($argv[2])) { $project = $argv[2]; }
if(isset($argv[3])) { $class = $argv[3]; }

if($param == "create" && isset($project)) {
print ">_ Criando projeto: $project...\n";
exec("mkdir $project");

exec(`cat <<EOF > $project/index.php
<?php

require __DIR__ . "/vendor/autoload.php";`);

exec(`cat <<EOF > $project/composer.json
{
    "name" : "$project/app",
    "description" : "Novo App",
    "minimum-stability" : "stable",
    "license" : "proprietary",
    "authors" : [
        {
            "name" : "Your Name",
            "role" : "Developer",
            "homepage" : "http://youwebsite.dev"
        }
    ],
    "autoload" : {
        "psr-4" : {
            "Source\\" : "src/"
        },
        "files" : [
            "src/Config.php"
        ]
    },
    "require" : {
        "php" : ">=7.4"
    }
}`);

exec(`cat <<EOF > $project/.htaccess
RewriteEngine On
#Options All -Indexes

## Router WWW Redirect.
#RewriteCond %{HTTP_HOST}% !^www\. [NC]
#RewriteRule ^ https://www.%{HTTP_HOST}%{REQUEST_URI}% [L,R=301]

## ROUTER HTTPS Redirect
#RewriteCond %{HTTP:X-Forwarded-Proto} !https
#RewriteCond %{HTTPS} off
#RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# ROUTER URL Rewrite
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=/$1 [L,QSA]`);

exec(`cat <<EOF > $project/README.md
app`);

exec(`cat <<EOF > $project/LICENSE.md

Copyright (C) 2021`);

exec(`cat <<EOF > $project/.gitignore
.gitignore
.env
*.sh
*.lock
*.yml
vendor/`);

exec(`touch $project/.env`);

exec(`cat <<EOF > $project/save.sh
#!/bin/bash
git status
git add .
git push`);

exec(`cat <<EOF > $project/php.dockerfile
# PHP version:type
FROM php:7.4-apache
# PHP extensions mysql with pdo
RUN \
    docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install \
            pdo \
            pdo_mysql \
            mysqli \
    && docker-php-ext-enable pdo_mysql
RUN a2enmod rewrite`);

exec(`cat <<EOF > $project/docker-compose.yml
version: "3.3"
services:
    www:
        container_name: "$project"
        build:
            context: .
            dockerfile: php.dockerfile
        ports:
            - "80:80"
        volumes:
            - ./:/var/www/html`);

exec(`cat <<EOF > $project/make.sh
#!/bin/bash
docker-compose up --build -d`);

exec("mkdir $project/public");

exec(`touch $project/public/script.js`);

exec(`cat <<EOF > $project/public/style.css
* {
    top: 0;
    left: 0;
    margin: 0;
    padding: 0;
    width: 100%;
    height: auto;
    display: block;
}`);

exec("touch $project/public/favicon.ico");

exec("mkdir $project/theme");

exec(`cat <<EOF > $project/theme/header.php
<?php require_once __DIR__ . "/filter.php" ?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Cache-Control" content="private; min-fresh=300; must-revalidate; no-store" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, paramial-scale=1.0" />
        <link rel="apple-touch-icon" sizes="180x180" href="/public/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon-16x16.png" />
        <link rel="icon" href="/public/favicon.ico" />
        <link rel="manifest" href="/public/site.webmanifest" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
        <link rel="stylesheet" href="/public/style.css" />
    </head>
    <body>`);

exec(`cat <<EOF > $project/theme/footer.php
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="/public/script.js"></script>
    </body>
</html>`);

exec(`cat <<EOF > $project/theme/filter.php
<?php
`);

exec("mkdir $project/src");

exec(`cat <<EOF > $project/src/Config.php
<?php

define("URL_BASE", "SERVER_NAME");`);

exec("mkdir $project/src/App");

exec("mkdir $project/src/Core");

exec("git init $project/");

exec("chmod 777 -R $project");

print ">_ Projeto Criado!\n";

}

if($param == "-mvc") {

print ">_ Criando MVC: $class\n";

exec(`cat <<EOF > $project/src/Core/__$class.php
<?php

namespace Source\Core;
class __$class
{
    public function __construct()
    {

    }
}`);

exec("mkdir $project/theme/$class");

exec(`cat <<EOF > $project/theme/$class/example.php
<?php include_once __DIR__ . '/../header.php' ?>
    <div class="container">
        <h1>Example Template</h1>
    </div>
<?php include_once __DIR__ . '/../footer.php' ?>`);

exec(`cat <<EOF > $project/src/App/$class.php
<?php

namespace Source\App;

class $class
{
    public function example()
    {
        require __DIR__ . "/../../theme/{$class}/example.php";
    }
}`);

print ">_ MVC Criado!\n";

}

if($param == "-m"){

print ">_ Criando Model: $class\n";

exec(`cat <<EOF > $project/src/Core/__$class.php
<?php

namespace Source\Core;
class __$class
{
    public function __construct()
    {

    }
}`);

print ">_ Model Criada!\n";

}

if($param == "-v") {

print ">_ Criando View: $class\n";

exec("mkdir $project/theme/$class");

exec(`cat <<EOF > $project/theme/$class/example.php
<?php include_once __DIR__ . '/../header.php' ?>
    <div class="container">
        <h1>Example Template</h1>
    </div>
<?php include_once __DIR__ . '/../footer.php' ?>`);

print ">_ View Criada!\n";

}

if($param == "-c") {

print ">_ Criando Controller: $class\n";

exec(`cat <<EOF > $project/src/App/$class.php
<?php

namespace Source\App;

class $class
{
    public function example()
    {

    }
}`);

print ">_ Controller Criada!\n";

}

if($param == "run") {
    exec("cd $project && ./make.sh");
}

if($param == "update") {
    exec("cd $project && composer update");
}