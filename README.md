Как запустить:
установить docker, docker compose

перейти в корневую директорию проекта
скопировать .docker/.env: 
```bash
cp ./.docker/.env.example ./.docker/.env
```
запустить контейнеры
```bash 
docker compose -f ./.docker/docker-compose.yml -p docker up -d
```

после этого запустится стек контейнеров, доступным по:

| название контейнера | ip:port        |
|---------------------|----------------|
| php-fpm             | localhost:8888 | 
| mysql               | localhost:8890 |

пароли к бд указаны в `.docker/.env`

затем нужно запустить dbdump.sql, находящийся в корне проекта, 
чтобы "засеять" тестовые данные командой: 

```bash
docker exec -i mysql mysql -udb -pdb db < ./dbdump.sql
```

далее нужно установить все зависимости проекта:
```bash
docker exec -i php-fpm composer install
```

далее обращаемся к роуту: http://localhost:8888/infographic/get/2022-01-08

должен быть ответ с телом:
```json
[
    {
        "proceeds": "1350.85",
        "hardCash": "670.42",
        "nonCash": "680.43",
        "creditCards": "910.42",
        "avgBill": "62.00",
        "avgGuest": "3.20",
        "removalFromCheck": "25.00",
        "removalFromBill": "35.00",
        "numberOfChecks": 68,
        "numberOfGuests": 30
    },
    {
        "proceeds": "1350.85",
        "hardCash": "670.42",
        "nonCash": "680.43",
        "creditCards": "910.42",
        "avgBill": "62.00",
        "avgGuest": "3.20",
        "removalFromCheck": "25.00",
        "removalFromBill": "35.00",
        "numberOfChecks": 68,
        "numberOfGuests": 30
    }
]
```