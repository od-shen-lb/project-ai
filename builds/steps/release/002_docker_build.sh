#!/usr/bin/env bash

if [[ ! "${RELEASE_BUILD_DISABLED}" == "true" ]]; then
    echo "Begin to build deployable app docker image." && echo ""
    compose_cmd --progress plain build --pull app-deploy
    compose_cmd --progress plain build --pull app-deploy-full
    docker_clean_build_cache
else
    echo "skip due to RELEASE_BUILD_DISABLED flag is true."
fi
