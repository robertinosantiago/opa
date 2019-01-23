<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rubric Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $file
 * @property bool $draft
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Question[] $questions
 */
class Rubric extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'description' => true,
        'file' => true,
        'draft' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'user' => true,
    ];

    protected function _getFullInfo(){
      return $this->_properties['title'] . ' - ' . $this->getNWordsFromString($this->_properties['description']);
    }

    public function getNWordsFromString($text,$numberOfWords = 10) {
      if($text != null) {
          $text = strip_tags($text);
          $textArray = explode(" ", $text);
          if(count($textArray) > $numberOfWords) {
              return implode(" ",array_slice($textArray, 0, $numberOfWords))."...";
          }
          return $text;
      }
      return "";
    }

}
