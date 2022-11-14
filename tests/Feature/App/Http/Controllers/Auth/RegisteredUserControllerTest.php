<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Customer\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = SignUpFormRequest::factory()->create([
            'email' => 'test@nikushkin.ru',
            'password' => '1234567890',
            'password_confirmation' => '1234567890'
        ]);
    }

    private function request(): TestResponse
    {
        return $this->post(
            action([RegisteredUserController::class, 'store']),
            $this->request
        );
    }

    private function findUser()
    {
        return User::query()
            ->where('email', $this->request['email'])
            ->first();
    }

    public function test_register_page_success(): void
    {
        $this->get(action([RegisteredUserController::class, 'create']))
            ->assertOk()
            ->assertViewIs('auth.sign-up');
    }

    public function test_validation_success(): void
    {
        $this->request()
            ->assertValid();
    }

    public function test_should_fail_validation_on_password_confirm(): void
    {
        $this->request['password_confirmation'] = '123';

        $this->request()
            ->assertInvalid(['password']);
    }

    public function test_user_created_success(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => $this->request['email']
        ]);

        $this->request();

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);
    }

    public function test_should_fail_validation_on_unique_email(): void
    {
        UserFactory::new()->create([
            'email' => $this->request['email']
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);

        $this->request()
            ->assertInvalid(['email']);
    }

    public function test_registered_event_and_listeners_dispatched(): void
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(Registered::class);
        Event::assertListening(
            Registered::class,
            SendEmailNewUserListener::class
        );
    }

    public function test_notification_send(): void
    {
        $this->request();

        Notification::assertSentTo(
            $this->findUser(),
            NewUserNotification::class
        );
    }

    public function test_user_authenticated_after_and_redirected(): void
    {
        $this->request()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($this->findUser());
    }
}
