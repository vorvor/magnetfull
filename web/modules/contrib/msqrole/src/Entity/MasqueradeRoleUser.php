<?php

namespace Drupal\msqrole\Entity;

use Drupal\msqrole\RoleManagerInterface;
use Drupal\user\Entity\User;
use Drupal\user\RoleInterface;

class MasqueradeRoleUser extends User {

  /**
   * The role manager.
   *
   * @var \Drupal\msqrole\RoleManagerInterface
   */
  protected RoleManagerInterface $roleManager;

  /**
   * Returns the role manager.
   *
   * @return \Drupal\msqrole\RoleManagerInterface
   */
  protected function roleManager(): RoleManagerInterface {
    if (!isset($this->roleManager)) {
      $this->roleManager = \Drupal::service('msqrole.manager');
    }

    return $this->roleManager;
  }

  /**
   * {@inheritdoc}
   */
  public function getRoles($exclude_locked_roles = FALSE) {
    if (!($id = $this->id()) || !$this->roleManager()->isActive($id)) {
      return parent::getRoles($exclude_locked_roles);
    }

    $roles = $this->roleManager()->getRoles($id);
    if ($exclude_locked_roles) {
      unset($roles[RoleInterface::ANONYMOUS_ID]);
      unset($roles[RoleInterface::AUTHENTICATED_ID]);
    }

    return $roles;
  }

}
