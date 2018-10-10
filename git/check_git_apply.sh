#!/bin/bash

# Check a git style patch (e.g "git diff" or "git show" output) against multiple
# tags/commits/branches.
#
# Usage: git tag | grep '^1\.' | check_git_apply foo.patch
#
# Assumes you're in the repository in question.

set -euo pipefail

main() {
    local patch="$1"
    local commitish
    check_git_status
    while read -r commitish; do
        if check_patch_applies "$patch" "$commitish" &> /dev/null; then
            echo "$commitish: OK"
        else
            echo "$commitish: fail"
        fi
    done
}

check_git_status() {
    if ! [[ -z "$(git status --porcelain)" ]]; then
        echo "ERROR: git status reports changes in the local repository, refusing to continue"
        exit 1
    fi
}

check_patch_applies() {
    local patch="$1"
    local commitish="$2"
    git checkout "$commitish" &> /dev/null
    git apply --check "$patch"
}

main "$@"