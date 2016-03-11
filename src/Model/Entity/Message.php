<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity.
 *
 * @property int $id
 * @property string $title
 * @property string $message
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $lat
 * @property string $lng
 * @property string $type
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $massage_id
 */
class Message extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
