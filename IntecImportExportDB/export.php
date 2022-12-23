<?php

class export
{
    public function __construct()
    {
    }

    function my_update_record($conn){

        $fp = fopen('export.csv', 'w');
        fputcsv($fp, array('id', 'name', 'name_trans', 'price', 'small_text', 'big_text', 'user_id'));
        $result = $conn->query("SELECT * FROM test_product");
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        echo "Данные из БД в файл CSV выгружены успешно"."<br>";
    }
}