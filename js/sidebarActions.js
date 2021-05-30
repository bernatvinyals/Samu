var credits= 0;
var albums = 0;
var tokens = 0;
var storeButton;
var upgradesButton;
var settingsButton;
var storeHUD;
var upgradesHUD;
var settingsHUD;
var buyPos=0;
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
	upgradesButton.style ="display:none;background-color: var(--idleSidebar);";
	settingsButton.style ="display:none;background-color: var(--idleSidebar);";
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
function buyByIndex(elID) {
	document.getElementById("obj-info").innerHTML = "";
	storeHUD.style.display = "none";
	storeButton.style = "background-color: var(--idleSidebar);";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 1) {
			showLoading();
		}
		if (this.readyState == 2 ||this.readyState == 3) {
			hideLoading();
		}
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("obj-info").innerHTML = this.responseText;
		}
		if (this.readyState == 4 && this.status != 200) {
			document.getElementById("obj-info").innerHTML = "Connection lost, try Refreshing the page.";
		}
	};
	xhttp.open("GET", "buyBuilding.php?id="+elID+"&pos="+buyPos, true);
	xhttp.send();
}

function upgradeByIndex(elID,lvl){
	//AJAX ask for upgradeBuilding.php?pos=X&nextLVL=Y;
	document.getElementById("obj-info").innerHTML = "";
	storeHUD.style.display = "none";
	storeButton.style = "background-color: var(--idleSidebar);";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 1) {
			showLoading();
		}
		if (this.readyState == 2 ||this.readyState == 3) {
			hideLoading();
		}
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("obj-info").innerHTML = this.responseText;
		}
		if (this.readyState == 4 && this.status != 200) {
			document.getElementById("obj-info").innerHTML = "Connection lost, try Refreshing the page.";

		}
	};
	xhttp.open("GET", "upgradeBuilding.php?id="+elID+"&lvl="+lvl, true);
	xhttp.send();
}
function updateINFO() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		document.getElementById("userInfo").innerHTML = this.responseText;//TODO: ALBUMS INCREMENTING ITSELF
		setTimeout(updateINFO,1000);
	}
	};
	xhttp.open("GET", "getInfoToAjax.php", true);
	xhttp.send();
}

function upateResources() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			setTimeout(upateResources,60000);
			progressBarPercentage = 0;
		}
	};
	xhttp.open("GET", "updateResources.php", true);
	xhttp.send();
}

function removeBuild() {
	document.getElementById("obj-info").innerHTML = "";
	storeHUD.style.display = "none";
	storeButton.style = "background-color: var(--idleSidebar);";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 1) {
			showLoading();
		}
		if (this.readyState == 2 ||this.readyState == 3) {
			hideLoading();
		}
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("obj-info").innerHTML = this.responseText;
		}
		if (this.readyState == 4 && this.status != 200) {
			document.getElementById("obj-info").innerHTML = "Connection lost, try Refreshing the page.";
		}
	};
	xhttp.open("GET", "removeBuild.php?pos="+buyPos, true);
	xhttp.send();
}
function getInfoOf(elID){
	document.getElementById("obj-info").innerHTML = "";
	storeHUD.style.display = "none";
	storeButton.style = "background-color: var(--idleSidebar);";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 1) {
			showLoading();
		}
		if (this.readyState == 2 ||this.readyState == 3) {
			hideLoading();
		}
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("obj-info").innerHTML = this.responseText;
		}
		if (this.readyState == 4 && this.status != 200) {
			document.getElementById("obj-info").innerHTML = "Connection lost, try Refreshing the page.";
		}
	};
	if (elID >9999) {
		xhttp.open("GET", "itemInfo.php?id="+(elID-9999)+"&hasToUpgrade=1", true);
	}else{	xhttp.open("GET", "itemInfo.php?id="+elID+"", true);}
	xhttp.send();
}

