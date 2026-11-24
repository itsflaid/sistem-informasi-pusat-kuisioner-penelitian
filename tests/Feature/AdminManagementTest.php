<?php

namespace Tests\Feature;

use App\Enums\QuestionnaireStatus;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_search_and_update_users(): void
    {
        $admin = User::factory()->admin()->create();
        $student = User::factory()->create(['name' => 'Mahasiswa Uji', 'nim' => '123456789']);

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['q' => '123456789']))
            ->assertOk()
            ->assertSee('Mahasiswa Uji');

        $this->actingAs($admin)
            ->patch(route('admin.users.update', $student), ['role' => 'admin', 'is_active' => false])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'role' => 'admin',
            'is_active' => false,
        ]);
    }

    public function test_admin_cannot_demote_or_deactivate_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch(route('admin.users.update', $admin), ['role' => 'student', 'is_active' => true])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_inactive_user_is_logged_out(): void
    {
        $student = User::factory()->create(['is_active' => false]);

        $this->actingAs($student)
            ->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_filter_and_close_questionnaires(): void
    {
        $admin = User::factory()->admin()->create();
        $active = Questionnaire::factory()->active()->create(['title' => 'Kuesioner Uji Aktif']);
        $draft = Questionnaire::factory()->draft()->create(['title' => 'Kuesioner Uji Draf']);

        $this->actingAs($admin)
            ->get(route('admin.questionnaires.index', ['status' => 'draft']))
            ->assertOk()
            ->assertSee('Kuesioner Uji Draf')
            ->assertDontSee('Kuesioner Uji Aktif');

        $this->actingAs($admin)
            ->get(route('admin.questionnaires.show', $active))
            ->assertOk()
            ->assertSee($active->external_url);

        $this->actingAs($admin)
            ->post(route('admin.questionnaires.close', $active))
            ->assertRedirect();

        $this->assertDatabaseHas('questionnaires', [
            'id' => $active->id,
            'status' => QuestionnaireStatus::Closed->value,
        ]);

        $this->assertDatabaseHas('questionnaires', [
            'id' => $draft->id,
            'status' => QuestionnaireStatus::Draft->value,
        ]);
    }

    public function test_student_cannot_open_admin_management_pages(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->actingAs($student)
            ->get(route('admin.questionnaires.index'))
            ->assertForbidden();
    }

    public function test_admin_layout_keeps_management_menu_and_hides_student_menu(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('app-sidebar', false)
            ->assertSee('Manajemen pengguna')
            ->assertSee('Manajemen kuesioner')
            ->assertDontSee('Kuesioner saya');
    }

    public function test_pagination_uses_the_bootstrap_theme(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->count(21)->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('pagination', false)
            ->assertSee('page-link', false);
    }
}
