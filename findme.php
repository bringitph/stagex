<?php
$command = "grep -ri 'findme' ./*";
$output = shell_exec($command);
echo "$output";
echo "Grep job over.";
?>