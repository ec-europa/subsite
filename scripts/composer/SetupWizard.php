<?php

declare(strict_types = 1);

namespace Subsite\composer;

use Composer\Json\JsonFile;
use Composer\Script\Event;
use Symfony\Component\Yaml\Yaml;

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

    $questions = [
      'project_id' => 'What is the Project Id (machine readable)?',
      'project_vendor' => 'What vendor will be used?',
      'project_description' => 'Provide a description.',
      ];

    foreach ($questions as $param => $question) {
      $params[$param] = $event->getIO()->ask('<info>' . $question . '</info> [<comment>' . $params[$param] . '</comment>]? ', $params[$param]);    
    }

    $params['project_namespace'] = $params['project_vendor'] . '/' . $params['project_id'];

    // Update runner.yml.dist.
    $runnerYmldist = Yaml::parse(file_get_contents(dirname(__DIR__, 2) . '/runner.yml.dist'));
    $runnerYmldist['toolkit']['project_id'] = $params['project_id'];
    $runnerYmldist['drupal']['site']['profile'] = $params['project_profile'];
    $updateRunnerYmldist = Yaml::dump($runnerYmldist, 5);
    file_put_contents(dirname(__DIR__, 2) .'/runner.yml.dist', $updateRunnerYmldist);

    // Update composer.json.
    $composer_json = new JsonFile($composer_filename);
    $config = $composer_json->read();
    $config['name'] = $params['project_namespace'];
    $config['description'] = $params['project_description'];
    $composer_json->write($config);

    return TRUE;
  }

}
