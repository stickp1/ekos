<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Themes Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsTo $Courses
 * @property |\Cake\ORM\Association\HasMany $Uploads
 *
 * @method \App\Model\Entity\Theme get($primaryKey, $options = [])
 * @method \App\Model\Entity\Theme newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Theme[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Theme|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Theme|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Theme patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Theme[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Theme findOrCreate($search, callable $callback = null, $options = [])
 */
class ThemesTable extends Table
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

        $this->setTable('themes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Courses', [
            'foreignKey' => 'courses_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Uploads', [
            'foreignKey' => 'theme_id'
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
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        $validator
            ->scalar('bibliography_1')
            ->maxLength('bibliography_1', 255)
            ->allowEmpty('bibliography_1');

        $validator
            ->scalar('bibliography_2')
            ->maxLength('bibliography_2', 255)
            ->allowEmpty('bibliography_2');

        $validator
            ->boolean('MD')
            ->allowEmpty('MD');

        $validator
            ->boolean('D')
            ->allowEmpty('D');

        $validator
            ->boolean('P')
            ->allowEmpty('P');

        $validator
            ->boolean('T')
            ->allowEmpty('T');

        $validator
            ->boolean('GD')
            ->allowEmpty('GD');

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
        $rules->add($rules->existsIn(['courses_id'], 'Courses'));

        return $rules;
    }
}
