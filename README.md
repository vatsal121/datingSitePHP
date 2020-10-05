# Dating Site PHP

###Project Demo
<div align="center" style="width: 100%">

![project-demo-gif](project-demo.gif)

</div>

<div align="center">
    <a href="https://php.net">
        <img
            alt="PHP"
            src="https://www.php.net/images/logos/new-php-logo.svg"
            width="150">
    </a>
</div>


Dating site is a simple dating site built using PHP.

  - PHP
  - HTML5, Bootstrap 4
  - MySQL as Database

### Installation

  - To run the project, clone it on your computer.
  - Create a Database with name "datingDB" in phpMyAdmin or MySQL Workbench.
  - Import the datingDB.sql file from the root of the project directory into your phpMyAdmin or MySQL Workbench.
  - Set up your Database credentials in the file located at "./Connector/DbConnectorPDO.php".
  - Run the project from your favourite IDE or put it in the "WWW" folder of WAMP or XAMPP. 


### Helper Functions

- Helper Functions are located in "./helper/helperFunctions.php
- Helper functions contains some common functions which are used globally in the site to improve code readability.
- Example: IsVariableIsSetOrEmpty($variableName) : Checks if variable is set and not empty. Returns TRUE or FALSE.