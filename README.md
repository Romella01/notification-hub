# Notification Hub

Сервис для отправки push‑уведомлений через Firebase Cloud Messaging (FCM).

---

## Быстрый старт

````bash
# 1 — клонируем репозиторий
$ git clone https://github.com/you/notification-hub.git
$ cd notification-hub

# 2 - копируем .env.example в .env
$ cp .env.example .env

# 3 — запускаем Docker Sail
$ ./vendor/bin/sail up -d

# 4 — устанавливаем зависимости
$ ./vendor/bin/sail composer install
$ ./vendor/bin/sail artisan key:generate
$ ./vendor/bin/sail artisan jwt:secret

# 5 — кладём service‑account Google
$ mkdir -p storage/app/firebase
$ mv ~/Downloads/service-account.json storage/app/firebase/sa.json

# 6 — запускаем миграции
$ ./vendor/bin/sail artisan migrate:fresh --seed

# 7 - команды готовности к старту
$ ./vendor/bin/sail artisan queue:work --queue=push,default
$ ./vendor/bin/sail artisan schedule:work
````

| URL                                               | Назначение          | Данные                                                   |
|---------------------------------------------------|---------------------|----------------------------------------------------------|
| [http://localhost/admin](http://localhost:85/admin) | Панель Filament     | [admin@example.com](mailto:admin@example.com) / admin123 |

---

## Стек

* Laravel 12, PHP 8.3
* **Redis**— очереди
* **Firebase Cloud Messaging** (`kreait/firebase-php`)
* Filament v3 — админка

---

## Конфигурация

| Переменная             | Значение                                                       |
|------------------------|----------------------------------------------------------------|
| `FIREBASE_CREDENTIALS` | путь к `sa.json` (по умолчанию `storage/app/firebase/sa.json`) |
| `QUEUE_CONNECTION`     | `redis`                                                        |

---

## Цикл работы

1. Мобильное приложение получает `fcm_token` и вызывает `POST /api/devices`.
2. Администратор создаёт уведомление в Filament, указывая текст и `send_at`.
3. Планировщик запускает `DispatchNotificationJob`, который генерирует задачи `SendPushJob` для всех устройств.
4. `SendPushJob` отправляет push через FCM, фиксируя статус (`sent`или`failed`).

---

## API

### POST `/api/devices`

Регистрация устройства пользователя.

```json
{
  "fcm_token": "AAA…xyz",
  "platform": "android"
}
```

Ответ`201 Created` возвращает объект устройства.

---

## Планировщик

`routes/console.php` задаёт интервал:

```php
Artisan::command('app:dispatch-due-notifications', function () {
    $this->comment('Dispatching due notifications...');
})->purpose('Dispatch Due Notifications')->everyMinute() // можно менять на everyFiveMinutes();

```

## Тестовые данные

`php artisan migrate:fresh --seed` создаёт:

* 6 пользователя (1 — админ).
* 12 устройств с фиктивными токенами.
* 1 уведомление, запланированное на +1 минуту.

---
