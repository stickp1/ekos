<?php
namespace App\Controller\Backoffice;

use App\Controller\Backoffice\AppController;

/**
 * Themes Controller
 *
 * @property \App\Model\Table\ThemesTable $Themes
 *
 * @method \App\Model\Entity\Theme[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ThemesController extends AppController
{

    /**
     * Edit method
     *
     * @param string|null $id Theme id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($course = null, $id = null)
    {
        $theme = $this->Themes->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $theme = $this->Themes->patchEntity($theme, $this->request->getData());
            if ($this->Themes->save($theme)) {
                $this->Flash->success(__('O tema foi atualizado.'));
                return $this->redirect(['controller' => 'courses', 'action' => 'view', $course]);
            } else {

            $this->Flash->error(__('Ocorreu um erro.'));}

        
        
        }
        
        $this->set(compact('theme', 'courses'));
    }
}
