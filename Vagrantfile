Vagrant.configure("2") do |config|
  # https://docs.vagrantup.com.
  # You can search for boxes at https://vagrantcloud.com/search.

  # grab image from vagrant repo officially maintained by Ubuntu (version 20.04)
  config.vm.box = "ubuntu/focal64"
  # set up access to local site at 127.0.0.1:4569
  config.vm.network :forwarded_port, guest: 80, host: 4569
  # identify location of my code on host; identify alias for Apache at /var/www on guest
  config.vm.synced_folder "/Users/jsalazar/PROJECTS/PHP/php-api-starter", "/var/www"
  # set location of provisioning script file inside your project directory
  config.vm.provision :shell, path: "bootstrap.sh"
end