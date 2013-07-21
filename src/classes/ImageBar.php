<?php
/**
 * This file implements the class ImageBar.
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 *
 * This file is part of PhotoShow.
 *
 * PhotoShow is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PhotoShow is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PhotoShow.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @author    Psychedelys <psychedelys@gmail.com>
 * @copyright 2011 Thibaud Rohmer + 2013 Psychedelys
 * @license   http://www.gnu.org/licenses/
 * @oldlink   http://github.com/thibaud-rohmer/PhotoShow
 * @link      http://github.com/psychedelys/PhotoShow
 */
/**
 * ImageBar
 *
 * The ImageBar contains some buttons insanely awesome
 * buttons, incredibly usefull. Yeah, it rocks.
 *
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @author    Psychedelys <psychedelys@gmail.com>
 * @copyright Thibaud Rohmer + Psychedelys
 * @license   http://www.gnu.org/licenses/
 * @oldlink   http://github.com/thibaud-rohmer/PhotoShow
 * @link      http://github.com/psychedelys/PhotoShow
 */
<<<<<<< HEAD
class ImageBar
{

	/// Buttons to display
	private $buttons = array();


	/**
	 * Create the ImageBar
	 * 
	 * @author Thibaud Rohmer
	 */
	public function __construct($fs=false){

		$file = urlencode(File::a2r(CurrentUser::$path));
		$this->buttons['prev'] = array('icon'=>"icon-step-backward","url"=>"?p=p&f=".$file);
		$this->buttons['linear'] = array('icon'=>"  icon-camera","url"=> "?f=".$file);
		$this->buttons['back'] = array('icon'=>" icon-th","url"=>"?f=".urlencode(File::a2r(dirname(CurrentUser::$path))));
		if(!Settings::$nodownload){
			$this->buttons['img'] = array('icon'=>"icon-picture","url"=>"?t=Big&f=".$file);
			$this->buttons['get'] = array('icon'=>"icon-download-alt","url"=>"?t=BDl&f=".$file);
		}
		
		$this->buttons['slideshow'] = array('icon'=>" icon-play","url"=> "?f=".$file);
		//~ $this->buttons['fullscreen'] = array('icon'=>" icon-fullscreen","url"=> "?f=".$file);
		$this->buttons['next'] = array('icon'=>"icon-step-forward","url"=>"?p=n&f=".$file);
		
	}

	/**
	 * Display ImageBar on Website
	 * 
	 * @author Thibaud Rohmer
	 */
	 public function toHTML(){
	 	foreach($this->buttons as $key=>$value){
	 		echo "<li id='$key'><a href='".$value['url']."' alt='$key'><i  class='".$value['icon']." icon-white'></i></a></li>";
	 	}
	 }

=======
class ImageBar {
    /// Buttons to display
    private $buttons = array();
    /**
     * Create the ImageBar
     *
     * @author Thibaud Rohmer
     */
    public function __construct($fs = false) {
        $file = urlencode(File::a2r(CurrentUser::$path));
        //		if($fs){
        //			$t = "?t=Fs&amp;";
        //		}else{
        $t = "?";
        //		}
        $this->buttons['prev'] = $t . "p=p&amp;f=" . $file;
        $this->buttons['back'] = "?f=" . urlencode(File::a2r(dirname(CurrentUser::$path)));
        if (!Settings::$nodownload) {
            $this->buttons['img'] = "?t=Big&amp;f=" . $file;
            $this->buttons['get'] = "?t=BDl&amp;f=" . $file;
        }
        $this->buttons['next'] = $t . "p=n&amp;f=" . $file;
        $this->buttons['slideshow'] = $t . "f=" . $file;
    }
    /**
     * Display ImageBar on Website
     *
     * @author Thibaud Rohmer
     */
    public function toHTML() {
        foreach ($this->buttons as $name => $url) {
            echo "<span id='$name'><a href='$url'>" . Settings::_("imagenav", $name) . "</a></span>";
            //echo "<span id='$name'><a href='$url'>$name</a></span>";
            
        }
    }
>>>>>>> 3fbb242568a4ddc60dee5d2c019391f366ad63d4
}
?>
