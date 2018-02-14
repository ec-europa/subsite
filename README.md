# NextEuropa
<img align="left" width="50%" src="https://ec.europa.eu/info/sites/info/themes/europa/images/svg/logo/logo--en.svg" />

<p>The Next EUROPA IT Platform is the technical side of the digital
transformation programme at the Commission. This composer project
contains the subsite template that are used to build the projects. It
also containse tools for Quality Assurance.</p>

## Installation
The build system for NextEuropa projects is packaged in a toolkit that can
be found here: [ec-europa/toolkit](https://github.com/ec-europa/toolkit). This is
the only required composer package to set up your project. To iniated a new
project you can execute the following command:

```bash
composer create-project ec-europa/subsite project-folder-name dev-master --no-interaction
```

This will clone the current repository and install the toolkit. After this is done
the .git/ files of the template repository will be removed. This sets up a clean
toolkit that you can `git init` your own project on. For any information on toolkit
usage, please refer to it's documentation: [ec-europa/toolkit](https://github.com/ec-europa/toolkit)
