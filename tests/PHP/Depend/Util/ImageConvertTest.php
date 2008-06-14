<?php
/**
 * This file is part of PHP_Depend.
 * 
 * PHP Version 5
 *
 * Copyright (c) 2008, Manuel Pichler <mapi@pmanuel-pichler.de>.
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
 *   * Neither the name of Manuel Pichler nor the names of his
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
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Util
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2008 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.manuel-pichler.de/
 */

require_once dirname(__FILE__) . '/../AbstractTest.php';

require_once 'PHP/Depend/Util/ImageConvert.php';

/**
 * Test case for the image convert utility class.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Util
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2008 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.manuel-pichler.de/
 */
class PHP_Depend_Util_ImageConvertTest extends PHP_Depend_AbstractTest
{
    /**
     * The temporary output file.
     *
     * @type string
     * @var string
     */
    private $_out = null;
    
    /**
     * Removes temporary output files.
     *
     * @return void
     */
    protected function tearDown()
    {
        if (file_exists($this->_out)) {
            unlink($this->_out);
        }
        
        parent::tearDown();
    }
    
    /**
     * Tests the copy behaviour for same mime types.
     *
     * @return void
     */
    public function testConvertMakesCopyForSameMimeType()
    {
        $input      = dirname(__FILE__) . '/_input/pyramid.svg';
        $this->_out = sys_get_temp_dir() . '/pdepend.out.svg';
        
        $this->assertFileNotExists($this->_out);
        
        PHP_Depend_Util_ImageConvert::convert($input, $this->_out);
        
        $this->assertFileExists($this->_out);
        $this->assertFileEquals($input, $this->_out);
    }
    
    /**
     * Tests the image convert behaviour of the image magick execution path.
     *
     * @return void
     */
    public function testConvertWithImageMagickExtension()
    {
        if (extension_loaded('imagick') === false) {
            $this->markTestSkipped('No pecl/imagick extension.');
        }
        
        $input      = dirname(__FILE__) . '/_input/pyramid.svg';
        $this->_out = sys_get_temp_dir() . '/pdepend.out.png';
        
        $this->assertFileNotExists($this->_out);
        PHP_Depend_Util_ImageConvert::convert($input, $this->_out);
        $this->assertFileExists($this->_out);
    }
}