<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Controller\Component\AuthComponent;
use Cake\Datasource\ConnectionManager;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        if ($this->request->is('ajax')) {
            $data = $this->request->data;

            $connection = ConnectionManager::get('default');
            
            $qCount = 'select count(*) count from messages as m '
                . 'where m.lat >= :slat and m.lat <= :nlat '
                . 'and m.lng >= :wlng and m.lng <= :elng';
            
            $q = 'select m.id, m.title, m.message, m.lat, m.lng, u.username from messages as m '
                . 'join users as u on m.user_id = u.id '
                . 'where m.lat >= :slat and m.lat <= :nlat '
                . 'and m.lng >= :wlng and m.lng <= :elng';

            $where = ['slat' => $data['slat'],
                    'nlat' => $data['nlat'],
                    'wlng' => $data['wlng'],
                    'elng' => $data['elng']];
            
            if ( isset($data['limit']) ) {
                $q .= ' limit :limit ';
                $where['limit'] = $data['limit'];
            }
            if ( isset($data['offset']) ) {
                $q .= ' offset :offset';
                $where['offset'] = $data['offset'];
            }
            
            $count = $connection->execute($qCount, $where)->fetchAll('assoc');
            $result = $connection->execute($q, $where)->fetchAll('assoc');

            echo json_encode(['count' => $count[0]['count'], 'data' => $result]);
            die();
        }
        $this->paginate = [
            'contain' => ['Users']
        ];
        $messages = $this->paginate($this->Messages);

        $this->set(compact('messages'));
        $this->set('_serialize', ['messages']);
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['Users', 'Messages']
        ]);

        $this->set('message', $message);
        $this->set('_serialize', ['message']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Messages->newEntity();
        if ($this->request->is(['patch', 'post', 'put', 'ajax'])) {
//        if ($this->request->is('ajax')) {
            $message = $this->Messages->patchEntity($message, $this->request->data);
            $message->user_id = $this->Auth->user('id');
            $message->type = $message->message_id ? 'comment' : 'message';
            if ($this->Messages->save($message)) {
                if ($this->request->is('ajax')) {
                    echo json_encode('SUCCESS');
                    die();
                }
                $this->Flash->success(__('The message has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                if ($this->request->is('ajax')) {
                    echo json_encode('ERROR');
                    die();
                }
                $this->Flash->error(__('The message could not be saved. Please, try again.'));
            }
        }
        $users = $this->Messages->Users->find('list', ['limit' => 200]);
        $this->set(compact('message', 'users'));
        $this->set('_serialize', ['message']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put', 'ajax'])) {
            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The message could not be saved. Please, try again.'));
            }
        }
        $users = $this->Messages->Users->find('list', ['limit' => 200]);
        $this->set(compact('message', 'users'));
        $this->set('_serialize', ['message']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
