# SAMU (Ogame like)
SAMU is a Ogame like game where you're a young boy that wants to start their Music empire.
Written in PHP and Javascript

##Instalation
To setup the game you'll need the following:
A Apache Server, a PHP server and a MySQL server.
- Start with editing globals.php file with the MySQL user, password and server.
- To setup the Database we need to open SETUP.php. This will create a user: admin pass:admin to test things and prorperly setup database tables.
- Now you can play the game by creating a account or by using the admin user previouisly crated.

##Buildings
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
#TODO
- Encrypt password
- Email Verification
- Upgrade Bulding Times
