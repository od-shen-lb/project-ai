#!/usr/bin/env bash

compose_set_env "code-quality"

compose_cmd --progress plain build --pull
docker_clean_build_cache
compose_cmd up -d --quiet-pull --wait app database redis
