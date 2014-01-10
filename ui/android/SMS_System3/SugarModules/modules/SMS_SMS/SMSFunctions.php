<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 ********************************************************************************/
/*********************************************************************************

 ********************************************************************************/

/**
 * SMSFunctions.php
 * This is a helper file used by the meta-data framework
 * @see modules/SMS_SMS/vardefs.php (SMSFunctions)
 * @author Collin Lee
 */
global $sugar_config;
require_once('lib/nusoap.php');
define("SERVICE_URL", $sugar_config['smsAPIUrl']);

function getSenderOpions($focus, $name = '', $value = '', $view = 'DetailView') {
   global $current_user, $app_list_strings;   
   $faultCode = false;
   $hiddenFieldValue = "";
   
   if($view == 'EditView' || $view == 'MassUpdate') {
   	  $senderOptionsData = callSenderIDs($value);
   	  
   	  $senderOptions = "<select name=\"$name\">";
   	  
      if(!strstr($senderOptionsData, "Error:")) $senderOptions .= $senderOptionsData;
      else {
      	$faultCode = true;
      }      
      $senderOptions .= '</select>';
      if($faultCode) {
      	$senderOptions .= "<span class='required'>&nbsp;&nbsp;".$senderOptionsData."</span>";
      	$hiddenFieldValue = $senderOptionsData;
      }
      else {      	
      	$qryBalance = getQueryBalance();
      	$senderOptions .= "<span class='required'>&nbsp;&nbsp;".$qryBalance."</span>"; 
      }
      $senderOptions .= "<input type=hidden name='errorFld' id='errorFld' value='".$hiddenFieldValue."'>";
   	  return $senderOptions;
   }   
   return $focus->sender_user_id;
}

function getToOpions($focus, $name = '', $value = '', $view = 'DetailView') {
   global $current_user, $app_list_strings;   
   if($view == 'EditView' || $view == 'MassUpdate') {
		$tmp_parent_id = $_REQUEST["parent_id"];
		$tmp_parent_type = $_REQUEST["parent_type"];

   		if(isset($_REQUEST["composeFrom"])){
			if($_REQUEST["composeFrom"] == "campaigns" && isset($_REQUEST["addlParams"])){
				return $_REQUEST["addlParamInfo"];
			}
			if($_REQUEST["composeFrom"] == "campaigns" && isset($_REQUEST["record"])){
				return showSelectedPersons($_REQUEST["record"]);
			}
   		}
   	
   	  $toOptions = "<select name=\"$name\">";
   	  
      $toOptions .= getRecipientData($tmp_parent_id, $tmp_parent_type, $value);
      
      $toOptions .= '</select>';
   	  return $toOptions;
   }   
   return $focus->to_user_id;
}

function getStatusOpions($focus, $name = '', $value, $view = 'DetailView') {
   global $current_user, $app_list_strings;
   if($view == 'EditView' || $view == 'MassUpdate') {
   	  $statusOptions = "<select name=\"$name\">"; 
   	  $statusOptions .= get_select_options_with_id($app_list_strings['sms_status_dom'], $focus->status);     
      $statusOptions .= '</select>';
   	  return $statusOptions;
   }   
   return $focus->status;
}

function showSelectedPersons($recordID) {	
	$sugarObj = new SMS_SMS_sugar();
	$sugarObj->get_to_user_data($recordID);
	$_REQUEST["addlParams"]	 = $sugarObj->other_infoData;
	return $sugarObj->to_user_id;
}

