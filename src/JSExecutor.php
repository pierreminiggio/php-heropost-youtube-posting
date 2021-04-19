<?php

namespace PierreMiniggio\HeropostYoutubePosting;

/**
 * @internal
 */
class JSExecutor
{

    public function __construct(private string $nodePath = 'node')
    {
    }

    public function execute(
        string $heropostLogin,
        string $herpostPassword,
        string $youtubeChannelId,
        string $title,
        string $description,
        int $youtubeCategoryId,
        string $videoFilePath
    ): ?string
    {
        return shell_exec(
            $this->nodePath
            . ' '
            . __DIR__
            . DIRECTORY_SEPARATOR
            . '..'
            . DIRECTORY_SEPARATOR
            . 'post.js '
            . escapeshellarg($heropostLogin)
            . ' '
            . escapeshellarg($herpostPassword)
            . ' '
            . escapeshellarg($youtubeChannelId)
            . ' '
            . escapeshellarg($title)
            . ' '
            . escapeshellarg($description)
            . ' '
            . $youtubeCategoryId
            . ' '
            . escapeshellarg($videoFilePath)
        );
    }
}
