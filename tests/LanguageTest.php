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

class LanguageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Expressions repository;
     * @var SLBR\Repositories\LanguageRepository
     */
    protected $languageRepository;

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
        $this->languageRepository = \App::make('SLBR\Repositories\LanguageRepository');
        $this->expressionRepository = \App::make('SLBR\Repositories\ExpressionRepository');
        $this->definitionRepository = \App::make('SLBR\Repositories\DefinitionRepository');
    }

    /**
     * Test that our repository is **not** empty.
     * @return void
     */
    public function testDefaultLanguagesCreated()
    {
        $languages = $this->languageRepository->all()->toArray();
        $this->assertNotEquals(0, count($languages));
        $found = false;
        foreach ($languages as $language)
        {
            if ($language['slug'] === 'en')
            {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found);
    }

    /**
     * Test that inserting languages is working.
     * @return void
     */
    public function testInsertWorks()
    {
        $language = $this->languageRepository->create(array(
            'id' => 100,
            'slug' => 'br',
            'description' => 'Breton',
            'local_description' => 'Breton'
        ))->toArray();
        $this->assertTrue($language['id'] > 0);
        $this->assertEquals('Breton', $language['local_description']);
    }

    public function testDefinitionUsesALanguage()
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

        $language = $this->languageRepository->find(1);
        $definitionsFromLanguage = $language->definitions()->get()->toArray();
        $found = false;
        foreach ($definitionsFromLanguage as $definitionFromLanguage)
        {
            if (((int) $definitionFromLanguage['id']) === ((int) $definition['id']))
                $found = true;
        }
        $this->assertTrue($found);
    }

}
