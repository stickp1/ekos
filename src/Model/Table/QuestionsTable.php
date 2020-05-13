<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Questions Model
 *
 * @property \App\Model\Table\ExamsTable|\Cake\ORM\Association\BelongsTo $Exams
 * @property \App\Model\Table\ThemesTable|\Cake\ORM\Association\BelongsTo $Themes
 * @property |\Cake\ORM\Association\BelongsTo $Courses
 *
 * @method \App\Model\Entity\Question get($primaryKey, $options = [])
 * @method \App\Model\Entity\Question newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Question[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Question|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Question|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Question patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Question[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Question findOrCreate($search, callable $callback = null, $options = [])
 */
class QuestionsTable extends Table
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

        $this->setTable('questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Exams', [
            'foreignKey' => 'exam_id'
        ]);
        $this->belongsTo('Themes', [
            'foreignKey' => 'theme_id'
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id'
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

        $validator
            ->scalar('op1')
            ->allowEmpty('op1');

        $validator
            ->scalar('op2')
            ->allowEmpty('op2');

        $validator
            ->scalar('op3')
            ->allowEmpty('op3');

        $validator
            ->scalar('op4')
            ->allowEmpty('op4');

        $validator
            ->scalar('op5')
            ->allowEmpty('op5');
            
        $validator
            ->scalar('a1')
            ->allowEmpty('a1');
            
        $validator
            ->scalar('a2')
            ->allowEmpty('a2');
            
            
        $validator
            ->scalar('a3')
            ->allowEmpty('a3');
            
        $validator
            ->scalar('a4')
            ->allowEmpty('a4');
			
		$validator
            ->scalar('a5')
            ->allowEmpty('a5');
	
        $validator
            ->scalar('justification')
            ->maxLength('justification', 4294967295)
            ->allowEmpty('justification');

        $validator
            ->scalar('question')
            ->maxLength('question', 4294967295)
            ->allowEmpty('question');

        $validator
            ->scalar('correct')
            ->maxLength('correct', 255)
            ->allowEmpty('correct');

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
        $rules->add($rules->existsIn(['exam_id'], 'Exams'));
        $rules->add($rules->existsIn(['theme_id'], 'Themes'));
        $rules->add($rules->existsIn(['course_id'], 'Courses'));

        return $rules;
    }
}
