<?php
namespace App\Controller\Backoffice;

use App\Controller\Backoffice\AppController;

/**
 * Classes Controller
 *
 * @property \App\Model\Table\ClassesTable $Classes
 *
 * @method \App\Model\Entity\Class[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FrontendController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function edit($id = 1)
    {
        $content = $this->Frontend->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->Frontend->patchEntity($content, $this->request->getData());
            if ($this->Frontend->save($content)) {
                $this->Flash->success(__('O texto foi atualizado.'));
            } else {

            $this->Flash->error(__('Ocorreu um erro.'));}
        
        }
        
        $this->set(compact('content', 'id'));
    }

    public function matrix()
    {
        $themes = $this->loadModel('Themes')->find('all', ['order' => ['domain', 'area']]);
        
        $this->set(compact('themes'));
    }

   
}
