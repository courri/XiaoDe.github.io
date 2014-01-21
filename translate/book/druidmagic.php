<?php
header("Content-Type: text/html; charset=utf-8");
$txt = '/sdcard/大地行者/小德/translate/book/druidmagic.zhcn.html';
$sqlite = '/data/data/com.amazon.kindle/databases/annotations.db';
copy($sqlite, dirname($txt).'/druidmagic.db');
copy(__FILE__, dirname($txt).'/druidmagic.php');
$fp = fopen($txt, 'w');
fwrite($fp, $css = <<<HTML
<!doctype html>
<meta charset="utf-8">
<style type="text/css">
  p {text-indent:2em}
  p.quote {font-style:italic}
</style>

HTML
);

echo $css;

$db = new pdo('sqlite:'.$sqlite);

$sql = 'select USER_TEXT from Annotations WHERE TYPE=1 AND BOOKID=\'AMZNID0/B00352M8LE/0/\' ORDER BY START_POS ASC';
$rs = $db->query($sql);
while(false !== $data=$rs->fetch(PDO::FETCH_NUM))
{
    echo $data[0];
    fwrite($fp, $data[0]);
}
fclose($fp);