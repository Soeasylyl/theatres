# Installation
### 1. Install Composer:
```bash
$ curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
```

### 2. Install Node Version Manager (NVM):
```bash
$ curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
```

### 3. Install Node.js:
```bash 
$ nvm install v18.16.0 
```

# Install Dependencies:
```bash
$ composer install
```
```bash
$ npm install
```

# Launch of the project
### 1. Running docker containers:
```shell
$ ./vendor/bin/sail up -d 
```

### 2. Build:
* Development Build:
```bash
$ npm run dev
```
* Production Build:
```bash
$ npm run build
```

### 3. Database Cleanup and Migration with Seeding (Only development):
```shell 
$ ./vendor/bin/sail artisan db:wipe && ./vendor/bin/sail artisan migrate --seed
```

# Working with application
### * View All Docker Containers:
```bash 
$ docker ps -a 
```

### * Down application:
```shell
$ ./vendor/bin/sail down
```

### * Check Node.js Version (MIN 16.17.0):
```shell
$ node -v
```
