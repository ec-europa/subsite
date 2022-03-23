CONTENTS OF THIS FILE
---------------------

* Introduction
* Requirements
* Configuration
* Local Installation
* Maintainers

INTRODUCTION
------------

Integrates Open Social with the European Commission CAS account provider.

When someone signs in or registers through EU Login a user account is
automatically created with:

* Username
* Email
* First name
* Last name
* Organization

REQUIREMENTS
------------

This module requires the following modules:

* [OE Authentication](https://github.com/openeuropa/oe_authentication)
* [CAS](https://www.drupal.org/project/cas)

It is basically a custom implementation of the

* [User Fields submodule](https://github.com/openeuropa/oe_authentication/tree/master/modules/oe_authentication_user_fields)

CONFIGURATION
-------------

Customize the OE Authentication in:

* Administration » Configuration » System » Authentication settings

Change **Application assurance level** to **LOW** to be able to login with
external accounts created for Open Social team.

Customize the CAS in:

* Administration » Configuration » People » CAS Settings

LOCAL INSTALLATION
-------------

For local testing you may use this domain: `opensocialtest.europa.eu`

You may configure local environment by following default Open Social [documentation](https://www.drupal.org/docs/drupal-distributions/open-social/installing-open-social#s-122-install-open-social-containers-and-site):

1. Add `opensocialtest.europa.eu` to your `/etc/hosts` file based on the `IP`
   of the docker machine.
2. Add the proxy container (make sure that you start nginx-proxy first, then
   your docker container).
`docker run -d -p 80:80 --name=proxy -v /var/run/docker.sock:/tmp/docker.sock:ro
nginxproxy/nginx-proxy`
3. Set `VIRTUAL_HOST=opensocialtest.europa.eu` in your `docker-compose.yml`
4. Build and start the docker containers. 
   `docker-compose up -d`
5. You may open site in the browser with a port which points to the web
   container: `http://opensocialtest.europa.eu:32770`

MAINTAINERS
-----------

Current maintainers:

* Bram ten Hove (bramtenhove) - https://www.drupal.org/user/1549848

This project has been sponsored by:

* Open Social - https://www.drupal.org/open-social
