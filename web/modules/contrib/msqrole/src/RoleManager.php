<?php

namespace Drupal\msqrole;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Utility\Token;
use Drupal\user\Entity\User;
use Drupal\user\UserDataInterface;

/**
 * Class RoleManager.
 *
 * @package Drupal\msqrole
 */
class RoleManager implements RoleManagerInterface {

  /**
   * The user data instance.
   *
   * @var \Drupal\user\UserDataInterface
   */
  protected UserDataInterface $userData;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * The msqrole config.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected ImmutableConfig $config;

  /**
   * The theme config.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected ImmutableConfig $themeConfig;

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected Token $token;

  /**
   * Constructs the RoleManager class.
   *
   * @param \Drupal\user\UserDataInterface $user_data
   *   The user data object.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(UserDataInterface $user_data, EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory, Token $token) {
    $this->userData = $user_data;
    $this->entityTypeManager = $entity_type_manager;
    $this->config = $config_factory->get('msqrole.settings');
    $this->themeConfig = $config_factory->get('system.theme');
    $this->token = $token;
  }

  /**
   * {@inheritDoc}
   */
  public function isPermissionInRoles($permission, array $roles) {
    $roles = $this->getAllRoles($roles);
    if (!$roles) {
      return FALSE;
    }

    foreach ($roles as $role) {
      if ($role->hasPermission($permission)) {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * {@inheritDoc}
   */
  public function getAllRoles(?array $role_ids = NULL) {
    if (is_array($role_ids)) {
      return $this->entityTypeManager
        ->getStorage('user_role')
        ->loadMultiple($role_ids);
    }

    return $this->entityTypeManager
      ->getStorage('user_role')
      ->loadMultiple();
  }

  /**
   * {@inheritDoc}
   */
  public function getConfigurableRoles() {
    /** @var RoleManagerInterface $role_manager */
    $roles = $this->getAllRoles();
    $disallow_roles = [
      'anonymous',
      'authenticated',
      'administrator',
    ];

    // Unset roles that shouldn't be masqueraded as.
    foreach ($disallow_roles as $role) {
      if (!isset($roles[$role])) {
        continue;
      }
      unset($roles[$role]);
    }

    return $roles;
  }

  /**
   * {@inheritDoc}
   */
  public function getRoles($uid) {
    $data = [];
    if (!empty($this->getData($uid, 'roles'))) {
      $data = unserialize($this->getData($uid, 'roles'));
    }
    return $data;
  }

  /**
   * {@inheritDoc}
   */
  public function getData($uid, string $key) {
    return $this->userData->get('msqrole', $uid, $key);
  }

  /**
   * {@inheritDoc}
   */
  public function setRoles($uid, array $roles) {
    return $this->setData($uid, 'roles', serialize($roles));
  }

  /**
   * {@inheritDoc}
   */
  public function setData($uid, string $key, $value) {
    return $this->userData->set('msqrole', $uid, $key, $value);
  }

  /**
   * {@inheritDoc}
   */
  public function isActive($uid) {
    return $this->getData($uid, 'active') ?? FALSE;
  }

  /**
   * {@inheritDoc}
   */
  public function setActive($uid, bool $active) {
    return $this->setData($uid, 'active', $active ? 1 : 0);
  }

  /**
   * {@inheritDoc}
   */
  public function removeData($uid, ?string $key = NULL) {
    return $this->userData->delete('msqrole', $uid, $key);
  }

  /**
   * {@inheritDoc}
   */
  public function invalidateTags($uid) {
    $user = User::load($uid);
    $admin_theme = $this->themeConfig->get('admin');
    $default_theme = $this->themeConfig->get('default');

    // Replace possible variables in the tags.
    $tags = Cache::mergeTags(
      RoleManagerInterface::TAGS_TO_INVALIDATE,
      (unserialize($this->config->get('tags_to_invalidate')) ?: [])
    );
    foreach ($tags as &$tag) {
      $tag = $this->token->replace($tag, [
        'user' => $user,
      ]);
      $tag = str_replace('[theme:admin]', $admin_theme, $tag);
      $tag = str_replace('[theme:default]', $default_theme, $tag);
    }
    $tags = array_filter($tags);

    Cache::invalidateTags($tags);
  }

}
