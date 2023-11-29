<?php

namespace Drupal\msqrole\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\msqrole\RoleManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MasqueradeRoleSettings
 *
 * @package Drupal\msqrole\Form
 */
class MasqueradeRoleSettings extends ConfigFormBase {

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected RendererInterface $renderer;

  /**
   * Constructs the settings form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   */
  public function __construct(ConfigFactoryInterface $config_factory, RendererInterface $renderer) {
    parent::__construct($config_factory);

    $this->renderer = $renderer;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('renderer')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'msqrole_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('msqrole.settings');

    $tags = unserialize($config->get('tags_to_invalidate')) ?: [];

    // Tags.
    $form['tags'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Extra tags to invalidate:'),
      '#default_value' => implode(PHP_EOL, $tags),
      '#description' => $this->t('These tags will be invalidated when changing roles. Each tag gets a new line.'),
    ];

    // Default tags that are always invalidated.
    $form['default_tags'] = [
      '#type' => 'inline_template',
      '#template' => '<strong>Default/always enabled tags:</strong><pre>{{ tags }}</pre>',
      '#context' => [
        'tags' => print_r(implode(PHP_EOL, RoleManagerInterface::TAGS_TO_INVALIDATE), TRUE)
      ],
    ];

    $token_info = [
      '#theme' => 'token_tree_link',
      '#token_types' => [
          'current-date' => 'current-date',
          'current-user' => 'current-user',
          'current-page' => 'current-page',
          'site' => 'site',
          'random' => 'random',
          'user' => 'user',
        ],
      '#show_restricted' => TRUE,
      '#weight' => 90,
    ];

    $form['tags']['#description'] .= '<br />' . $this->t('This field supports tokens. @browse_tokens_link', [
      '@browse_tokens_link' => $this->renderer->renderPlain($token_info),
    ]);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Do nothing.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('msqrole.settings');
    $tags = explode(PHP_EOL, $form_state->getValue('tags'));
    foreach ($tags as &$tag) {
      $tag = trim($tag);
    }
    $config->set('tags_to_invalidate', serialize($tags ?? []));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'msqrole.settings',
    ];
  }

}

