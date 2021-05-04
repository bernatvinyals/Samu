var storeButton;
var upgradesButton;
var settingsButton;
var storeHUD;
var upgradesHUD;
var settingsHUD;
function setVarSidebar(){
	storeButton = document.getElementById("Buildings");
	upgradesButton = document.getElementById("Upgrades");
	settingsButton = document.getElementById("Settings");
	storeHUD = document.getElementById("shopHUD");
	//upgradesButton = document.getElementById("Upgrades");
	//settingsButton = document.getElementById("Settings");
}
function setHudActive(obj) {
	storeButton.style = "background-color: var(--idleSidebar);";
	upgradesButton.style ="background-color: var(--idleSidebar);";
	settingsButton.style ="background-color: var(--idleSidebar);";
	obj.style = "background-color: var(--activeSidebar);"; 
	if (obj.id == "Buildings") {
		storeHUD.style.display = "grid";
		//upgradesHUD.style.display = "none";
		//settingsHUD.style.display = "none";
	}
	if (obj.id == "Upgrades") {
		storeHUD.style.display = "none";
		//upgradesHUD.style.display = "none";
		//settingsHUD.style.display = "none";
	}
	if (obj.id == "Settings") {
		storeHUD.style.display = "none";
		//upgradesHUD.style.display = "none";
		//settingsHUD.style.display = "none";
	}
	console.log("ok");
}
function buyRequest(elID) {
		
}
function getInfoOf(elID){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 2) {
		document.getElementById("obj-info").innerHTML = "<p>Getting INFO</p>";
		}
		if (this.readyState == 4 && this.status == 200) {
		document.getElementById("obj-info").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "itemInfo.php?id="+elID+"", true);
	xhttp.send();
}
