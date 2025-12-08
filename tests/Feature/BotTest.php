<?php

namespace Feature;

use Illuminate\Foundation\Testing\TestCase;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;
use PHPUnit\Framework\Assert;

class BotTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getTestChatId()
    {
        return (int)env("TEST_CHAT_ID");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }

    /**
     * @testdox Бот готов к работе
     * @test
     */
    public function itCanUseRestApi()
    {
        $result = MaxMessengerApiClient::bots()->getMyInfo();

        $isBot = $result["is_bot"] ?? false;

        Assert::assertTrue(
            $isBot,
            "Из api не вернулся признак бота: " .
            json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}
