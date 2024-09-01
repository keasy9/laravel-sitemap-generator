# Пакет для автоматической генерации sitemap.xml на основе моделей.

### Установка:

    composer require keasy9/laravel-sitemap-generator

### Использование:

    php artisan sitemap:generate

Сгенерирует карту сайта. По умолчанию струкрутра файлов такая:

    /public/sitemap.xml - индексная карта сайта
    /public/sitemaps/sitemap-{N}.xml - карта сайта для конкретной модели

Модели, которые содержат слишком много записей, будут разбиты на несколько файлов. Лимит записей в файле определяется в конфигурации и по-умолчанию совпадает со стандартом sitemap.xml - 50000 ссылок на файл

Пути и названия файлов можно изменить в кофигурации.

    php artisan sitemap:clear

Удалит сгенерированную карту сайта. Использует пути и названия файлов из конфигурации.

### Для того, чтобы твои модели попали в карту сайта, они должны:

* реализовывать интерфейс Keasy9\SitemapGenerator\Interfaces\SitemapSourceInterface

* бысть зарегестрированы в App\Providers\AppServiceProvider::boot():

        $this->app->make(SitemapGeneratorService::class)->registerSource(MOdel::class)

* необязательно - использовать трейт Keasy9\SitemapGenerator\Traits\SitemapSource, который реализует бОльшую часть методов интерфейса

Кроме того, пакет имеет предустановленную модель для заполнения карты сайта вручную через БД - Keasy9\SitemapGenerator\Models\SitemapUrl. Миграцию для этой модели можно получить таким образом: 

    php artisan vendor:publish --tag=sitemap-generator-migrations

### Конфигурация и шаблоны доступны для переопределения:

    php artisan vendor:publish --tag=sitemap-generator

### Дополнительные методы сервиса:

* Keasy9\SitemapGenerator\Services\SitemapGeneratorService::isSitemapExists(): bool - проверяет, существует ли карта сайта
* Keasy9\SitemapGenerator\Services\SitemapGeneratorService::getSitemapUrl(): string - возвращает url индексной карты сайта
* Keasy9\SitemapGenerator\Services\SitemapGeneratorService::getSitemapDate(): Carbon - возвращает время создания файла индекса карты сайта