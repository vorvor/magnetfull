<?php

/**
 * Implements hook_views_data_alter().
 */
function magnet_views_data_alter(array &$data) {
  $data['node']['magnet_ndfield'] = array(
    'title' => t('Magnet Next Deadline'),
    'group' => t('Content'),
    'field' => array(
      'title' => t('Magnet Next Deadlineee'),
      'help' => t('It is what it is.'),
      'id' => 'magnet_ndfield',
    ),
  );
}
