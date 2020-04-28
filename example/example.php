<?php
/***
 * A Really Simple PHP Template Class
 * Author: Alistair Baillie
 *
 * Copyright 2012 - 2020 Alistair Baillie
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ***/
 require_once ( "../class.template.php" ); // Include the class.template.php file

 /***
  * Create your template instance and assign it to a variable
  * The constructor expects a single arguement which is a string
  * containing the path to your Template Directory - it is a good
  * idea to ensure this is a fixed path from your server root.
  * eg: 'C:\\inetpub\\wwwroot\\tpl\\' on windows.
  ***/
 $tpl = new Template ( '/path/to/template/directory/' );

 /***
  * Load the template we wish to use
  * First Arguement: A name identifying this template (it can be whatever
  * you want as long as it is unique to the current execution.
  *
  * Second Arguement: File name within the defined template directory.
  * You can also use sub directories too such as 'email/registration.tpl'
  * File extension can be whatever you want - as long as it matches your
  * file.
  ***/
  $tpl->load ( "page", "example.tpl" );

  /***
   * Assign a value to a variable
   * First Arguement: Variable name in the template
   * Second Arguement: String to assign
   ***/
  $tpl->add_var ( "pageTitle", "Template Example Usage" );
  $tpl->add_var ( "pageTextExample", "This is the second paragraph <b>it is generated</b> by the PHP script as an example." );

  /***
   * Example of iteration (such as database result) using a
   * sub-template within the main template.
   *
   * This example just adds 10 rows to the table
   ***/
  $tmp = "";
  for ( $a = 0; $a < 10; $a++ ) {
    $tpl->add_var ( "iCounter", $a );
    $tpl->add_var ( "iCounter2", "This is just an example (" . $a . ") Showing how to iterate." );
    $tmp .= $tpl->build ( "page.Row" ); // <loaded template name>.<sub template name in the file>
  }
  $tpl->add_var ( "tplSubRow", $tmp ); // Assigns the contents of $tmp to the sub template

  /***
   * Return our page to the browser
   * Single arguement which is the template to "build" using the name
   * provided when loading.
   ***/
  echo $tpl->build ( "page" );
?>
