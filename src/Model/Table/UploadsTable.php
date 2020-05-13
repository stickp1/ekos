<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Uploads Model
 *
 * @property \App\Model\Table\ThemesTable|\Cake\ORM\Association\BelongsTo $Themes
 *
 * @method \App\Model\Entity\Upload get($primaryKey, $options = [])
 * @method \App\Model\Entity\Upload newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Upload[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Upload|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Upload|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Upload patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Upload[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Upload findOrCreate($search, callable $callback = null, $options = [])
 */
class UploadsTable extends Table
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

        $this->setTable('uploads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Themes', [
            'foreignKey' => 'theme_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'owner'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
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
            ->scalar('url')
            ->maxLength('url', 140)
            ->allowEmpty('url');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmpty('type');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->integer('owner')
            ->allowEmpty('owner');

        $validator
            ->dateTime('timestamp')
            ->allowEmpty('timestamp');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */

}
