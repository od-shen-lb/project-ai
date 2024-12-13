# Laravel Project AI

## installations

* please git clone this repository
* run command - `composer install && rm -rf .git`

## post actions

* change project name
  * change `name` field in `composer.json`
  * change `APP_NAME` env in `.env.example`
* change database name
  * please search `(MYSQL_DATABASE=xxxx)` with `builds/docker/docker-compose.yml`
  * change `DB_DATABASE` env in `.env.example`
* change database password
  * please search `(MYSQL_PASSWORD=xxxx)` with `builds/docker/docker-compose.yml`
  * change `DB_PASSWORD` env in `.env.example`
* change php base image url
  * change `BASE_GCR_REPO` & `BASE_APP_IMAGE_NAME` & `BASE_APP_IMAGE_VERSION` in `builds/configs/shared.sh`
  * for example, if your new base image url = `asia-east1-docker.pkg.dev/demo/applications/php-base:1.0.0`
    * BASE_GCR_REPO = `asia-east1-docker.pkg.dev/demo/applications`
    * BASE_APP_IMAGE_NAME = `php-base`
    * BASE_APP_IMAGE_VERSION = `1.0.0`
* change semantic-release config `.releaserc`
  * change `repositoryUrl` to right github url.