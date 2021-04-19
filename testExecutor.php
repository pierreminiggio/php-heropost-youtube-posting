<?php

use PierreMiniggio\HeropostYoutubePosting\JSExecutor;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/** @var string[] $args */
$args = $argv;
array_shift($args);

$executor = new JSExecutor();
var_dump($executor->execute(...$args));
