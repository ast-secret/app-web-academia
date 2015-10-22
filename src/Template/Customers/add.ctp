<?= $this->assign('title', ' - Criar cliente') ?>


<?php 
	$this->Html->addCrumb('Clientes', ['action' => 'index']);
	$this->Html->addCrumb('Criar cliente');
	echo $this->Html->getCrumbList();
?>

<br>

<?php
	echo $this->Form->create($customer, ['novalidate' => true, 'horizontal' => true]);
	echo $this->Form->input('registration', ['label' => 'Matrícula']);
	echo $this->Form->input('name', ['label' => 'Nome']);
	echo $this->Form->input('email');
	echo $this->Form->input('password', ['label' => 'Senha']);
	echo $this->Form->input('confirm_password', ['type' => 'password', 'label' => 'Confirmar Senha']);
	
	echo $this->Form->input('is_active', ['label' => 'Ativo']);
	echo '<hr>';
	echo $this->Form->submit('Adicionar Cliente');
	echo $this->Form->end();
?>	