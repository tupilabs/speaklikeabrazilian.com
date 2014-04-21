<?php 

use \Seeder;
use \Expression;
use \Definition;

class DevSeeder extends Seeder {
	
	public function run() 
	{
		$this->runExpressions();
		$this->runDefinitions();
		$this->runUsers();
	}

	public function runExpressions()
	{
		DB::table('expressions')->delete();

		Expression::create(
			array(
				'text' => 'Caranga',
				'char' => 'C',
				'contributor' => 'kinow',
				'moderator_id' => null
			)
		);

		Expression::create(
			array(
				'text' => 'Jo&atilde;o Pessoa',
				'char' => 'J',
				'contributor' => 'kinow',
				'moderator_id' => null
			)
		);

		Expression::create(
			array(
				'text' => 'Duro na queda',
				'char' => 'D',
				'contributor' => 'kinow',
				'moderator_id' => null
			)
		);

		Expression::create(
			array(
				'text' => 'No definitions',
				'char' => 'N',
				'contributor' => 'kinow',
				'moderator_id' => null
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

	public function runUsers()
	{
		try
		{
		    // Create the user
		    $user = Sentry::createUser(array(
		        'email'     => 'test@speaklikeabrazilian.com',
		        'password'  => 'test',
		        'activated' => true,
		        'permissions' => array(
		            'user.create' => 1,
		            'user.delete' => 1,
		            'user.view'   => 1,
		            'user.update' => 1,
		        ),
		    ));

		    // Find the group using the group id
		    // $adminGroup = Sentry::findGroupById(1);

		    // Assign the group to the user
		    // $user->addGroup($adminGroup);
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