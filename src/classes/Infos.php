<<<<<<< HEAD
<?php
/**
 * This file implements the class Infos.
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
 * @copyright 2011 Thibaud Rohmer
 * @license   http://www.gnu.org/licenses/
 * @link      http://github.com/thibaud-rohmer/PhotoShow
 */

/**
 * Used to print the info panel
 *
 * The ImagePanel contains one image, and the infos
 * about that image (such as EXIF, Comments).
 * If the user is logged, it contains even more stuff.
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @copyright Thibaud Rohmer
 * @license   http://www.gnu.org/licenses/
 * @link      http://github.com/thibaud-rohmer/PhotoShow
 */

class Infos implements HTMLObject
{
	private $info;
	
	private $exif;

	private $comments;

	public function __construct(){

		if(CurrentUser::$admin || CurrentUser::$uploader){
			$this->info = new AdminPanel();
		}

		if(!Settings::$nocomments){
			$this->comments	=	new Comments(CurrentUser::$path);
		}

	}

	public function toHTML(){

		echo "<div id='share'>\n";
		
        /*
		if(Settings::$plusone){	
			echo "<br/><br/>";
			echo '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>';
			
			echo '<g:plusone></g:plusone>';
			echo '<br/><br/>';
		}
         */

        
		
        if(Settings::$like){				

            $rootURL = Settings::$site_address;
            $pageURL = $rootURL."/?f=".urlencode(File::a2r(CurrentUser::$path));

            echo '<iframe src="//www.facebook.com/plugins/like.php?href='.$pageURL.'&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>';
        }


		echo "</div>";

	}

}

?>
=======
<?php
/**
 * This file implements the class Infos.
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
 * Used to print the info panel
 *
 * The ImagePanel contains one image, and the infos
 * about that image (such as EXIF, Comments).
 * If the user is logged, it contains even more stuff.
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
class Infos implements HTMLObject {
    private $info;
    private $exif;
    private $comments;
    public function __construct() {
        if (CurrentUser::$admin || CurrentUser::$uploader) {
            $this->info = new AdminPanel();
        }
        $this->exif = new Exif(CurrentUser::$path);
        if (!Settings::$nocomments) {
            $this->comments = new Comments(CurrentUser::$path);
        }
    }
    public function toHTML() {
        if (CurrentUser::$admin || CurrentUser::$uploader) {
            $this->info->toHTML();
        }
        $this->exif->toHTML();
        echo "<div id='comments' class='box'>\n";
        if (!Settings::$nocomments) {
            $this->comments->toHTML();
        }
        echo "</div>\n";
        echo "<div id='share'>\n";
        echo "</div>";
    }
}
?>
>>>>>>> 3fbb242568a4ddc60dee5d2c019391f366ad63d4
