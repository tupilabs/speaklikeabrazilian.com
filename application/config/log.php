<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

/*
 * Codeigniter-Monolog integration package
 *
 * (c) Andreas Pfotenhauer <pfote@ypsilon.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* GENERAL OPTIONS */

$config['handler']     = 'file';    /* valid handlers are syslog|file|gelf|raven */
$config['name']        = 'slbr';
$config['threshold']   = '5';    /* log all */
$config['formatter']   = 'line';
$config['line_format'] = "[%datetime%][%level_name%] %message%\n\n";
/* use this if you log to syslog */
/* $config['line_format'] = '%channel%.%level_name%: %message%'; */

/* use this if you log to raven */
/* $config['line_format'] = "%message% %context% %extra%\n"; */

/* syslog handler options */
$config['syslog_channel']  = 'slbr';
$config['syslog_facility'] = 'local6';

/* file handler options */
$config['file_logfile'] = APPPATH . 'logs/slbr.log';

/* GELF options */
$config['gelf_host'] = 'localhost';
$config['gelf_port'] = '12201';

/* Raven options */
$config['raven_endpoint'] = 'http://api:key@localhost/1';