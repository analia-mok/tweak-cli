# Tweak CLI

An opinionated bootstrapper tool for setting up [Lando-based](https://docs.lando.dev/) projects.

At [GeekHive](https://www.geekhive.com/), we've standardized on using Lando for local development on WordPress and Drupal projects. However,
for every new project, I always have to tweak (__hint hint nudge nudge__) the Lando config to add a
set of helper tooling to make the team's life easier. So here is Tweak CLI, a simple tool for adding
our helper commands and scripts to new projects.

Currently, the tool __tweaks in__ yaml configuration and bash scripts into your current project. When the
[latest release of Lando](https://blog.lando.dev/2020/02/10/q1-2020-update/) is out, we will convert most - if not all - of the helpers into a proper [Lando plugin](https://docs.lando.dev/contrib/contrib-plugins.html#plugins).

## Installation

Run `composer global require analia-mok/tweak-cli`

## Upgrading

Run `composer global update analia-mok/tweak-cli`

## How to Use

Make sure you have `~/.composer/vendor/bin` in your terminal's path.

Preferably, you will already have created your project on Pantheon and have run `lando init`.

Once done, simply run `tweak in` and you will be set up with all of Tweak's helpers.

## Pre-1.0 Goals
- [X] Implement `tweak in`: Primary command for "tweaking in" helper scripts and adjusting
your lando.yml file.
- [X] Support Pantheon-hosted projects
- [X] Support composer and non-composer projects
- [X] Support WordPress and Drupal
- [ ] Adjust pulldb and pullfiles scripts to allow selection of environments.
- [ ] Add better test coverage...

## Future Goals

- [ ] CI/CD file generation. We do have a standard set of CircleCI-related files that barely change from project to project that we could share.
  - Ex. WordPress + Pantheon's CircleCI Orb.
- [ ] Opt-in to tweak in `pantheon.yml` configuration for quicksilver (e.g. Slack, New Relic Notifications)
- [ ] There's some caveats to using Symfony's Process component for running external commands. It would be convenient to run `lando init` if the current project to `tweak in` does not a lando.yml yet.
- [ ] Support other hosting platforms that are lando friendly, such as [Platform.sh](https://platform.sh).
- [ ] Add Laravel helpers support
