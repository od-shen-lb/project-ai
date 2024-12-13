#!/usr/bin/env bash

if [[ -z "${RELEASE_GCR_REPO}" ]]; then
    echo "RELEASE_GCR_REPO env is empty. exit."
    exit 1
fi

compose_set_env "release"

export RELEASE_IMAGE_VERSION="${1:-latest}"
export RELEASE_BUILD_DISABLED="${RELEASE_BUILD_DISABLED:+true}"
export RELEASE_PUSH_DISABLED="${RELEASE_PUSH_DISABLED:+true}"
export APP_DOCKER_IMAGE_URL="${DEPLOY_APP_DOCKER_IMAGE}:${RELEASE_IMAGE_VERSION}"

echo "done."
