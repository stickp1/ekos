<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FeedUserSurveys Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\LecturesTable|\Cake\ORM\Association\BelongsTo $Lectures
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsTo $Courses
 *
 * @method \App\Model\Entity\FeedUserSurvey get($primaryKey, $options = [])
 * @method \App\Model\Entity\FeedUserSurvey newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FeedUserSurvey[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FeedUserSurvey|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeedUserSurvey|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeedUserSurvey patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FeedUserSurvey[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FeedUserSurvey findOrCreate($search, callable $callback = null, $options = [])
 */
class FeedUserSurveysTable extends Table
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

        $this->setTable('feed_user_surveys');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Lectures', [
            'foreignKey' => 'lecture_id'
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
            ->scalar('code')
            ->maxLength('code', 10)
            ->allowEmpty('code');

        $validator
            ->integer('answered')
            ->allowEmpty('answered');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['lecture_id'], 'Lectures'));
        $rules->add($rules->existsIn(['course_id'], 'Courses'));

        return $rules;
    }
}
