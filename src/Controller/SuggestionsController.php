<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Suggestions Controller
 *
 * @property \App\Model\Table\SuggestionsTable $Suggestions */
class SuggestionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $breadcrumb = [
            'active' => 'Sugestões'
        ];

        $filter = !isset($this->request->query['filter']) ? 1 : (int)$this->request->query['filter'];

        switch ($filter) {
            case 1:
                $filterCondition = ['Suggestions.is_read' => 0];
                break;
            case 2:
                $filterCondition = [
                    'Suggestions.is_star' => 1
                ];
                break;
            case 3:
                $filterCondition = ['Suggestions.is_read' => 1];
                break;
            
            default:
                $filterCondition = [];
                break;
        }

        $this->paginate = [
            'contain' => ['Customers'],
            'conditions' => [
                $filterCondition
            ]
        ];

        $this->set(compact('breadcrumb', 'filter'));
        $this->set('suggestions', $this->paginate($this->Suggestions));
    }
    /**
     * View method
     *
     * @param string|null $id Suggestion id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {

        $breadcrumb = [
            'parents' => [
                [
                    'label' => 'Sugestões',
                    'url' => [
                        'action' => 'index'
                    ]
                ]
            ],
            'active' => 'Sugestão'
        ];

        $suggestion = $this->Suggestions->get($id, [
            'contain' => ['Customers']
        ]);
        $this->set(compact('breadcrumb'));
        $this->set('suggestion', $suggestion);
        $this->set('_serialize', ['suggestion']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $suggestion = $this->Suggestions->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['customer_id'] = 1;
            $suggestion = $this->Suggestions->patchEntity($suggestion, $this->request->data);
            if ($this->Suggestions->save($suggestion)) {
                $this->Flash->success('The suggestion has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The suggestion could not be saved. Please, try again.');
            }
        }
        //$customers = $this->Suggestions->Customers->find('list', ['limit' => 200]);
        $customers = $this->Suggestions->Customers->find('list', array('conditions' => array('Customers.id' => '1')));        
        $this->set(compact('suggestion', 'customers'));
        $this->set('_serialize', ['suggestion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Suggestion id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $suggestion = $this->Suggestions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $suggestion = $this->Suggestions->patchEntity($suggestion, $this->request->data);
            if ($this->Suggestions->save($suggestion)) {
                $this->Flash->success('The suggestion has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The suggestion could not be saved. Please, try again.');
            }
        }
        $customers = $this->Suggestions->Customers->find('list', ['limit' => 200]);
        $this->set(compact('suggestion', 'customers'));
        $this->set('_serialize', ['suggestion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Suggestion id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $suggestion = $this->Suggestions->get($id);
        if ($this->Suggestions->delete($suggestion)) {
            $this->Flash->success('The suggestion has been deleted.');
        } else {
            $this->Flash->error('The suggestion could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

}
