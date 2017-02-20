<?php namespace Chronicle;


trait Updaters {

  public function save() {
    $this->send_callback('before_vaildation');
    if (!$this->validate()) {
      return false;
    }
    $this->send_callback('after_vaildation');
    if ($this->is_new_record()) {
      $this->send_callback('before_create');
      $this->send_callback('before_save');
      return $this->_create_record();
      $this->send_callback('after_save');
      $this->send_callback('after_create');
    } else {
      $this->send_callback('before_save');
      return $this->_update_record();
      $this->send_callback('after_save');
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
