<?php

$tim = time() -(9 * 24 * 60 * 60);
echo $tim.'</br>';

echo date("d:m:Y H:i:s",$tim).'</br>';

echo date("d:m:Y H:i:s",time()).'</br>';