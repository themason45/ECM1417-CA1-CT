# ECM1417-CA1-CT

## Project setup

I used PHPStorm to develop this project, so all the testing was done in the environment generated there.
An important thing to note is the version of PHP that I used, which is `php8.0`.

To use the live version, go to the url:

http://ml-lab-4d78f073-aa49-4f0e-bce2-31e5254052c7.ukwest.cloudapp.azure.com:58399/

## To run the external server:

The external server is a substitute for the Web Api that is used in the actual project.
Of course that API is off most of the time, so a local version is required.

`cd ext_service & php -S 0.0.0.0:8001`