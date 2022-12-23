<?php

require "handlerFieldsOfForm.php";

class import
{
    //Предположим что в сессии есть ключ user_id, в котором лежит id авторизованного пользователя, который совершает импорт.
    private $randomUserID;
    public function __construct()
    {
        $this->randomUserID = rand(1,3);
    }
    var $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );

    function importToDB($connect){
            // Проверяем, является ли выбранный файл CSV-файлом
            $insertNewProducts = 0;
            $updateProducts = 0;
            $handlerForm = new handlerFieldsOfForm();
            if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $this->fileMimes)) {
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                // Пропускаем первую строку с названиями столбцов
                fgetcsv($csvFile);
                // Парсим (разбираем) данные из файла CSV построчно
                while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                    // Получаем данные строки из файла
                    $id = $getData[0];
                    $name = $getData[1];
                    $name_trans = $getData[2];
                    $price = $getData[3];
                    $small_text = $getData[4];
                    $big_text = $getData[5];

                    //Обработка поля small_text
                    $small_text = $handlerForm->rightSmallText($small_text, $big_text);
                    $resultFromBD = mysqli_query($connect, "SELECT id, user_id FROM test_product WHERE id = $id AND user_id = $this->randomUserID")->fetch_array() ;

                    $requestUpdateDB = "UPDATE test_product SET name = '$name', name_trans = '$name_trans', price = '$price', 
                        small_text = '$small_text', big_text = '$big_text' WHERE id = $id AND user_id = $this->randomUserID";

                    $requestInsertToDB = "INSERT INTO test_product (id, name, name_trans, price, small_text, big_text, user_id) VALUES(
                        '$id', '$name', '$name_trans', '$price', '$small_text', '$big_text', '$this->randomUserID')";
                    if($id !== $resultFromBD[0]){
                        mysqli_query($connect, $requestInsertToDB);
                        $insertNewProducts++;
                    } else if($this->randomUserID == $resultFromBD[1]){
                        mysqli_query($connect, $requestUpdateDB);
                        $updateProducts++;
                    } else {
                        mysqli_query($connect, $requestInsertToDB);
                        $insertNewProducts++;
                    }
                }
                // Закрываем открытый CSV-файл
                fclose($csvFile);
                echo "Сейчас импорт выполняется пользователем под User_id $this->randomUserID<br>";
                echo "Загрузка данных из CSV файла в БД выполнена успешно. ". "Добавлено " . $insertNewProducts . " / Обновлено " . $updateProducts . "<br>";

            } else {
                echo "Пожалуйста выберите CSV файл для импорта";
            }
    }
}