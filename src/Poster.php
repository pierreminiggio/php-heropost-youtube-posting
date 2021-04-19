<?php

namespace PierreMiniggio\HeropostYoutubePosting;

use PierreMiniggio\HeropostYoutubePosting\Exception\MaybeAlreadyPostedButScrapingException;
use PierreMiniggio\HeropostYoutubePosting\Exception\AccountNotSetupOrQuotaExceededException;
use PierreMiniggio\HeropostYoutubePosting\Exception\HeropostConfigurationException;
use PierreMiniggio\HeropostYoutubePosting\Exception\QuotaExceededException;
use PierreMiniggio\HeropostYoutubePosting\Exception\ScrapingException;
use PierreMiniggio\HeropostYoutubePosting\Exception\UnknownHeropostException;
use PierreMiniggio\YoutubeVideoIdFromLink\BadLinkException;
use PierreMiniggio\YoutubeVideoIdFromLink\YoutubeIdGetter;

class Poster
{

    private YoutubeIdGetter $youtubeIdGetter;

    public function __construct(private JSExecutor $executor)
    {
        $this->youtubeIdGetter = new YoutubeIdGetter();
    }

    /**
     * @throws MaybeAlreadyPostedButScrapingException
     * @throws HeropostConfigurationException
     * @throws UnknownHeropostException
     * @throws ScrapingException
     *
     * @return string youtubeVideoId
     */
    public function post(
        string $heropostLogin,
        string $herpostPassword,
        string $youtubeChannelId,
        YoutubeVideo $youtubeVideo,
        string $videoFilePath
    ): string
    {
        $res = $this->executor->execute(
            $heropostLogin,
            $herpostPassword,
            $youtubeChannelId,
            $youtubeVideo->title,
            $youtubeVideo->description,
            $youtubeVideo->categoryId,
            $videoFilePath
        );

        if (str_contains($res, 'not set up on heropost account or Youtube quota exceeded')) {
            throw new AccountNotSetupOrQuotaExceededException($res);
        }

        if (str_contains($res, 'Scraping error')) {
            throw new ScrapingException($res);
        }

        if (str_contains($res, 'Quota exceeded')) {
            throw new QuotaExceededException($res);
        }

        if (str_contains($res, 'Unknow error')) {
            throw new UnknownHeropostException($res);
        }

        if (str_contains($res, 'Youtube API')) {
            throw new UnknownHeropostException($res);
        }

        if (str_contains($res, 'Video link not found')) {
            throw new MaybeAlreadyPostedButScrapingException($res);
        }
        
        try {
            return $this->youtubeIdGetter->get($res);
        } catch (BadLinkException $e) {
            throw new MaybeAlreadyPostedButScrapingException($e->getMessage());
        }
    }
}
