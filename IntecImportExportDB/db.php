<?php
/*Устанавливаем связь с базой данных
Нужно указать $servername, $username, $password, $dbname;
*/
class db
{
    public function __construct()
    {
    }

    function connectWithDB(){
        $servername='localhost';
        $username='root';
        $password='';
        $dbname = "intec_test";
        $link = mysqli_connect($servername,$username,$password,"$dbname");
        if(!$link){
            print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
        }
        return $link;
    }

}