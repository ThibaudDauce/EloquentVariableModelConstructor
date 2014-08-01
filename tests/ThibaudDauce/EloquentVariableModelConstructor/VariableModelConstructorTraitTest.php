<?php
use ThibaudDauce\EloquentVariableModelConstructor\VariableModelConstructorTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class VariableModelConstructorTraitTest extends PHPUnit_Framework_TestCase {

  public $character;
  public $characterCustomClassnameField;
  public $warrior;

  public function setUp()
  {
    parent::setUp();

    // Build some objects for our tests
    $this->character              = new Character;
    $this->warrior                = new Warrior;

    $this->characterCustomClassnameField = new CharacterCustomClassnameField;
  }

  public function tearDown()
  {
    //
  }

  public function testNewFromBuilderDefaultClassnameField()
  {
    // Test without a class_name
    $character = new Character;
    $characterAttributes = ['name' => 'Antoine'];
    $character = $character->newFromBuilder($characterAttributes);

    $this->assertTrue($character instanceof Character);
    $this->assertFalse($character instanceof Warrior);
    $this->assertFalse($character instanceof Wizard);
    $this->assertEquals($characterAttributes['name'], $character->getAttribute('name'));

    // Test with a class_name
    $character = new Character;
    $characterAttributes = ['class_name' => 'Warrior', 'name' => 'Antoine', 'rage' => 42];
    $warrior = $character->newFromBuilder($characterAttributes);

    $this->assertTrue($warrior instanceof Warrior);
    $this->assertEquals($characterAttributes['name'], $warrior->getAttribute('name'));
    $this->assertEquals($characterAttributes['rage'], $warrior->getAttribute('rage'));
  }

  public function testNewFromBuilderSpecificClassnameField()
  {
    // Test with a class_name (wrong class_name_field)
    $character = new CharacterCustomClassnameField;
    $characterAttributes = ['class_name' => 'Warrior', 'name' => 'Antoine'];
    $character = $character->newFromBuilder($characterAttributes);

    $this->assertTrue($character instanceof CharacterCustomClassnameField);
    $this->assertFalse($character instanceof Warrior);
    $this->assertEquals($characterAttributes['name'], $character->getAttribute('name'));

    // Test with a custom_class_name_field (right class_name_field)
    $character = new CharacterCustomClassnameField;
    $characterAttributes = ['custom_class_name_field' => 'Warrior', 'name' => 'Antoine'];
    $character = $character->newFromBuilder($characterAttributes);

    $this->assertTrue($character instanceof Warrior);
    $this->assertTrue($character instanceof Character);
    $this->assertEquals($characterAttributes['name'], $character->getAttribute('name'));
  }
}

// The parent classes
class Character extends Eloquent {

  use VariableModelConstructorTrait;
}

class CharacterCustomClassnameField extends Eloquent {

  use VariableModelConstructorTrait;

  protected function getClassnameField() { return 'custom_class_name_field'; }
}

// Child classe
class Warrior extends Character {

}
