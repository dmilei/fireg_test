#!/bin/bash

printenv | sort >> /etc/environment
exec "$@"