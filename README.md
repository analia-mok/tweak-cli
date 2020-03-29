# Tweak CLI

An opinionated bootstrapper tool for setting up [Lando-based](https://docs.lando.dev/) projects.

## Installation

TODO

## How to Use

Preferably, you will already have created your project on Pantheon and have run `lando init`.

Once done, simply run `tweak in` and you will be set up with all of Tweak's helpers.

## Goals / Priorities

- [ ] Implement `tweak in`: Primary command for "tweaking in" helper scripts and adjusting
your lando.yml file.
- [ ] Support Pantheon-hosted projects
- [ ] Support composer and non-composer projects
- [ ] Support WordPress and Drupal

## Future Goals

- [ ] Adjust pulldb and pullfiles scripts to allow selection of environments.
- [ ] CI/CD file generation. We do have a standard set of CircleCI-related files that barely change from project to project that we could share.
  - WordPress + Pantheon's CircleCI Orb.
- [ ] Opt-in to tweak in `pantheon.yml` configuration for quicksilver (e.g. Slack, New Relic Notifications)
- [ ] There's some caveats to using Symfony's Process component for running external commands. It would be convenient to run `lando init` if the current project to `tweak in` does not a lando.yml yet.
- [ ] Support other hosting platforms that are lando friendly, such as [Platform.sh](https://platform.sh).
- [ ] Add Laravel helpers support
