<?php

namespace Feature;

use Illuminate\Foundation\Testing\TestCase;

class ChatTest extends TestCase
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
     * @testdox Отправка сообщения в чат
     * @test
     */
    public function itCanStoreFileFromUploadedFile()
    {
    }
}
