# token_project_name

[![Build Status](https://drone.fpfis.eu/api/badges/token_vendor/token_project_id-reference/status.svg)](https://drone.fpfis.eu/token_vendor/token_project_id-reference)

<p>token_project_description</p>

This is an example, feel free to drop it and customize as you need.

## 1. Development

### 1.1 Prerequisites

You need to have the following software installed on your local development
environment: [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
, [Docker](https://docs.docker.com/install/)
and [Docker Compose](https://docs.docker.com/compose/install/)

### 1.2 Configuring the project

The project ships with default configuration in the `runner.yml.dist` file. This
file is configured to run the website on the provided docker containers. If you
are happy using those, you can skip directly to the 
[installing the project](#14-installing-the-project) section. You can customize 
the default configuration by copying `runner.yml.dist` to `runner.yml` and 
changing for example the connection details for your database server and 
selenium server.

### 1.3 Setting up the environment

By default, docker-compose reads two files, a `docker-compose.yml` and an
optional `docker-compose.override.yml` file. By convention, the
`docker-compose.yml` contains your base configuration, and it is committed to
the repository. This file contains a webserver, a mysql server and a selenium
server. It very closely matches the environment the website is deployed on.

The override file, as its name implies, can contain configuration overrides for
existing services, or it can add entirely new services. This file is never
committed to the repository.

#### 1.3.1 Make your life easier with aliases

You can shorten the commands listed below by setting an alias in your `.bashrc`
file:

```bash
alias dcup="docker-compose up -d"
alias dcweb="docker-compose exec web"
```

### 1.4 Installing the project

```bash
# Run composer install in the web service.
dcweb composer install
# Build your development instance of the website.
dcweb ./vendor/bin/run toolkit:build-dev
# Perform a clean installation of the website.
dcweb ./vendor/bin/run toolkit:install-clean
# Perform a clone installation with production data.
dcweb ./vendor/bin/run toolkit:install-clone
```

Using default configuration your Drupal site will be available locally at:

- [http://127.0.0.1:8080/web](http://127.0.0.1:8080/web)
    - does not support EU Login
    - no http auth by default

**NOTE:** If Cloud9 is used for the project development, when
setting up a project there it will be available at either:

- [https://|your-c9-username|.c9.fpfis.tech.ec.europa.eu/web](https://|your-c9-username|.c9.fpfis.tech.ec.europa.eu/web)
    - supports EU Login
    - http auth by default (request credentials with a teammember)
- [https://|aws-machine-id|.vfs.cloud9.eu-west-1.amazonaws.com/web](https://|aws-machine-id|.vfs.cloud9.eu-west-1.amazonaws.com/web)
    - does not support EU Login
    - protected by C9 session

### 1.5 Testing the project

```bash
# Run coding standard checks.
dcweb ./vendor/bin/run toolkit:test-phpcs
# Run behat tests on a clean installation.
dcweb ./vendor/bin/run toolkit:test-behat
# Run behat tests on a clone installation.
dcweb ./vendor/bin/run toolkit:test-behat -D "behat.tags=@clone"
```

### 1.6 Updating composer.lock

When having a conflict on the composer.lock file it is best to solve the
conflict manually and then update the lock file.

```bash
dcweb composer update --lock
```
