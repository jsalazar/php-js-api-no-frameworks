# POC: PHP API, No Frameworks
This is basic boilerplate for implementing a PHP driven API for your project along with some vanilla Javascript.

# Goals
- attempted to abstract API class as much as possible 
- no framework for PHP or Javascript
- OOP implementation
- abstraction of database, queries, flexible arguments for api 
- can be abstracted further with the `config.php` file to pass in flexible and unlimted amount of arguments
- config.php  is stored outside of webroot
- `.htaccess` is setup so all requests to /api/ are handled by root `index.php` 
 

# Requirements 
- Vagrant should be installed on your machine to run and work on this project
- If you don't have it, try it out: https://www.vagrantup.com/downloads


# Setup & Configuration

Clone this repo: 
```bash
git clone https://link-to-project

cd /your/path/php-api-starter
```


Open up the `Vagrantfile` and edit these lines to change the port and directory path to reflect yours. 
```bash
# set up access to local site at 127.0.0.1:4569
config.vm.network :forwarded_port, guest: 80, host: 4569

# identify location of my code on host; identify alias for Apache at /var/www on guest
config.vm.synced_folder "/Users/jsalazar/your/path/php-api-starter", "/var/www"
```

Save your changes to the `Vagrantfile`.


Run Vagrant to provision the environment:
```bash
vagrant up
```


  The Vagrant `bootstrap.sh` will install the following:
  - stack: Apache2, MariaDB (latest), PHP7.4 on Ubuntu 20.04
  - configure Apache and MariaDB
  - create a database, user, table, and dummy records






# Developer Experience
How to use this setup...

Note:
All vagrant commands should be run in your terminal from inside 
your project directory where your `Vagrantfile` is located.


To launch the VM:  
```bash
vagrant up

# Don't worry, Vagrant will only provision (install software) once. 
# After the first `vagrant up`, Vagrant will simply start your VM.
```


To ssh into your VM from your host machine:
```bash
vagrant ssh
```

To view your ssh connection settings:

```bash
vagrant ssh-config
```

To check the status of the vagrant machine within current project directory
```bash
vagrant status
```

To view the status of ALL Vagrant environments running on your machine:
```bash
vagrant global-status
```

If you need to stop or shutdown your VM or, if you need to restart your host machine (your laptop): 

- Halting the virtual machine will gracefully shut down the guest operating system and power down the guest machine.
- Halting your machine will cleanly shut it down, preserving the contents of disk and allowing you to cleanly start it again.

```bash
vagrant halt
```

When your ready to begin working again: 
```bash
vagrant up
```




# Configure Database (optional)
Once provisioning has been completed, you can set up your database tool to connect to MariaDB.
This is useful if you want to check and confirm your API crud operations are working.

To obtain all your connection details:
```bash
vagrant ssh-config
```



# Demo 

Open up the following URL and open up DevTools to review Console and Network activity
- http://127.0.0.1:4569/
