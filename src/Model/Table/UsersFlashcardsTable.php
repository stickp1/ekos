<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersFlashcards Model
 *
 * @property \App\Model\Table\FlashcardsTable|\Cake\ORM\Association\BelongsTo $Flashcards
 * @property \App\Model\Table\FlashcardsTable|\Cake\ORM\Association\BelongsTo $Flashcards
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\UsersFlashcard get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersFlashcard newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsersFlashcard[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersFlashcard|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersFlashcard|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersFlashcard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersFlashcard[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersFlashcard findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersFlashcardsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users_flashcards');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['flashcard_id', 'user_id']);

        $this->belongsTo('Flashcards', [
            'foreignKey' => 'flashcard_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }
}
