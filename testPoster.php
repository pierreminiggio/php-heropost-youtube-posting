<?php

use PierreMiniggio\HeropostYoutubePosting\JSExecutor;
use PierreMiniggio\HeropostYoutubePosting\Poster;
use PierreMiniggio\HeropostYoutubePosting\YoutubeVideo;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/** @var string[] $args */
$args = $argv;
array_shift($args);

$poster = new Poster(new JSExecutor());
var_dump($poster->post(
    $args[0],
    $args[1],
    $args[2],
    new YoutubeVideo(
        $args[3],
        $args[4],
        $args[5]
    ),
    $args[6]
));
