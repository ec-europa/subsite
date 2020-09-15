<?php

declare(strict_types = 1);

namespace Subsite\composer;

use Composer\Json\JsonFile;
use Composer\Script\Event;

/**
 * Setup wizard to handle user input during initial composer installation.
 *
 * @phpcs:ignorefile Generic.PHP.ForbiddenFunctions
 */
class SetupWizard {

  /**
   * The setup wizard.
   *
   * @param \Composer\Script\Event $event
   *   The Composer event that triggered the wizard.
   *
   * @return bool
   *   TRUE on success.
   *
   * @throws \Exception
   *   Thrown when an error occurs during the setup.
   */
  public static function setup(Event $event): bool {
    $composer_filename = $event->getComposer()->getConfig()->getConfigSource()->getName();
    $params = [];

    // Ask for the project name, and suggest the various machine names.
    $params['project_profile'] = 'openeuropa';
    $params['project_id'] = 'subsite';
    $params['project_vendor'] = 'digit';
    $params['project_description'] = 'Drupal 8 template for websites hosted in DIGIT.';

    $options = [
      'minimal',
      'standard',
      'openeuropa',
      ];

    $params['project_profile'] = $event->getIO()->select('<info>Select the installation profile?</info> [<comment>' . $params['project_profile'] . '</comment>]? ', $options, $params['project_profile']);
    exec("find ./ -type f  ! -path '*/web/*' ! -path '*/vendor/*' ! -path '*/.git/*' ! -path '*/scripts/*' -exec sed -i 's/%project_profile/{$options[$params["project_profile"]]}/g' {} +");

    $questions = [
      'project_id' => 'What is the Project Id (machine readable)?',
      'project_vendor' => 'What vendor will be used?',
      'project_description' => 'Provide a description.',
      ];

    foreach ($questions as $param => $question) {
      $params[$param] = $event->getIO()->ask('<info>' . $question . '</info> [<comment>' . $params[$param] . '</comment>]? ', $params[$param]);
      if ($params[$param] != 'project_vendor') {
        exec("find ./ -type f  ! -path '*/web/*' ! -path '*/vendor/*' ! -path '*/.git/*' ! -path '*/scripts/*' -exec sed -i 's/%{$param}/{$params[$param]}/g' {} +");
      }
    }

    return TRUE;
  }

}
