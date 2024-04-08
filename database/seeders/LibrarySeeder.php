<?php

namespace Database\Seeders;

use Database\Seeders\Auth\PermissionRoleSeeder;
use Database\Seeders\Auth\UserRoleSeeder;
use Database\Seeders\Auth\UserSeeder;
use Database\Seeders\Book\BookSeeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;

/**
 * Class BookSeeder.
 */
class LibrarySeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->truncateMultiple([
            'books',
        ]);

        $this->call(BookSeeder::class);

        $this->enableForeignKeys();
    }
}
