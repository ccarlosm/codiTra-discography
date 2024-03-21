<?php

namespace API\V1\Mail;

use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function testAppCanSendMail(): void
    {
        Mail::fake();

        // Assume you have a user to whom you want to send the test email
        $user = User::factory()->create([
            'email' => 'test_email@example.com',
        ]);

        // Send the email
        Mail::to($user->email)->send(new TestMail());

        // Assert that an email was sent to the given user
        Mail::assertSent(TestMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
