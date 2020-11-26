<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class RoleTest extends DuskTestCase
{
    /**
     * Test create new role.
     *
     * @return void
     * @throws Throwable
     */
    public function testCreateNewRole()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(User::find(1))
                ->visit('/user-access/roles')
                ->assertSee('User Role')
                ->clickLink('Create ')
                ->assertSee('Create Role')
                ->type('role', 'Customer Test Role')
                ->type('description', 'Customer group access')
                ->check('#permission_29')
                ->check('#permission_30')
                ->check('#permission_31')
                ->check('#permission_32')
                ->press('Save Role')
                ->assertSee('Customer Test Role');
        });
    }

    /**
     * Test delete existing role
     */
    public function testDeleteRole()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(User::find(1))
                ->visit('/user-access/roles')
                ->assertSee('Customer Test Role')
                ->press('#dropdown-customer-test-role')
                ->pause(200)
                ->press('.confirm-delete[data-label="Customer Test Role"]')
                ->waitForText('Are you sure want to delete', 2)
                ->press('#modal-delete button[type="submit"]')
                ->assertDontSee('Customer Test Role');
        });
    }
}
