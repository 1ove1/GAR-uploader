<?php

namespace GAR\Uploader\DB\Table\SQL;

/**
 * META INTERFACE
 * USE FOR GET INFO ABOUT TABLE
 */
interface Meta
{
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