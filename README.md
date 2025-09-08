## Steps of setting up the project locally

- clone the repository using the command `git clone git@github.com:felexkemboi/SmartTicketTriage.git`
- Run `composer install` to install necessary packages
- Run `npm install` to install Javascript packages(make sure you have node version 20)
- Have MYSQL installed and create a database
- Create a `.env` file in the root directory
- Copy file `.env.example` to `.env`
- Update the db name, user and password of your Database configurations in your .env file
- Run `php artisan key:generate` to generate key for the app(if it will be missing)
- Run `php artisan migrate --seed` to migrate and seed your Database with mock data
- Run `npm run dev` to have localhost up
- Run `php artisan serve` to fire up the Laravel server in another terminal tab
- Head over to `http://localhost:8000`


## Notes
- In some cases it is reffered to Note, some reffered to Body
- Added some columns not mentioned in the description
- Rate limiter is not added since it has no real openAI

## How to classify
You can classify the tickets in 2 ways,
  - Bulk classify using the command `php artisan tickets:bulk-classify`
  - Classify individual ticket by clicking on the `Classify` button on details modal