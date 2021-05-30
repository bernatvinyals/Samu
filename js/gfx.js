function updateGFX() {
	setTimeout(function(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("gameGrid").innerHTML = this.responseText;
			}
		};
	xhttp.open("GET", "imageUpdateAjax.php", true);
	xhttp.send();	
	}, 400);
}
function updateProgressBar(){
	document.getElementById("resourceProgress").style = "width:"+(window.innerWidth-232)+"px;"
}
var progressBarPercentage = 0;
function progressBar(){
	var proggress = 100/60;
	progressBarPercentage += proggress;
	document.getElementById("resourceProgressBar").style = "width:"+(progressBarPercentage)+"%;"
	setTimeout(progressBar,1000)
}