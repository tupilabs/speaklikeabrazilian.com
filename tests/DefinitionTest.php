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
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
        $this->expressionRepository = $this->app->make('SLBR\Repositories\ExpressionRepository');
        $this->definitionRepository = $this->app->make('SLBR\Repositories\DefinitionRepository');
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
            'status' => 'P',
            'email' => 'nobody@localhost.localdomain',
            'user_ip' => '127.0.0.1',
            'contributor' => 'kinow',
            'language_id' => 1
        ));

        $definition = $definitionEloquent->toArray();
        $expressionFromDefinition = $definitionEloquent->expression()->first()->toArray();

        $this->assertTrue($definition['id'] > 0);
        $this->assertEquals('bebida, bar', $definition['tags']);
        $this->assertEquals('P', $definition['status']);
        $this->assertEquals('Alambique', $expressionFromDefinition['text']);
    }

    /**
     * Test the formatted description of a definition.
     * @return void
     */
    public function testFormattedDescription()
    {
        $expression = $this->expressionRepository->create(array(
            'text' => 'Alambique',
            'char' => 'a',
            'contributor' => 'kinow'
        ))->toArray();
        $this->assertTrue($expression['id'] > 0);

        $definitionEloquent = $this->definitionRepository->create(array(
            'expression_id' => $expression['id'],
            'description' => 'Uma expressao [do natal] do ano passado',
            'example' => 'Ele bebeu um alambique inteiro!',
            'tags' => 'bebida, bar',
            'status' => '',
            'email' => 'nobody@localhost.localdomain',
            'user_ip' => '127.0.0.1',
            'contributor' => 'kinow',
            'language_id' => 1
        ));

        $this->assertEquals(
            'Uma expressao <a href="http://localhost/en/expression/define?e=do natal">do natal</a> do ano passado',
            get_definition_formatted_text($definitionEloquent['description'], ['slug' => 'en'])
        );

        $definitionEloquent->description = 'Uma expressao do natal do ano passado';
        $this->assertEquals(
            'Uma expressao do natal do ano passado',
            get_definition_formatted_text($definitionEloquent['description'], ['slug' => 'en'])
        );
    }

    /**
     * Test the formatted example of a definition.
     * @return void
     */
    public function testFormattedExample()
    {
        $expression = $this->expressionRepository->create(array(
            'text' => 'Alambique',
            'char' => 'a',
            'contributor' => 'kinow'
        ))->toArray();
        $this->assertTrue($expression['id'] > 0);

        $definitionEloquent = $this->definitionRepository->create(array(
            'expression_id' => $expression['id'],
            'description' => 'Uma expressao [do natal] do ano passado',
            'example' => 'Ele [bebeu] um alambique inteiro!',
            'tags' => 'bebida, bar',
            'status' => '',
            'email' => 'nobody@localhost.localdomain',
            'user_ip' => '127.0.0.1',
            'contributor' => 'kinow',
            'language_id' => 1
        ));

        $this->assertEquals(
            'Ele <a href="http://localhost/en/expression/define?e=bebeu">bebeu</a> um alambique inteiro!',
            get_definition_formatted_text($definitionEloquent['example'], ['slug' => 'en'])
        );

        $definitionEloquent->example = 'Ele bebeu um alambique inteiro!';
        $this->assertEquals(
            'Ele bebeu um alambique inteiro!',
            get_definition_formatted_text($definitionEloquent['example'], ['slug' => 'en'])
        );
    }

    /**
     * Test that the default language (English) is used when language_id = 1
     * @return void
     */
    public function testDefaultEnglishLanguage()
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

        $language = $definitionEloquent->language()->first()->toArray();

        $this->assertEquals('en', $language['slug']);
    }
}
