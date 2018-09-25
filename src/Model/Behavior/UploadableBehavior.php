<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class UploadableBehavior extends Behavior {

  public function upload($file = array()) {
    $dir = ROOT . DIRECTORY_SEPARATOR . 'files';

    if(($file['error']!=0) and ($file['size']==0)) {
       throw new NotImplementedException('Alguma coisa deu errado, o upload retornou erro '.$file['error'].' e tamanho '.$file['size']);
   }

   $this->create_directory($dir);
   $file = $this->create_name($file, $dir);
   $this->move_file($file, $dir);

   return $file['name'];
  }

  public function create_directory($dir) {
    $folder = new Folder();
    if (!is_dir($dir)) {
      $folder->create($dir, 0755);
    }
  }

  public function create_name($file, $dir) {
    $fileinfo = pathinfo($dir . DIRECTORY_SEPARATOR . $file['name']);
    $filename = 'file' . md5(uniqid(rand(), true)) . '.' . $fileinfo['extension'];
    while(file_exists($dir . DIRECTORY_SEPARATOR . $filename)) {
      $filename = 'file' . md5(uniqid(rand(), true)) . '.' . $fileinfo['extension'];
    }
    $file['name'] = $filename;
    return $file;
  }

  public function move_file($file, $dir) {
    $newfile = new File($file['tmp_name']);
    $newfile->copy($dir . DIRECTORY_SEPARATOR . $file['name']);
    $newfile->close();
  }
}
