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

use Illuminate\Database\Seeder;

use SLBR\Models\Expression;
use SLBR\Models\Definition;
use SLBR\Models\Rating;
use SLBR\Models\Media;


class DevDatabaseSeeder extends Seeder
{

    const NUMBER_OF_EXPRESSIONS = 20;
    const NUMBER_OF_DEFINITIONS = 100;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runExpressions();
        $this->runDefinitions();
    }

    public function runExpressions()
    {
        DB::table('expressions')->delete();

        for ($i = 0; $i < self::NUMBER_OF_EXPRESSIONS; $i++)
        {
            $expression = factory(Expression::class)->create();
        }
    }
    public function runDefinitions()
    {
        for ($i =0; $i < self::NUMBER_OF_DEFINITIONS; $i++)
        {
            $definition = factory(Definition::class)->create();
            // randomly assign it to an expression
            $definition->expression_id = rand(1, self::NUMBER_OF_EXPRESSIONS);
            // randomly dis/approve it
            $definition->status = rand(1, 2);
            
            if ($definition->status == 2)
            {
                // randomly add a media
                if ((bool)random_int(0, 1))
                {
                    for ($j = 0; $j < rand(1, 3); $j++)
                    {
                        $media = factory(Media::class)->create();
                        $media->status = 1;
                        $media->definition_id = $definition->id;
                        $media->save();
                    }
                }

                // add some random votes
                for ($j = 0; $j < rand(0, 5); $j++)
                {
                    $rating = factory(Rating::class)->make();
                    $rating->definition_id = $definition->id;
                    $rating->save();
                }
            }

            // save it again
            $definition->save();
        }
    }

}
