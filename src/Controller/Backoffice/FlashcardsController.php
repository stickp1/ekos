<?php
namespace App\Controller\Backoffice;


use App\Controller\Backoffice\AppController;
use Cake\ORM\TableRegistry;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FlashcardsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($course_id = null, $category = null)
    {
        $id = $this->Auth->user('id');
        $user = $this->loadModel('Users')->get($id, [
            'contain' => ['Moderators']
            ])->toArray();

        if($user['moderators'] != ''):
            $moderators = array();
        foreach ($user['moderators']  as $key => $value) {
            array_push($moderators, $value['courses_id']);
        }
        endif;

        if(!isset($category))
            $category = 2;

        $this->paginate = [
            'NewFlashcardsTable' => [
                'scope' => 'new_flashcards',
            ],
            'FlashcardsTable' => [
                'scope' => 'old_flashcards',
            ]
        ];

        TableRegistry::setConfig('NewFlashcardsTable', [
            'className' => 'App\Model\Table\FlashcardsTable',
            'table' => 'flashcards',
            'entityClass' => 'App\Model\Entity\Flashcard'
        ]);

        
        $themes = $this->loadModel('Themes')->find('list')->toArray();

        $user_cats = ['Flashcards privados', 'Flashcards públicos', 'Flashcards por validar'];

        $flashcards = $this->Flashcards->find('all', [
                'scope' => 'old_flashcards',
                'contain' => 'Courses'
            ])->where(['active !=' => 2]);

        $pendingFlashcards = TableRegistry::getTableLocator()->get('NewFlashcardsTable')->find('all', [
                'scope' => 'new_flashcards',
                'contain' => 'Courses'
            ])->where([
                'active' => $category, 
                'user_ids !=' => 'NULL'
            ]);


        if($course_id) {
            $flashcards->where(['course_id' => $course_id]);
            $pendingFlashcards->where(['course_id' => $course_id]);
        }

        if($user['role'] > 2)
            $courses = $this->loadModel('Courses')->find('list')->toArray();
        else {
            $flashcards->where(['course_id in ('.implode(',', $moderators).')']);
            $courses = $this->loadModel('Courses')->find('list', [
                'conditions' => 'id in ('.implode(',', $moderators).')'
            ])->toArray();
        }

        $flashcards = $this->paginate($flashcards);
        $pendingFlashcards = $this->paginate($pendingFlashcards);

        $this->set(compact('flashcards', 'pendingFlashcards', 'themes', 'courses', 'user_cats','category'));
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Exams', 'Themes']
        ]);

        $this->set('question', $question);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $flashcard = $this->Flashcards->newEntity();

        $id = $this->Auth->user('id');
        $user = $this->loadModel('Users')->get($id, [
            'contain' => ['Moderators']
            ])->toArray();

        if($user['moderators'] != ''):
            $moderators = array();
            foreach ($user['moderators']  as $key => $value) {
                array_push($moderators, $value['courses_id']);
            }
        endif;

        if($user['role'] > 2):

            $courses = $this->loadModel('Courses')->find('list')->toArray();

        else:

            $courses = $this->loadModel('Courses')->find('list', ['conditions' => 'id in ('.implode(',', $moderators).')'])->toArray();

        endif;


        if ($this->request->is('post')) {
            $flashcards = $this->Flashcards->patchEntity($flashcard, $this->request->getData());
            
            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success(__('O flashcard foi guardado'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $themes = $this->Flashcards->Themes->find('list', ['limit' => 500]);
        $this->set(compact('flashcard', 'courses', 'themes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flashcard = $this->Flashcards->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $flashcard = $this->Flashcards->patchEntity($flashcard, $this->request->getData());

            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success(__('O flashcard foi guardado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        $themes = $this->Flashcards->Themes->find('list', ['conditions' => ['courses_id' => $flashcard->course_id]]);
        $this->set(compact('flashcard', 'themes'));
    }


    public function toggle($id = null)
    {
        if($this->request->is('post')) {
            $flashcards = $this->Flashcards->get($id);
            if ($flashcards['active'] == 1)
                $flashcards['active'] = 0; 
            else 
                $flashcards['active'] = 1;

            $this->Flashcards->save($flashcards);
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $flashcard = $this->Flashcards->get($id);
        if ($this->Flashcards->delete($flashcard)) {
            $this->Flash->success(__('O flashcard foi eliminado'));
        } else {
            $this->Flash->error(__('Ocorreu um erro. Por favor, tenta novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}
