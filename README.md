# leaseweb
Laravel Backend API and React Frontend on Docker Container

## Install
In order to make the project run you need to execute **docker-compose up --build**.
Once Docker is up, in a new terminal in the same app path run **docker exec -it **leaseweb_backen_1 sh**,
when the docker terminal run, use **php artisan migrate** to run migrations and finally run **php artisan db:seed --class=ServerSeeder**
to load the xsl data in the data base table.
Finally, open your browser in **localhost:3000** and you can see the application running.

## API DOCS
To access API DOCS open in your browser **localhost:8080/api**
