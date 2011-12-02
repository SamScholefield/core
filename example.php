<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Core.php Test Page</title>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>

<?php
  
  /**
   * Test and example page for Core.php
   */



  //============= Setting up ==============================

  // Define IN_SCRIPT
  define('IN_SCRIPT', 'what the hell');

  // include the class definition
  require_once 'core.php';

  // Use getInstance rather than "new Core()"
  $core = Core::getInstance();

  $core->startTimer();
  
  
  
  // =============== Write out some arrays ==================
  $test = array(1, 
                2, 
                'foo', 
                'bar', 
                array(5, 6, 7), 
                $core,
                'this' => 'that',
                'true' => false);

  echo '<h2>Using write()</h2>';
  echo $core->write($test, 'test');

  echo '<h2>Using writeArrayNicely()</h2>';
  echo $core->writeArrayNicely($test);

  // Note: The globals variable contains a reference to itself
  //       writeArrayNicely() contains a workaround to prevent
  //       infinite recursion. However this only works for the
  //       $GLOBALS array - it's not a generic fix!
  echo $core->writeArrayNicely($GLOBALS);


  
  
  // ================ Create table for test data ==========
  echo 'Creating test table... ';
  $create_sql = 'CREATE TABLE IF NOT EXISTS test_table 
                  (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                    name TEXT
                  )';
  $result = $core->executeSQL($create_sql);
  if ($result) {
    echo 'Success!<br>';
  } else {
    echo 'Problem creating test table. Exiting...';
    exit();
  }



  
  // ================ Insert some data ====================
  echo 'Inserting some user data... ';
  $insert_sql = "INSERT 
                 INTO test_table 
                   (name)
                 VALUES
                   ('Alice')";

  $result = $core->executeSQL($insert_sql);
  if ($result) {
    echo 'Success!<br>';
  } else {
    echo 'Error inserting names. Exiting...';
    exit();
  }

  

  
  // ================ Select some data ====================
  echo 'Selecting some data... ';
  $select_sql = 'SELECT id, name FROM test_table';

  $data = $core->executeSQL($select_sql);

  if (!is_array($data)) {
    die('No results found.');
  } else {
    echo 'Success! <br>';
    // Dump the data variable between <pre> tags
  $core->write($data);

  // Display $data in nice nested divs
  echo $core->writeArrayNicely($data);
  }


  
  
  // ================ Delete the data =====================
  echo 'Deleting data... ';

  $delete_sql = 'DELETE FROM test_table';

  $result = $core->executeSQL($delete_sql);

  echo 'Success! <br>';


  
  
  // ================ Dropping table ======================
  echo 'Dropping test table... ';
  $drop_sql = 'DROP TABLE test_table';
  $result = $core->executeSQL($drop_sql);
  if ($result) {
    echo 'Success! <br>';
  } else {
    echo 'Failed. Exiting.';
    exit();
  }

  
  
  
  // ================ Get Timer ===========================
  echo '<br>That all took '.$core->getTime().' seconds. <br><br>';
  echo 'If you\'re reading this then everything worked!';

?>

</body>
</html>