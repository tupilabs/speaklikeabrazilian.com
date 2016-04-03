<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 TupiLabs
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
 
use Illuminate\Foundation\Testing\DatabaseMigrations;

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

    /**
     * Test that when an expression is created it has no definitions.
     * @return void
     */
    public function testAnExpressionHasNoDefinitionsByDefault()
    {
        $definitions = $this->expressionRepository->create(array(
            'text' => 'Alambique',
            'char' => 'a',
            'contributor' => 'kinow'
        ))->definitions()->get()->toArray();
        $this->assertTrue(empty($definitions));
    }
}
