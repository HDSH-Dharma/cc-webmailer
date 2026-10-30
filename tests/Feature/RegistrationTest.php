<?php

namespace Tests\Feature;

use App\Mail\RegistrationConfirmation;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use RuntimeException;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function formData(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Haning Galih Rani Kumbara',
            'email' => 'Haning.Kumbara@ciputra.ac.id',
            'password' => 'secret-pass-123',
            'password_confirmation' => 'secret-pass-123',
            'birthdate' => '2005-10-07',
            'ticket_category' => 'tribune',
            'quantity' => 2,
        ], $overrides);
    }

    private function makeRegistration(): Registration
    {
        return Registration::create([
            'booking_code' => 'NSL-TEST01',
            'full_name' => 'Haning Galih Rani Kumbara',
            'email' => 'haning.kumbara@ciputra.ac.id',
            'password' => 'secret-pass-123',
            'birthdate' => '2005-10-07',
            'event' => config('concert.name'),
            'ticket_category' => 'tribune',
            'quantity' => 2,
            'total_price' => 1000000,
        ]);
    }

    public function test_the_registration_form_is_shown(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(config('concert.name'))
            ->assertSee('Get your tickets')
            ->assertSee('Full name')
            ->assertSee('Email')
            ->assertSee('Confirm password')
            ->assertSee('Birthdate')
            ->assertSee('Register');
    }

    public function test_a_registration_is_saved_and_the_details_are_emailed_to_the_address_in_the_form(): void
    {
        Mail::fake();

        $this->post('/register', $this->formData())
            ->assertRedirect(route('registration.sent'));

        $registration = Registration::firstOrFail();

        $this->assertSame('haning.kumbara@ciputra.ac.id', $registration->email);
        $this->assertSame(2, $registration->quantity);
        $this->assertSame(1000000, $registration->total_price);
        $this->assertStringStartsWith('NSL-', $registration->booking_code);
        $this->assertNull($registration->confirmed_at);
        $this->assertTrue(Hash::check('secret-pass-123', $registration->password));

        Mail::assertSent(RegistrationConfirmation::class, function (RegistrationConfirmation $mail) {
            return $mail->hasTo('haning.kumbara@ciputra.ac.id');
        });
    }

    public function test_the_email_contains_the_form_details_and_a_confirmation_link(): void
    {
        $registration = $this->makeRegistration();

        $mail = new RegistrationConfirmation($registration);

        $mail->assertSeeInHtml('Haning Galih Rani Kumbara');
        $mail->assertSeeInHtml('haning.kumbara@ciputra.ac.id');
        $mail->assertSeeInHtml('October 7, 2005');
        $mail->assertSeeInHtml('NSL-TEST01');
        $mail->assertSeeInHtml('Rp 1.000.000');
        $mail->assertSeeInHtml('Confirm My Registration');
        $mail->assertSeeInHtml('/register/confirm/'.$registration->id);
        $mail->assertSeeInHtml('within 7 days');
    }

    public function test_the_same_email_can_register_more_than_once(): void
    {
        Mail::fake();

        $this->post('/register', $this->formData())->assertRedirect(route('registration.sent'));
        $this->post('/register', $this->formData())->assertRedirect(route('registration.sent'));

        $this->assertDatabaseCount('registrations', 2);
        Mail::assertSent(RegistrationConfirmation::class, 2);
    }

    public function test_a_bcc_copy_is_sent_when_configured(): void
    {
        Mail::fake();
        config(['concert.bcc_email' => 'copy@example.com']);

        $this->post('/register', $this->formData());

        Mail::assertSent(RegistrationConfirmation::class, fn ($mail) => $mail->hasBcc('copy@example.com'));
    }

    public function test_the_confirmation_link_confirms_the_registration(): void
    {
        $registration = $this->makeRegistration();

        $url = URL::temporarySignedRoute('registration.confirm', now()->addDays(7), [
            'registration' => $registration->id,
        ]);

        $this->get($url)->assertOk()->assertSee('is confirmed');

        $this->assertNotNull($registration->fresh()->confirmed_at);
    }

    public function test_the_confirmation_link_expires_after_seven_days(): void
    {
        $registration = $this->makeRegistration();

        $url = URL::temporarySignedRoute('registration.confirm', now()->addDays(7), [
            'registration' => $registration->id,
        ]);

        $this->travel(8)->days();

        $this->get($url)->assertForbidden()->assertSee('invalid or has expired');

        $this->assertNull($registration->fresh()->confirmed_at);
    }

    public function test_a_tampered_confirmation_link_is_rejected(): void
    {
        $registration = $this->makeRegistration();

        $this->get('/register/confirm/'.$registration->id.'?signature=fake')->assertForbidden();

        $this->assertNull($registration->fresh()->confirmed_at);
    }

    public function test_invalid_input_is_rejected(): void
    {
        Mail::fake();

        $this->post('/register', $this->formData([
            'email' => 'not-an-email',
            'password_confirmation' => 'something-else',
            'birthdate' => now()->addDay()->toDateString(),
            'ticket_category' => 'backstage',
            'quantity' => 9,
        ]))->assertSessionHasErrors(['email', 'password', 'birthdate', 'ticket_category', 'quantity']);

        $this->assertDatabaseCount('registrations', 0);
        Mail::assertNothingSent();
    }

    public function test_nothing_is_saved_when_the_email_cannot_be_sent(): void
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP is down'));

        $this->post('/register', $this->formData())->assertSessionHasErrors('mail');

        $this->assertDatabaseCount('registrations', 0);
    }
}
