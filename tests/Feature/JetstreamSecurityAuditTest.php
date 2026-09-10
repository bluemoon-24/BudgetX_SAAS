<?php

namespace Tests\Feature;

use App\Actions\Fortify\UpdateUserPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class JetstreamSecurityAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_fortify_password_update_hashes_new_password(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        (new UpdateUserPassword())->update($user, [
            'current_password' => 'password',
            'password' => 'new-strong-password',
            'password_confirmation' => 'new-strong-password',
        ]);

        $this->assertTrue(Hash::check('new-strong-password', $user->fresh()->password));
        $this->assertNotSame('new-strong-password', $user->fresh()->password);
    }

    public function test_jetstream_uses_web_guard_for_session_authentication(): void
    {
        $this->assertSame('web', config('jetstream.guard'));
    }
}
