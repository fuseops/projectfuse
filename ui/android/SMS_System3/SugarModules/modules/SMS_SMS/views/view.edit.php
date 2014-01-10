<?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 * *******************************************************************************/
/*
 * Created on Apr 13, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
//require_once('include/MVC/View/views/view.config.php');
require_once('include/MVC/View/views/view.edit.php');

//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "Amudha";

class SMS_SMSViewEdit extends ViewEdit {

 	function SMS_SMSViewEdit(){ 		 		
 		parent::SugarView();
 		$this->options["show_header"] = 0;
 		$this->options["show_footer"] = 0;
 		$this->options["show_search"] = 0;
 		$this->options["show_all"] = 0;
 		$this->showTitle = false;
 	}
 	
	function display(){
		//Begin The following is for the SMS in Campaigns, if there are multiple users then show them one below the other with the name and the sent to Number
		$_REQUEST["addlParamInfo"] = "";
		if(isset($_REQUEST["addlParams"])) {
			$addlParamData = $_REQUEST["addlParams"];
			$addlDArray = explode("~~~", $addlParamData);
			$addlParamInfo = "<table border=0 width=100% cellpadding=2><tr>";			
			$rCnting = 0;
			foreach ($addlDArray as $aK => $aV) {
				$addlDataArray = explode(":::", $aV);				
				//if($addlParamInfo != "") $addlParamInfo .= "<tr>";
				if($rCnting % 6 == 0 && $rCnting != 0) {$addlParamInfo .= "</tr><tr>"; $rCnting = 0;}
				$addlParamInfo .= "<td nowrap>".$addlDataArray[1]." <br> [".$addlDataArray[2]."] </td>";
				$rCnting ++;
			}
			$rCnting = 6 - $rCnting ;
			if($rCnting > 0)  {
				$addlParamInfo .= "<td colspan=$rCnting width=100%>&nbsp;</td>";
			}
			$_REQUEST["addlParamInfo"] = $addlParamInfo."</tr></table>";
		}
		//End Comment
		
		if(isset($_REQUEST["record"])) {
 			$sqlQry = "DELETE FROM tracker WHERE item_id='".$_REQUEST["record"]."' and module_name='SMS_SMS'";
 			$res = $GLOBALS['db']->query($sqlQry,true);
		}		
		switch($this->action) {			
			case "DetailView":
			case "EditView":
				global $mod_strings;
				global $theme, $image_path;		
				insert_popup_header($theme);
				
				echo $this->get_module_title();
				
				parent::display();
				insert_popup_footer();		
				break;
			default:
				parent::display();
				break;
		}
	} 	
	function get_module_title() {
		global $image_path;
		$module="SMS_SMS";
		$the_title = "<BR><table width='100%' cellpadding='5' cellspacing='0' border='0' class='moduleTitle'><tr><td valign='top' nowrap>\n";
		$module = preg_replace("/ /","",$module);
		
		
		$the_title .= "&nbsp;<h2>Compose SMS</h2></td>\n";
		$the_title .= "<td align=right valign=top><a href='http://www.intdevsms.com' target='_new'><IMG src='custom/themes/default/images/smslogo.jpg' border='0' style='margin-top: 3px; margin-right: 3px;' alt='SMS'></a>&nbsp;</td>";
		
		
		$the_title .= "</tr></table>\n";
		return $the_title;
	}
}

?>
