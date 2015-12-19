<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DefinitionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Expressions repository;
     * @var SLBR\Repositories\ExpressionRepository
     */
    protected $expressionRepository;

    /**
     * Expressions repository;
     * @var SLBR\Repositories\DefinitionRepository
     */
    protected $definitionRepository;

    public function setUp()
    {
        parent::setUp();
        $this->expressionRepository = \App::make('SLBR\Repositories\ExpressionRepository');
        $this->definitionRepository = \App::make('SLBR\Repositories\DefinitionRepository');
    }

    /**
     * Test that our repository is empty.
     * @return void
     */
    public function testNoDefinitionsAtBeginning()
    {
        $definitions = $this->definitionRepository->all()->toArray();
        $this->assertEquals(0, count($definitions));
    }

    /**
     * Test that inserting definitions is working.
     * @return void
     */
    public function testInsertWorks()
    {
        $expression = $this->expressionRepository->create(array(
            'text' => 'Alambique',
            'char' => 'a',
            'contributor' => 'kinow'
        ))->toArray();
        $this->assertTrue($expression['id'] > 0);

        $definitionEloquent = $this->definitionRepository->create(array(
            'expression_id' => $expression['id'],
            'description' => 'A drinking barrel',
            'example' => 'Ele bebeu um alambique inteiro!',
            'tags' => 'bebida, bar',
            'status' => '',
            'email' => 'nobody@localhost.localdomain',
            'user_ip' => '127.0.0.1',
            'contributor' => 'kinow',
            'language_id' => 1
        ));

        $definition = $definitionEloquent->toArray();
        $expressionFromDefinition = $definitionEloquent->expression()->first()->toArray();

        $this->assertTrue($definition['id'] > 0);
        $this->assertEquals('bebida, bar', $definition['tags']);
        $this->assertEquals('Alambique', $expressionFromDefinition['text']);
    }

}
