# DIGIT TEMPLATES
<img align="left" width="50%" src="https://ec.europa.eu/info/sites/info/themes/europa/images/svg/logo/logo--en.svg" />

<p>The OPEN EUROPA IT Platform is the technical side of the digital
transformation programme at the Commission. This composer project
contains the subsite template that are used to build the projects. It
also contains tools for Quality Assurance.</p>

## Installation Drupal 7
The build system for NextEuropa projects is packaged in a toolkit that can
be found here: [ec-europa/toolkit](https://github.com/ec-europa/toolkit#user-guide). This is
the only required composer package to set up your project. To initiate a new
project you can execute the following command:

```bash
composer create-project ec-europa/subsite project-folder-name dev-release/3.x --no-interaction
```

This will clone the current repository and install the toolkit. After this is done
the .git/ files of the template repository will be removed. This sets up a clean
toolkit that you can `git init` your own project on. For any information on toolkit
usage, please refer to its documentation: [ec-europa/toolkit](https://github.com/ec-europa/toolkit#user-guide)

## Installation Drupal 9
The build system for OpenEuropa projects is packaged in a toolkit that can
be found here: [ec-europa/toolkit](https://github.com/ec-europa/toolkit/tree/release/4.x#user-guide). This is
the only required composer package to set up your project. To initiate a new
project you can execute the following command:

```bash
composer create-project ec-europa/subsite project-folder-name dev-release/8.x

# or in docker way

git clone git@github.com:ec-europa/subsite.git --branch=release/8.x project-folder-name
cd project-folder-name
docker-compose up -d
docker-compose exec web composer create-project
```

This will clone the current repository and install the toolkit. After this is done
the .git/ files of the template repository will be removed. This sets up a clean
toolkit that you can `git init` your own project on. For any information on toolkit
usage, please refer to its documentation: [ec-europa/toolkit](https://github.com/ec-europa/toolkit/tree/release/4.x#user-guide)
