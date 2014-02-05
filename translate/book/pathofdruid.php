<?php
/**
* kindle笔记导出成html
*/

/* 欲导出电子书id */
$bookId = 'AMZNID0/B005HVKYCG/0/';

/* 导出目录 */
$exportPath = '/sdcard/大地行者/小德/translate/book';

/* 导出html文件名 */
$htmlName = 'pathofdruid.zhcn.html';

/* 复制笔记数据库文件名 */
$dbName = 'pathofdruid.db';

/* 复制php文件名 */
$phpName = 'pathofdruid.php';

/* kindle笔记数据库路径 */
$noteDbPath = '/data/data/com.amazon.kindle/databases/annotations.db';

/* 以下无需修改 */
header("Content-Type: text/html; charset=utf-8");
//复制php和db文件
copy($noteDbPath, "$exportPath/$dbName");
copy(__FILE__, "$exportPath/$phpName");
$fp = fopen("$exportPath/$htmlName", 'w');

$db = new pdo("sqlite:$noteDbPath");

$sql = "SELECT USER_TEXT FROM Annotations WHERE TYPE=1 AND BOOKID='$bookId' ORDER BY START_POS ASC";
$rs = $db->query($sql);
while(false !== $data=$rs->fetch(PDO::FETCH_NUM))
{
    echo $data[0];
    fwrite($fp, $data[0]);
    if (preg_match('!</\w+>$!s', $data[0])) {
        echo "\n";
        fwrite($fp, "\n");
    }
}
fclose($fp);