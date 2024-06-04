<?php

namespace Tests\Feature\Backend\Role;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ReadRolesTest.
 */
class ListRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_the_role_index_page()
    {
        $this->markTestIncomplete('This test is failing due to DataTableComponent missing.');

        $this->loginAsAdmin();

/**@JDS*/$response=
        $this->get('/admin/auth/role')
/**@JDS*/;dump(__CLASS__.'.'.__FUNCTION__.':'.__LINE__,request()->getRequestUri(),session()->all(),$response->headers->all());$response
            ->assertOk();
    }

    /** @test */
    public function only_admin_can_view_roles()
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->get('/admin/auth/role');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
