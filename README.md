# SAMU (Ogame like)
SAMU is a Ogame like game where you're a young boy that wants to start their Music empire.
Written in PHP and Javascript

## Installation
To setup the game you'll need the following:
A Apache Server, a PHP server and a MySQL server.
- Start with editing globals.php file with the MySQL user, password and server.
- To setup the Database we need to open SETUP.php. This will create a user: admin pass:admin to test things and properly setup database tables.
- Now you can play the game by creating a account or by using the admin user previously crated.

## Buildings
In the game there's 4 buildings Studio, Merch Store, Museum and Tower. Each has the following:
```
Name:Studio
Reputation Req: 0
Initial Price:0
Income/minute: 10 Credits
```
```
Name:Merch Store
Reputation Req: 100
Initial Price:100
Income/minute: 30 Credits
```
```
Name:Museum
Reputation Req: 600
Initial Price:600
Income/minute: 200 Credits
```
```
Name:Tower
Reputation Req: 1000
Initial Price:5600
Income/minute: 460 Credits
```

## DATABASE
```
users(
	userID INT PRIMARY KEY AUTO_INCREMENT
	username VARCHAR(16) NOT NULL
	pass VARCHAR(32) NOT NULL
	email VARCHAR (80) NOT NULL
	confCode INT - (For Email Verification //Not used)
	verified INT - (For Email Verification //Not used)
	avatarID INT - (For Player Avatar //Not used)
	lastLoginTime TIMESTAMP NOT NULL
	)
```
```
curXP(
	infID INT PRIMARY KEY AUTO_INCREMENT,
	userID INT
	rep INT
	credits INT
	tokens INT
	albums INT
	FOREIGN KEY (userID) REFERENCES users(userID)
	)
```
```
buildings(
	bID INT PRIMARY KEY
	bName VARCHAR(16)
	bPrice INT
	bLvl INT
	rep INT - (Used to set reputation requirements)
	credits INT - (Used to calculate Income)
	dailyFee INT - (Used to calculate Upgrades)
	)
```
```
playerhasbuild (
	userID INT
	bID INT
	bLvl INT
	bPos INT - (Used to know what grid position is in)
	isUpgrading INT - (For Upgrade Cooldown //Not used)
	timestampSec TIMESTAMP NOT NULL
	FOREIGN KEY (userID) REFERENCES users(userID) 
	FOREIGN KEY (bID) REFERENCES buildings(bID)
	)
```

## FILES DESCRIPTION
```
- buyBuilding.php 		=> Through AJAX send id of building and uses userID in $_SESSION[userID] to assign it on playerhasbuild
- game.php 				=> Opened after login. Acts as the HTML structure of the game. Contains game grid and calculates how much income a player had during offline
- getInfoToAjax.php 	=> Replaces Topbar values with updated ones.
- globals.php			=> To set Database User
- imageUpdateAjax.php 	=> Replaces game grid with updated one
- itemInfo.php 			=> Showes Building info of grid and store
- login.php 			=> Basic login screen with md5 Encryption
- logout.php 			=> Deletes the entire session and sends player to login.php
- register.php 			=> Basic register screen with md5 Encryption
- removeBulding.php 	=> Removes building that's on certain position
- updateResources.php 	=> Updates database with 1 minute progress
- upgradeBuilding.php 	=> Upgrades Bulding selected
```

## TODO
- Email Verification
- Upgrade Bulding Times
- Player Avatar
- Intro story presentation
- In game tutorial

## ASSETS CREDITS
Disclaimer: This is not a production game, these assets have to be changed if used in production or in any comercial use.
- pixel jeff for Login and Register background [Giphy](https://giphy.com/gifs/pixel-art-jeff-lkceXNDw4Agryfrwz8) 
- Jake Bushell for raining gif [Giphy](https://giphy.com/stickers/arsissist-jakebushell-thebigdrip-sclaXPuYMBQVN4OsuM)
- ansimuz for in game background [Itch.io](https://ansimuz.itch.io/)
- Exuin for tileset [Itch.io](https://emily2.itch.io/)