# SpeakLikeABrazilian.com website

Speak Like A Brazilian is a web site that helps you to learn common 
expressions used in Brazilian Portuguese, in a interactive way. You 
can vote and share your favourite expressions, as well as subscribing 
to our mailing list or playing some of our games.

The original code was developed by TupiLabs and Open Sourced in 2013.

## Contributing

First of all, the major contribution are your expressions. Should you know 
any Brazilian slang or expression, feel free to post it on SpeakLikeABrazilian.com 
and explain how other people could use it too.

For sending code improvements, bug fixes or reporting bugs, please use 
GitHub's Pull Requests and issues.

## Licensing

The code is licensed under MIT License. It uses other Open Source frameworks, 
API's and libraries. These tools have different licenses.

## Developing

The project uses CodeIgniter, a PHP web framework, in conjunction with Composer 
and packages, Sparks and sparks, and libraries and helpers. Below a complete list 
of what is being used in Speak Like A Brazilian (thanks to everyone who 
contributes to Open Source).

*Server side*

- CodeIgniter
- Custom MY_Controller for Twiggy and UI utilities
- Custom MY_Router for handling folders within the controllers folder
- Ion Auth
- Secureimage
- Sparks
- Twiggy
- Composer
- Monolog
- PieCrust

In order to run SLBR in your local computer, you will have to:

- Create a MySQL database and update application/config/database.php
- Import application/documentation/database/ion-auth/ion_auth.sql
- Import application/documentation/database/schema.sql

Take a look at the controllers (application/controllers) and in the 
Twig/gy templates (application/themes/), as well at the database models 
(application/models).

*UI*

- FlatStrap

The default controller **is home** and not **welcome**.