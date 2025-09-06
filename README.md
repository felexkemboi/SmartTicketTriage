## Steps of setting up the project locally

- clone the repository using the command `git clone git@github.com:felexkemboi/SmartTicketTriage.git`
- Run `composer install` to install necessary packages
- Run `npm install` to install Javascript packages(make sure you have node version 20)
- Have MYSQL installed and create a database
- Copy file `.env.example` to `.env`
- Update the db name, user and password of your Database configurations in your .env file
- Run `php artisan migrate --seed` to migrate and seed your Database with mock data
- Run `php artisan serve` to fire up the Laravel server
- Run `npm run dev` to have localhost up
- Run `npm run build` to build your frontend
- Head over to `http://localhost:5173`


In some cases it is reffered to Note, some reffered to Body
Added some columns not mentioned in the description