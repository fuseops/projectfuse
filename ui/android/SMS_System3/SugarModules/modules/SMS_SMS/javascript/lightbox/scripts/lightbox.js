//Created by Amudha Murlaikannan for lightbox
function closeEscButton() {
  if (!event) event = window.event;
	if (event.keyCode == 27) {
		closeLightWindow();
	}
	
}

document.onkeyup = function (event) {
  if (!event) event = window.event;
	if (event.keyCode == 27) {
		closeLightWindow();
	}

}

function checkItemsSelected() 
{
	//return sListView.send_mass_update('selected', 'Please select at least 1 record to proceed.');
	the_form=document.MassUpdate;
	var chkCnt = 0;
	var itemId = "";
	for(wp=0;wp<the_form.elements.length;wp++) 
	{
		var _el = the_form.elements[wp];
		if(_el && _el.type == "checkbox" && _el.checked == true && _el.name !="massall") {
			if(itemId != "") itemId += "~~~";
			var selName = "sendToNameFld_"+_el.value;
			var conName = "contactNameFld_"+_el.value;
			var conType = "contactTypeFld_"+_el.value;
			
			itemId += _el.value+":::"+document.getElementById(conName).value+":::"+document.getElementById(selName).value+":::"+document.getElementById(conType).value;
			chkCnt ++;
		}
	}
	if(chkCnt == 0) {
		alert("Please select at least 1 record to proceed.");
		return false;
	}
	if(itemId == "") return false;
	return itemId;
		
}
function openDialogCampaignWindow(thCtrl, smsStatus) {
	var params = "composeFrom=campaigns";
  	var composeFromData = "campaigns";	
  if(smsStatus == '') smsStatus = 'NotSent';
  loadDivInfo(thCtrl, smsStatus, params, composeFromData);
  document.getElementById("lbLoadMessage").style.width = 750;
  document.getElementById("lbLoadMessage").style.height = 450;
  return false;

}
function openDialogWindow(thCtrl, smsStatus, moduleName123) {
  var params = '';
  var composeFromData = "";
  if(smsStatus == "sendSMSForCampaigns") {
  	var itemId = checkItemsSelected();
  	if(!itemId) {
  		return false;
  	} else params = itemId;
  	if(params != "") params = "composeFrom=campaigns&addlParams="+params;  	
  	var composeFromData = "campaigns";
  }
  if(document.getElementById("composeFrom") && smsStatus == "NotSent" && moduleName123 == "campaigns"){
  	params = "composeFrom=campaigns";
  	var composeFromData = "campaigns";  	
  }
  if(smsStatus == '') smsStatus = 'NotSent';
  loadDivInfo(thCtrl, smsStatus, params, composeFromData);
  return false;
}

function loadDivInfo(thCtrl, smsStatus, params, composeFromData) {

 if(smsStatus != 'Sent')
 	topPosition = findPos(document.getElementById("smsBtn"));
 else
	topPosition = findPos(document.getElementById("smsBtnHistory")); 
 if(document.getElementById("overlay")) { 
  	bod = document.getElementsByTagName('body')[0];
  	document.getElementById("overlay").style.display = "inline";
    
	document.getElementById("overlay").style.top="0";
	document.getElementById("overlay").style.left="0";
	document.getElementById("overlay").style.zIndex=5000;
	document.getElementById("overlay").style.width="100%";
	document.getElementById("overlay").style.height="100%";
	document.getElementById("overlay").style.backgroundColor="#000";
	document.getElementById("overlay").style.opacity=".80";
	document.getElementById("overlay").style.filter="alpha(opacity=80)";
	document.getElementById("overlay").style.position="fixed";
  //document.getElementById("overlay").style.height = bod.scrollHeight;  
  //document.getElementById("overlay").style.width = bod.scrollWidth;  
 }
/*
if(composeFromData == "campaigns")
 	document.getElementById("lbLoadMessage").style.top = topPosition - 120;
 else document.getElementById("lbLoadMessage").style.top = topPosition ;
 */
 	document.getElementById("lbLoadMessage").style.display = "inline"; 
	document.getElementById("lbLoadMessage").style.top="10%";
	document.getElementById("lbLoadMessage").style.left="15%";
	document.getElementById("lbLoadMessage").style.zIndex=9999;
	document.getElementById("lbLoadMessage").style.width="70%";
	document.getElementById("lbLoadMessage").style.height="50%";
	document.getElementById("lbLoadMessage").style.float="left"; 
	document.getElementById("lbLoadMessage").style.background="#EFEFEF";
	document.getElementById("lbLoadMessage").style.textAlign="left";
	document.getElementById("lbLoadMessage").style.position="fixed";
 	document.getElementById("lbLoadMessage").innerHTML = "<table height='100%' width='100%' align=center><tr><td align=center><B>Loading...</b></td></tr></table>";  
 
  
  
  var myAjax = new Ajax.Request(
    thCtrl.href,
    {method: 'post', parameters: params, onComplete: processInfo}
  );
}
	
	// Display Ajax response
	function processInfo(response){	
		var info = "<div id='lbContent'>" + response.responseText.toString() + "</div>&nbsp;&nbsp;";
		var slen = info.length;
		info = info.substr(0,(slen-1));		
		document.getElementById("lbLoadMessage").innerHTML = info;
	}
	
	function closeLightWindow() {
	  if(document.getElementById("lbLoadMessage"))
		  document.getElementById("lbLoadMessage").style.display = "none";
		if(document.getElementById("overlay"))
		  document.getElementById("overlay").style.display = "none";
  }
  
