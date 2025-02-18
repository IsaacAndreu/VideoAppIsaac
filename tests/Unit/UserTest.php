<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Comprova si la funció isSuperAdmin() retorna correctament true per un super admin.
     */
    public function test_user_is_super_admin()
    {
        $user = new User(['super_admin' => true]);

        $this->assertTrue($user->isSuperAdmin());
    }

    /**
     * Comprova si la funció isSuperAdmin() retorna false per un usuari normal.
     */
    public function test_user_is_not_super_admin()
    {
        $user = new User(['super_admin' => false]);

        $this->assertFalse($user->isSuperAdmin());
    }
}
