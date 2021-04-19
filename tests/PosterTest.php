<?php

namespace PierreMiniggio\HeropostYoutubePostingTest;

use PHPUnit\Framework\TestCase;
use PierreMiniggio\HeropostYoutubePosting\Exception\AccountNotSetupOrQuotaExceededException;
use PierreMiniggio\HeropostYoutubePosting\Exception\MaybeAlreadyPostedButScrapingException;
use PierreMiniggio\HeropostYoutubePosting\Exception\QuotaExceededException;
use PierreMiniggio\HeropostYoutubePosting\Exception\ScrapingException;
use PierreMiniggio\HeropostYoutubePosting\Exception\UnknownHeropostException;
use PierreMiniggio\HeropostYoutubePosting\JSExecutor;
use PierreMiniggio\HeropostYoutubePosting\Poster;
use PierreMiniggio\HeropostYoutubePosting\YoutubeCategoriesEnum;
use PierreMiniggio\HeropostYoutubePosting\YoutubeVideo;

class PosterTest extends TestCase
{

    /**
     * @dataProvider provideMessagesAndExceptions
     */
    public function testRecievedException(
        string $executorMessage,
        string $exceptionClass
    ): void
    {
        $executor = $this->createMock(JSExecutor::class);
        $executor->expects(self::once())->method('execute')->willReturn($executorMessage);
        $this->expectException($exceptionClass);
        $poster = new Poster($executor);
        $poster->post(
            'login',
            'password',
            'channelId',
            new YoutubeVideo('title', 'description', YoutubeCategoriesEnum::EDUCATION),
            'test.mp4'
        );
    }

    /**
     * @dataProvider provideGoodMessagesAndIds
     */
    public function testRecievedId(
        string $executorMessage,
        string $expectedId
    ): void
    {
        $executor = $this->createMock(JSExecutor::class);
        $executor->expects(self::once())->method('execute')->willReturn($executorMessage);
        $poster = new Poster($executor);
        self::assertSame($expectedId, $poster->post(
            'login',
            'password',
            'channelId',
            new YoutubeVideo('title', 'description', YoutubeCategoriesEnum::EDUCATION),
            'test.mp4'
        ));
    }

    /**
     * @return string[][]
     */
    public function provideMessagesAndExceptions(): array
    {
        return [
            [
                'Heropost/Youtube error : Channel UC6G2NXfyAq-w0oOhIUHGTQg not set up on heropost account or Youtube quota exceeded',
                AccountNotSetupOrQuotaExceededException::class
            ],
            [
                'Scraping error : Checkbox for channel UC6G2NXfyAq-w0oOhIUHGTQg is missing !',
                ScrapingException::class
            ],
            [
                'Scraping error : Title input selector is missing !',
                ScrapingException::class
            ],
            [
                'Scraping error : Category Select selector is missing !',
                ScrapingException::class
            ],
            [
                'Scraping error : Description input selector is missing !',
                ScrapingException::class
            ],
            [
                'Scraping error : Video file input selector is missing !',
                ScrapingException::class
            ],
            [
                'Scraping error : Post button selector is missing !',
                ScrapingException::class
            ],
            [
                'Scraping error : Post button selector is missing !',
                ScrapingException::class
            ],
            [
                'Heropost/Youtube error : Quota exceeded !',
                QuotaExceededException::class
            ],
            [
                'Heropost/Youtube error : Unknow error while posting',
                UnknownHeropostException::class
            ],
            [
                'Scraping error : Bell button selector is missing !',
                ScrapingException::class
            ],
            [
                'Scraping error : Posted item selector is missing !',
                ScrapingException::class
            ],
            [
                'Heropost/Youtube error : Youtube API returned an error ?',
                UnknownHeropostException::class
            ],
            [
                'Heropost/Youtube error : Video link not found ?',
                MaybeAlreadyPostedButScrapingException::class
            ],
            [
                'zizi',
                MaybeAlreadyPostedButScrapingException::class
            ]
        ];
    }

    /**
     * @return string[][]
     */
    public function provideGoodMessagesAndIds(): array
    {
        return [
            [
                'https://www.youtube.com/watch?v=11GAfiiJuZ0',
                '11GAfiiJuZ0'
            ]
        ];
    }
}
