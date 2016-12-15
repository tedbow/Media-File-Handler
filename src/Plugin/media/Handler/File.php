<?php

  namespace Drupal\media_file_handler\Plugin\media\Handler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\media\MediaInterface;
use Drupal\media\MediaHandlerBase;

/**
 * Provides generic media type.
 *
 * @MediaHandler(
 *   id = "file",
 *   label = @Translation("File handler"),
 *   description = @Translation("File media handler."),
 *   allowed_field_types = {"file"},
 * )
 */
class File extends MediaHandlerBase {

  /**
   * {@inheritdoc}
   */
  public function getThumbnail(MediaInterface $media) {
    return $this->getDefaultThumbnail();
  }

  /**
   * {@inheritdoc}
   */
  public function getProvidedFields() {
    return [
      'field_1' => $this->t('Field 1'),
      'field_2' => $this->t('Field 2'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getField(MediaInterface $media, $name) {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'test_config_value' => 'This is default value.',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['test_config_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Test config value'),
      '#default_value' => empty($this->configuration['test_config_value']) ? NULL : $this->configuration['test_config_value'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function createSourceFieldStorage() {
    return $this->entityTypeManager
      ->getStorage('field_storage_config')
      ->create([
        'entity_type' => 'media',
        'field_name' => $this->getSourceFieldName(),
        // Strings are harmless, inoffensive puppies: a good choice for a
        // generic media type.
        'type' => 'file',
      ]);
  }

}
