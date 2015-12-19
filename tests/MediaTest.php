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

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MediaTest extends TestCase
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

    /**
     * Expressions repository;
     * @var SLBR\Repositories\MediaRepository
     */
    protected $mediaRepository;

    public function setUp()
    {
        parent::setUp();
        $this->expressionRepository = \App::make('SLBR\Repositories\ExpressionRepository');
        $this->definitionRepository = \App::make('SLBR\Repositories\DefinitionRepository');
        $this->mediaRepository = \App::make('SLBR\Repositories\MediaRepository');
    }

    /**
     * Test that inserting medias is working.
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

        $this->assertTrue($definition['id'] > 0);
        $this->assertEquals('bebida, bar', $definition['tags']);

        $mediaEloquent = $this->mediaRepository->create(array(
            'definition_id' => $definition['id'],
            'url' => 'http://imgur.com/xiv.png',
            'reason' => 'Good image',
            'email' => 'test@localhost.localdomain',
            'status' => 'P',
            'content_type' => 'image/png',
            'contributor' => 'kinow'
        ));
        $definitionFromMedia = $mediaEloquent->definition()->first();

        $media = $mediaEloquent->toArray();

        $this->assertTrue($media['id'] > 0);

        $this->assertEquals('Ele bebeu um alambique inteiro!', $definitionFromMedia->toArray()['example']);

        $this->assertEquals('Good image', $media['reason']);
    }

}
