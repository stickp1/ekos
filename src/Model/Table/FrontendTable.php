<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Frontend Model
 *
 * @method \App\Model\Entity\Frontend get($primaryKey, $options = [])
 * @method \App\Model\Entity\Frontend newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Frontend[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Frontend|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Frontend|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Frontend patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Frontend[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Frontend findOrCreate($search, callable $callback = null, $options = [])
 */
class FrontendTable extends Table
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

        $this->setTable('frontend');
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
            ->allowEmpty('id');

        $validator
            ->scalar('content')
            ->maxLength('content', 4294967295)
            ->allowEmpty('content');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        return $validator;
    }
}
