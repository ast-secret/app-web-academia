
<div>
	<div style="border-radius: 10px; background-color: #FFF; padding: 20px;">
		<h3 class="text-center">Entrar no sistema</h3>

		<br>
		<br>

		<?= $this->Form->input('username', ['label' => false, 'placeholder' => 'Email', 'class' => '', 'autofocus' => true]) ?>
		<?= $this->Form->input('password', ['label' => false, 'placeholder' => 'Senha', 'class' => '']) ?>
		<button class="btn btn-primary btn-block">
			Entrar
		</button>

		<br>
		<hr>
		<div class="text-center"><a href="#">Esqueceu a sua senha?</a></div>
	</div>
</div>