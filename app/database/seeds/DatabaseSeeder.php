<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2014 TupiLabs
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

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->populateGroups();
		$this->populateUsers();

		$this->call('LanguagesSeeder');
	}

	public function populateGroups()
	{
		try
		{
		    // Create the groups
		    $moderators = Sentry::createGroup(array(
		        'name'        => 'Moderators',
		        'permissions' => array(
		            'admin' => 0,
		            'moderator' => 1,
		        ),
		    ));

		    $admins = Sentry::createGroup(array(
		        'name'        => 'Administrators',
		        'permissions' => array(
		            'admin' => 1,
		            'moderator' => 1,
		        ),
		    ));

		    
		}
		catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
		{
		    echo 'Name field is required';
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
		    echo 'Group already exists';
		}
	}

	public function populateUsers()
	{
		try
		{
		    // Create the user
		    $user = Sentry::createUser(array(
		    	'first_name' => 'Bruno', 
		    	'last_name' => 'Kinoshita',
		        'email'     => 'mod@speaklikeabrazilian.com',
		        'password'  => 'test',
		        'activated' => true
		    ));

		    // Find the group using the group id
		    $moderatorsGroup = Sentry::findGroupByName('Moderators');

		    // Assign the group to the user
		    $user->addGroup($moderatorsGroup);

		    // Create the user
		    $user = Sentry::createUser(array(
		    	'first_name' => 'Bruno', 
		    	'last_name' => 'Kinoshita',
		        'email'     => 'admin@speaklikeabrazilian.com',
		        'password'  => 'test',
		        'activated' => true
		    ));

		    // Find the group using the group id
		    $adminsGroup = Sentry::findGroupByName('Administrators');

		    // Assign the group to the user
		    $user->addGroup($adminsGroup);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    echo 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    echo 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    echo 'User with this login already exists.';
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    echo 'Group was not found.';
		}
	}

}