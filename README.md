# DIGIT TEMPLATES

<img width="40%" src="https://commission.europa.eu/themes/contrib/oe_theme/dist/ec/images/logo/positive/logo-ec--en.svg" />

The OPEN EUROPA IT Platform is the technical side of the digital
transformation programme at the European Commission. This composer project
contains the subsite templates that are used to build the projects.

## Choose the right version

A specific branch is provided for each Drupal core version.

| Branch                                                                   | Drupal Core | Toolkit version | PHP version | MySQL version | Selenium version |
|--------------------------------------------------------------------------|-------------|-----------------|-------------|---------------|------------------|
| [`release/7.x`](https://github.com/ec-europa/subsite/tree/release/7.x)   | ^7.91       | ^3.6.6          | 7.4         | 5.7           | 3.141.59         |
| [`release/8.x`](https://github.com/ec-europa/subsite/tree/release/8.x)   | ^9.4.7      | ^8.6.17         | &gt;=8.0    | 5.7           | 3.141.59         |
| [`release/9.x`](https://github.com/ec-europa/subsite/tree/release/9.x)   | ^9.4.7      | ^9.2            | &gt;=8.1    | 8.0           | 4.1.3-20220405   |
| [`release/10.x`](https://github.com/ec-europa/subsite/tree/release/10.x) | ^10.0       | ^9.2            | &gt;=8.1    | 8.0           | 4.1.3-20220405   |

* Note: these are the default values that you can configure.

## Installation

The build system for NextEuropa projects is packaged in a toolkit that can be
found here:
[ec-europa/toolkit](https://github.com/ec-europa/toolkit#user-guide-and-documentation)
.
This is the only required composer package to set up your project. To initiate
a new project you can execute the following command (replace the branch to
fit your needs):

```bash
git clone git@github.com:ec-europa/subsite.git --branch=release/9.x project-folder-name
cd project-folder-name
docker-compose up -d
docker-compose exec web composer create-project
```

This will clone the current repository and install the toolkit. After this is
done the .git/ files of the template repository will be removed. This sets up a
clean toolkit that you can `git init` your own project on. For any information
on toolkit usage, please refer to its documentation:
[ec-europa/toolkit](https://github.com/ec-europa/toolkit#user-guide)
