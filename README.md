# dwp-demo

A minimalistic blogging site intended to demonstrate my experience with Symfony.

## Installation

Setup is pretty easy, assuming you're familiar with Docker:
1. From the project root, run `composer install` to install all dependencies.
2. Run `docker-compose up` and wait for the services to start.
3. Type `docker exec dwp-demo_web_1 /var/www/html/bin/console doctrine:schema:create`. 
   This will create the database schema on the included MySQL server.

Once the site is running, it can be accessed on localhost port 80.

I'm also running a public instance at https://dwp-demo.richardkriesman.com if you're interested in trying out a
working copy.
