<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Expressions repository;
     * @var SLBR\Repositories\LanguageRepository
     */
    protected $languageRepository;

    public function setUp()
    {
        parent::setUp();
        $this->languageRepository = \App::make('SLBR\Repositories\LanguageRepository');
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

}
