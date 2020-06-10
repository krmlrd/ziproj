### Laravel Vue Admin Photo Gallery

### Installation

-   `git clone https://github.com/krmlrd/ziproj.git` to clone the project
-   `cd ziproj` to go into project dir
-   `cp .env.example .env` and fill it later with required params
-   `composer install` to install vendor locally
-   `docker-compose build app` to build app
-   `docker-compose up -d` to start app as detached
-   `docker-compose exec app ls -l` useful to see the list of files in the container dir
-   `docker-compose exec app php artisan migrate:fresh --seed` to create db and fill with seeder info
-   `docker-compose exec app php artisan passport:install` to create oauth clients and keys
-   `docker-compose exec app npm install` to install node_modules
-   `docker-compose exec app npm run dev` to build frontend


![Image of Homepage](https://github.com/krmlrd/ziproj/blob/master/public/readme-images/homepage.png)
![Image of Login](https://github.com/krmlrd/ziproj/blob/master/public/readme-images/login.png)
![Image of Register](https://github.com/krmlrd/ziproj/blob/master/public/readme-images/register.png)
![Image of Admin](https://github.com/krmlrd/ziproj/blob/master/public/readme-images/admin.png)
![Image of Admin Posts](https://github.com/krmlrd/ziproj/blob/master/public/readme-images/admin-posts.png)
![Image of Admin Photos](https://github.com/krmlrd/ziproj/blob/master/public/readme-images/admin-photos.png)
