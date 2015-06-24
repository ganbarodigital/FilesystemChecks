<?php

/**
 * Copyright (c) 2015-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   Filesystem/ValueBuilders
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-file-system
 */

namespace GanbaroDigital\Filesystem\ValueBuilders;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

use GanbaroDigital\Filesystem\Checks\IsFolder;
use GanbaroDigital\Filesystem\DataTypes\FilesystemPathData;

class ExplodeFolderList
{
    /**
     * return a list of matching folders inside a given folder
     *
     * @param  FilesystemPathData $fsData
     *         the folder to look inside
     * @param  string $pattern
     *         the regex to match
     * @return array<string>
     *         a list of the folders found
     *         will be empty if no folders found
     */
	public static function fromFilesystemPathData(FilesystemPathData $fsData, $pattern = ".+")
	{
		// make sure we have a folder
		if (!IsFolder::checkFilesystemPathData($fsData)) {
			return [];
		}

		// at this point, we are happy that we have a folder
		$directory = (string)$fsData;

        $dirIter = new RecursiveDirectoryIterator($directory);
        $recIter = new RecursiveIteratorIterator($dirIter, RecursiveIteratorIterator::SELF_FIRST);
        $regIter = new RegexIterator($recIter, '|^.+' . $pattern . '$|i', RegexIterator::GET_MATCH);

        // what happened?
        $filenames = [];
        foreach ($regIter as $match) {
            // skip over . and ..
            $endOfMatch = basename($match[0]);
            if (($endOfMatch === '.' && $match[0] !== '.') || $endOfMatch === '..') {
                continue;
            }

            // skip over anything that isn't a folder
            if (!IsFolder::checkFilename($match[0])) {
                continue;
            }

            // if we get here, then we are happy
            $filenames[] = $match[0];
        }

        // let's get the list into some semblance of order
        sort($filenames);

        // all done
        return $filenames;
	}
}