<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpressionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Expressions repository;
     * @var SLBR\Repositories\ExpressionRepository
     */
    protected $expressionRepository;

    public function setUp()
    {
        parent::setUp();
        $this->expressionRepository = \App::make('SLBR\Repositories\ExpressionRepository');
    }

    /**
     * Test that our repository is empty.
     * @return void
     */
    public function testNoExpressionsAtBeginning()
    {
        $expressions = $this->expressionRepository->all()->toArray();
        $this->assertEquals(0, count($expressions));
    }

    /**
     * Test that inserting expressions is working.
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
        $this->assertEquals('kinow', $expression['contributor']);
    }

    /**
     * Test that an expression cannot be inserted twice.
     * @return void
     */
    public function testExpressionTextIsUnique()
    {
        $this->setExpectedException('Illuminate\Database\QueryException');
        $expressionOne = $this->expressionRepository->create(array(
            'text' => 'Bebado',
            'char' => 'b',
            'contributor' => 'albuquerque'
        ))->toArray();
        $expressionTwo = $this->expressionRepository->create(array(
            'text' => 'Bebado',
            'char' => 'b',
            'contributor' => 'albuquerque'
        ))->toArray();
    }
}
