<?php namespace Chronicle;


trait Updaters {

  public function save() {
    if (!$this->validate()) { return false; }
    if ($this->id() == null) {
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
    if (!$this->changed()) {return;}
    $query = new Query\Update(get_called_class());
    $query->set_attributes($this->attributes());
    $query->where(['id' => $this->id()]);
    echo $query->toSQL();
    return $query->execute();
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
