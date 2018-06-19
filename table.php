<?php
    require_once 'app.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Database editor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <?php $tabName = $controller->getTabName(); ?>
    <h1>Добавить столбец в таблицу "<?= $tabName ?>"</h1>
    
    <form action="" method="post" accept-charset="utf-8">
        <input type="text" name="name" value="" placeholder="Имя столбца">
        
        <select name="type">
            <?php foreach($db->getAllowedTypes() as $gname => $group) : ?>
                <optgroup label="<?= $gname ?>">
                    <?php foreach($group as $type) : ?>
                        
                        <option value="<?= $type ?>"><?= $type ?></option>
                    <?php endforeach ?>
                </optgroup>
            <?php endforeach ?>
        </select>
        
        <input type="text" name="type_value" value="" placeholder="Длина/Значения">
        
        <label>
            <input type="checkbox" name="nullable" value="1">
            NULL
        </label>
        
        <hr>
        <button type="submit" name="add_column" value="1">Добавить столбец</button>
    </form>
</div>
</body>
</html>
    /**
     * Created by PhpStorm.
     * User: konstantin
     * Date: 16.06.2018
     * Time: 12:28
     */