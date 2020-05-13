<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Flashcards Model
 *
 * @property \App\Model\Table\ThemesTable|\Cake\ORM\Association\BelongsTo $Themes
 * @property \App\Model\Table\FlashcardsUser7Table|\Cake\ORM\Association\HasMany $FlashcardsUser7
 *
 * @method \App\Model\Entity\Flashcard get($primaryKey, $options = [])
 * @method \App\Model\Entity\Flashcard newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Flashcard[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Flashcard|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Flashcard|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Flashcard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Flashcard[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Flashcard findOrCreate($search, callable $callback = null, $options = [])
 */
class FlashcardsTable extends Table
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

        $user_id = $_SESSION['Auth']['User']['id'];

        $this->setTable('flashcards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Themes', [
            'foreignKey' => 'theme_id'
        ]);

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id'
        ]);

        $this->hasOne('FlashcardsUser'.$user_id, [
            'foreignKey' => 'flashcard_id'
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
        $rules->add($rules->existsIn(['theme_id'], 'Themes'));

        return $rules;
    }
}
