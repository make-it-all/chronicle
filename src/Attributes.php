<?php namespace Chronicle;

trait Attributes {

  private $attributes = [];
  public $attribute_methods = [];

  public function id() {
    return $this->attributes['id']->get();
  }

  public function attributes() {
    return $this->attributes;
  }

  public function add_attribute($name_or_column) {
    $attribute = new Attribute($name_or_column);
    $this->attributes[$attribute->name()] = $attribute;
    $attribute->attribute_methods($this, $this->attribute_methods);
    return $attribute;
  }

  public function is_attribute($attribute) {
    return array_key_exists($attribute, $this->attributes);
  }

  public function get_attribute($attribute) {
    if ($this->is_attribute($attribute)) {
      return $this->attributes[$attribute];
    }
  }

  public function assign_attributes($new_attributes) {
    foreach($new_attributes as $new_attr => $new_value) {
      $this->write_attribute($new_attr, $new_value);
    }
  }

  public function assign_initial_attributes($new_attributes) {
    foreach($new_attributes as $new_attr => $new_value) {
      if (self::is_attribute($new_attr)) {
        $this->attributes[$new_attr]->set_initial_value($new_value);
      }
    }
  }

  public function read_attribute($attribute) {
    if ($this->is_attribute($attribute)) {
      return $this->attributes[$attribute]->get();
    }
  }

  public function write_attribute($attribute, $value) {
    if (self::is_attribute($attribute)) {
      $this->attributes[$attribute]->set($value);
    }
  }

  public function attribute_array() {
    $attributes = [];
    foreach ($this->attributes as $attribute) {
      $attributes[$attribute->name()] = $attribute->get();
    }
    return $attributes;
  }

  public function __get($key) {
    $key = "get_$key";
    if (array_key_exists($key, $this->attribute_methods)) {
      if (method_exists($this, $key)) {
        return $this->$key();
      } else {
        return $this->attribute_methods[$key]();
      }
    } else {
      throw new \Exception("method not found: $key");
    }
  }

  public function __set($key, $value) {
    $key = "set_$key";
    if (array_key_exists($key, $this->attribute_methods)) {
      return $this->attribute_methods[$key]($value);
    } else {
      throw new \Exception("method not found: $key");
    }
  }

  public static function toUnderScore($str) {
    $str = preg_replace('([A-Z]+)', '_$0', $str);
    $str = strtolower($str);
    $str = trim($str, '_');
    return $str;
  }

  public static function toCamelCase($str) {
    // TODO: IMPLEMENT
  }
}
