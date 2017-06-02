<?php 
	/**
	 * Github/Bitbucket Wiki Smarty HTML browser autolad
	 **/

	/* initialize config */
	define('DEBUG', false);

  /* autoload libraries*/
	$loadsDir = array (
		'./markdown/Parser.php',
    './markdown/block/',
    './markdown/inline/',
		'./markdown/Markdown.php',
		'./markdown/MarkdownExtra.php',
		'./markdown/GithubMarkdown.php',
		'./viewer/Viewer.php'
	);
	function __autoloads($loadsDir, $debug = false){
			foreach ($loadsDir as $dir) {
				  if (is_dir($dir)){
						if ($gestor = opendir($dir)) {
							while (false !== ($entrada = readdir($gestor))) {
								  if ($entrada == '.' || $entrada == '..') continue;
									if ($debug)
									  echo 'Load: ' . $dir . $entrada . '<br>';
									require_once($dir . $entrada);
							}
							closedir($gestor);
							continue;
						}
						die('Error iterating over dir: ' . $dir);
					} else if (is_file($dir)){
						if ($debug)
							echo 'Load: ' . $dir . '<br>';
						require_once($dir);
						continue;
					}
					die('Error loading dir: ' . $dir);
			}
	}
	__autoloads($loadsDir, DEBUG);
	/**
	 * Thanks to https://github.com/cebe/markdown for his library markdown that parses txt to html. 
	 * Markdown library license is: The MIT License (MIT). 
	 * 
	 * The MIT License (MIT)
	 *
	 * Copyright (c) 2014 Carsten Brandt
	 *
	 * Permission is hereby granted, free of charge, to any person obtaining a copy
 	 * of this software and associated documentation files (the "Software"), to deal
	 * in the Software without restriction, including without limitation the rights
	 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	 * copies of the Software, and to permit persons to whom the Software is
	 * furnished to do so, subject to the following conditions:
	 *
	 * The above copyright notice and this permission notice shall be included in all
	 * copies or substantial portions of the Software.
	 *
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	 * SOFTWARE.
	 **/
		