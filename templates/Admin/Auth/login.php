<?php $this->assign('title', 'Portail Administration - Connexion'); ?>

<div class="mb-8 text-center">
    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10 mb-4">Admin</span>
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Administration</h2>
</div>

<?= $this->Form->create(null, ['class' => 'space-y-6']); ?>
    <?= $this->Form->control('email', [
        'type' => 'email', 
        'label' => ['text' => 'Adresse email', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'placeholder' => 'admin@easy-procedures.com',
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6'
        ]); ?>

        <?= $this->Form->control('password', [
        'type' => 'password',
        'label' => ['text' => 'Mot de passe', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'placeholder' => '••••••••',
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6'
    ]) ?>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-colors">
            Se connecter
        </button>
    </div>
<?= $this->Form->end(); ?>

<div class="mt-6 text-center">
    <a href="<?= $this->Url->build('/') ?>" class="text-sm font-medium text-gray-600 hover:text-gray-500">
        &larr; Retour à l'accueil
    </a>
</div>
