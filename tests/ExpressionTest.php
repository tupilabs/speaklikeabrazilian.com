<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use SLBR\Models\Expression;
use SLBR\Repositories\ExpressionRepository;

class ExpressionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Expressions repository;
     * @var SLBR\Repositories\ExpressionRepository
     */
    protected $expressions;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
