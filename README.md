## Final Year Project
## Technical Stack:
**Programming Languages**: JavaScript (for front-end development), PHP (for back-end development)<br>
**Front-end Frameworks/Libraries**: HTML, CSS , JS<br>
**Back-end Frameworks/Libraries**: Laravel<br>
**Tools**: Git (for version control), MySQL(for database management)

## Installation
### Step 1
clone this repository
``` bash 
git clone https://github.com/yishak-cs/Interners.git
cd Interners
```
### Step 2
Install dependencies
```bash
composer install 
```
### Step 3
Install the necessary node modules
```bash
npm install 
```
###  Step 4
Create ``.env`` file and copy everything from ``.env.example`` to ``.env`` file
for linux
```bash
cat .env.example >> .env
```
and generate ``APP_KEY``
```bash
php artisan key:generate
```
### Step 5
Migrate the schema
```bash
php artisan migrate
```
>_optional_, you can also seed the users table (ADMIN)<br>
**email** : `admin@gmail.com`<br>
**password** : `12345678`
>```bash
>php artisan db:seed
>```
### Step 6
to compile frontend assest run
```bash
npm run dev 
```
### Step 7
Start the server and explore!
```bash
php artisan serve
```

## Contributors
- [yishak-cs](https://github.com/yishak-cs)
- [thomas](https://github.com/rutemul)
