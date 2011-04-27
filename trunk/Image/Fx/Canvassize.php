<?php
/**
 * image-fx-canvassize
 *
 * Copyright (c) 2009-2011, Nikolay Petrovski <to.petrovski@gmail.com>.
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
 *   * Neither the name of Sebastian Bergmann nor the names of his
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
 * @package   Image
 * @author    Nikolay Petrovski <to.petrovski@gmail.com>
 * @copyright 2009-2011 Nikolay Petrovski <to.petrovski@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @since     File available since Release 1.0.0
 */


class Image_Fx_Canvassize extends Image_Plugin_Base implements Image_Plugin_Interface {

    public $type_id = "effect";

    public $sub_type_id = "canvassize";

    public $version = 1.0;

    public function __construct($t = 10, $r = 10, $b = 10, $l = 10, $color = "")
    {
        $this->t = $t;
        $this->r = $r;
        $this->b = $b;
        $this->l = $l;
        $this->color = $color;
    }

    public function generate()
    {
        $width = $this->_owner->imagesx();
        $height = $this->_owner->imagesy();
        $temp = new Image_Image();
        if(! empty($this->color)) {
            $temp->createImageTrueColor($width + ($this->r + $this->l), $height +
             ($this->t + $this->b));
            $arrColor = Image_Image::hexColorToArrayColor($this->color);
            $tempcolor = imagecolorallocate($temp->image, $arrColor['red'], $arrColor['green'], $arrColor['blue']);
            imagefilledrectangle($temp->image, 0, 0, $temp->imagesx(), $temp->imagesy(), $tempcolor);
        }
        else {
            $temp->createImageTrueColorTransparent($width + ($this->r + $this->l), $height +
             ($this->t + $this->b));
        }
        imagecopy($temp->image, $this->_owner->image, $this->l, $this->t, 0, 0, $width, $height);
        $this->_owner->image = $temp->image;
        unset($temp);
        return true;
    }
}
