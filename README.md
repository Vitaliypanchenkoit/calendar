<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Server requirements
PHP 8.0 <br>
MySql 8.0.25 <br>
Laravel 8.27.0 <br>
Composer 2.0.14 <br>
Nodejs 14.16.1 <br>
npm 7.12.0 <br>
vue js 2.5.17 <br>
redis-server 5.0.7 (for caching data) <br>

## Node packages
1. badger-accordion <br>
https://vuejsexamples.com/badger-accordion-component-for-vue-2/ <br>
https://github.com/stuartjnelson/badger-accordion <br>

## Реализация паттернов
=== PROXY === <br>
(app/Services/CalendarProxyService) <br>
Данный паттерн используется при получении данных (новостей, напоминаний, событий). Если запрос на получение данных происходит впервые,
данные получаем из базы данных и тут же кешируем. При повторном запросе, данные получаем из кеша. Драйвер кеширования - Redis. <br>

## Broadcasting
Для того, чтоб пользователь получал напоминание в браузере в режиме реального времени, мы используем бродкастинг.
В качестве драйвера используется Pusher Channels (https://pusher.com/channels)

## Implemented patterns ##
1. Proxy
Этот паттерн реализован для кеширования данных. В качестве драйвера кеширования использую Redis.
Паттерн реализован в сервисе app/Services/CalendarProxyService

2. Observer
Данный паттерн реализован для уведомления участников мероприятий, если мероприятие было изменено.
В качестве тренировки данный паттерн был реализован в "чистом виде" - см. папку app/Services/ObserverService (в приложении не используется)
Так как паттерн Observer в Ларавел реализован в виде Events/Listeners, в приложении используется данные возможности Ларавел
* Events - это Subjects
* Listeners - это Observers

3. Chain of responsibility
Laravel Middleware реализует инверсию данного паттерна. То есть кажый Middleware проверяет, если выполняется заданное условие, он
передаёт запрос по цепочке на дальнейшую обработку.

Кроме этого, данный паттерн был реализован в сервисе app/Services/LoggerChaneService для многоуровневого логирования ошибок.
Если код ошибки = 0 или >= 500, тогда высылаем сообщение об ошибки на почту администратора.
При этом во всех случаях записываем ошибку в лог файл.
