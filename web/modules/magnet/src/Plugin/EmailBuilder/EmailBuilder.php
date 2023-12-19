<?php

namespace Drupal\magnet\Plugin\EmailBuilder;

use Drupal\symfony_mailer\EmailInterface;
use Drupal\symfony_mailer\Processor\EmailBuilderBase;

/**
* Email Builder plug-in for the magnet module.
*
* @EmailBuilder(
*   id = "magnet_email",
*   sub_types = {
*     "login" = @Translation("Login notification"),
*   },
*   common_adjusters = {"email_subject", "email_body"},
* )
*/
class EmailBuilder extends EmailBuilderBase {
  # In the class ExampleEmailBuilder.
  public function build(EmailInterface $email) {
    $email->setFrom('vorosborisz@gmail.com');
  }
}
