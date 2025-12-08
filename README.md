# Max Bot API Client (PHP)

![PHP Version](https://img.shields.io/badge/PHP-8.0+-007ec6.svg?logo=php&logoColor=ffffff)
[![Latest Version](https://img.shields.io/packagist/v/maxkhim/laravel-max-api-client.svg?style=flat&label=Packagist&logo=packagist&logoColor=ffffff)](https://packagist.org/packages/maxkhim/laravel-storage-dedupler)
[![Laravel](https://img.shields.io/badge/Laravel-10+-007ec6.svg?logo=laravel&logoColor=ffffff)](https://laravel.com)

Простой и типобезопасный PHP-клиент для работы с [Max Bot API](https://dev.max.ru/docs-api/). Позволяет легко отправлять сообщения, обрабатывать обновления и работать с вложениями через объекты.

---

## ✨ Особенности

- Объектно-ориентированный интерфейс для сообщений, вложений и кнопок
- Поддержка **фабрик**: `Attachment::image(...)`, `Link::reply(...)`
- Поддержка:
    - Текстовых сообщений с форматированием (`markdown`, `html`).
    - Кнопок: `callback`, `link`, `request_contact` и др.
    - Вложений: фото, видео, файлы, геолокация, контакты
    - Ответов на сообщения (`reply`) и пересылки (`forward`)
- Совместимость с Laravel

---

## 📦 Установка


В `.env` файле добавьте:
```dotenv
MAX_BOT_TOKEN="Токен бота"
```

В папке вашего проекта выполните установку:
```bash
bash composer require maxkhim/laravel-max-messenger-api-client
```

Выполнить проверку корректности установки:
```bash
php artisan max-bot:check
```

---

## 🚀 Быстрый старт

### Отправка сообщения

```php
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message; 
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Attachment; 

$message = Message::message('Привет, мир!') 
    ->addAttachment( Attachment::location(64.529183, 40.54926) ) 
    ->addAttachment( 
        Attachment::inlineKeyboard
         [ 
             [ 
                Attachment::callbackButton('Нажми меня', 'btn_1'), 
                Attachment::callbackButton('Нажми меня ещё раз', 'btn_2'), 
             ], 
             [ 
                Attachment::linkButton('Мой GitHub', 'https://github.com/maxkhim'), 
             ]
         ]
    );
```

### 2. Обработка входящих обновлений

```php

```

## 🧰 Возможности

### Кнопки

| Тип кнопки                | Метод                                                |
|---------------------------|------------------------------------------------------|
| Callback                  | `Button::callbackButton('Текст', 'payload')`         |
| Ссылка                    | `Button::linkButton('Текст', 'https://...')`         |
| Запрос контакта           | `Button::requestContactButton('Поделиться')`         |
| Запрос геолокации         | `Button::requestLocationButton('Отправить локацию')` |
| Сообщение от пользователя | `Button::messageButton('Отправить')`                 |
| Запуск приложения         | `Button::openAppButton('Запустить', 'bot_name')`     |

### Вложения

| Тип                 | Метод                                    |
|---------------------|------------------------------------------|
| Фото                | `Attachment::image('https://...')`       |
| Видео               | `Attachment::video('token_...')`         |
| Файл                | `Attachment::file('token_...')`          |
| Геолокация          | `Attachment::location(55.7558, 37.6176)` |
| Контакт             | `Attachment::contact('Иван', 123456)`    |
| Предпросмотр ссылки | `Attachment::share('https://...')`       |

### Ответ на сообщение


