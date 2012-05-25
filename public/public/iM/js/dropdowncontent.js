/* //function toggle5(showHideDiv, switchImgTag) {
	var ele = document.getElementById(showHideDiv);
	var imageEle = document.getElementById(switchImgTag);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
			
  	}
	else {
		ele.style.display = "block";
$("#main tr").addClass('bg-repeat');
}
} 
// */

$(document).ready(function(){
$("#imageDivLink").click(function () {
$("#togglecontent").toggle( function()
						   {$("#main tr").addClass('bg-repeat');
						   $(" #togglecontent").show();
}
						   ,function ()
						   {
							   $("#main tr").removeClass('bg-repeat');
						  $(" #togglecontent").hide();

						   });
});
}); 


