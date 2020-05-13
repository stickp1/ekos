<?php
namespace App\Controller\Backoffice;

use App\Controller\Backoffice\AppController;
use Cake\I18n\Time;

/**
 * Lectures Controller
 *
 * @property \App\Model\Table\LecturesTable $Lectures
 *
 * @method \App\Model\Entity\Lecture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LecturesController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($course, $id)
    {
        $lecture = $this->Lectures->newEntity();
        if ($this->request->is('post')) {
            $lecture = $this->Lectures->patchEntity($lecture, $this->request->getData());
            $lecture['group_id'] = $id;
            $lecture['themes'] = implode(',', $this->request->getData()['themes']);
            if($this->request->getData()['datetime'] != ''):
            $lecture['datetime'] = Time::createFromFormat('d/m/Y H:i',$this->request->getData('datetime'),'Europe/Lisbon'); endif;

            if ($this->Lectures->save($lecture)) {
                $this->Flash->success(__('A aula foi adicionada'));                
            } else {
            $this->Flash->error(__('Ocorreu um erro.'));
            }
        }

        return $this->redirect(['controller' => 'courses', 'action' => 'edit-group', $course, $id]);

    }

    /**
     * Edit method
     *
     * @param string|null $id Lecture id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($course, $id = null)
    {
        $lecture = $this->Lectures->get($id, [
            'contain' => []
        ]);

        $themes = $this->loadModel('Themes')->find('list', ['conditions' => ['courses_id' => $course, 'active' => 1]]);

        $users = $this->loadModel('Users')->find('all', ['conditions' => ['role >' => 0]])->toArray();
        foreach ($users as $key => $value) {
            $teachers[$value['id']] = $value['first_name']." ".$value['last_name'];
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $lecture = $this->Lectures->patchEntity($lecture, $this->request->getData());
            if($this->request->getData()['datetime'] != ''):
            $lecture['datetime'] = Time::createFromFormat('d/m/Y H:i',$this->request->getData('datetime'),'Europe/Lisbon'); endif;
            $lecture['themes'] = implode(',', $this->request->getData()['themes']);
            if ($this->Lectures->save($lecture)) {
                $this->Flash->success(__('Aula atualizada com sucesso'));

                return $this->redirect(['controller' => 'courses', 'action' => 'edit-group', $course, $lecture['group_id']]);
            }
            $this->Flash->error(__('Ocorreu um erro.'));
        }

        $this->set(compact('lecture', 'teachers', 'themes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lecture id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($course, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lecture = $this->Lectures->get($id);
        if ($this->Lectures->delete($lecture)) {
            $this->Flash->success(__('A aula foi apagada.'));
        } else {
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        return $this->redirect(['controller' => 'courses', 'action' => 'edit-group', $course, $lecture->group_id]);
    }
}
