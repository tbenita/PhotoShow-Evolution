<?php
/**
 * This file implements the class JS Accounts.
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
 * JS Accounts
 *
 * Form for editing accounts. With JS.
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
class JSAccounts
{

	/// The accounts
	private $accounts;

	/// The groups
	private $groups;



	public function __construct(){
		$this->accounts = Account::findAll();

		$this->groups = Group::findAll();
	}

	public function toHTML(){
		$groupaccounts = array();
		echo "<div class='row-fluid'>";
		echo "<div class='span6'>";
		echo "<h3>".Settings::_("jsaccounts","accounts")."</h3>";
		
		foreach($this->accounts as $acc){
			echo "<div class='accountitem alert alert-info'>
					<form class='removeacc form-inline' action='?t=Adm&a=ADe' method='post'>
					<fieldset>
						<input type='hidden' name='name' value='".htmlentities($acc['login'], ENT_QUOTES ,'UTF-8')."'>
						<input class='btn btn-danger btn-mini' type='submit' value='x'>		
						<span class='name'>".$acc['login']."</span>
					</fieldset>
					</form>";
			echo "<div class='name hide'>".$acc['login']."</div>";					
			foreach($acc['groups'] as $g){
				$groupaccounts["$g"][] = $acc['login'];
				echo "<form id='rmgroup-form' style='display:inline;' method='post' action='?t=Adm&a=AGR'>
					<button type='submit' class='btn btn-mini'>
					<i class=' icon-trash'></i> <span class='groupname'>".htmlentities($g, ENT_QUOTES ,'UTF-8')."</span>
					</button>
					<input type='hidden' name='acc' value='".$acc['login']."'/>
					<input type='hidden' name='group' value='$g'/>
					</form>&nbsp;";				
			}
			echo "</div>";
		}
		echo "</div>";

		echo "<div class='span6'>";
		echo "<h3>".Settings::_("jsaccounts","groups")."</h3>";
		echo "<div class='newgroup well'>";
		echo "
		<form class='addgroup form-inline' method='post' action='?t=Adm&a=GC'>";
		echo "<legend>".Settings::_("jsaccounts","addgroup")."</legend>\n";
		//~ echo "<fieldset>\n";				
		//~ echo "<label for='groupname' class='control-label'>".Settings::_("jsaccounts","groupname")."</label>";
		echo "<input id='groupname' class='input-medium' type='text' name='group' placeholder='".Settings::_("jsaccounts","groupname")."'>\n";
		echo "<input class='btn btn-primary' type='submit' value='".Settings::_("jsaccounts","addgroup")."'>\n";
		//~ echo "</fieldset>\n";		
		echo "</form>\n";
		echo "</div>";
		foreach($this->groups as $g){
			$gn = $g['name'];
			echo "<div class='groupitem alert alert-success'>
					<form class='removegroup' action='?t=Adm&a=GDe' method='post'>
						<input type='hidden' name='name' value='$gn'>
						<input class='btn btn-danger btn-mini' type='submit' value='x'>
						<span class='groupname'>".$gn."</span>
					</form>";
			echo "<div class='name hide'>".$gn."</div>";					
			if(isset($groupaccounts["$gn"])){
				foreach($groupaccounts["$gn"] as $g){
					echo "<form id='rmacc-form' style='display:inline;' method='post' action='?t=Adm&a=AGR'>
						<button type='submit' class='btn btn-mini'>
						<i class=' icon-trash'></i> <span class='accname'>".htmlentities($g, ENT_QUOTES ,'UTF-8')."</span>
						</button>
						<input type='hidden' name='acc' value='$g'/>
						<input type='hidden' name='group' value='$gn'/>
						</form>&nbsp;";
				}
			}
			echo "</div>";
		}
		
		echo "</div>\n";
		echo "</div>\n";
	}

}
=======
class JSAccounts {
    /// The accounts
    private $accounts;
    /// The groups
    private $groups;
    public function __construct() {
        $this->accounts = Account::findAll();
        $this->groups = Group::findAll();
    }
    public function toHTML() {
        $groupaccounts = array();
        echo "<div class='leftcolumn'>";
        echo "<h1>" . Settings::_("jsaccounts", "accounts") . "</h1>";
        foreach ($this->accounts as $acc) {
            echo "<div class='accountitem'>
						<div class='delete'>
							<form action='?t=Adm&a=ADe' method='post'>
								<input type='hidden' name='name' value='" . htmlentities($acc['login'], ENT_QUOTES, 'UTF-8') . "'>
								<input type='submit' value='x'>
							</form>
						</div>";
            echo "<div class='name'>" . $acc['login'] . "</div>";
            foreach ($acc['groups'] as $g) {
                $groupaccounts["$g"][] = $acc['login'];
                echo "<div class='inlinedel'><span class='rmgroup'>x</span><span class='groupname'>" . htmlentities($g, ENT_QUOTES, 'UTF-8') . "</span></div>";
            }
            echo "</div>";
        }
        echo "</div>";
        echo "<div class='rightcolumn'>";
        echo "<h1>" . Settings::_("jsaccounts", "groups") . "</h1>";
        echo "<div class='newgroup'>";
        echo "
		<div class='section'>
		<h2>Create group</h2>
		<form class='addgroup' method='post' action='?t=Adm&a=GC'>
		
			<fieldset>
			<div class='fieldname'>Group Name</div>
			<div class='fieldoptions'>
			<span>" . Settings::_("jsaccounts", "groupname") . "</span>
			<div><input type='text' name='group' value='Group Name' /></div>
			</div>
			</fieldset>
			
			<fieldset class='alignright'><input type='submit' value='" . Settings::_("jsaccounts", "addgroup") . "'></fieldset>
			
			</form>\n";
        echo "</div></div>";
        foreach ($this->groups as $g) {
            $gn = $g['name'];
            echo "<div class='groupitem'>
						<div class='delete'>
							<form action='?t=Adm&a=GDe' method='post'>
								<input type='hidden' name='name' value='$gn'>
								<input type='submit' value='x'>
							</form>
						</div>";
            echo "<div class='name'>" . $gn . "</div>";
            if (isset($groupaccounts["$gn"])) {
                foreach ($groupaccounts["$gn"] as $g) {
                    echo "<div class='inlinedel'><span class='rmacc'>x</span><span class='accname'>" . htmlentities($g, ENT_QUOTES, 'UTF-8') . "</span></div>";
                }
            }
            echo "</div>";
        }
        echo "</div>";
    }
}
>>>>>>> 3fbb242568a4ddc60dee5d2c019391f366ad63d4
