<?php

namespace GAR\Uploader\DB\Table\SQL;

interface SQL
{
  /**
   * Make SELECT query
   * @param array $fields - fields to select
   * @param array|null $cond - conditions
   * @param array|null $comp - values that need to compare
   * @return $this
   */
  function select(array $fields, ?array $cond, ?array $comp) : self;

  /**
   * Make insert query (require do save before use)
   * @param array $values - values that need to insert
   * @return $this
   */
  function insert(array $values) : self;

  /**
   * Complete insert query
   * @return $this
   */
  function save() : self;


}