function getRecipientData($recordID, $moduleName, $value) {
	$sqlQry = "";
	$recipientData = "";
	switch(strtolower($moduleName)) {
		case "contacts":
			$sqlQry = "SELECT  phone_mobile , phone_home, phone_work, phone_other from contacts WHERE id ='".$recordID."'";
			break;
		case "leads":
			$sqlQry = "SELECT  phone_mobile , phone_home, phone_work, phone_other from leads WHERE id ='".$recordID."'";
			break;
		case "accounts":
			$sqlQry = "SELECT  phone_office , phone_alternate from accounts WHERE id ='".$recordID."'";
			break;
		case "prospects":
			$sqlQry = "SELECT  phone_mobile , phone_home, phone_work, phone_other from prospects WHERE id ='".$recordID."'";
			break;
		case "users":
			$sqlQry = "SELECT  phone_mobile , phone_home, phone_work, phone_other from users WHERE id ='".$recordID."'";
			break;
		case "accounts":
			$sqlQry = "SELECT  concat(COALESCE(name,''), '')  as relateName from accounts WHERE id ='".$recordID."'";
			break;
	}
	$srchArray = array(" ","-","(",")","+");
	$replaceArray = array("","","","","");
	if($sqlQry != "") {
		$res = $GLOBALS['db']->query($sqlQry);
		if($res) {
			while($row = $GLOBALS['db']->fetchByAssoc($res)) {				
				$cNumber = "";
				
				$cNumber = (isset($row["phone_mobile"]) ? $row["phone_mobile"] :"");
				$cNumber = str_replace($srchArray, $replaceArray, $cNumber);
				$selected = "";
				if($value == $cNumber) $selected = "selected";
				$recipientData .= ($cNumber != "" ? "<option value='".$cNumber."' ".$selected.">".$cNumber."</option>" : "");
				
				$cNumber = (isset($row["phone_home"]) ? $row["phone_home"] :"");				
				$cNumber = str_replace($srchArray, $replaceArray, $cNumber);
				$selected = "";
				if($value == $cNumber) $selected = "selected";
				$recipientData .= ($cNumber != "" ? "<option value='".$cNumber."' ".$selected.">".$cNumber."</option>" : "");
				
				$cNumber = (isset($row["phone_work"]) ? $row["phone_work"] :"");				
				$cNumber = str_replace($srchArray, $replaceArray, $cNumber);
				$selected = "";
				if($value == $cNumber) $selected = "selected";
				$recipientData .= ($cNumber != "" ? "<option value='".$cNumber."' ".$selected.">".$cNumber."</option>" : "");
				
				$cNumber = (isset($row["phone_other"]) ? $row["phone_other"] :"");				
				$cNumber = str_replace($srchArray, $replaceArray, $cNumber);
				$selected = "";
				if($value == $cNumber) $selected = "selected";
				$recipientData .= ($cNumber != "" ? "<option value='".$cNumber."' ".$selected.">".$cNumber."</option>" : "");

				$cNumber = (isset($row["phone_office"]) ? $row["phone_office"] :"");				
				$cNumber = str_replace($srchArray, $replaceArray, $cNumber);
				$selected = "";
				if($value == $cNumber) $selected = "selected";
				$recipientData .= ($cNumber != "" ? "<option value='".$cNumber."' ".$selected.">".$cNumber."</option>" : "");
				
				$cNumber = (isset($row["phone_alternate"]) ? $row["phone_alternate"] :"");				
				$cNumber = str_replace($srchArray, $replaceArray, $cNumber);
				$selected = "";
				if($value == $cNumber) $selected = "selected";
				$recipientData .= ($cNumber != "" ? "<option value='".$cNumber."' ".$selected.">".$cNumber."</option>" : "");
				
			}
		}
		//echo mysql_error();
	}	
	return $recipientData;
}
function getSMSUserInfo($smsUserName='', $smsPassword='') {
	global $current_user;
	if($smsUserName != '')
		$apiKey = $smsUserName;
	else
		$apiKey = $current_user->getPreference("SMSAPIKEY");
	if($smsUserName != '')
		$apiPassword = $smsPassword;
	else
		$apiPassword = $current_user->getPreference("SMSAPIPASSWORD");			
	$params = array(
	    'apiKey' => $apiKey,
	    'password' => $apiPassword,
	    'username' => $apiKey,
	);
	return $params;
}

function getQueryBalance($smsUserName='', $smsPassword = '') {

	
	$senderIDs = $sValues = "";
	$client = new nusoap_client(SERVICE_URL, 'wsdl');
	$err = $client->getError();
	if ($err) {
		return "Constructor error: ".$err;
	}
	$params = getSMSUserInfo($smsUserName, $smsPassword);
	if($params["apiKey"] == "") return "Error: Please go to the User Settings and provide the SMS login credentials";
	
	$result = $client->call('QueryBalance', $params);
	
	if ($client->fault) {
	    if(isset($result["faultcode"])) return "Error:". $result["faultcode"]."  ". $result["faultstring"];
	} else {
	    $err = $client->getError();
	    if ($err) {
	        return "Error: ".$err;
	    } else {
	    	return "Balance: ".round($result["balance"],2)." ".$result["currency"];	    	
	    }
	}
}

