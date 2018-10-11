<?php
/**
 * Created by PhpStorm.
 * User: Dmitry Andreevich
 * Date: 25.09.2018
 * Time: 19:17
 */

namespace app\controllers;


use app\models\Files;
use League\Flysystem\Filesystem;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\UploadedFile;

class MainController extends Controller
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    public function __construct($id, Module $module, array $config = [])
    {
        $selectedStore = Yii::$app->request->post('selectedStore');

        $this->fileSystem = Yii::$app->get( $selectedStore == 'S3' ? 'awss3Fs' :'fs' );

        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetFilesData()
    {
        $path = Yii::$app->request->post('path');
        $content = $this->fileSystem->listContents($path);

        echo json_encode($content, JSON_FORCE_OBJECT);
        exit;
    }

    public function actionDelete()
    {
        $type = Yii::$app->request->post('type'); // dir or another file
        $path = Yii::$app->request->post('path');

        if( isset($path) && !empty($path) ) {
            if( isset($type) && !empty($type) ){
                if( $this->fileSystem->has($path) ){

                    if($type === 'dir')
                        $this->fileSystem->deleteDir($path);
                    else
                        $this->fileSystem->delete($path);
                }
            }
        }
    }

    public function actionNewFolder()
    {
        $folderName = Yii::$app->request->post('name');
        $path = Yii::$app->request->post('path');

        if( isset($folderName) && !empty($folderName) ) {

            if(! $this->fileSystem->has("$path/$folderName"))
                $this->fileSystem->createDir("$path/$folderName");
        }
    }

    public function actionRename()
    {
        $path = Yii::$app->request->post('path');
        $newPath = Yii::$app->request->post('newPath');

        if( isset($path) && isset($newPath) ) {

            if( $this->fileSystem->has($path) )
                $this->fileSystem->rename($path, $newPath);
        }
    }

    public function actionGetContent()
    {
        $path = Yii::$app->request->post('path');

        if( isset($path) ) {

            if( $this->fileSystem->has($path) ){
                $file = $this->fileSystem->get($path);

                if($file->getType() !== 'dir') {
                    $content = $file->read();
                    $response = [
                        'type' => $file->getMimetype(),
                        'basename' => basename($this->fileSystem->path . '/' . $path),
                        'content' => strstr($file->getMimetype(), 'image') ? base64_encode($content) : $content
                    ];

                    echo json_encode($response);
                    exit;
                }
            }
        }
    }

    public function actionCreateOrRewriteFile()
    {
        $path = Yii::$app->request->post('path');
        $content = Yii::$app->request->post('content');

        if( isset($path) && isset($content) ) {

            if( $this->fileSystem->has($path) )
                $this->fileSystem->update($path, $content);
            else
                $this->fileSystem->write($path, $content);

            echo $path;
            exit;
        }
    }

    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('file');
        $pathToSave = Yii::$app->request->post('path');

        if($file) {
            $tmpPath = $file->tempName;
            $content = file_get_contents($tmpPath);
            $pathToSave .= '/' . $file->getBaseName() . '.' . $file->getExtension();
            $this->fileSystem->write($pathToSave, $content);
        }
    }

    public function actionUploadToDb(){
        $uploadedFile = UploadedFile::getInstanceByName('file');

        if($uploadedFile) {
            $content = file_get_contents($uploadedFile->tempName);

            $file = new Files();
            $file->name = $uploadedFile->getBaseName();
            $file->extension = $uploadedFile->getExtension();
            $file->content = $content; // AS BLOB
            $file->size = $uploadedFile->size;
            $file->save();
        }
    }
}