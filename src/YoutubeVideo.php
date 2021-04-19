<?php

namespace PierreMiniggio\HeropostYoutubePosting;

class YoutubeVideo
{
    
    /**
     * @see YoutubeCategoriesEnum for $categoryId values
     */
    public function __construct(
        public string $title,
        public string $description,
        public int $categoryId
    )
    {
    }
}
