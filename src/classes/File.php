<?php
/**
 * This file implements the class File.
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
 * File
 *
 * All functions regarding files.
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @copyright Thibaud Rohmer
 * @license   http://www.gnu.org/licenses/
 * @link      http://github.com/thibaud-rohmer/PhotoShow
 */

class File
{
	/// Path to the file
	public $path;
	
	/// File extension
	public $extension;
	
	/// File name
	public $name;
	
	/// File type
	public $type;
	
	/**
	 * Check that file exists, and parse its infos (extension,name,type)
	 *
	 * @param string $path 
	 * @author Thibaud Rohmer
	 */
	public function __construct($path){
		
		/// Check that file exists
		if(!file_exists($path))
			throw new jsonRPCException("The file doesn't exist !");
		
		/// Set variables
		$this->path			=	$path;
		$this->extension		=	self::Extension($path);
		$this->name			=	self::Name($path);	
		$this->type			=	self::Type($path);
		$this->root			=	self::Root();		
	}
	
	/**
	 * Return the root directory
	 *
	 * @return void
	 * @author C�dric Levasseur
	 */
	public static function Root(){
		return realpath(dirname(__FILE__)."/../../");
	}	
	
	/**
	 * Return the extension of $file
	 *
	 * @param string $file 
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function Extension($file){
		return pathinfo($file,PATHINFO_EXTENSION);
	}
	
	/**
	 * Return the name of $file, without the extension
	 *
	 * @param string $file 
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function Name($file){
		$info	=	pathinfo($file);
		return	basename($file,'.'.$info['extension']);
	}
	
	/**
	 * Return True/False Datediff lastmodified file and number days
	 *
	 * @param string $file 
	 * @param string $numberdays 
	 * @return void
	 * @author C�dric Levasseur
	 */
	public static function LastModified($file,$numberdays=null){
		if (file_exists($file)) {
			$ajd = new DateTime(date('F d Y'));
			$aj = new DateTime(date("F d Y",filemtime($file)));
			if ( $ajd->diff($aj)->format('%a') <= $numberdays) {
				return true;
			}
			return false;
		}
	}
	
	/**
	 * Return the type of $file
	 *
	 * @param string $file 
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function Type($file){
		$file=strtolower($file);
		if(self::Name($file) == "."){
			return "folder";
		}

		$ext	=	self::Extension($file);
		if(!isset($ext) || empty($ext)){
			return "Folder";
		}
		if (in_array($ext,Settings::$allowedExtImages)) 
			return "Image";
		if (in_array($ext,Settings::$allowedExtVideos))
			return "Video";
		if (in_array($ext,Settings::$allowedExtFiles) || $ext=='xml')
			return "File";
		return 0;

	}
	
	public static function path2Thumb($file,$type='thumb') {
		$file = stripslashes(str_replace(Settings::$photos_dir,Settings::$thumbs_dir,$file));
		switch(self::Type($file)){
			case "Image":
				if (strtolower($type) =="thumb") { $type="_thumb.jpg"; } else {$type="_small.jpg";}
				return dirname($file).'/'.(self::Name($file).$type);
			case "Video":
				if (strtolower($type) =="thumb") { $type="_thumb.jpg"; } else {$type=".".Settings::$encode_type;}
				return dirname($file).'/'.(self::Name($file).$type);
			case "Folder":
				return $file;
		}	
	}
	
	/**
	 * Absolute path comes in, relative path goes out !
	 *
	 * @param string $file 
	 * @param string $dir Directory from where the relative path will be (if NULL : photos_dir)
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function a2r($file,$dir=NULL){

		if(!isset($dir)){
			$dir		=	Settings::$photos_dir;
		}
				
		$rf	=	realpath($file);
		$rd =	realpath($dir);
		
		if($rf==$rd) return "";
		
		if( substr($rf,0,strlen($rd)) != $rd ){
			throw new jsonRPCException("This file $file is not inside the photos folder $dir !<br/>");
		}
		return ( substr($rf,strlen($rd) + 1 ) );
	}

	/**
	 * Relative path comes in, absolute path goes out !
	 *
	 * @param string $file 
	 * @param string $dir 
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function r2a($file,$dir=NULL){
		if(!isset($dir)){
			$dir		=	Settings::$photos_dir;
		}
		
		return $dir."/".$file;
	}
	
	/**
	 * Path comes in, relative and absolute path come out
	 *
	 * @param string $path 
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function paths($path,$dir=NULL){
		if(!isset($dir)){
			$dir		=	Settings::$photos_dir;
		}
		try{
			$rel		=	File::a2r($path,$dir);
			$abs		=	$path;
		}catch(Exception $e){
			// This path is already relative
			$rel		=	$path;
			$abs		=	File::r2a($path,$dir);
		}
		
		return array($rel,$abs);
	}

	/**
	 * Returns absolute path to next item
	 * 
	 * @param string $path
	 * @return $next
	 * @author Thibaud Rohmer
	 */
	 public static function next($path){
	 	$files 	= 	Menu::list_files(dirname($path));
	 	$pos 	=	array_search($path,$files);

	 	if( isset($pos) && $pos < sizeof($files) - 1 ){
	 		/// Found $path
 			return $files[$pos+1];
	 	}
	 	return $path;
	 }



	/**
	 * Returns absolute path to previous item
	 * 
	 * @param string $path
	 * @return $prev
	 * @author Thibaud Rohmer
	 */
	 public static function prev($path){
	 	$files 	=	Menu::list_files(dirname($path));
	 	$pos 	=	array_search($path,$files);

	 	if( isset($pos) && $pos > 0 ){
	 		/// Found $path
 			return $files[$pos-1];
	 	}
	 	return $path;
	 }

}
?>