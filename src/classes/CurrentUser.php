<?php
/**
 * This file implements the class CurrentUser.
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
 * CurrentUser
 *
 * Stores the information of the currently logged user.
 * Implements login and logout function.
 *
 * @category  Website
 * @package   Photoshow
 * @author    Thibaud Rohmer <thibaud.rohmer@gmail.com>
 * @copyright Thibaud Rohmer
 * @license   http://www.gnu.org/licenses/
 * @link      http://github.com/thibaud-rohmer/PhotoShow
 */

class CurrentUser
{
	///	Current user account
	public static $account;
    
	///	Current user guest token
	public static $token;

	/// Bool : true if current user is an admin
	public static $admin;

	/// Bool : true if current user is allowed to upload
	public static $uploader;

	/// Current path requested by the user
	public static $path;

	/// Current type of stuff requested by user (Page / Zip / Image)
	public static $action = "Page";

	/// Type of page to display
	public static $page;

	/// File containing users info
	static public $accounts_file;

	/// File containing groups info
	static public $groups_file;

	/// File containing tokens info
	static public $tokens_file;

	/// Is this a JS query ?
	static public $js = false;

	/**
	 * Retrieves info for the current user account
	 *
	 * @author Thibaud Rohmer
	 */
	static public function init(){

		CurrentUser::$accounts_file =	Settings::$conf_dir."/accounts.xml";

		CurrentUser::$groups_file	=	Settings::$conf_dir."/groups.xml";

		CurrentUser::$tokens_file	=	Settings::$conf_dir."/guest_tokens.xml";

		/// Authentiated User
		if(isset($_GET['login']) && isset($_GET['pass'])){
			CurrentUser::login(stripslashes($_GET['login']),stripslashes($_GET['pass']));
		}
	
		///Check Token
		if(isset($_GET['token'])){
		    $token = $_GET['token'];
		    if (GuestToken::exist($token)){
			if (isset($_SESSION['login']) || isset(CurrentUser::$account)){
			    CurrentUser::logout();
			}
			CurrentUser::$token = $token;
			$_SESSION['token'] = CurrentUser::$token;
		    }
		} elseif (isset($_SESSION['token'])){
		    CurrentUser::$token = $_SESSION['token'];
		}
		

		/// Set path
		if(isset($_GET['f'])){
			CurrentUser::$path = stripslashes(File::r2a($_GET['f']));
			if(isset($_GET['p'])){
				switch($_GET['p']){
					case 'n':	CurrentUser::$path = File::next(CurrentUser::$path);
								break;
					case 'p':	CurrentUser::$path = File::prev(CurrentUser::$path);
								break;
				}
			}

		}else{
			/// Path not defined in URL
			CurrentUser::$path = Settings::$photos_dir;
		}

		/// Set CurrentUser account
		if (isset($_SESSION['login'])) {

			self::$account = new Account($_SESSION['login']);

			// groups sometimes can be null
			$groups = self::$account->groups === NULL ? array() : self::$account->groups;

			self::$admin = in_array("root", $groups);
			self::$uploader = in_array("uploaders", $groups);
			Settings::set_lang(self::$account->language);

			$_SESSION['token'] = "";

		} 
		
		/// Set action (needed for page layout)
		if(isset($_GET['t'])){
			switch($_GET['t']){

				case "Page"	:
				case "Img"	:
				case "Vid"	:
				case "Reg"	:
				case "Log"	:
				case "Com"	:
				case "Rights"	:
				case "Token"	:
				case "Exif"	:
				case "MyA"	:
				case "Adm"	:
				case "MkD"	:
				case "MvD"	:
				case "Thb"	:	CurrentUser::$action=$_GET['t'];
								break;
				case "Big"	:
				case "BDl"	:
				case "Zip"	:	if(!Settings::$nodownload){
									CurrentUser::$action=$_GET['t'];
								}
								break;
				default		:	CurrentUser::$action = "Page";
								break;
			}
		}else{
			CurrentUser::$action = "Page";
		}
		


		//~ if(isset($_GET['a']) && CurrentUser::$action != "Adm"){
			//~ if(CurrentUser::$admin || CurrentUser::$uploader){
				//~ new Admin();
			//~ }
		//~ }

		if(isset($_GET['j'])){
			CurrentUser::$action =	"JS";
		}

		/// Set default action
		if(!isset(CurrentUser::$action)){
			CurrentUser::$action = "Page";
		}

		/// Create Group File if it doesn't exist
		if(!file_exists(CurrentUser::$groups_file)){
			Group::create_group_file();
		}
		
		/// Throw exception if accounts file is missing
		if(!file_exists(CurrentUser::$accounts_file)){
			//~ throw new Exception("Accounts file missing",69);
			Index::$welcome = true;
		}		

		if(isset(CurrentUser::$account)){
			CurrentUser::$admin = in_array("root",CurrentUser::$account->groups);
		}
	}

	/**
	 * Log the user in
	 *
	 * @param string $login User login
	 * @param string $password User password
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function login($login,$password){
		CurrentUser::$admin	=	false;
		$acc =	new Account($login);

		// Check password
		if(Account::password($password) == $acc->password){
			$_SESSION['login']		=	$login;
			CurrentUser::$account	=	$acc;
			$_SESSION['token']     	 =   NULL;
		}else{
			// Wrong password						
			return false;
		}
		if(in_array('root',$acc->groups)){
			CurrentUser::$admin = true;
		}
		if(in_array('uploaders',$acc->groups)){
			CurrentUser::$uploader = true;
		}
		return true;
	}

	/**
	 * Log the user in
	 *
	 * @param string $login User login
	 * @param string $password User password
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function keyin($key){

		CurrentUser::$admin	=	false;

		$acc =	new Account(NULL,$key);
		if(!isset($acc->login)){
			return false;
		}

		CurrentUser::$account = $acc;
		$_SESSION['login']		=	$acc->login;
		$_SESSION['token']		=	"";

		if(in_array('root',$acc->groups)){
			CurrentUser::$admin = true;
		}
		if(in_array('uploaders',$acc->groups)){
			CurrentUser::$uploader = true;
		}

		return true;
	}

	/**
	 * Log the user out
	 *
	 * @return void
	 * @author Thibaud Rohmer
	 */
	public static function logout(){
		CurrentUser::$account	= NULL;
		CurrentUser::$token 	= NULL;
		CurrentUser::$admin 	= false;
		CurrentUser::$uploader 	= false;
		session_unset();
		return true;
	}

}
?>
