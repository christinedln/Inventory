<?php
echo "Installed PHP Extensions:\n";
print_r(get_loaded_extensions());
echo "\n\nPDO Drivers:\n";
print_r(PDO::getAvailableDrivers());
?>