function callSenderIDs($value) {
	
	$senderIDs = $sValues = "";
	$client = new nusoap_client(SERVICE_URL, 'wsdl');
	$err = $client->getError();
	if ($err) {
		return "Constructor error: ".$err;
	}
	$params = getSMSUserInfo();
	if($params["apiKey"] == "") return "Error: Please go to the User Settings and provide the SMS login credentials";
	
	$result = $client->call('ListSenderIDSByUsername', $params);
	
	if ($client->fault) {
	    if(isset($result["faultcode"])) return "Error:". $result["faultcode"]."  ". $result["faultstring"];
	} else {
	    $err = $client->getError();
	    if ($err) {
	        return "Error: ".$err;
	    } else {
	    	
	        if(isset($result["ListSenderIDSByUsernameResult"]["diffgram"]["NewDataSet"]["Table"])) {
	        	if(sizeof($result["ListSenderIDSByUsernameResult"]["diffgram"]["NewDataSet"]["Table"]) >0 && is_array($result["ListSenderIDSByUsernameResult"]["diffgram"]["NewDataSet"]["Table"])) {
	        		//If there are multiple entries
	        		if(isset($result["ListSenderIDSByUsernameResult"]["diffgram"]["NewDataSet"]["Table"][0])) {
		        		foreach($result["ListSenderIDSByUsernameResult"]["diffgram"]["NewDataSet"]["Table"] as $sKey => $sVal) {
							$selected = "";
							if($value == $sVal["SenderID"]) $selected = "selected";
		        			$senderIDs .= "<option value='".$sVal["SenderID"]."' ".$selected.">".$sVal["SenderID"]." </option>\n";
		        			$sValues .= $sVal["SenderID"];
		        		}
	        		} else { // If there is only one entry
							$selected = "";
							$sVal = $result["ListSenderIDSByUsernameResult"]["diffgram"]["NewDataSet"]["Table"];
							if($value == $sVal["SenderID"]) $selected = "selected";
		        			$senderIDs .= "<option value='".$sVal["SenderID"]."' ".$selected.">".$sVal["SenderID"]." </option>\n";   		
		        			$sValues .= $sVal["SenderID"];
	        		}
	        	}
	        }
	    }
	}	
	return $senderIDs;
}

	function sendSMS($vars)
    {
    	global $sugar_config;
	    $urlencoded = "";
	    while (list($key, $value) = each($vars))
        {
            $urlencoded.= urlencode($key)."=".$value."&";
        }
	    $urlencoded = substr($urlencoded, 0, -1);
	    
	    $url = $sugar_config['smsClientUrl'];
	    $ch = curl_init();    // initialize curl handle
	    curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
	    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
	    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // times out after 5s
	    curl_setopt($ch, CURLOPT_POST, 1); // set POST method
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $urlencoded); // add POST fields
	    $sentResult = curl_exec($ch); // run the whole process
	    curl_close($ch);
	    
	    
		
		$sentResultDes = "";
	
		$sentResArray = explode("|", $sentResult);		
		switch($sentResArray[0]) {					
			case "0":
				$sentResultDes = $sentResult;
				break;			
			case "-1":
				$sentResultDes = "Authentication failed. Your API Key, Password combination is not valid or your account has been locked.";
				break;
			case "-2":
				$sentResultDes = "Invalid Sender ID. The Sender ID you submitted does not belong to your account.";
				break;
			case "-3":
				$sentResultDes = "System Failure. Your request could not be processed due to an internal system failure or outage. Note: This is a rare case but should be taken into account.";
				break;
			case "-4":
				$sentResultDes = "Argument validation failed. One or more of your POST-Vars is invalid or missing.";
				break;
			case "-5":
				$sentResultDes = "Insufficient Credits. You do not have sufficient credits to send the message.";
				break;
			case "-6":
				$sentResultDes = "Invalid MSISDN. The mobile number is not valid or can not be reached via the API";
				break;
				
		}
		return (array($sentResArray[0], $sentResultDes));			
		
	    
	}
	
	
	function SendBatchMessage($smsParams) {
		$retData = "";
		//echo "<pre>";print_r($smsParams);
		$client = new nusoap_client(SERVICE_URL, 'wsdl');
		$err = $client->getError();
		if ($err) {
			return "Constructor error: ".$err;
		}
		$params = getSMSUserInfo();
		if($params["apiKey"] == "") return "Error: Please go to the User Settings and provide the SMS login credentials";
		unset($params["username"]);
		$params["senderId"] = $smsParams["SenderID"];
		
		$result = $client->call('CreateBatch', $params);
		
		if ($client->fault) {
		    if(isset($result["faultcode"])) return "Error:". $result["faultcode"]."  ". $result["faultstring"];
		} else {
		    $err = $client->getError();
		    if ($err) {
		        return "Error: ".$err;
		    } else {
		    	if($result["CreateBatchResult"] > 0) {
		    		//Add Batch Message
		    		$smsParams["batchId"] = $result["CreateBatchResult"];
		    		foreach($smsParams as $sK => $sV) {
		    			$smsParamsData = $sV;
						$smsParamsData["batchId"] = $smsParams["batchId"];
			    		$batchParams = getAddBatchMessageParam($smsParamsData);
			    		if(is_array($batchParams)) {
				    		//echo "<pre>";print_r($batchParams);
							$addBatchResult = $client->call('AddBatchMessage', $batchParams);					
							//echo "<pre>";print_r($addBatchResult);
							if ($client->fault) {
							    if(isset($addBatchResult["faultcode"])) return "Error:". $addBatchResult["faultcode"]."  ". $addBatchResult["faultstring"];
							} else {
							    $err = $client->getError();
							    if ($err) {
							        return "Error: ".$err;
							    } else {
							    	if($addBatchResult["AddBatchMessageResult"] > 0 )
						    			return "Error:"."in AddBatchMessageResult";
							    }
							}
			    		}//end if		    		
		    		}//end for each
					//CloseAndCostBatch Begins	
					$smsParams[0]["batchId"] = $smsParams["batchId"];				
					$closeBatchParams = getCloseBatchMessageParam($smsParams[0]);
					$closeBatchResult = $client->call('CloseAndCostBatch', $closeBatchParams);
						//echo "<pre>";print_r($closeBatchResult);
						if ($client->fault) {
						    if(isset($closeBatchResult["faultcode"])) return "Error:". $closeBatchResult["faultcode"]."  ". $closeBatchResult["faultstring"];
						} else {
						    $err = $client->getError();
						    if ($err) {
						        return "Error: ".$err;
						    } else {
						    	if($closeBatchResult["CloseAndCostBatchResult"] == 0) {
							    	//Accept and send sms Begins
							    	$acceptBatchParams = $closeBatchParams;
									$acceptBatchResult = $client->call('AcceptBatchCost', $acceptBatchParams);
									//echo "<pre>";print_r($acceptBatchResult);
									//echo "<BR>".$qryBalance = getQueryBalance();
									if ($client->fault) {
									    if(isset($acceptBatchResult["faultcode"])) return "Error:". $acceptBatchResult["faultcode"]."  ". $acceptBatchResult["faultstring"];
									} else {
									    $err = $client->getError();
									    if ($err) {
									        return "Error: ".$err;
									    } else {
									    	if($acceptBatchResult["AcceptBatchCostResult"] == 0)
								    			return $acceptBatchResult["AcceptBatchCostResult"];
								    		else return "Error:in Accept Batch Cost ";
									    }
									}						    	
							    	//Accept and send sms ends
						    	} else return "Error:in CloseandCost Batch Call";
						    }
						}
					//CloseAndCostBatch Ends					
		    			    		
		    	} else     	
		    		return $result["CreateBatchResult"];	    	
		    }
		}		
	}
	function getAddBatchMessageParam($smsParams) {
		if(isset($smsParams["APIKey"]) && $smsParams["APIKey"] != 1) {
			$paramData = array(
			    'apiKey' => $smsParams["APIKey"],
			    'password' => $smsParams["APIPassword"],
			    'batchId' => $smsParams["batchId"],
			    'message' => $smsParams["Message"],
			    'recipient' => $smsParams["MSISDN"],
			);
			return $paramData; 
		}
		else return 0;
	}
	function getCloseBatchMessageParam($smsParams) {
		if(isset($smsParams["APIKey"]) && $smsParams["APIKey"] != 1) {
			$paramData = array(
			    'apiKey' => $smsParams["APIKey"],
			    'password' => $smsParams["APIPassword"],
			    'batchId' => $smsParams["batchId"],
			);
			return $paramData; 
		}
		else return 0;
	}
	
?>