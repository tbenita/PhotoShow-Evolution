<?php
/**
 * This file implements the class Menu.
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
 * @link      http://github.com/thibaud-rohmer/PhotoShow-v2
 */

/**
 * Menu
 *
 * Creates a menu, by creating Menu instances for 
 * each directory in $dir.
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @copyright Thibaud Rohmer
 * @license   http://www.gnu.org/licenses/
 * @link      http://github.com/thibaud-rohmer/PhotoShow-v2
 */
class Menu
{
	/// Name of current directory
	public $title;
	
	/// HTML Class of the div : "selected" or empty
	public $class;
		
	/// HTML-formatted relative path to file
	private $webdir;
	
	/// Array of Menu instances, one per directory inside $dir
	private $items=array();
	
	/**
	 * Create Menu
	 *
	 * @param string $dir 
	 * @author Thibaud Rohmer
	 */
	public function __construct($dir){
		/// Check rights
		if(!(Judge::view($dir)))	return;		

		/// Set variables
		$this->title = basename($dir);
		$this->webdir=urlencode(File::a2r($dir));

		try{
			/// Check if selected dir is in $dir
			File::a2r(CurrentUser::$path,$dir);
			
			$this->selected			=	true;
			$this->class 			=	"selected";
		}catch(Exception $e){
			/// Selected dir not in $dir, or nothing is selected
			
			$this->selected			=	false;
			$this->class 			=	"";
		}
		/// Create Menu for each directory
		foreach($this->list_dirs($dir) as $d){
			$this->items[]	=	new Menu($d);
		}
	}
	
	/**
	 * Display Menu in website
	 *
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public function toHTML(){
		echo "<div class='menu_item $this->selected_class'>\n";
		echo "<div class='menu_title'><a href='?f=$this->webdir'>$this->title</a></div>\n";
		echo "<div class='menu_content'>\n";
		foreach($this->items as $item)
			$item->toHTML();
		echo "</div>\n</div>\n";
		
	}
	
	/**
	 * List directories in $dir, omit hidden directories
	 *
	 * @param string $dir 
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function list_dirs($dir){
		
		/// Directories list
		$list=array();

		/// Check that $dir is a directory, or throw exception
		if(!is_dir($dir)) 
			throw new Exception("$dir is not a directory");
			
		/// Directory content
		$dir_content = scandir($dir);
		
		/// Check each content
		foreach ($dir_content as $content){
			
			/// Content isn't hidden and is a directory
			if(	($content[0] != '.') && is_dir($path=$dir."/".$content)){
				/// Add content to list
				$list[]=$path;
			}
			
		}
		
		/// Return directories list
		return $list;
	}
	
	/**
	 * List files in $dir, omit hidden files
	 *
	 * @param string $dir 
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function list_files($dir){
		/// Directories list
		$list=array();
		
		/// Check that $dir is a directory, or throw exception
		if(!is_dir($dir)) 
			throw new Exception("$dir is not a directory");
			
		/// Directory content
		$dir_content = scandir($dir);
		
		/// Check each content
		foreach ($dir_content as $content){
			
			/// Content isn't hidden and is a file
			if(	($content[0] != '.') && is_file($path=$dir."/".$content)){
				/// Add content to list
				$list[]=$path;
			}
			
		}
		/// Return files list
		return $list;
	}
	
}
?>