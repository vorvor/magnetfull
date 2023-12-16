<?php

namespace Drupal\screenshot\Form;

use Drupal\Component\Render\PlainTextOutput;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\screenshot\Ajax\SendImageCommand;
use Symfony\Component\HttpFoundation\Request;

/**
 * In view mode send image.
 */
class SendImageForm extends ConfigFormBase {

  /**
   * Save Image.
   */
  public static function saveImage(string $selector, Request $request) : AjaxResponse {
    $encoded_image = $request->request->get('screenshot');
    $url = '';
    $fid = FALSE;
    $delta = $request->request->get("delta");
    $entity_type = $request->request->get("entity_type");
    $bundle = $request->request->get("bundle");
    $field_name = $request->request->get("field_name");
    $fieldConfig = \Drupal::entityTypeManager()
      ->getStorage('field_config')
      ->load($entity_type . '.' . $bundle . '.' . $field_name);
    $file_directory = $request->request->get("file_directory");
    if (!empty($fieldConfig)) {
      $file_directory = $fieldConfig->getSetting('file_directory');
    }
    if (!empty($encoded_image)) {
      // Create image directory.
      $file_directory = trim($file_directory, '/');
      $destination = PlainTextOutput::renderFromHtml(\Drupal::token()
        ->replace($file_directory, []));
      $dir = $uri = \Drupal::config('system.file')->get('default_scheme') . '://';
      if (!empty($destination)) {
        $uri .= $destination . '/';
        $fileService = \Drupal::service('file_system');
        $path = $fileService->realpath($uri);
        if ($path) {
          $fileService->prepareDirectory($path, FileSystemInterface::CREATE_DIRECTORY);
        }
        else {
          $extract = explode('/', str_replace('\\', '/', $destination));
          foreach ($extract as $dirName) {
            $dir .= $dirName . '/';
            $path = $fileService->realpath($dir);
            $fileService->prepareDirectory($path, FileSystemInterface::CREATE_DIRECTORY);
          }
        }
      }
      // Convert image base64 to file.
      [$dataImage, $encoded_image] = explode(",", $encoded_image);
      [$tmp, $ext] = explode('/', str_replace([';', 'base64', ','], '', $dataImage));
      unset($tmp);
      $encoded_image = str_replace(' ', '+', $encoded_image);
      $decoded_image = base64_decode($encoded_image);
      $filename = date('ymd') . '_' . rand(1000, 9999) . '.' . $ext;
      // Saves a file to the specified destination and creates a database entry.
      $file = \Drupal::service('file.repository')->writeData($decoded_image, $uri . $filename, FileSystemInterface::EXISTS_REPLACE);
      $fid = $file->id();
      $uri = $file->getFileUri();
      $url = \Drupal::service('file_url_generator')->generate($uri)->toString();
    }
    if (!empty($url)) {
      $response = new AjaxResponse();
      $inputFid = "{$field_name}[$delta][fids]";
      $response->addCommand(new SendImageCommand($selector, $url, $inputFid, $fid));
    }

    return $response;
  }

  /**
   * Form id.
   */
  public function getFormId() {
    return 'screenshot_sendImage_form';
  }

  /**
   * Get editable configuration name.
   */
  protected function getEditableConfigNames() {
    return [$this->getFormId() . '.setting'];
  }

}
