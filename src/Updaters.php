<?php namespace Chronicle;


trait Updaters {

  public function save() {
    if (!$this->validate()) {
      return false;
    }
    if ($this->is_new_record()) {
      return $this->_create_record();
    } else {
      return $this->_update_record();
    }
  }

  private function _create_record() {
    $query = new Query\Insert(get_called_class());
    $query->set_attributes($this->attributes());
    return $query->execute();
  }

  private function _update_record() {
    $query = new Query\Update(get_called_class());
    $query->set_attributes($this->attributes());
    echo $query->toSQL();
    return Base::connection()->insert(get_called_class()::$table_name, $attrs);
  }

  public function update($attrs) {
    $this->assign_attributes($attrs);
    return $this->save();
  }

  public function destroy() {
    $query = new Query\Delete(get_called_class());
    $query->where(['id' => $this->id()])->results();
    $query->execute();
  }

}
