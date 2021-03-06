<div style="padding-top: 10px;padding-bottom: 10px;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4 class="sidemenu-brand">
					<?= ucwords(str_replace('-', ' ', $this->request->params['gym_slug'])) ?>
				</h4>
			</div>
		</div>
	</div>
</div>

<div class="sidemenu-name-display" style="margin-bottom: 20px;padding-top: 10px; padding-bottom: 10px;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10">
				<div class="media">
					<div class="media-left">

					</div>
					<div class="media-body">
						<span>
							<strong><?= $loggedinUser['short_name'] ?></strong>
							<br>
							<em>
								<small>
									<?= $loggedinUser['role']['name'] ?>
								</small>
							</em>
						</span>
					</div>
				</div>
			</div>	
			<div class="col-md-2 text-center">
				<button data-toggle="dropdown"
					class="dropdown-toggle  pull-right" style="margin-top: 10px; background: none; border: 0;">
					<span
						class="glyphicon glyphicon-chevron-down">
					</span>
				</button>

				<ul class="dropdown-menu dropdown-menu-right" role="menu">
					<li role="presentation" class="dropdown-header">
						<?= $loggedinUser['username'] ?>
					</li>
					<li role="presentation">
						<?= $this->Html->link('Configurações de conta', [
							'controller' => 'Users',
							'action' => 'mySettings'
						])
						?>
					</li>
					<li role="presentation" class="divider"></li>
					<li role="presentation">
						<!-- <a role="menuitem" tabindex="-1" href="#">Sair</a> -->
						<?= $this->Html->link('Sair', ['controller' => 'Users', 'action' => 'logout']) ?>
					</li>
				</ul>		
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<ul class="side-menu nav nav-pills nav-stacked">
				<?php foreach ($menuItems as $item): ?>
					<?php if (!in_array($item['controller'], $menuNotAllowedAuthorizations)): ?>
						<li
							class="<?= ($this->request->controller == $item['controller']) ? 'active' : '' ?>">
							<?= $this->Html->link(
								$item['label'],
								[
									'controller' => $item['controller'],
									'action' => $item['action']
								]
							)?>
						</li>
					<?php endif ?>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>