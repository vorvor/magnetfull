<?php

declare(strict_types = 1);

namespace Drupal\screenshot\Controller;

use Drupal\Component\Render\PlainTextOutput;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Utility\Token;
use Drupal\file\FileRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for Screenshot widget routes.
 */
final class ScreenshotController extends ControllerBase {

  /**
   * The controller constructor.
   */
  public function __construct(
    private readonly FileRepositoryInterface $fileRepository,
    private readonly FileUrlGeneratorInterface $fileUrlGenerator,
    private readonly FileSystemInterface $fileSystem,
    private readonly Token $token,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('file.repository'),
      $container->get('file_url_generator'),
      $container->get('file_system'),
      $container->get('token'),
    );
  }

  /**
   * Builds the response.
   */
  public function save(Request $request) {
    $content = Json::decode($request->getContent());
    [$dataImage, $encoded_image] = explode(",", $content['screenshot']);
    [$tmp, $ext] = explode('/', str_replace([';', 'base64', ','], '', $dataImage));
    unset($tmp);
    $encoded_image = str_replace(' ', '+', $encoded_image);
    $decoded_image = base64_decode($encoded_image);
    $filename = date('ymd') . '_' . rand(1000, 9999) . '.' . $ext;

    $destination = trim($content['file_directory'], '/');
    // Replace tokens. As the tokens might contain HTML we convert it to plain
    // text.
    $destination = PlainTextOutput::renderFromHtml($this->token->replace($destination, []));
    $destination = 'public://' . $destination . '/';
    if ($this->fileSystem->prepareDirectory($destination, FileSystemInterface::CREATE_DIRECTORY)) {
      // Save the Image data to a file.
      $file_path = $destination . $filename;
      $file = $this->fileRepository->writeData($decoded_image, $file_path, FileSystemInterface::EXISTS_REPLACE);
      $uri = $file->getFileUri();
      $url = $this->fileUrlGenerator->generate($uri)->toString();
      return new JsonResponse(['url' => $url]);
    }
    else {
      // Handle the case where the file upload fails.
      return new JsonResponse(['error' => 'File upload failed.'], 400);
    }
  }

}
