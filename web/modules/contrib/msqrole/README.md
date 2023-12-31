# Masquerade Role

The Masquerade Role module allows the user to swap roles on the fly.
This is especially useful during development and QA phases of websites.

Some cache tags are invalidated when masquerading as a different role
(e.g. local task), this is only done because this module behaves strangely in
combination 'user 1'.
Invalidating said cache tags (also configurable in the UI) solves this issue.

- For a full description of the module, visit the
  [project page](https://www.drupal.org/project/msqrole)

- To submit bug reports and feature suggestions, or track changes
  [issue queue](https://www.drupal.org/project/issues/msqrole)


## Contents of this file

- Requirements
- Recommended modules
- Installation
- Configuration
- Troubleshooting
- Maintainers


## Requirements

This module has no special requirements.


## Recommended modules

- [Masquerade](https://www.drupal.org/project/masquerade) - This is a very
  similar module that provides functionality that crosses paths with msqrole.
  The difference with this module is that you actually swap user, instead of
  only your active roles.


## Installation

Install as you would normally install a contributed Drupal module. Visit
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules) for further information.


## Configuration

- Configure the user permissions in `Administration » People » Permissions`
- Configure the cache tags to be invalidated at
  `Administration » Configuration » People » Masquerade Role Settings`


## Troubleshooting

- If some blocks/items are incorrectly appearing/disappearing (if the role has
  no permission to it):

    - Check the cache tags this block/item uses
    - Add them via the configuration page to be cleared when
      masquerading as a different role.


## Maintainers

- [Randal Vanheede (Randal V)](https://www.drupal.org/u/randalv)
