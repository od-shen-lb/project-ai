#!/usr/bin/env bash

# modify if need.
export BASE_GCR_REPO="asia-east1-docker.pkg.dev/jarvis-247902/applications"
export BASE_APP_IMAGE_NAME="backend-swoole-docker-app"
export BASE_APP_IMAGE_VERSION="3.0.3"

# shared config sections.
export APP_DOCKER_IMAGE="${BASE_GCR_REPO}/${BASE_APP_IMAGE_NAME}:${BASE_APP_IMAGE_VERSION}"
export DEPLOY_APP_DOCKER_IMAGE="${RELEASE_GCR_REPO}/${APP_NAME}-app-deploy"
