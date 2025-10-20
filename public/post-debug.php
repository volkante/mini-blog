<?php
echo '<pre>';
var_dump($_POST);
echo '</pre>';
?>
<form method="post">
    <label for="baslik">Başlık</label>
    <input name="title"><br>
    <label>İçerik</label>
    <textarea name="content"></textarea><br>
    <button type="submit">Gönder</button>
</form>
