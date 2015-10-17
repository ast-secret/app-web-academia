<?= $this->assign('title', ' - Comunicados') ?>

<?php 
    $this->Html->addCrumb('Comunicados');
    echo $this->Html->getCrumbList();
?>

<div class="row row-add-button">
    <div class="col-md-12">
        <?= $this->Html->link($this->Html->icon('plus') . ' Criar Comunicado', [
            'action' => 'add'
        ], [
            'class' => 'btn btn-danger pull-right',
            'escape' => false
        ])?>  
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form method="GET" class="form-inline">
            <div class="form-group">
                <input
                    class="form-control"
                    id="q"
                    name="q"
                    placeholder="Pesquisar pelo texto..."
                    type="text"
                    value="<?= $this->request->query('q')?>">
            </div>
            <div class="form-group">
                <label class="sr-" for="from">De</label>
                <input
                    class="form-control"
                    id="from"
                    name="from"
                    placeholder="De"
                    type="date"
                    value="<?= $this->request->query('from') ?>">
            </div>
            <div class="form-group">
                <label class="sr-" for="to">Até</label>
                <input
                    class="form-control" 
                    id="to"
                    name="to"
                    type="date"
                    value="<?= $this->request->query('to') ?>">
            </div>     
            <div class="form-group">
                <button type="submit" class="btn btn-default" type="button" title="Pesquisar">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </form>
    </div>
</div>
<hr>

<ul class="nav nav-tabs">
    <li
        role="presentation"
        class="<?= $tab == '1' ? 'active' : '' ?>">
        <?= $this->Html->link('Publicados', [ 'action' => 'index', '?' => ['tab' => '1']]) ?>
    </li>
    <li
        role="presentation"
        class="<?= $tab == '2' ? 'active' : '' ?>">
        <?= $this->Html->link('Não publicados', [ 'action' => 'index', '?' => ['tab' => '2']]) ?>
    </li>
    <li
        role="presentation"
        class="<?= $tab == '3' ? 'active' : '' ?>">
        <?= $this->Html->link('Todos', ['action' => 'index','?' => ['tab' => '3']]) ?>
    </li>
</ul>

<br>
<div class="table-responsive">
    <table class="table table-striped">
        <tbody>
            <?php if (count($releases) > 0): ?>
                <?php foreach ($releases as $release): ?>
                    <tr>
                        <td class="text-center" style="width: 120px;">
                            <?= $this->TextBootstrap->labelBoolean($release->is_active,
                                'Publicado',
                                'Não Publicado'
                            ) ?>
                        </td>
                        <td>
                            <?= $this->Html->link(
                                h($release->user->name),
                                [
                                    'controller' => 'Users',
                                    'action' => 'index',
                                    '?' => ['q' => h($release->user->name)]
                                ],
                                [
                                    'escape' => true,
                                    'title' => $release->user->name
                                ])
                            ?>
                            <br>
                            <em class="text-muted">
                                <?= $this->Time->timeAgoInWords(
                                    $release->created,
                                    [
                                        'format' => 'dd MMM',
                                        'end' => '+1 week'
                                    ]
                                ) ?>
                            </em>
                            <h4><?= h($release->title) ?></h4>
                            <p class="text-align: justify; text-justify: inter-word;">
                                <?= h($release->text) ?>
                            </p>
                        </td>
                        <td class="text-center" style="width: 80px;">
                            <?php if ($me_id == $release->user_id): ?>
                                <?= $this->Html->link(
                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                    ['action' => 'edit', $release->id], [
                                        'escape' => false,
                                        'class' => 'btn btn-default btn-xs',
                                        'title' => 'Editar'
                                    ])
                                ?>
                                <?= $this->Form->postLink(
                                    '<span class="glyphicon glyphicon-remove"></span>',
                                    ['action' => 'delete', $release->id], [
                                        'escape' => false,
                                        'confirm'=> 'Você realmente deseja deletar este comunicado? Esta operação não poderá ser desfeita.',
                                        'class' => 'btn btn-default btn-xs',
                                        'title' => 'Deletar'
                                    ])
                                ?>
                            <?php endif ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10"><em>Nenhum comunicado para exibir.</em></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->element('Common/paginator') ?>

</div>
