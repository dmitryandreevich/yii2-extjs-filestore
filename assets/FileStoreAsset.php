<?php
/**
 * Created by PhpStorm.
 * User: Dmitry Andreevich
 * Date: 09.10.2018
 * Time: 15:39
 */

namespace app\assets;


use yii\web\AssetBundle;
use yii\web\View;

class FileStoreAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = ['fileStoreApp/microloader.js','fileStoreApp/app.js'];
}