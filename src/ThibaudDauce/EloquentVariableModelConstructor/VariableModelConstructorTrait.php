<?php namespace ThibaudDauce\EloquentVariableModelConstructor;

trait VariableModelConstructorTrait {

  /**
   * Get class name field.
   *
   * @return string
   */
  protected function getClassnameField()
  {
    return 'class_name';
  }

  /**
   * Create a new model instance that is existing.
   *
   * @override Illuminate\Database\Eloquent\Model
   * @param  array  $attributes
   * @return \Illuminate\Database\Eloquent\Model|static
   */
  public function newFromBuilder($attributes = array())
  {
    if (!isset($attributes[$this->getClassnameField()]))
      return parent::newFromBuilder($attributes);

    $class = $attributes[$this->getClassnameField()];
    $instance = new $class;

    $instance->setRawAttributes((array) $attributes, true);

    return $instance;
  }

}
