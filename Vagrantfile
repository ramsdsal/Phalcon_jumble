# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "Ubuntu"
  config.vm.network "forwarded_port", guest: 6379, host: 6379  
  config.vm.network "private_network", ip: "192.168.7.0"
  config.vm.synced_folder "./www", "/var/www/"
  #config.vm.synced_folder ".", "/vagrant/", :mount_options => ["dmode=777","fmode=666"]
  #config.vm.synced_folder "./www", "/var/www/", :mount_options => ["dmode=775","fmode=644"], :owner => 'vagrant', :group => 'www-data' 
end