function check_form1() {
	
	document.getElementById("nameMsg").innerHTML = "";
	
  //Check whether the sms login authentication exists/valid or not.
  if(document.getElementById("errorFld").value != "") {
  	document.getElementById("nameMsg").innerHTML = document.getElementById("errorFld").value;
  	return false;
  }
  
 if(document.getElementById("composeFrom").value == "campaigns") {
  		if(document.getElementById("msg_name").value == "") {
			document.getElementById("nameMsg").innerHTML = "Missing Message";
			return false;
		}
		var urlStandard ="index.php?sugar_body_only=true&to_pdf=true&module=SMS_SMS&action=SMSAJAX&smsAction=SaveData";
		
		if(document.MassUpdate) {
			if(document.MassUpdate.record)
				var recordId= document.MassUpdate.record.value;		
			else var recordId= '';
			var obj = "name="+document.MassUpdate.name.value+"&sender_user_id="+document.EditView.sender_user_id.value;
			if(document.MassUpdate.to_user_id) {
				obj += "&to_user_id="+document.MassUpdate.to_user_id.value;
			} else if(document.EditView.composeFrom.value == "campaigns"){
				obj += "&addlParams="+document.EditView.addlParams.value+"&composeFrom="+document.EditView.composeFrom.value;
			}
			obj += "&parent_id="+document.EditView.parent_id.value+"&parent_type="+document.EditView.parent_type.value;
			obj += "&record="+recordId;		
		} 
		if(document.EditView) {
			var recordId= document.EditView.record.value;		
			var obj = "name="+document.EditView.msg_name.value+"&sender_user_id="+document.EditView.sender_user_id.value;
			if(document.EditView.to_user_id) {
				obj += "&to_user_id="+document.EditView.to_user_id.value;
			} else if(document.EditView.composeFrom.value == "campaigns"){
				obj += "&addlParams="+document.EditView.addlParams.value+"&composeFrom="+document.EditView.composeFrom.value;
			}
			obj += "&parent_id="+document.EditView.parent_id.value+"&parent_type="+document.EditView.parent_type.value;
			obj += "&record="+document.EditView.record.value;		
		} 

  } else {
		if(document.EditView.to_user_id.value == "") {
			document.getElementById("nameMsg").innerHTML = "Invalid To value";
			return false;
		}
		if(document.EditView.msg_name.value == "") {
			document.getElementById("nameMsg").innerHTML = "Missing Message";
			return false;
		}
		var recordId= document.EditView.record.value;
		var urlStandard ="index.php?sugar_body_only=true&to_pdf=true&module=SMS_SMS&action=SMSAJAX&smsAction=SaveData";
		var obj = "name="+document.EditView.msg_name.value+"&sender_user_id="+document.EditView.sender_user_id.value;
		if(document.EditView.to_user_id) {
			obj += "&to_user_id="+document.EditView.to_user_id.value;
		} else if(document.EditView.composeFrom.value == "campaigns"){
			obj += "&addlParams="+document.EditView.addlParams.value+"&composeFrom="+document.EditView.composeFrom.value;
		}
		obj += "&parent_id="+document.EditView.parent_id.value+"&parent_type="+document.EditView.parent_type.value;
		obj += "&record="+document.EditView.record.value;
  }
  
  

	AjaxObject.startRequest(callbackEditSMSView, urlStandard + "&" + obj,true);		
	return false;
}



