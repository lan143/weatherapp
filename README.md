Weather App
============================

Требования
------------
Минимальная версия PHP: 5.4.0

Установка
------------

### Установка через Composer

Если у вас нет [Composer](http://getcomposer.org/), вы можете его установить следуя инструкции на [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

После вы можете установить проект следующими командами:

~~~
php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"
php composer.phar create-project --prefer-dist --stability=dev lan143/weatherapp weatherapp
~~~

### Установка через Git

Вам необходимо склонировать этот репозиторий командой:
~~~
git clone git@github.com:lan143/weatherapp.git
~~~

Настройка
------------

Вам необходимо настроить подключение к базе данных в файле config/db.php

Так же вам нужно настроить компонент weather в файле config/console.php и config/test.php
 
~~~
$config = [
    ...
    'components' => [
        'weather' => [
            'class' => 'app\weather\WeatherComponent',
            'access_token' => '',
            'timeout' => 6,
        ],
    ],
    ...
];
~~~

Где в access_token вам необходимо указать ключ доступа который вы получите после регистрации
на сервисе [Weathersource](weathersource.com). timeout создает задержку между запросами к API.
Она необходима, если вы используете бесплатный аккаунт, т.к. на нем стоит ограничение в
количестве запросов в минуту.

Если вы не использовали Composer для установки проекта, то вам так же необходимо
в файле config/web.php указать cookieValidationKey и установить права доступа 777 на папку runtime,
web/asset а так же права 755 на файл yii.

После этого вам необходимо настроить ваш веб сервер для того, чтобы папка weatherapp/web была доступна через web сервер.

Структура бд
------------
После настройки приложения вам необходимо создать структуру базы данных. Для этого выполните команду
~~~
php yii migrate
~~~

Использование
------------
Загрузить данные с API в базу вы можете с помощью команды:
~~~
php yii parser/index
~~~

После этого на главной странице приложения вы сможете увидеть результаты в таблице.

Тесты
------------
Для тестирования используется Codeception. Если он у вас установлен глобально, то запустить
тесты вы можете с помощью команды:
~~~
codecept run
~~~

либо
~~~
./vendor/bin/codecept run
~~~