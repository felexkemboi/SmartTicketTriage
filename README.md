## Steps of setting up the project locally

- clone the repository using the command `git clone git@github.com:felexkemboi/SmartTicketTriage.git`
- composer install
- npm install
- Have MYSQL installed, create a database
- Copy .env.example to .env
- Update the db name, user and password of your Database configurations in .env file
- php artisan migrate --seed
- npm run dev
- npm run build
- Head over to localhost