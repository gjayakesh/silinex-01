#!/usr/bin/env bash
# build.sh – helper script to build the Docker image from the repository root.
# This ensures Docker can locate the Dockerfile regardless of the current working directory.

# Determine the directory of this script (repo root)
REPO_ROOT="$(cd "$(dirname "$0")" && pwd)"

# Change to the repo root
cd "$REPO_ROOT" || { echo "Failed to cd to repo root: $REPO_ROOT"; exit 1; }

# Build the Docker image (you can customize the tag as needed)
# Example tag: silinex-01:latest

docker build -t silinex-01:latest -f Dockerfile .
