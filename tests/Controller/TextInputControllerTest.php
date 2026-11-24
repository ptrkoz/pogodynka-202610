<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TextInputControllerTest extends WebTestCase
{
    public function testFormDisplaysAndEscapesSubmittedText(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/text-input/');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('textarea[name="text_input[text]"]');

        $form = $crawler->filter('form')->form();
        $form['text_input[text]'] = '<script>alert("XSS")</script>';
        $client->submit($form);

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('p', '<script>alert("XSS")</script>');
        self::assertSelectorNotExists('p script');
    }
}