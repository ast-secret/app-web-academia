<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

use Cake\Controller\Component\RequestHandlerComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $helpers = [
        'Form' => [
            'className' => 'Bootstrap.BootstrapForm'
        ],
        'Html' => [
            'className' => 'Bootstrap.BootstrapHtml'
        ],
        'Paginator' => [
            'className' => 'Bootstrap.BootstrapPaginator'
        ],
        'Modal' => [
            'className' => 'Bootstrap.BootstrapModal'
        ]
    ];

    public $menuNotAllowedAuthorizations = [
        '1' => [],
        '2' => ['Users', 'Suggestions', 'Releases', 'Services'],
        '3' => ['Users', '']
    ];

    public $authorizations = [
            '1' => [
                'allowed' => ['*']
            ],
            '2' => [
                'notAllowed' => ['*'],
                'allowed' => [
                    'Cards',
                    'Customers' => [
                        'notAllowed' => ['*'],
                        'allowed' => ['index']
                    ],
                    'Users' => [
                        'notAllowed' => ['*'],
                        'allowed' => ['mySettings', 'myPasswordSettings']
                    ]
                ],
            ],
            '3' => [
                'allowed' => [
                    'Users' => [
                        'notAllowed' => ['*'],
                        'allowed' => ['mySettings', 'myPasswordSettings']
                    ],
                    '*'
                ],
                'notAllowed' => [
                    'Cards'
                ]
            ]
        ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {

        $this->viewBuilder()->layout('custom');
        
        $this->loadComponent('RequestHandler');

        $menuItems = [
            [
                'label' => 'Clientes',
                'controller' => 'Customers',
                'action' => 'index',
            ],
            [
                'label' => 'Aulas',
                'controller' => 'Services',
                'action' => 'index',
            ],
            [
                'label' => 'Comunicados',
                'controller' => 'Releases',
                'action' => 'index',
            ],
            [
                'label' => 'Caixa de Sugestões',
                'controller' => 'Suggestions',
                'action' => 'index',
            ],
            [
                'label' => 'Usuários',
                'controller' => 'Users',
                'action' => 'index',
            ],
        ];

        $this->set(compact('menuItems'));

        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Customers',
                'action' => 'index'
            ],
            'authError' => 'Você deve fazer o login para acessar esta área.',
            'authenticate' => [
                'MyAuth' => [
                    'contain' => ['Gyms', 'Roles'],
                    'scope' => ['deleted' => 0, 'is_active' => 1]
                ]
            ]
        ]);

        $this->loadComponent('Flash');
    }

    public function beforeFilter(Event $event)
    {
        if ($this->Auth->user()) {
            if ($this->Auth->user('gym.slug') != $this->request->params['gym_slug'] && $this->request->action != 'login') {
                return $this->redirect(['controller' => 'Site', 'action' => 'home']);
            }

            $loggedinUser = $this->Auth->user();

            $shortName = explode(' ', $loggedinUser['name']);
            $total = count($shortName);
            $loggedinUser['short_name'] = ($total > 1) ? $shortName[0] . ' ' . $shortName[$total - 1] : $shortName[0];

            $this->set(compact('loggedinUser'));

            $this->set('menuNotAllowedAuthorizations', $this->menuNotAllowedAuthorizations[$loggedinUser['role']['id']]);
        }
        // Evita que ele vá para a tela de login já logado
        if (
            $this->request->controller == 'Users' &&
            $this->request->action == 'login' &&
            $this->Auth->user() &&
            $this->Auth->user('gym.slug') == $this->request->params['gym_slug']) {
            return $this->redirect(['controller' => 'Customers']);
        }
    }

    public function errorsToList($fields)
    {
        $list = '<dl>';

        foreach ($fields as $fieldKey => $field) {
            $list .= "<dt>{$fieldKey}</dt>";
            foreach ($field as $error) {
                $list .= "<dd>{$error}</dd>";
            }
        }
        
        $list .= '<dl>';

        return $list;
    }

    public function tabFilter($tab, $model)
    {
        $condition = [];
        switch ($tab) {
            case 0:
                $condition = [$model . '.is_active' => 1];
                break;
            case 1:
                $condition = [$model . '.is_active' => 0];
                break;
        }

        return $condition;
    }

    public function isAuthorized($user = null)
    {
        if ($this->request->param('controller') == 'Users' && $this->request->param('action') == 'logout') {
            return true;
        }

        return $this->myAuth($this->authorizations[$user['role_id']], 'controller');
    }
    protected function myAuth($array, $type)
    {
        $out = false;
        foreach ($array as $key => $values) {
            if ($key == 'allowed') {
                $tempOut = true;
            } else {
                $tempOut = false;
            }
            foreach ($values as $k => $v) {
                if ($v == '*') {
                    $out = $tempOut;
                    break;
                }
                $compair = '';
                if (is_array($v)) {
                    if ($this->request->param($type) == $k) {
                        return $this->myAuth($v, 'action');
                    }
                } else {
                    if ($this->request->param($type) == $v) {
                        $out = $tempOut;
                        break;
                    }
                }
            }
        }
        return $out;
    }
}
