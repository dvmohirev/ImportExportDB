
<?php
require "db.php";
require "export.php";
require "import.php";
include "templates/header.php";

$connect = new db();
$link = $connect->connectWithDB();

$exportToFile = new export();
$importToBase = new import();

//Описание каждого файла - суть его работы

?>
    <body>
    <div class="container">
        <h1>Страница для импорта CSV файла в базу данных и экспорта CSV файла из базы данных</h1>
        <br>
        <h3>Выберите CSV файл для импорта с помощью кнопки "Browse"</h3>
        <br>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFileInput" aria-describedby="customFileInput" name="file">
                    <label class="custom-file-label" for="customFileInput">Select file</label>
                </div>
                <div class="input-group-append">
                    <input type="submit" name="submit_to_import" value="Upload" class="btn btn-primary">
                </div>
            </div>
        </form>
        <?php
        if (isset($_POST['submit_to_import'])) {
            $importToBase->importToDB($link);
        } ?>
    </div>
    <br>
    <div class="container">

        <h3>Нажмите кнопку "Экспорт в CSV файл", чтобы выгрузить файл в папку с программой</h3>
        <br>
        <form method="POST">
            <input type="submit" name="export_to_CSV" value="Экспорт в CSV файл" />
        </form>
        <?php
        if(isset( $_POST['export_to_CSV'] )){
            $exportToFile->my_update_record($link);
        } ?>
    </div>

<?php include "templates/footer.php";?>