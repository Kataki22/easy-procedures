<?php $this->assign('title', 'Procedures'); ?>

<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-500">Procedures</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-8">
    <h1 class="text-2xl font-semibold leading-6 text-gray-900"><?= __('Available Procedures') ?></h1>
    <p class="mt-2 text-sm text-gray-700">Choose a procedure to begin your request.</p>
</div>

<div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <?php foreach ($procedures as $procedure) : ?>
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md flex flex-col">
            <div class="aspect-video w-full overflow-hidden bg-gray-100 shrink-0">
                <?php
                    $imgFile = $procedure->image && file_exists(WWW_ROOT . 'template' . DS . 'images' . DS . $procedure->image)
                        ? $procedure->image
                        : 'procedure_default.jpg';
                ?>
                <img src="<?= $this->Url->build('/template/images/' . $imgFile) ?>" alt="<?= h($procedure->name) ?>" class="h-full w-full object-cover">
            </div>
            <div class="p-6 flex flex-col flex-1">
                <h3 class="text-lg font-semibold leading-6 text-gray-900"><?= h($procedure->name) ?></h3>
                <p class="mt-2 text-sm text-gray-500 line-clamp-2 flex-1"><?= h($procedure->description) ?></p>
                <div class="mt-6 shrink-0">
                    <a href="<?= $this->Url->build(['action' => 'details', $procedure->id]); ?>" class="inline-flex w-full justify-center items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        View Details <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
