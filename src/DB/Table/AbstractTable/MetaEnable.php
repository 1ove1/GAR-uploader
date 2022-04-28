<?php

namespace GAR\Uploader\DB\Table\AbstractTable;

/**
 * META INTERFACE
 * USE FOR GET INFO ABOUT TABLE
 */
interface MetaEnable
{
  /**
   * Return name of table
   * @return string - name of table
   */
  function getName() : string;

  /**
   * Return mta info about table
   * @return array|null - meta info about table
   */
  function getMetaInfo(): ?array;

  /**
   * Return fields for curr table
   * @return array|null - fields
   */
  function getFields() : ?array;

  /**
   * Set the custom fields that need to create
   * @return array|null - fields and their params
   */
  function setFieldsToCreate() : ?array;
}