<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Machines Controller
 *
 * @property \App\Model\Table\MachinesTable $Machines */
class MachinesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Gyms']
        ];
        $this->set('machines', $this->paginate($this->Machines));
        $this->set('_serialize', ['machines']);
    }

    /**
     * View method
     *
     * @param string|null $id Machine id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $machine = $this->Machines->get($id, [
            'contain' => ['Gyms', 'CardsExercises']
        ]);
        $this->set('machine', $machine);
        $this->set('_serialize', ['machine']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $machine = $this->Machines->newEntity();
        if ($this->request->is('post')) {
            $machine = $this->Machines->patchEntity($machine, $this->request->data);
            if ($this->Machines->save($machine)) {
                $this->Flash->success('The machine has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The machine could not be saved. Please, try again.');
            }
        }
        $gyms = $this->Machines->Gyms->find('list', ['limit' => 200]);
        $this->set(compact('machine', 'gyms'));
        $this->set('_serialize', ['machine']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Machine id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $machine = $this->Machines->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $machine = $this->Machines->patchEntity($machine, $this->request->data);
            if ($this->Machines->save($machine)) {
                $this->Flash->success('The machine has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The machine could not be saved. Please, try again.');
            }
        }
        $gyms = $this->Machines->Gyms->find('list', ['limit' => 200]);
        $this->set(compact('machine', 'gyms'));
        $this->set('_serialize', ['machine']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Machine id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $machine = $this->Machines->get($id);
        if ($this->Machines->delete($machine)) {
            $this->Flash->success('The machine has been deleted.');
        } else {
            $this->Flash->error('The machine could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
