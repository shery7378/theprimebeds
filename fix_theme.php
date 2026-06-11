<?php
$content = shell_exec("git show HEAD:resources/views/front/themes/theme1.blade.php");
file_put_contents("resources/views/front/themes/theme1.blade.php", $content);
echo "Restored theme1.blade.php from git HEAD.";
