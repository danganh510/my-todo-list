<?php

// Define an autoloader function
function autoloader($class) {
  // Create an array of directories to be autoloaded
  $autoLoad = array(
    'MyTodoList\Models' => __DIR__ . '/../apps/models/',
    'MyTodoList\Controllers' => __DIR__ . '/../apps/controllers/'
  );
  
  $arrNameSpace = explode("\\",$class);
  
  $class = $arrNameSpace[count($arrNameSpace) - 1];
  
  unset($arrNameSpace[count($arrNameSpace) - 1]);
  
  $name_space = implode("\\",$arrNameSpace);
  
  $class = str_replace('\\', '/', $class) . '.php';
  // Make sure the class file exists
  if (file_exists($autoLoad[$name_space] . $class)) {
    // Include the class file
    include $autoLoad[$name_space] . $class;
  }
}

// Register the autoloader function
spl_autoload_register('autoloader');
