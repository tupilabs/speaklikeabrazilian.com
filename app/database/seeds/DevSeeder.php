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

use \Seeder;
use \Expression;
use \Definition;

class DevSeeder extends Seeder {
	
	public function run() 
	{
		$this->runExpressions();
		$this->runDefinitions();
		$this->runGroups();
		$this->runUsers();
	}

	public function runExpressions()
	{
		DB::table('expressions')->delete();

		Expression::create(
			array(
				'text' => 'Caranga',
				'char' => 'C',
				'contributor' => 'kinow'
			)
		);

		Expression::create(
			array(
				'text' => 'Jo&atilde;o Pessoa',
				'char' => 'J',
				'contributor' => 'kinow'
			)
		);

		Expression::create(
			array(
				'text' => 'Duro na queda',
				'char' => 'D',
				'contributor' => 'kinow'
			)
		);

		Expression::create(
			array(
				'text' => 'No definitions',
				'char' => 'N',
				'contributor' => 'kinow'
			)
		);
	}

	public function runDefinitions()
	{
		for ($i =0; $i < 15; $i++)
		{
			Definition::create(
				array(
					'expression_id' => 1, 
					'description' => 'A nice car',
					'example' => 'O Johnny tem uma bela caranga',
					'tags' => 'carro, carrao, maquina',
					'status' => 1,
					'email' => 'kinow@slbr.com',
					'contributor' => 'kinow',
					'moderator_id' => null
				)
			);

			$approvedDefinition = Definition::create(
				array(
					'expression_id' => 1, 
					'description' => 'Someone born in Carangopolis',
					'example' => 'De onde você &eacute;? <br/>Eu sou Caranga.',
					'tags' => 'carro, carrao, maquina',
					'status' => 2,
					'email' => 'kinow@slbr.com',
					'contributor' => 'kinow',
					'moderator_id' => 1
				)
			);

			Rating::create(
				array(
					'user_ip' => '127.0.0.1',
					'rating' => 1, 
					'definition_id' => $approvedDefinition->id
				)
			);

			Rating::create(
				array(
					'user_ip' => '192.168.0.1',
					'rating' => 1, 
					'definition_id' => $approvedDefinition->id
				)
			);

			Rating::create(
				array(
					'user_ip' => '192.168.0.16',
					'rating' => 1, 
					'definition_id' => $approvedDefinition->id
				)
			);

			Rating::create(
				array(
					'user_ip' => '192.168.0.115',
					'rating' => -1, 
					'definition_id' => $approvedDefinition->id
				)
			);

			Definition::create(
				array(
					'expression_id' => 2, 
					'description' => 'A place in the Northeast',
					'example' => 'Vamos para Jo&atilde;o Pessoa?',
					'tags' => 'cidade, para&iacute;ba',
					'status' => 2,
					'email' => 'stufi@slbr.com',
					'contributor' => 'stufi',
					'moderator_id' => 2
				)
			);

			Definition::create(
				array(
					'expression_id' => 3, 
					'description' => 'Hard to beat',
					'example' => 'Meu time &eacute; duro na queda',
					'tags' => 'duro, bravo, confi&aacute;vel',
					'status' => 1,
					'email' => 'angels@slbr.com',
					'contributor' => 'angels',
					'moderator_id' => 1
				)
			);
		}
	}

	public function runGroups()
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

	public function runUsers()
	{
		try
		{
		    // Create the user
		    $user = Sentry::createUser(array(
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