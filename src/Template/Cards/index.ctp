<?= $this->assign('title', ' - Fichas de exercícios de '. $customer->name) ?>

<?php 
    $this->Html->addCrumb('Clientes', ['controller' => 'Customers', 'action' => 'index']);
    $this->Html->addCrumb($customer->name, null);
    $this->Html->addCrumb('Fichas', null);
    echo $this->Html->getCrumbList();
?>


<?= $this->Html->link('Nova Ficha',
    ['action' => 'add', 'customer_id' => $customer->id],
    ['class' => 'btn btn-danger pull-right', 'escape' => false]) ?>

<!-- <h3><?= $customer->name ?></h3>
<hr> -->

<br style="clear: both;">

<br>

<ul class="nav nav-tabs">
    <li
        role="presentation"
        class="<?= $tab == '0' ? 'active' : '' ?>">
        <?= $this->Html->link('Ativas', ['action' => 'index', 'customer_id' => $customer_id,'?' => ['tab' => '0']]) ?>
    </li>
    <li
        role="presentation"
        class="<?= $tab == '1' ? 'active' : '' ?>">
        <?= $this->Html->link('Histórico', [
            'action' => 'index',
            'customer_id' => $customer_id,
            '?' => ['tab' => '1']
        ]) ?>
    </li>
</ul>
<br>

<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th style="width: 200px;">
                Instrutor
            </th>
            <th style="width: 200px;">
                Objetivo
            </th>
            <th>
                Observação
            </th>
            <th style="width: 200px;">
                Validade
            </th>
            <th style="width: 170px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cards as $card): ?>
            <tr>
                <td>
                    <?= h($card->user->name) ?>
                </td>

                <td>
                    <?= h($card->goal) ?>
                </td>
                <td>
                   <em class="text-muted">
                        <?= ($card->obs) ? h($card->obs) : 'Nenhuma observação' ?>
                    </em>
                </td>
                <td>
                    <?php if ($card->overdue): ?>
                        <em class="text-muted text-danger">
                            Vencida <?= $card->end_date_in_words ?>
                        </em>
                    <?php else: ?>
                        <em class="text-muted text-success">
                            Vence em <?= $card->end_date_in_words ?>
                        </em>
                    <?php endif ?>
                </td>
                <td style="vertical-align: middle;" class="text-center">
                    <?= $this->Html->link($this->Html->icon('fire'), [
                        'action' => 'exercises',
                        'card_id' => $card->id,
                        'customer_id' => $customer->id
                    ], [
                        'title' => 'Exercícios',
                        'escape' => false,
                        'class' => 'btn btn-default btn-xs'
                    ]) ?>
                    <?= $this->Html->link(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        [
                            'controller' => 'Cards',
                            'action' => 'edit',
                            'card_id' => $card->id
                        ],
                        [
                            'escape' => false,
                            'class' => 'btn btn-default btn-xs',
                            'title' => 'Editar'
                        ])
                    ?>
                    <?= $this->Html->link(
                        '<span class="glyphicon glyphicon-print"></span>',
                        [
                            'controller' => 'Cards',
                            'action' => 'printCard',
                            'card_id' => $card->id
                        ],
                        [
                            'target' => '_blank',
                            'escape' => false,
                            'class' => 'btn btn-default btn-xs',
                            'title' => 'Imprimir'
                        ]) ?>
                    <?= $this->Form->postLink(
                        '<span class="glyphicon glyphicon-remove"></span>',
                        [
                            'controller' => 'Cards',
                            'action' => 'delete',
                            'card_id' => $card->id
                        ],
                        [
                            'confirm' =>
                                'Você realmente deseja deletar esta ficha? esta ação não pode ser desfeita.',
                            'escape' => false,
                            'class' => 'btn btn-default btn-xs',
                            'title' => 'Deletar Ficha'
                        ])
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (count($cards) == 0): ?>
            <tr>
                <td colspan="6">Nenhuma ficha cadastrada ainda.</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
    
<?= $this->element('Common/paginator') ?>