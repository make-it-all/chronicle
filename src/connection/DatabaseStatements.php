<?php namespace Chronicle\Connection;

trait DatabaseStatements {

  public abstract function select($sql);
  public abstract function select_all($table_name);
  public abstract function insert($attributes);
  public abstract function update($sql);
  public abstract function delete($sql);

  public abstract function table_exists();

  public abstract function columns();

  public abstract function execute($sql);

}
