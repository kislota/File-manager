<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileManager extends Model {
    /*
     * Обрабатываем запрос с путём к нужной директории и выводим нужную инфу
     */

    public static function dirAll($path) {
        $path = FileManager::dirUrl($path); //Формирование ссылок
        $arr = FileManager::getDisk($path['path_url']); //Массив папок и файлов

        return [
            'root' => $path['root'], //Для ссылок в списке папок
            'back' => $path['back'], //Ссылка для кнопки назад
            'top' => $path['top'], //Путь для отображения
            'dirname' => $arr['dirall'], //Массив папок
            'file' => $arr['files'], //Массив файлов
        ];
    }

    /*
     * Получаение размера файла с приставкой размера
     */

    public static function getFileSize($files) {
        $filesize = filesize(storage_path('app\public\web\\' . $files));
        if ($filesize > 1024) {
            $filesize = ($filesize / 1024);
            if ($filesize > 1024) {
                $filesize = ($filesize / 1024);
                if ($filesize > 1024) {
                    $filesize = ($filesize / 1024);
                    $filesize = round($filesize, 1);
                    return $filesize . " GB";
                } else {
                    $filesize = round($filesize, 1);
                    return $filesize . " MB";
                }
            } else {
                $filesize = round($filesize, 1);
                return $filesize . " KB";
            }
        } else {
            $filesize = round($filesize, 1);
            return $filesize . " byt";
        }
    }

    /*
     * Провераяем на правильность имени папки
     */

    public static function dirNameAllow($dir) {
        foreach ($dir as $key => $folder) {
            $dirtmp = explode('/', $folder);
            $folder = array_pop($dirtmp);
            $f = preg_match('/[0-9]+/', $folder);
            if (!$f) {
                $dirall[$folder] = 'Allow';
            } else {
                $dirall[$folder] = 'Deny';
            }
        }
        return $dirall;
    }

    /*
     * Получаем массив папок и файлов
     */

    public static function getDisk($path) {
        $d = Storage::disk('web');
        $f = $d->files($path);
        if (!$f) {
            $files = null;
        } else {
            foreach ($f as $key => $file) {
                $files[$key]['size'] = FileManager::getFileSize($file);
                $files[$key]['name'] = $file;
            }
        }
        $dir = $d->directories($path);
        if (!$dir) {
            $dirall = null;
        } else {
            $dirall = FileManager::dirNameAllow($dir);
        }
        return compact(['files', 'dirall']);
    }

    /*
     * Получаем ссылки для вывода
     */

    public static function dirUrl($path) {
        $path_url = preg_replace("/&/", '/', $path);
        if ($path) {
            $back = FileManager::backUrl($path); //Значениедля кнопки назад
            $path .= '&';
            $top = $path_url; //Сообщение если нет папок для верхнего уровня
        } else {
            $back = null; //Значение по умолчанию для кнопки назад что бы не отображать
            $top = 'Корневая директория'; //Сообщение если нет папок для верхнего уровня
        }

        return [
            'root' => $path,
            'back' => $back,
            'top' => $top,
            'path_url' => $path_url,
        ];
    }
/*
 * Делаем ссылку назад
 */
    public static function backUrl($path) {
        $pref = null;//Определяем ссылку для префикса
        $path = explode('&', $path);//Смотрим на сколько ушли
        if (count($path) != 1) {//Если ушли далеко
            for ($i = 0; (count($path) - 1) > $i; $i++) {//Формируем обратный путь
                $back .= $pref . $path[$i];//Добавляем значение ссылки и префикс разделителя
                $pref = '&';//Определяем разделитель
            }
        } else {
            $back = '/';//Если ушли не далеко остаёмся в корне
        }


        return $back;
    }

}
