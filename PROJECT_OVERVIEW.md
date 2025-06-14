# Обзор проекта Notification Hub

Документ кратко описывает, **что есть** в тестовом проекте и **как этим пользоваться**.

---

## 1. Основная идея

Notification Hub — сервис для отправки push‑уведомлений на мобильные устройства и веб‑браузеры.
Бэкенд написан на **Laravel 12**, использует **Firebase Cloud Messaging** как транспорт.

---

## 2. Функциональные возможности

| Модуль                                                                       | Описание                                                                                                                                            |
| ---------------------------------------------------------------------------- |-----------------------------------------------------------------------------------------------------------------------------------------------------|
| **Аутентификация**                                                           | Laravel  JWT. Для демо‑целей сидер создаёт администратора `admin@example.com / admin123`.                                                           |
| **Регистрация устройств**                                                    | API `POST /api/devices` принимает `fcm_token` и `platform`, привязывает токен к текущему пользователю. Дедупликация по паре `(user_id, fcm_token)`. |
| **Админ‑панель (Filament v3)**                                               | • Создание уведомлений (body, title, send\_at)                                                                                                      |
| • Просмотр зарегистрированных устройств                                      |                                                                                                                                                     |
| • История доставок с цветными статусами и фильтром `sent / failed / queued`. |                                                                                                                                                     |
| **Очереди**                                                                  | Redis . `DispatchNotificationJob` генерирует `SendPushJob`‑ы, которые отправляют сообщения через FCM.                                               |
| **Планировщик**                                                              | Команда `notifications:dispatch-due` раз в минуту ищет готовые к отправке уведомления.                                                              |
| **Firebase Cloud Messaging**                                                 | `FcmService` инкапсулирует вызов API `messages:send`.                                                                                               |
| **История доставок**                                                         | Таблица `notification_device` хранит статус (`queued / sent / failed`) для каждого устройства.                                                      |
| **Тестовые данные**                                                          | Сидеры создают 3 пользователей, 6 устройств, 1 уведомление (+1 мин).                                                                                |

---

## 3. Как пользоваться

1. **Запуск** — см. раздел «Быстрый старт» в `README.md`.
2. **Вход в админку** → `http://localhost:85/admin`, логин выше.
3. **Создать уведомление** → вкладка *Notifications* → *Create*.
4. **Отследить доставку** → *Notification Logs*.
5. **Логин пользователя** → пример curl:
```bash
    curl --location 'http://localhost:{APP_PORT}/api/v1/auth/login' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json' \
    --data-raw '{
        "email": "info@admin.com",
        "password": "password"
    }'
```
6. **Регистрация устройства** → пример curl:

```bash
    curl --location 'http://localhost:{APP_PORT}/api/v1/devices' \
    --header 'Content-Type: application/json' \
    --header 'Authorization: Bearer {token}' \
    --data '{
        "fcm_token": "{fcm_token}",
        "platform": "ios" ֊» ios,android,web
    }'
```

---

## 4. Технические детали

* **БД‑схема** — `users`, `devices`, `notifications`, `notification_device`.
* **Ключ сервис-аккаунта** — `storage/app/firebase/sa.json`, путь в `.env`.

---
