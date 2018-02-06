# Symfony Project Configuration


### Requirements for server:
* Composer 
* PHP needs to be a minimum version of PHP 7.0
* GD libaray extension needs to be enabled
* JSON extension needs to be enabled
* Ctype extension needs to be enabled
* Required for unit Test PHPUnit 6.1.x  follow  for instalation https://phpunit.de/

### Configuration Todo:

1. Clone this repo  https://github.com/khanmuhammad/symfony3.2
2. got to repo  and Run **composer update** 
3. Setup  database credential and SMTP Credential in   app/config/parameters.yml.
4. if database is not created run **php bin/console doctrine:database:create**
5. Run following  command  **php bin/console doctrine:migrations:migrate** for DataBase structure and schema creation
6. Now you can run project.
 
 ### Additional  Configuration :
 in (app/config/config.yml)
 * For attachment saving folder change parameter is attachments.  
 * For email from ID change parameter is email_from. 
 * for email subject change parameter is  email_subject.
 
 
#### Front page:
On the front page applicants can insert their name, email address and attach a document.

All field are mandatory.

There is no restrication about file format in attachment.

On submit an email is sent to the applicant with something like "Dear Applicant Name, 
Thanks for your application! we will get back to you as fast as we can.".

Everything is saved in an MySql Database.

System will show the message application submitted.

#### Admin page
This is a secured area. After logging in (user: lengoo, password: lengoo) you will see a List with all applications. By clicking on one you can see the details from the form, the creation time and you download the attachment. And there is a Logout.


#### Unit Test
* Run Unit test  **phpunit tests/AppBundle/Controller/**
