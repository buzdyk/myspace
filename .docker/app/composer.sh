#!/bin/sh
set -e

set -- composer.phar "$@"

if [ "${GIT_SSH_COMMAND}" != "" ]; then
    exec "$@"
fi

GIT_SSH_COMMAND='ssh -i /etc/ssh/gitlab.id_rsa -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no' \
    exec "$@"
