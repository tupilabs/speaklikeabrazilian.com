<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2016 TupiLabs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use SLBR\Models\Language;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Database seeder. Creates basic entities, required for all environments.
 * @since 2.1
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->populateRoles();
        $this->populateUsers();
        $this->populateLanguages();

        // Calls the DevDatabaseSeeder only for the development environments
        if (App::environment('dev', 'test', 'local')) {
            Log::info("Seeding DEVELOPMENT data");
            $this->call(DevDatabaseSeeder::class);
        }

        Model::reguard();
    }

    /**
     * Populates the roles table.
     *
     * @return void
     */
    public function populateRoles()
    {
        DB::table('roles')->delete();
        // Create the groups
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Moderators',
            'slug' => 'mods',
        ]);
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Administrators',
            'slug' => 'admins',
        ]);
    }

    /**
     * Populates the users table.
     *
     * @return void
     */
    public function populateUsers()
    {
        DB::table('users')->delete();
        $mod = Sentinel::register(array(
            'email'    => 'mod@speaklikeabrazilian.com',
            'password' => 'bruno',
        ), /* activate */ true);

        $modRole = Sentinel::findRoleByName('Moderators');
        $modRole->users()->attach($mod);

        $admin = Sentinel::register(array(
            'email'    => 'admin@speaklikeabrazilian.com',
            'password' => 'bruno',
        ), /* activate */ true);

        $adminRole = Sentinel::findRoleByName('Administrators');
        $adminRole->users()->attach($admin);
        $modRole->users()->attach($admin);
    }

    /**
     * Populates the languages table.
     *
     * @return void
     */
    public function populateLanguages()
    {
        DB::table('languages')->delete();
        Language::create(
            array(
                'id' => 1,
                'slug' => 'en',
                'description' => 'English',
                'local_description' => 'English'
            )
        );
        Language::create(
            array(
                'id' => 2,
                'slug' => 'es',
                'description' => 'Spanish',
                'local_description' => 'Espa&ntilde;ol'
            )
        );
        Language::create(
            array(
                'id' => 3,
                'slug' => 'it',
                'description' => 'Italian',
                'local_description' => 'Italiano'
            )
        );
        Language::create(
            array(
                'id' => 4,
                'slug' => 'pt',
                'description' => 'Portuguese',
                'local_description' => 'Portugu&ecirc;s'
            )
        );
        Language::create(
            array(
                'id' => 5,
                'slug' => 'jp',
                'description' => 'Japanese',
                'local_description' => 'Nihongo'
            )
        );
        Language::create(
            array(
                'id' => 6,
                'slug' => 'de',
                'description' => 'German',
                'local_description' => 'Deutsch'
            )
        );
        Log::info('Languages added!');
    }
}
