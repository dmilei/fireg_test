## Install 

- In the root directory run 'docker-compose up'
- Bash into the container: 'docker exec -it fireg-app bash'
- In the container: php artisan migrate:fresh --seed

The backend and DB is up and running, by default on the 9000 and 9001 ports

## Run the application

- Change dir to frontend
- npm install
- npm run serve

The frontend is up and running, by default on the 8080 port