var AjaxObject = {
	ret : '',
	currentRequestObject : null,
	timeout : 9999999999, // 30 second timeout default
	forceAbort : true,
	trail : new Array(),

	/**
	 */
	_reset : function() {
		this.timeout = 30000;
		this.forceAbort = false;
	},


	/**
	 */
    handleFailure : function(o) {
    	alert("FFFFFFF");
    	if(document.EditView)
    		document.EditView.button[0].disabled=false;
		// Failure handler
		//overlay('Exception occurred...', o.statusText, 'alert');

	},

	/**
	 */
	handleSuccess : function(o) {
		alert("success");
	},
	
	/**
	 */
	startRequest : function(callback, args, forceAbort) {
		if(document.EditView)
			document.EditView.button[0].disabled=true;
		if(this.currentRequestObject != null) {
			if(this.forceAbort == true) {
				YAHOO.util.Connect.abort(this.currentRequestObject, null, false);
			}
		}



		this.currentRequestObject = YAHOO.util.Connect.asyncRequest('POST', "./index.php", callback, args);
		this._reset();
	}
};

var callbackEditSMSView = {	
success : function (o) {
	//return false;		
	if(document.getElementById("composeFrom").value == "campaigns") {
		document.location.href = "index.php?module=Campaigns&action=DetailView&record="+document.getElementById("parent_id").value;
	} else {
		if(o.responseText != "sentsuccess"){
				remove_url = "index.php?module="+get_module_name()+"&action=SubPanelViewer&subpanel=activities&record="+document.EditView.parent_id.value+"&sugar_body_only=1&inline=1&refresh_page=0";
			showSubPanel('activities',remove_url,true);
	    	closeLightWindow();		
		}
		else {
			remove_url = "index.php?module="+get_module_name()+"&action=SubPanelViewer&subpanel=activities&record="+document.EditView.parent_id.value+"&sugar_body_only=1&inline=1&refresh_page=0";
			remove_url1 = "index.php?module="+get_module_name()+"&action=SubPanelViewer&subpanel=history&record="+document.EditView.parent_id.value+"&sugar_body_only=1&inline=1&refresh_page=0";
			showSubPanel('activities',remove_url,true);
			setTimeout("showSubPanel('history',remove_url1,true)", 10);
			closeLightWindow();		
		}
	}

},
failure : function (o) {
	if(document.EditView)
    		document.EditView.button[0].disabled=false;	
	if(document.getElementById("composeFrom").value == "campaigns") {
		document.location.href = "index.php?module=Campaigns&action=DetailView&record="+document.getElementById("parent_id").value;
	} else {
			remove_url = "index.php?module="+get_module_name()+"&action=SubPanelViewer&subpanel=activities&record="+document.EditView.parent_id.value+"&sugar_body_only=1&inline=1&refresh_page=0";
			remove_url1 = "index.php?module="+get_module_name()+"&action=SubPanelViewer&subpanel=history&record="+document.EditView.parent_id.value+"&sugar_body_only=1&inline=1&refresh_page=0";
			showSubPanel('activities',remove_url,true);
			setTimeout("showSubPanel('history',remove_url1,true)", 10);
			closeLightWindow();
	}
},

timeout	: AjaxObject.timeout	
};


function strcount(id)
{
	var str=document.getElementById("msg_name").value;
	document.getElementById('msgCnt').innerHTML=160-(str.length);
}
function chngcnt(id)
{
	strcount(id);
	if(document.getElementById("msg_name").value.length>160)
	{      	
		document.getElementById("msg_name").value = document.getElementById("msg_name").value.substring(0, 160);	
		strcount(id);
		document.getElementById("msg_name").focus();
		return true;
	}
}

function findPos(obj) {
	
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	
	return curtop;
	//return [curleft,curtop];	
}