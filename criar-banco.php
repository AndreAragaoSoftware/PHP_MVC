<?php

$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');

$pdo->exec("CREATE TABLE videos (id INTEGER PRIMARY KEY, url TEXT, title TEXT);");