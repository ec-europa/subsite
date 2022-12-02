# DIGIT TEMPLATES

<img width="50%" src="https://ec.europa.eu/info/sites/info/themes/europa/images/svg/logo/logo--en.svg" />

The OPEN EUROPA IT Platform is the technical side of the digital
transformation programme at the European Commission. This composer project
contains the subsite templates that are used to build the projects.

## Choose the right version

A specific branch is provided for each Drupal core version.

| Branch                                                                 | Drupal Core | Toolkit | PHP version |
|------------------------------------------------------------------------|-------------|---------|-------------|
| [`release/7.x`](https://github.com/ec-europa/subsite/tree/release/7.x) | ^7.91       | ^3.6.6  | 7.4         |
| [`release/8.x`](https://github.com/ec-europa/subsite/tree/release/8.x) | ^9.4.7      | ^8.6.17 | &gt;=8.0    |
| [`release/9.x`](https://github.com/ec-europa/subsite/tree/release/9.x) | ^9.4.7      | ^9.2    | &gt;=8.1    |
| [`release/10.x`](https://github.com/ec-europa/subsite/tree/release/10.x) | ^10.0       | ^9.2    | &gt;=8.1    |

## Installation

The build system for NextEuropa projects is packaged in a toolkit that can be
found here:
[ec-europa/toolkit](https://github.com/ec-europa/toolkit#user-guide-and-documentation)
.
This is the only required composer package to set up your project. To initiate
a new project you can execute the following command (replace the branch to
fit your needs):

```bash
composer create-project ec-europa/subsite dg-project-id dev-release/9.x --no-interaction
```

This will clone the current repository and install the toolkit. After this is
done the .git/ files of the template repository will be removed. This sets up a
clean toolkit that you can `git init` your own project on. For any information
on toolkit usage, please refer to its documentation:
[ec-europa/toolkit](https://github.com/ec-europa/toolkit#user-guide)
