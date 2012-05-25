var watermarkObj = new Array();
var watermarkVal = new Array();

function watermark(id, value) {
	
	// Get object
	var box = document.getElementById(id);
	
	// Setup clear function
	box.onfocus = function() {
		if (this.value == value)
			this.value = "";
	}
	
	// Setup autofill function
	box.onblur = function() {
		if (this.value == "")
			this.value = value;
	}
	
	// Set initial value
	if (box.value == "") {
		box.value = value;
	}

	// Add to arrays
	watermarkObj[watermarkObj.length] = id;
	watermarkVal[watermarkVal.length] = value;
}

function clearDefaults() {
	
	/* Call this function to clear all
	   default values (such as before
	   submitting a form) */

	for (var i = 0; i < watermarkObj.length; i++) {
		var obj = get(watermarkObj[i]);
		if (obj.value == watermarkVal[i])
			obj.value = "";
	}
}
	
function setDefaults() {
	
	/* Call this function to reset all
	   blank fields to their
	   watermark values */
	
	for (var i = 0; i < watermarkObj.length; i++) {
		var obj = get(watermarkObj[i]);
		if (obj.value == "")
			obj.value = watermarkVal[i];
	}
}
