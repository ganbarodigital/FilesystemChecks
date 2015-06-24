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

namespace GanbaroDigital\Filesystem\Iterators;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

use GanbaroDigital\Filesystem\Checks\IsFolder;
use GanbaroDigital\Filesystem\DataTypes\FilesystemPathData;

class SplFolderIterator
{
    // this is:
    //
    //     FilesystemIterator::KEY_AS_PATHNAME
    //     | FilesystemIterator::CURRENT_AS_FILEINFO
    //     | FilesystemIterator::SKIP_DOTS
    //
    // we have to pre-calcuate the value to use here, which sucks tbh
    const DEFAULT_FLAGS = 4096;

    /**
     * run the PHP RecursiveDirectoryIterator over a folder
     *
     * this is really meant to be used as a ValueBuilder in other ValueBuilders,
     * but feel free to use it directly if you need to
     *
     * @param  FilesystemPathData $fsData
     *         the folder to look inside
     * @param  string $pattern
     *         regex pattern to match
     * @param  int $flags
     *         the FilesystemIterator flags to use
     * @return RegexIterator
     *         iterate over this to get the matches
     */
    public static function fromFilesystemPathData(FilesystemPathData $fsData, $pattern = ".+", $flags = self::DEFAULT_FLAGS)
    {
        $dirIter = new RecursiveDirectoryIterator((string)$fsData, $flags);
        $recIter = new RecursiveIteratorIterator($dirIter, RecursiveIteratorIterator::SELF_FIRST);
        $regIter = new RegexIterator($recIter, '|^.+' . $pattern . '$|i', RegexIterator::GET_MATCH);

        return $regIter;
    }
}