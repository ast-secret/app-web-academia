<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Network\Exception\NotFoundException;
use Cake\Collection\Collection;

/**
 * Services Controller
 *
 * @property \App\Model\Table\ServicesTable $Services */
class ServicesController extends AppController
{

    public $helpers = ['Weekdays'];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $conditions = [];
        /**
         * Filtra a busca da caixa de busca
         * @var string
         */
        $q = $this->request->query('q');
        if ($q) {
            $conditions[] = ['Services.name LIKE' => "%{$q}%"];
        }

        $tab = (int)$this->request->query('tab');

        switch ($tab) {
            case 0:
                $conditions[] = ['Services.is_active' => 1];
                break;
            case 1:
                $conditions[] = ['Services.is_active' => 0];
                break;
        }

        $conditions[] = ['Services.gym_id' => $this->Auth->user('gym_id')];
        
        $this->paginate = [
            'conditions' => $conditions,
            // 'contain' => [
            //     'Times' => [
            //         'strategy' => 'select',
            //         'queryBuilder' => function($q){
            //             return $q->order(['weekday' => 'ASC', 'start_hour' => 'ASC']);
            //         }
            //     ]
            // ],
            // 'order' => ['Times.weekday_id' => 'DESC'],
            'order' => ['Services.description' => 'DESC']
        ];
        $this->set('services', $this->paginate($this->Services));

        $this->set(compact('tab'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $service = $this->Services->newEntity();

        if ($this->request->is('post')) {

            /**
             * O ID deve ser inserido antes do patchEntity pois é usado na validação
             * de nome único 
             */
            $this->request->data['gym_id'] = $this->Auth->user('gym_id');
            $service = $this->Services->patchEntity($service, $this->request->data);

            if ($this->Services->save($service)) {
                $this->Flash->success('A aula foi salva com sucesso.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('A aula não pode ser salva, por favor tente novamente.');    
            }
        }

        $this->set(compact('service'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Service id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $service = $this->Services->get($id);
        $gym_id = $this->Auth->user('gym_id');

        if ($service->gym_id != $gym_id) {
            throw new NotFoundException();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->request->data['gym_id'] = $gym_id;
            $service = $this->Services->patchEntity($service, $this->request->data);

            $service->accessible('gym_id', false);
            if ($this->Services->save($service)) {
                $this->Flash->success('A aula foi editada com sucesso.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('A aula não pode ser salva, por favor tente novamente.');
            }
        }

        $this->set(compact('service'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Service id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $service = $this->Services->get($id);
        if ($this->Services->delete($service)) {
            $this->Flash->success('The service has been deleted.');
        } else {
            $this->Flash->error('The service could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
    public function times()
    {
        $id = $this->request->service_id;
        if (!$id) {
            throw new NotFoundException("Aula não informada");
        }
        $service = $this->Services->get($id, [
            'contain' => ['Times' => function($q){
                return $q->order(['start_hour']);
            }],
            'conditions' => [
                'gym_id' => $this->Auth->user('gym_id')
            ],
        ]);

        if (!$service) {
            throw new NotFoundException("Aula não encontrada");
        }
        
        $times = new Collection($service->times);
        $timesById = $times->groupBy('weekday');

        $this->set(compact('service', 'timesById'));
        $this->set(['timesById' => $timesById->toArray()]);
    }
    public function timesEdit()
    {
        $service_id = $this->request->service_id;
        $weekday = $this->request->weekday;
        if (!$service_id) {
            throw new NotFoundException("Aula não informada");
        }
        if ($weekday < 1 || $weekday > 7) {
            throw new NotFoundException("Dia da semana inválido.");
        }
        $service = $this->Services->get($service_id, [
            'contain' => ['Times' => function($q){
                return $q->where(['Times.weekday' => $this->request->weekday]);
            }],
            'conditions' => [
                'gym_id' => $this->Auth->user('gym_id')
            ]
        ]);

        if (!$service) {
            throw new NotFoundException("Aula não encontrada");
        }

        if ($this->request->is(['put', 'post'])) {
            $this->request->data['weekday'] = $weekday;
            
            $service->accessible('*', false);
            $service->accessible('times', true);
            /** 
             * Precisa liberar pois é usado no deleteall
             */
            $service->accessible('weekday', true);

            $service = $this->Services->patchEntity($service, $this->request->data);

            if ($this->Services->save($service)) {
                $this->Flash->success('Horários salvos com sucesso.');
                return $this->redirect(['action' => 'times', 'service_id' => $service_id]);
            } else {
                $this->Flash->error('Ocorreu um erro ao salvar os seus horários. Por favor, tente novamente.');
            }
        }

        $this->set(['service' => $service]);
    }
}
