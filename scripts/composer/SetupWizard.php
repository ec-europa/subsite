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

    $params['project_profile'] = $event->getIO()->select(
      '<info>Select the installation profile?</info> [<comment>' . $params['project_profile'] . '</comment>]? ',
      ['minimal', 'standard', 'openeuropa'],
      $params['project_profile'],
    );
    $params['project_id'] = $event->getIO()->ask('<info>What is the Project Id (machine readable)?</info> [<comment>' . $params['project_id'] . '</comment>]? ', $params['project_id']);
    $params['project_vendor'] = $event->getIO()->ask('<info>What vendor will be used?</info> [<comment>' . $params['project_vendor'] . '</comment>]? ', $params['project_vendor']);
    $params['project_description'] = $event->getIO()->ask('<info>Provide a description</info> [<comment>' . $params['project_description'] . '</comment>]? ', $params['project_description']);

    if ($params['project_profile'] == '0') {
      $params['project_profile'] = "minimal";
    }
    elseif ($params['project_profile'] == '1') {
      $params['project_profile'] = "standard";
    }
    elseif ($params['project_profile'] == '2') {
      $params['project_profile'] = "oe_profile";
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
