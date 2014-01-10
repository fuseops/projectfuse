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
require_once('include/MVC/View/views/view.detail.php');
require_once('include/DetailView/DetailView2.php');

//echo "<pre>";print_r($view_config);echo "</pre>";
//echo "Amudha";

class SMS_SMSViewDetail extends ViewDetail {

 	function SMS_SMSViewDetail(){ 		 		 		
 		$this->options["show_header"] = 0;
 		$this->options["show_footer"] = 0;
 		$this->options["show_search"] = 0;
 		$this->options["show_all"] = 0;
 		$this->options["view_print"] = 0;
 		$this->showTitle = false; 		
 		parent::SugarView();
 		
 	}

 	function preDisplay(){
 		$metadataFile = null;
 		$foundViewDefs = false;
 		//echo "<pre>";print_r($_REQUEST);
 		if(file_exists('custom/modules/' . $this->module . '/metadata/detailviewdefs.php')){
 			$metadataFile = 'custom/modules/' . $this->module . '/metadata/detailviewdefs.php';
 			$foundViewDefs = true;
 		}else{
	 		if(file_exists('custom/modules/'.$this->module.'/metadata/metafiles.php')){
				require_once('custom/modules/'.$this->module.'/metadata/metafiles.php');
				if(!empty($metafiles[$this->module]['detailviewdefs'])){
					$metadataFile = $metafiles[$this->module]['detailviewdefs'];
					$foundViewDefs = true;
				}
			}elseif(file_exists('modules/'.$this->module.'/metadata/metafiles.php')){
				require_once('modules/'.$this->module.'/metadata/metafiles.php');
				if(!empty($metafiles[$this->module]['detailviewdefs'])){
					$metadataFile = $metafiles[$this->module]['detailviewdefs'];
					$foundViewDefs = true;
				}
			}
 		}
 		$GLOBALS['log']->debug("metadatafile=". $metadataFile);
		if(!$foundViewDefs && file_exists('modules/'.$this->module.'/metadata/detailviewdefs.php')){
				$metadataFile = 'modules/'.$this->module.'/metadata/detailviewdefs.php';
 		}
 		if(isset($_REQUEST["composeFrom"])){
 			if($_REQUEST["composeFrom"] == "campaigns") {
				$metadataFile = 'modules/' . $this->module . '/metadata/campaigns_detailviewdefs.php';
				$foundViewDefs = true;
 			}
 		}

		$this->dv = new SMS_SMSViewDetail2();
		$this->dv->ss =&  $this->ss;
		$this->dv->setup($this->module, $this->bean, $metadataFile, 'include/DetailView/DetailView.tpl'); 		
 	} 
 	
	function display(){
 		$sqlQry = "DELETE FROM tracker WHERE item_id='".$_REQUEST["record"]."' and module_name='SMS_SMS'";
 		$res = $GLOBALS['db']->query($sqlQry,true);
		switch($this->action) {			
			case "DetailView":
			case "EditView":
				global $mod_strings;
				global $theme, $image_path;		
				insert_popup_header($theme);
				parent::display();
				insert_popup_footer();		
				break;
			default:
				parent::display();
				break;
		}
	}
	
}
class SMS_SMSViewDetail2 extends DetailView2 {
	function showTitle($showTitle = false){
    	global $mod_strings;
    	if($showTitle) {
            $titleKey = (!empty($this->moduleTitleKey) && isset($this->moduleTitleKey)) ? $this->moduleTitleKey : 'LBL_MODULE_NAME';
            $title = $mod_strings[$titleKey] . ((empty($this->fieldDefs['name']['value'])



                ) ? '' : (': ' . $this->fieldDefs['name']['value']));
            return '<BR><p>' . $this->get_smsmodule_title( $title, false)  . '</p>';
        }
        return '';
    } 
    
    function get_smsmodule_title($module_title) {
		$module="SMS_SMS";
		$the_title = "<table width='100%' cellpadding='5' cellspacing='0' border='0' class='moduleTitle'><tr><td valign='top' >\n";
$module = preg_replace("/ /","",$module);

$the_title .= "<h2 style='margin-bottom: 0px;'>".$module_title."</h2></td>\n";


$the_title .= "<td align=right valign=top><a href='http://www.intdevsms.com' target='_new'><IMG src='custom/themes/default/images/smslogo.jpg' border='0' style='margin-top: 3px; margin-right: 3px;' alt='SMS'></a>&nbsp;</td>";


$the_title .= "</tr></table>\n";
return $the_title;
	}	
}

?>
