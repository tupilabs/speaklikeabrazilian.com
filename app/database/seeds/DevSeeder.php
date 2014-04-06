<?php 

use \Seeder;
use \Expression;
use \Definition;

class DevSeeder extends Seeder {
	
	public function run() 
	{
		$this->runExpressions();
		$this->runDefinitions();
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

		Definition::create(
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