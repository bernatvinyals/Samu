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
