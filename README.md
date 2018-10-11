## Система управления файловыми хранилищами.


![N|Solid](https://github.com/dmitryandreevich/ext-filestore-manager/blob/imgs/images/files-list.png?raw=true)

### Установка
Для установки потребуется [composer](https://getcomposer.org/), чтобы загрузить все необходимые зависимости проекта.

- Необходимо склонировать проект.
```
git clone https://github.com/dmitryandreevich/yii2-extjs-filestore-manager
```
- Загрузить все необходимые зависимости для проекта.
```
composer install
```
- Если необходимо работать с Amazon S3, то в конфигурационном файле ``config/web.php``, нужно добавить свои данные от аккаунта.
```PHP
'awss3Fs' => [
    'class' => 'creocoder\flysystem\AwsS3Filesystem',
    'key' => '',
    'secret' => '',
    'bucket' => '',
    'region' => '',
],
```
- Если необходимо работать с базой данных, то нужно добавить свои данные для подключения к ней в файле ``config/db.php``, a так же произвести миграцию базы данных.
```
yii migrate
```
#### Используемые технологии
  - Extjs 6 Trial
  - Yii2
  - Flysystem


Для удобной работы с разными файловыми хранилищами, я выбрал PHP-библиотеку [Flysystem](http://flysystem.thephpleague.com/docs/).


#### Возможности
- Переходы по папкам
- Создание и удаление файлов
- Создание и удаление папок
- Просмотр и редактирование текстовых файлов
- Просмотр фотографий
- Переименование файлов и папок
- Скачивание файлов. В данный момент не до конца доработано.
- Смена хранилища (Локальное хранилище или Amazon S3)
- Загрузка файлов
### Cкриншоты

##### Создание папки
![N|Solid](https://github.com/dmitryandreevich/ext-filestore-manager/blob/imgs/images/newfolder.png?raw=true)
##### Переименовывание
![N|Solid](https://github.com/dmitryandreevich/ext-filestore-manager/blob/imgs/images/rename.png?raw=true)
##### Простой текстовый редактор
![N|Solid](https://github.com/dmitryandreevich/ext-filestore-manager/blob/imgs/images/t-editor.png?raw=true)
##### Просмотр картинок
![N|Solid](https://github.com/dmitryandreevich/ext-filestore-manager/blob/imgs/images/image-viewer.png?raw=true)
##### Смена хранилища
![N|Solid](https://github.com/dmitryandreevich/ext-filestore-manager/blob/imgs/images/change-store.png?raw=true)

