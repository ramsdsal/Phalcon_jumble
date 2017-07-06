# phalcon_Jumble    

**Video 9.1 - Phalcon Vagrant Setup**  
	- Vagrant box - ubuntu-precise-64  
	- Ubuntu 14.04  
	- Php 5.5.9  
	- Phalcon 3.2.0
	- DevTools 3.2.0    

**Video 9.2 - Point Apache Setup Barebones**    
	- Enter the folder in   
	$ cd /etc/apache2/sites-avaiable/  
	$ sudo nano playground.conf    
		<VirtualHost *:80>  
		DocumentRoot /var/www/  
		</VirtualHost>  
		<Directory "/var/www/">  
		Options Indexes FollowSymlinks  
		AllowOverride All  
		Require all granted  
		</Directory>        
	$ sudo a2ensite playground.conf  
	$ sudo a2dissite 000-default.conf  
	$ sudo service apache2 reload  
	- Enter the folder $ cd /var/www and create a new phalcon project  
	$ phalcon project jumble    



   