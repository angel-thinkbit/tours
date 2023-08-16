# Tours
A small admin panel that can manage tours bookings

## Laravel Version
- 9.19.0
  
## Server Requirements

- Apache Web Server to utilize `.htaccess` (Nginx is supported but not optimized)
- Laravel's [Server Requirements](https://laravel.com/docs/installation#server-requirements)
- PHP 8.1+ is [required by Laravel 9](https://laravel.com/docs/9.x/releases#laravel-9)
- MySQL 5.6+ is [supported by Laravel](https://laravel.com/docs/database#introduction)

### Installing the project

[https://github.com/angel-thinkbit/tours](https://github.com/angel-thinkbit/tours/)

1.  Download from the *main* branch then extract the project. 
    
2.  Update your Homestead.yaml file.
    
3.  Reference for setting up homestead.yaml - Note: type: “nfs” is for mac os only
    
   ```
 folders:
        - map: ~/code/tours
        to: /home/vagrant/tours
        type: "nfs"

    sites:
        - map: tours.local #localhost url site
        to: /home/vagrant/tours/public
        schedule: true
        type: "apache"

    databases:
        - digithai_tours
```

4.  If you haven’t installed the plugin `(https://github.com/cogitatio/vagrant-hostsupdater)`. Install using `vagrant plugin install vagrant-hostsupdater` on homestead directory. This is for the vagrant automatically managing the `hosts` file and for the localhost url site on your homestead yaml to work.
    
5.  If your machine is running on windows, open command-prompt and run as administrator then type this command cacls %SYSTEMROOT%\system32\drivers\etc\hosts /E /G %USERNAME%:W
    

6.  Connect via SSH
    
7.  Navigate to your project’s directory
    
8.  Execute composer install
    
9.  Execute php -r "file_exists('.env') || copy('.env.example', '.env');"
    
10.  Update .env variables such as DB_DATABASE, DB_USERNAME & DB_PASSWORD

11.  Execute php artisan key:generate
    
12.  Execute php artisan migrate:fresh --seed --seeder=UserSeeder

13.  Execute npm install && npm run dev
    
14.  In your browser, navigate to your project’s URL to check if you’ve set up correctly.
    
