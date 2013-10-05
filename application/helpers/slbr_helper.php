<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
/**
* SLBR helper class.
*
* @package		CodeIgniter
* @author		Bruno P. Kinoshita
* @since        0.9
* @filesource
*/

/**
 * http://stackoverflow.com/questions/10571326/why-is-my-php-regex-that-parses-markdown-links-broken
 */
if ( ! function_exists('parse_expression'))
{
    function parse_expression($text) {
        $CI =& get_instance(); // get CI instance
        
        $base_url = $CI->config->site_url('');
        $text = nl2br(urldecode($text));
        $pattern = "/\[([^]]*)\]/i";
        $replace = "<a href=\"{$base_url}expression/define?e=$1\">$1</a>";
        $text = preg_replace($pattern, $replace, $text);
        return $text;
    }
}

/**
 * Highlights a word in a sentence
 */
if ( ! function_exists('highlight_word'))
{
	function highlight_word($sentence, $word) {
		$sentence = str_ireplace($word, '<span style="color: black; font-weight: bold; background-color: #FFFF99; padding: 2px 3px;">'.$word.'</span>', $sentence);
		return $sentence;
	}
}

?>