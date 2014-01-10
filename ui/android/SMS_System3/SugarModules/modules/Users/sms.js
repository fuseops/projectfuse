function getQueryBalanceCheckSettings() {
	
	document.getElementById("qryBalanceSpan").innerHTML = "";
	document.getElementById("SMSAPIKEYError").innerHTML = "";
	document.getElementById("SMSAPIPASSWORDError").innerHTML = "";
	document.EditView.testsettings.disabled = false;
	
  //Check whether the sms login authentication exists/valid or not.
  if(document.EditView.SMSAPIKEY.value == "") {
  	document.getElementById("SMSAPIKEYError").innerHTML = "Missing SMS UserName";
  	return false;
  }
  
  if(document.EditView.SMSAPIPASSWORD.value == "") {
	 document.getElementById("SMSAPIPASSWORDError").innerHTML = "Missing SMS Password";
	 return false;
  }	
  
    
    document.EditView.testsettings.disabled = true;
	document.getElementById("qryBalanceSpan").innerHTML = "Checking...";
	var urlStandard ="index.php?sugar_body_only=true&to_pdf=true&module=SMS_SMS&action=SMSAJAX&smsAction=getQueryBalanceCheckSettings";
	var obj = "SMSAPIKEY="+document.EditView.SMSAPIKEY.value+"&SMSAPIPASSWORD="+document.EditView.SMSAPIPASSWORD.value;
	AjaxObject.startRequest(callbackTestSMSSettings, urlStandard + "&" + obj,true);		
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
		// Failure handler
		document.EditView.testsettings.disabled = false;
	},

	/**
	 */
	handleSuccess : function(o) {
		
	},
	
	/**
	 */
	startRequest : function(callback, args, forceAbort) {		
		if(this.currentRequestObject != null) {
			if(this.forceAbort == true) {
				YAHOO.util.Connect.abort(this.currentRequestObject, null, false);
			}
		}



		this.currentRequestObject = YAHOO.util.Connect.asyncRequest('POST', "./index.php", callback, args);
		this._reset();
	}
};
var callbackTestSMSSettings = {
success : function (o) {
	document.EditView.testsettings.disabled = false;
	document.getElementById("qryBalanceSpan").innerHTML = o.responseText;
},
failure	: AjaxObject.handleFailure,
timeout	: AjaxObject.timeout	
};
function getQueryBalanceCheckSettings() {
	
	document.getElementById("qryBalanceSpan").innerHTML = "";
	document.getElementById("SMSAPIKEYError").innerHTML = "";
	document.getElementById("SMSAPIPASSWORDError").innerHTML = "";
	document.EditView.testsettings.disabled = false;
	
  //Check whether the sms login authentication exists/valid or not.
  if(document.EditView.SMSAPIKEY.value == "") {
  	document.getElementById("SMSAPIKEYError").innerHTML = "Missing SMS UserName";
  	return false;
  }
  
  if(document.EditView.SMSAPIPASSWORD.value == "") {
	 document.getElementById("SMSAPIPASSWORDError").innerHTML = "Missing SMS Password";
	 return false;
  }	
  
    
    document.EditView.testsettings.disabled = true;
	document.getElementById("qryBalanceSpan").innerHTML = "Checking...";
	var urlStandard ="index.php?sugar_body_only=true&to_pdf=true&module=SMS_SMS&action=SMSAJAX&smsAction=getQueryBalanceCheckSettings";
	var obj = "SMSAPIKEY="+document.EditView.SMSAPIKEY.value+"&SMSAPIPASSWORD="+document.EditView.SMSAPIPASSWORD.value;
	AjaxObject.startRequest(callbackTestSMSSettings, urlStandard + "&" + obj,true);		
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
		// Failure handler
		document.EditView.testsettings.disabled = false;
	},

	/**
	 */
	handleSuccess : function(o) {
		
	},
	
	/**
	 */
	startRequest : function(callback, args, forceAbort) {		
		if(this.currentRequestObject != null) {
			if(this.forceAbort == true) {
				YAHOO.util.Connect.abort(this.currentRequestObject, null, false);
			}
		}



		this.currentRequestObject = YAHOO.util.Connect.asyncRequest('POST', "./index.php", callback, args);
		this._reset();
	}
};
var callbackTestSMSSettings = {
success : function (o) {
	document.EditView.testsettings.disabled = false;
	document.getElementById("qryBalanceSpan").innerHTML = o.responseText;
},
failure	: AjaxObject.handleFailure,
timeout	: AjaxObject.timeout	
};
