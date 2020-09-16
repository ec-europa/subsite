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

    // Ask for the project name, and suggest the various machine names.
    $params = [
      'project_profile' => 'openeuropa',
      'project_id' => 'subsite',
      'project_name' => 'My Website',
      'project_vendor' => 'digit',
      'project_description' => 'Drupal 8 template for websites hosted in DIGIT.'
    ];

    $options = [
      'minimal',
      'standard',
      'openeuropa',
      ];

    $questions = [
      'project_id' => 'What is the Project Id (machine readable)?',
      'project_vendor' => 'What vendor will be used?',
      'project_description' => 'Provide a description.',
      'project_name' => 'What is the Website name?',
      ];

    foreach ($questions as $param => $question) {
      $params[$param] = $event->getIO()->ask('<info>' . $question . '</info> [<comment>' . $params[$param] . '</comment>]? ', $params[$param]);
      exec("find ./ -type f  ! -path '*/web/*' ! -path '*/vendor/*' ! -path '*/.git/*' ! -path '*/scripts/*' -exec sed -i 's/token_{$param}/{$params[$param]}/g' {} +");
    }

    return TRUE;
  }

}
