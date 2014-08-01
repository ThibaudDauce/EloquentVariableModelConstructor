<?php namespace ThibaudDauce\EloquentVariableModelConstructor;

trait VariableModelConstructorTrait {

  /**
   * Database field indicated class name.
   *
   * @var string
   */
  protected $class_name_field = 'class_name';

  /**
   * Create a new model instance that is existing.
   *
   * @override Illuminate\Database\Eloquent\Model
   * @param  array  $attributes
   * @return \Illuminate\Database\Eloquent\Model|static
   */
  public function newFromBuilder($attributes = array())
  {
    if (!isset($attributes->$class_name_field))
      return parent::newFromBuilder($attributes);

    $class = $attributes->$class_name_field;
    $instance = new $class;

    $instance->setRawAttributes((array) $attributes, true);

    return $instance;
  }

}
