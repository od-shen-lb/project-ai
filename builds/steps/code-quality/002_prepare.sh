#!/usr/bin/env bash

export APP_ID
APP_ID="$(compose_get_container_id app)"

docker_cmd cp tests "${APP_ID}:${WORKSPACE_DIR}"
docker_cmd cp .env.example "${APP_ID}:${WORKSPACE_DIR}/.env"
docker_cmd cp .phplint.yml "${APP_ID}:${WORKSPACE_DIR}"
docker_cmd cp phpcs.xml.dist "${APP_ID}:${WORKSPACE_DIR}"
docker_cmd cp phpunit.xml.dist "${APP_ID}:${WORKSPACE_DIR}"
docker_cmd cp phpstan.neon.dist "${APP_ID}:${WORKSPACE_DIR}"
docker_cmd cp pint.json "${APP_ID}:${WORKSPACE_DIR}"

docker_cmd exec "${APP_ID}" chown -R "${COMPOSE_USER}:${COMPOSE_USER}" "${WORKSPACE_DIR}/tests"
docker_cmd exec "${APP_ID}" chown -R "${COMPOSE_USER}:${COMPOSE_USER}" "${WORKSPACE_DIR}/.env"
docker_cmd exec "${APP_ID}" chown -R "${COMPOSE_USER}:${COMPOSE_USER}" "${WORKSPACE_DIR}/.phplint.yml"
docker_cmd exec "${APP_ID}" chown -R "${COMPOSE_USER}:${COMPOSE_USER}" "${WORKSPACE_DIR}/phpcs.xml.dist"
docker_cmd exec "${APP_ID}" chown -R "${COMPOSE_USER}:${COMPOSE_USER}" "${WORKSPACE_DIR}/phpunit.xml.dist"
docker_cmd exec "${APP_ID}" chown -R "${COMPOSE_USER}:${COMPOSE_USER}" "${WORKSPACE_DIR}/phpstan.neon.dist"
docker_cmd exec "${APP_ID}" chown -R "${COMPOSE_USER}:${COMPOSE_USER}" "${WORKSPACE_DIR}/pint.json"

compose_exec_cmd app mkdir -p "${WORKSPACE_DIR}/${ARTIFACT_RELATIVE_DIR}"

echo "done."
