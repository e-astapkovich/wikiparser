# Веб-приложение, копирующее статьи из Википедии во внутреннюю БД, с возможностью дальнейшего поиска и навигации по статьям..
*Тестовое задание*

## Используемый стек технологий:
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

## Сборка и запуск проекта:
Проект написан на Laravel 10.
Поэтому развернуть его локально проще всего при помощи встроенного пакета Laravel Sail.
1) Для запуска проекта должны быть установлены:
    - PHP версии 8.1 или выше.
    - Composer
    - Docker (для Windows - Docker Desktop)
2) Клонировать проект (git clone).
3) Файл '.env.example' переименовать в '.env'. При необходимости, настроить его согласно окружению, в котором планируете развернуть проект.
В частности, настроить подключение к БД.
2) Установить бэкенд-зависимости командой `composer update` набрав ее, находясь в корневой директории проекта.
4) Выполнить команду `./vendor/bin/sail artisan key:generate`
6) Запуск контейнеров осуществляется командой `./vendor/bin/sail up -d`.
(при необходимости можно настроить алиас для команды ./vendor/bin/sail.
Инструкция:  https://laravel.com/docs/10.x/sail#configuring-a-shell-alias)
