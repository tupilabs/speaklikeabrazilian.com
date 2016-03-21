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

use \DB;

use Illuminate\Database\Seeder;

use SLBR\Models\Expression;
use SLBR\Models\Definition;
use SLBR\Models\Rating;
use SLBR\Models\Media;

class DevDatabaseSeeder extends Seeder
{
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
        Expression::create(
            array(
                'text' => 'Caranga',
                'char' => 'C',
                'contributor' => 'kinow'
            )
        );
        Expression::create(
            array(
                'text' => 'Jo&atilde;o Pessoa',
                'char' => 'J',
                'contributor' => 'kinow'
            )
        );
        Expression::create(
            array(
                'text' => 'Duro na queda',
                'char' => 'D',
                'contributor' => 'kinow'
            )
        );
        Expression::create(
            array(
                'text' => 'No definitions',
                'char' => 'N',
                'contributor' => 'kinow'
            )
        );
    }
    public function runDefinitions()
    {
        for ($i =0; $i < 15; $i++)
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
                    'language_id' => 1
                )
            );
            $approvedDefinition = Definition::create(
                array(
                    'expression_id' => 1, 
                    'description' => 'Someone born in Carangopolis',
                    'example' => 'De onde você &eacute;? <br/>Eu sou Caranga.',
                    'tags' => 'carro, carrao, maquina',
                    'status' => 2,
                    'email' => 'kinow@slbr.com',
                    'contributor' => 'kinow',
                    'language_id' => 1
                )
            );
            Media::create(
                array(
                    'url' => 'http://i.imgur.com/D1J7DRu.gif',
                    'reason' => 'Chuaaa',
                    'email' => 'user@internet.zijjj',
                    'status' => 2,
                    'content_type' => 'image/gif',
                    'contributor' => 'Thom',
                    'definition_id' => $approvedDefinition->id
                )
            );
            Rating::create(
                array(
                    'user_ip' => '127.0.0.1',
                    'rating' => 1, 
                    'definition_id' => $approvedDefinition->id
                )
            );
            Rating::create(
                array(
                    'user_ip' => '192.168.0.1',
                    'rating' => 1, 
                    'definition_id' => $approvedDefinition->id
                )
            );
            Rating::create(
                array(
                    'user_ip' => '192.168.0.16',
                    'rating' => 1, 
                    'definition_id' => $approvedDefinition->id
                )
            );
            Rating::create(
                array(
                    'user_ip' => '192.168.0.115',
                    'rating' => -1, 
                    'definition_id' => $approvedDefinition->id
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
                    'language_id' => 1
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
                    'language_id' => 1
                )
            );
        }
    }
}
