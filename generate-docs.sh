#php ./bin/console.php api:swagger ./var/swagger/Definitions.php -vv
php ./bin/console.php api:swagger -d ./var/swagger/Definitions.php -vv ./src
./vendor/bin/swagger -o ./var/swagger/api.swagger.json -e ./src/Command/GenerateSwaggerCommand.php  ./src ./var/swagger
npx -q redoc-cli bundle -o docs/api.html ./var/swagger/api.swagger.json --options.requiredPropsFirst