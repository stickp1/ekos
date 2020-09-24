<?php
namespace App\Controller\Backoffice;

use App\Controller\Backoffice\AppController;
use Cake\I18n\Time;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\CoursesTable $Courses
 *
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    // public function index()
    // {
    //     $courses = $this->paginate($this->Courses);

    //     $this->set(compact('courses'));
    // }

    /**
     * View method
     *
     * @param string|null $id Course id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $course = $this->Courses->get($id, [
            'contain' => [
                'Themes', 
                'Groups' => [
                    'conditions' => [
                        'Groups.deleted' => 0
                    ]
                ], 
                'WaitingList' => [ 
                    'Users'
                ]
            ]
        ]);
        
        $cities = $this->loadModel('Cities')->find('list')->toArray();

        $this->set(compact('course', 'cities'));
    }

    public function edit($id = null)
    {
        $course = $this->Courses->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('O curso foi atualizado.'));
                return $this->redirect(['action' => 'view', $id]);
            } else {

            $this->Flash->error(__('Ocorreu um erro.'));}
        
        }
        
        $this->set(compact('course'));
    }

    public function toggleGroup($course = null, $id = null)
    {
        if($this->request->is('post')) {
            $group = $this->loadModel('Groups')->get($id);
            if ($group['active'] == 1){$group['active'] = 0;} else {$group['active'] = 1;}
            $this->loadModel('Groups')->save($group);
            return $this->redirect(['action' => 'view', $group['courses_id']]);
        }
    }

    public function addGroup($id)
    {
        $group = $this->loadModel('Groups')->newEntity();
        if ($this->request->is('post')) {
            $group['name'] = $this->request->data['name'];
            $group['city_id'] = $this->request->data['city_id'];
            $group['courses_id'] = $this->request->data['courses_id'];
            if ($this->loadModel('Groups')->save($group)) {
                $this->Flash->success(__('Turma criada com sucesso.'));
            } else {
            $this->Flash->error(__('Ocorreu um erro.'));
            }
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    public function deleteGroup($course = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->loadModel('Groups')->get($id);
        $group['deleted'] = 1;
        if ($this->loadModel('Groups')->save($group)) {
            $this->Flash->success(__('A turma foi eliminada.'));
        } else {
            $this->Flash->error(__('Não foi possível eliminar a turma.'));
        }

        return $this->redirect(['action' => 'view', $group['courses_id']]);
    }

    public function deleteWaiting($course = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->loadModel('WaitingList')->get($id);
        if ($this->loadModel('WaitingList')->delete($group)) {
            $this->Flash->success(__('O aluno foi removido.'));
        } else {
            $this->Flash->error(__('Não foi possível eliminar o aluno.'));
        }

        return $this->redirect(['action' => 'view', $course]);
    }

    public function toggleTheme($course = null, $id = null)
    {
        if($this->request->is('post')) {
            $theme = $this->loadModel('Themes')->get($id);
            if ($theme['active'] == 1){$theme['active'] = 0;} else {$theme['active'] = 1;}
            $this->loadModel('Themes')->save($theme);
            return $this->redirect(['action' => 'view', $theme['courses_id']]);
        }
    }

    public function addTheme($id)
    {
        $theme = $this->loadModel('Themes')->newEntity();
        if ($this->request->is('post')) {
            $theme['name'] = $this->request->data['name'];
            $theme['courses_id'] = $this->request->data['courses_id'];
            if ($this->loadModel('Themes')->save($theme)) {
                $this->Flash->success(__('Turma criada com sucesso.'));
            } else {
            $this->Flash->error(__('Ocorreu um erro.'));
            }
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    public function deleteTheme($course = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $theme = $this->loadModel('Themes')->get($id);
        if ($this->loadModel('Themes')->delete($theme)) {
            $this->Flash->success(__('A turma foi eliminada.'));
        } else {
            $this->Flash->error(__('Não foi possível eliminar a turma.'));
        }

        return $this->redirect(['action' => 'view', $theme['courses_id']]);
    }

    public function editGroup($course = null, $id = null)
    {
        $group = $this->loadModel('Groups')->get($id, ['contain' => ['Cities', 'Users', 'Lectures' => ['Users']]]);
        $users = $this->loadModel('Users')->find('all', ['conditions' => ['role >' => 0]])->toArray();
        $themes = $this->loadModel('Themes')->find('list', ['conditions' => ['courses_id' => $course, 'active' => 1]]);
        foreach ($users as $key => $value) {
            $teachers[$value['id']] = $value['first_name']." ".$value['last_name'];
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Courses->patchEntity($group, $this->request->getData());
            if ($this->loadModel('Groups')->save($group)) {
                $this->Flash->success(__('A turma foi atualizada.'));

                return $this->redirect(['action' => 'edit-group', $course, $id]);
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor tenta novamente.'));
        }
        $this->set(compact('group', 'teachers', 'themes'));
    }

    public function addUserGroup($course = null, $id)
    {
        $user_group = $this->loadModel('UsersGroups')->newEntity();
        if ($this->request->is('post')) {
            $user_group['groups_id'] = $id;
            $user_group['groups_courses_id'] = $this->request->data['courses_id'];
            $user_group['users_id'] = $this->request->data['user_id'];

            if(@$this->request->data['sale'] == 1){
                $group = $this->loadModel('Groups')->get($id, ['contain' => ['Courses']])->toArray();
                if($group['course']['price']) {$price = $group['course']['price'];} else {$price = 0;}
                $sale = $this->loadModel('Sales')->newEntity();
                $sale['users_id'] = $this->request->data['user_id'];
                $sale['value'] = $price;
                $sale = $this->loadModel('Sales')->save($sale);

                $product = $this->loadModel('Products')->newEntity();
                $product['group_id'] = $id;
                $product['group_courses_id'] = $this->request->data['courses_id'];
                $product['sale_id'] = $sale->id;
                $product['sales_users_id'] = $this->request->data['user_id'];
                $product['value'] = $price;

                if(!$product = $this->loadModel('Products')->save($product)){
                     $this->Flash->error(__('Ocorreu um erro ao gerar a venda.'));
                } else {
                     $this->Flash->success(__('Venda gerada com sucesso.'));
                }
            } else {

                //SÓ ADICIONA FORMANDO SE O OBJETIVO NÃO ERA GERAR VENDA
                if ($this->loadModel('UsersGroups')->save($user_group)) {
                    $this->Flash->success(__('Formando adicionado com sucesso.'));
                } else {
                $this->Flash->error(__('Ocorreu um erro.'));
                }

            }
        }

        return $this->redirect(['action' => 'edit-group', $course, $id]);
    }

    public function deleteUserGroup($course = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user_group = $this->loadModel('UsersGroups')->get($id);
        if ($this->loadModel('UsersGroups')->delete($user_group)) {
            $this->Flash->success(__('O formando foi removido.'));
        } else {
            $this->Flash->error(__('Ocoreu um erro.'));
        }

        return $this->redirect(['action' => 'edit-group', $course, $user_group['groups_id']]);
    }

    /*
    public function newYearGroups()
    {

        $this->loadModel('Lectures');
        $currentGroups = $this->loadModel('Groups')->find('all', [
            'conditions' => [
                'courses_id not in' => [1, 14, 15, 16, 17, 18],
                'active' => 1,
                'deleted' => 0
            ],
            'fields' => [
                'id',
                'name',
                'courses_id',
                'active',
                'deleted',
                'city_id'
            ]
        ]);

        if ($currentGroups->count() <= 50){

            foreach($currentGroups as $group){
                
                $newGroup = $this->Groups->newEntity();
                $newGroup->name = $group->name;
                $newGroup->courses_id = $group->courses_id;
                $newGroup->active = 0;
                $newGroup->city_id = $group->city_id;
                $newGroup = $this->Groups->save($newGroup);
                if(!$newGroup)
                    $this->Flash->error(__('Ocorreu um erro.'));
                
                $lectures = $this->Lectures->find('all', [
                    'conditions' => [
                        'group_id' => $group->id
                    ],
                    'fields' => [
                        'group_id',
                        'description',
                        'teacher',
                        'themes'
                    ]
                ]);
                
                foreach($lectures as $lecture){
                    $newLecture = $this->Lectures->newEntity();
                    $newLecture->group_id = $newGroup->id;
                    $newLecture->description = $lecture->description;
                    $newLecture->teacher = $lecture->teacher;
                    $newLecture->themes = $lecture->themes;
                    $newLecture = $this->Lectures->save($newLecture);
                    if(!$newLecture)
                        $this->Flash->error(__('Ocorreu um erro.'));
                }
            }
        }

        $this->Flash->success(__('Os grupos e aulas foram criados com sucesso (provavelmente).'));
    }
    */

    /*
    public function createOnlineCity()
    {

        $this->loadModel('Lectures');
        $currentGroups = $this->loadModel('Groups')->find('all', [
            'conditions' => [
                'courses_id not in' => [1, 14, 15, 16, 17, 18],
                'active' => 1,
                'deleted' => 0,
                'city_id' => 1,
                "name like '%Semana%'" 
            ],
            'fields' => [
                'id',
                'name',
                'courses_id',
                'active',
                'deleted',
                'city_id'
            ]
        ]);

        if ($currentGroups->count() == 11){

            $allnewlectures = [];
            $allnewgroups = [];

            foreach($currentGroups as $group){
                
                $newGroup = $this->Groups->newEntity();
                $newGroup->name = $group->name;
                $newGroup->courses_id = $group->courses_id;
                $newGroup->active = 0;
                $newGroup->city_id = 3;
                $newGroup = $this->Groups->save($newGroup);
                array_push($allnewgroups, $newGroup);
                if(!$newGroup)
                    $this->Flash->error(__('Ocorreu um erro.'));
                
                $lectures = $this->Lectures->find('all', [
                    'conditions' => [
                        'group_id' => $group->id
                    ],
                    'fields' => [
                        'group_id',
                        'description',
                        'teacher',
                        'themes',
                        'datetime'
                    ]
                ]);
                
                foreach($lectures as $lecture){
                    $newLecture = $this->Lectures->newEntity();
                    $newLecture->group_id = $newGroup->id;
                    $newLecture->description = $lecture->description;
                    $newLecture->teacher = $lecture->teacher;
                    $newLecture->themes = $lecture->themes;
                    $newLecture->datetime = $lecture->datetime;
                    $newLecture = $this->Lectures->save($newLecture);
                    array_push($allnewlectures, $newLecture);
                    if(!$newLecture)
                        $this->Flash->error(__('Ocorreu um erro.'));
                }
            }
        }
        $this->set(compact('allnewgroups', 'allnewlectures'));
        $this->Flash->success(__('Os grupos e aulas foram criados com sucesso (provavelmente).'));
    }
    /*
}
