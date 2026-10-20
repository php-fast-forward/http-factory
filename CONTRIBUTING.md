# Contributing

Add one independent `.changelog/*.md` fragment for each observable change.
Use [Fast Forward Changelog](https://github.com/php-fast-forward/changelog)
through CPX with PHP 8.5 or newer; the package's PHP requirements stay unchanged.

```sh
cpx --skip-local fast-forward/changelog help add
cpx --skip-local fast-forward/changelog add "Describe the change." --category=fixed --no-interaction
cpx --skip-local fast-forward/changelog check --no-interaction
```

Choose the category and semantic impact that describe the change. Commit the
fragment with the contribution; leave published history intact and do not add
an `Unreleased` section to `CHANGELOG.md`. After committing, validate the PR delta
with `check --since=origin/main --source=tags --no-interaction` using the same CLI.
This local check uses tags without requiring GitHub access; the workflow uses
GitHub Releases to retain existing release notes during consolidation.

Run `composer install` to fetch the project skill into
`.agents/skills/fast-forward-changelog`. The committed `skills.json` selects its
GitHub source through `llm/skills`; generated `.agents` files stay out of Git.
This does not install Changelog's runtime dependencies into the library.
Inspect the copy with `composer skills:show` and refresh compatible versions with
`composer skills:update --from=github`. Keep the skill under this manager's
ownership; do not run the legacy Changelog skill installer on it.

The GitHub workflow checks fragments, maintains PR feedback and prepares a
version PR from stable ancestral tags and committed history. Its title identifies
the package and version transition, for example
`chore(release): fast-forward/http-factory v1.2.0 → v1.2.1`. Review that PR's
version, history and fragment deletions before merging it. It never merges itself;
its approved merge publishes the version tag and GitHub Release. Installing the
workflow or merging an ordinary contribution does not publish a release.

`CHANGELOG.md` includes all four published stable versions, backfilled from
GitHub Releases with their original publication dates and actual bodies. The
workflow uses `source: github` to retain that evidence. Only `v1.2.0` has a body
(a comparison link);
the earlier releases are empty. Do not invent historical changes, authors or PR
references to fill those gaps. New fragments are consolidated using Keep a
Changelog headings and version links, with verified origin PR links when available.
The new GitHub Release receives the same release-section text; existing GitHub
Release bodies stay unchanged.

## Container consumer skill

The same development-only manager also restores `fast-forward-container` from
`php-fast-forward/container` within `^1.10.0`, alongside the other configured
skills. Inspect all sources with `composer skills:show` and refresh them with
`composer skills:update --from=github`. Generated copies stay ignored; this
configuration does not upgrade the runtime library. Check the installed
Container version before following the skill: its API contract supports `^1.10`
and requires reporting earlier versions instead of assuming compatibility.
