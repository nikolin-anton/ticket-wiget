
# Мини-CRM (Widget + Admin)

Проект реализован на Laravel 12, PHP 8.4 с использованием Docker для быстрого локального запуска. Используемые пакеты:
- spatie/laravel-permission для ролей
- spatie/laravel-medialibrary для работы с файлами
- laravel/fortify для авторизации в админ панели


### Запуск и описание проекта
1. Клонировать репозиторий
- git clone https://github.com/nikolin-anton/ticket-wiget.git
- cd ticket-widget
2. Копировать .env.example в .env, и указать параметры подключения к БД
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=ticket_wiget
   DB_USERNAME=root
   DB_PASSWORD=root
3. Собрать и запустить контейнеры:
- docker-compose build
- docker-compose up -d
4. Установить зависимости
- docker-compose exec php bash
- composer install
5. Запустить миграции и сидеры:
- php artisan:migrate --seed
  После выполнения база данных заполнится тесновыми данными:
- Customer - клиенты
- Ticket - заявки
- User - администратор и менеджер
  Роли пользователей:
- admin - может изменять статус и удалять заявки
- manager - может только обновление статус заявки
6. Для работы с файлами нужно выполнить также команду:
- php artisan storage:link
7. Виджет страница доступна по ссылке http://your-domain.com/widget, он реализован как Blade страница, которая отправляет данные через AJAX на REST API - (POST) 'api/tickets'.
   Пример использования на внешних сайтах <iframe src="http://localhostyour-domain.com/widget" style="width:100%; height:600px;border:0;"></iframe>
8. Пример создания заявки:
   Маршрут POST /api/tickets
- Загловок
  Accept: application/json
- Тело (JSON)
  {
  "name" : "Bill Gates",
  "email" : "billgates@mail.com",
  "phone" : "+380955553322",
  "subject" : "Lorem ipsum dolor",
  "text" : "Eum reiciendis quaerat sapiente laudantium, eveniet neque, vel fuga obcaecati tempore accusamus qui enim assumenda quam numquam odit, voluptas earum laborum voluptatibus."
  }
- Успешный ответ (HTTP 201)
  {
  "data": {
  "id": 204,
  "subject": "Lorem ipsum dolor",
  "text": "Eum reiciendis quaerat sapiente laudantium, eveniet neque, vel fuga obcaecati tempore accusamus qui enim assumenda quam numquam odit, voluptas earum laborum voluptatibus.",
  "status": "new",
  "customer": {
  "id": 14,
  "name": "Bill Gates",
  "email": "billgates@mail.com",
  "phone": "+380955553322"
  },
  "files": null,
  "created_at": "2 025-11-10T15:05:21.000000Z"
  }
  }
  Все поля валидируются через FormRequest
  Для 'phone' используется формат E.164
9. Статистика заявок:
   Маршрут GET /api/tickets/statistics
   Возвращает колличество созданых заявок за  сутки, неделю и месяц
   {
   "data": {
   "day": 4,
   "week": 18,
   "month": 68
   }
   }
10. Админ-панель доступна только авторизованным пользователям с ролями 'admin' или 'manager'.
    Функционал:
- просмотр и фильтрация заявок (по дате, статусу, email, телефону)
- обновление статусов
- удаление заявок (только 'admin')
11. Реализовано ограничение - не более одной заявки в сутки с одного номера телефона или email

12. Функционал покрыт базовыми тестами:
- создание заявки
- обновление статуса
- получение статистики
- огранечение отправки заявки

Запуск:
- php artisan test 
