# php-simple-template
Is a very basic and simple PHP HTML Template handler ideal for simple projects which don't require a lot of complicated functions.

It is good practice to separate HTML from PHP code and while there is a multitude of template handlers out there, they can be massively overly complicated for what you may need.

I created this class several years ago and have updated it to work with PHP7 recently and provided it here in the hope you may find it useful.

## Usage
Please see the example file for a demonstration of it's usage, a more detailed description is below for anyone just starting out with PHP.

## Template Files
Can be as many or as few as you require. You can use nested templates or at the most basic level you can simply have an entire HTML page in one template file.

Each template file can contain multiple Variables and Sub Templates which are defined using the method below;

### Variables in Template Files
You define a variable in the template file using curly-braces "{{" and "}}". Your variable can only contain the letters a-z and can be a mixture of upper and lowercase characters. {{strUserName}} or {{intUserName}} or {{myUserName}} are all valid.

Variables can be called whatever you want but it's a good idea to develop a naming convention you like and stick to it.

### Sub Templates
You can define Sub Templates using the square-brackets "[[" and "]]". Sub Templates can only exist within the top level of the template (you can not nest sub templates).

To define a sub template you need to have an opening tag eg. [[Error]] and a closing tag eg. [[/Error]], anything including variables between the two tags will be treated as a sub template called Error.

Sub Templates can be called whatever you want, but can only contain letters a-z.

## Using the Template Class
To use the class include the class.template.php file within your code or copy and paste it into an existing include file on your code and then assign the class to a variable.

```php
require_once ( "class.template.php" );
$tpl = new Template ( 'PATH_TO_TEMPLATE_DIRECTORY' );
```

### Load a Template file
Template Files should be placed in to a template directory that you have
specified in the class constructor. Template files can be called whatever you want, but I recommend using .tpl for consistency.

```php
$tpl->load ( "mytemplatename", "page.tpl" );
```

* Argument 1: An internal name to refer to your template - it must be unique to the current execution or it will be over written.
* Argument 2: Name of the template file

### Assign a Value to a Variable
To assign a value to a variable you use the below code;

```php
$tpl->add_var ( "variableName", "Variable Text Goes Here" );
$tpl->add_var ( "anotherVariable", $something );
$tpl->add_var ( "yetAnotherVariable", "Something: " . $something );
$tpl->add_var ( "fourthVariable", "You can have {{variableName}} variables within variables like this", true );
```

* Argument 1: Name of variable to replace<
* Argument 2: Data to replace variable with
* Argument 3 **[OPTIONAL]**: Set to true to replace variables within your string with their pre-set values - variable must have been previously set or it will be null.

**Note: If a variable within a template hasn't been defined before you call the build method, it will be treated as null and generate a notice level warning.**

### Sub Sections
Sub sections can be used for repeating sections, such as table rows or other data that is generated on the fly from a database.

Sub Sections are automatically replaced by a temporary variable starting with tplSub followed by the sub-section name, for example {{tplSubError}} or {{tplSubRow}} or {{tplSubUsers}} or {{tplSubTableData}} which would refer to sub sections called; Error, Row, Users, TableData respectively.

As they are replaced with temporary variables you can write to them as you would any other variable, however to use it for iteration you can "build" the sub template and assign it to the temporary variable as per below;

```php
$tmp = ""; //Create a temporary variable to hold your repeating data

//Do your repeating section, assigning the repeating data to variables that exist within your sub section.

while ( $tD = mysqli_result_array ( $query ) ) {
  $tpl->add_var ( "myName", $tD[0] );
  $tpl->add_var ( "mySurname", $tD[1] );

  // Build the Sub Template and append it to our temporary variable
  $tmp .= $tpl->build ( "mainTemplateName.subTemplateName" );
}

// Once finished repeating section, assign the temporary variable to the temporary sub-section variable.
$tpl->add_var ( "tplSubsubTemplateName", $tmp );
```
