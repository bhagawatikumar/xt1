<?php
$opts = getopt("u:p:");
print_r($opts);
if(isset($opts['u']) && $opts['u'] != ''){
    if(isset($opts['p']) && $opts['p'] != ''){
        
    }else{
        echo "Password : ";
        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);
        if(trim($line) != 'yes'){
            echo "ABORTING!\n";
            exit;
        }
        echo "\n"; 
        echo "Thank you, continuing...\n";
    }
}else{
   echo "Username : ";
   $handle = fopen ("php://stdin","r");
   $line = fgets($handle);
   if(trim($line) != 'yes'){
      echo "ABORTING!\n";
      exit;
   }
   if(isset($opts['p']) && $opts['p'] != ''){
        
    }else{
        echo "Password : ";
        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);
        if(trim($line) != 'yes'){
            echo "ABORTING!\n";
            exit;
        }
        echo "\n"; 
        echo "Thank you, continuing...\n";
    }
    
    
}
//echo "Are you sure you want to do this?  Type 'yes' to continue: ";
//$handle = fopen ("php://stdin","r");
//$line = fgets($handle);
//if(trim($line) != 'yes'){
//    echo "ABORTING!\n";
//    exit;
//}
//echo "\n"; ";
//echo "Thank you, continuing...\n";
?>