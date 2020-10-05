# Dating Site PHP by Vatsal Chauhan and Meet Patel

<div align="center">
    <h3>Project Demo</h3>
</div>

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


### Dating site is a simple dating site built using PHP.

  - PHP
  - HTML5, Bootstrap 4
  - MySQL as Database

### Project Demo
    - Video file is located at the root directory named "dating-site-working-demo.mp4".
    - GIF file is located at the root directory named "project-demo.gif".
    - Database file is located at the root directory named "datingdb.sql".



### Installation

  - To run the project, clone it on your computer using the following command or download the project as zip directly.
  	
	`git clone https://github.com/vatsal121/datingSitePHP.git`
  
  - To add the database, Import the "datingDB.sql" file which contains pre-entered data and test users from the root of the project directory into your phpMyAdmin or MySQL Workbench.
  - Set up your Database credentials in the database file located at "./Connector/DbConnectorPDO.php".
  - Run the project from your favourite IDE or put it in the "WWW" folder of WAMP or XAMPP. 

                    
### Test Credentials

Email  | Password | UserRole 
------------- | ------------- | -------------
meet@gmail.com  | test | premium user
vatsal@gmail.com  | test | premium user
justin@gmail.com  | test | regular user
janki@gmail.com  | test | regular user
mariadb@gmail.com  | test | regular user
angelpriya@gmail.com  | test | regular user
testing@gmail.com | test | premium user

### Helper Functions

- Helper Functions are located in "./helper/helperFunctions.php
- Helper functions contains some common functions which are used globally in the site to improve code readability.
- Example: IsVariableIsSetOrEmpty($variableName) : Checks if variable is set and not empty. Returns TRUE or FALSE.


### Features

- Register Page : 
	- 1) This page has a form with validation 
	- 2) In this page user has to give his Email-id ,First name ,Last name ,Password ,City ,Birth Of date ,Gender and Image.
	- 3) All the field in this is compulsory
	- 4) There is Password and Confirm password field  both the field value matches then it will register or else it will show an error
			
			Example : 
			Email-Id : testing@gmail.com
			First Name : Test
			Last Name : User
			Password: test
			Confirm Password: test
			City: Montreal			
			Date of Birth: 05/12/1995
			Image: url
			Gender: male
			
	- 5) When a user selects an image, a preview will be shown of the image to the user.

- Login Page : 
	- 1) This Page has a form with validation
	- 2) If user enter wrong password then it will show an error
	- 3) Successful Email id and Password will give access to the website	
	      
	      Example: 
		  Email-Id : testing@gmail.com
		  Password: test 

- Become Premium Member Page:
	- 1) User should add his/her card detail to pay the membership fee
	-  2) Once validated user will become premium user

- Chat User Page : 
	- 1) Logged in user can chat to other users. 
	- 2) If user has a premium membership then user can see whether other user has read the messasge or not
	- 3) Winks sent from the profile page will be also sent into the chat directly.

- View-Profile : 
	- 1) In this page user can search the another user with First Name, City , Age and Gender.
	- 2) If the user is not logged in then user can only view the other user profiles but won't be able to send wink or messages or add them to their favourite list.
	- 3) User can search also for another user without logged in.
	- 4) To Chat with other user, user needs to be logged in to the website.
	- 5) User has a premium account then user can see whether the other user has read the message or not. 
	- 6) While having a premium account they can also add other users to their own favourite list and can also see who added them.
	- 7) User can send wink to other users directly.
	- 8) "Send wink" button will send the wink to the chat directly.

- Edit-Profile : 
	- 1) In this page, user can see and update their details.
	- 2) Here user can also update their profile image.

- Favourite Page: 
	- 1) In this page user can able to see whom they have marked favourite or other users that marked them favourite.
	- 2) User can remove the person from that list.



### Task Distributions

##### The functionality achieved in the following pages are fully implemented by us individually.

- Vatsal Chauhan
                    
Pages  | Folders 
------------- | -------------
DbConnectionPDO.php  |  Connector Folder 
helperFunctions.php  |  helper Folder 
view-profiles.php  |  root Folder 
become-premium-member.php  |  root Folder 
chat-users.php  |  root Folder 
logout.php  |  root Folder 


- Meet Patel
                    
Pages  | Folders 
------------- | -------------
login.php  |  root Folder 
register.php  |  root Folder 
edit-profiles.php  |  root Folder 
favourite_list.php  |  root Folder

##### The functionality achieved in the following pages are fully implemented by us both.

- Tasks By Vatsal Chauhan and Meet Patel combined
                    
Pages  | Folders 
------------- | -------------
header.php  |  include Folder 
nav-var.php  |  include Folder 
footer.php  |  include Folder 
style.css  |  css Folder
site_images,user_images | images Folder
index.php | root Folder

### Database Designed by Vatsal Chauhan and Meet Patel

