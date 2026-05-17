<?php
$this->assign('title', 'Dashboard');

$requestsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Requests');

$pendingCount  = $requestsTable->find()->where(['Requests.deleted' => 0, 'status' => 'pending'])->count();
$approvedCount = $requestsTable->find()->where(['Requests.deleted' => 0, 'status' => 'success'])->count();
$rejectedCount = $requestsTable->find()->where(['Requests.deleted' => 0, 'status' => 'rejected'])->count();
$totalCount    = $requestsTable->find()->where(['Requests.deleted' => 0, 'status !=' => 'Draft'])->count();

$pendingRequests = $requestsTable->find()
    ->contain(['Procedures', 'Users'])
    ->where(['Requests.deleted' => 0, 'status' => 'pending'])
    ->order(['Requests.created' => 'ASC'])
    ->limit(5)
    ->all();
?>

<!-- Page header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Espace Agent</h1>
        <p class="page-subtitle">Bonjour <?= isset($user) ? h($user->name) : '' ?> — voici les demandes à traiter</p>
    </div>
    <div class="flex items-center gap-2 text-xs text-gray-400">
        <i class="fa-solid fa-circle text-emerald-400 text-[8px]"></i>
        <?= date('l d F Y') ?>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <?php
    $stats = [
        ['fa-inbox',        'bg-amber-100',  'text-amber-600',  $pendingCount,  'À traiter',    '/agent/requests/pending'],
        ['fa-circle-check', 'bg-emerald-100','text-emerald-600',$approvedCount, 'Approuvées',   null],
        ['fa-circle-xmark', 'bg-red-100',    'text-red-600',    $rejectedCount, 'Rejetées',     null],
        ['fa-folder-open',  'bg-indigo-100', 'text-indigo-600', $totalCount,    'Total',        null],
    ];
    foreach ($stats as [$icon, $bg, $text, $val, $label, $link]) :
    ?>
    <div class="card card-body <?= $link ? 'hover:shadow-md transition-shadow cursor-pointer' : '' ?>"
         <?= $link ? "onclick=\"location.href='$link'\"" : '' ?>>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1"><?= $label ?></p>
                <p class="text-3xl font-bold text-gray-900"><?= $val ?></p>
            </div>
            <div class="w-10 h-10 rounded-xl <?= $bg ?> flex items-center justify-center flex-shrink-0">
                <i class="fa-solid <?= $icon ?> <?= $text ?>"></i>
            </div>
        </div>
        <?php if ($label === 'À traiter' && $pendingCount > 0) : ?>
        <div class="mt-3 flex items-center gap-1 text-xs text-amber-600 font-medium">
            <i class="fa-solid fa-arrow-up text-[10px]"></i> Action requise
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pending requests table + info panel -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Pending requests list -->
    <div class="lg:col-span-2 card">
        <div class="card-header">
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Demandes en attente de traitement</h2>
                <p class="text-xs text-gray-500 mt-0.5">Par ordre d'ancienneté</p>
            </div>
            <a href="/agent/requests/pending" class="text-xs font-medium text-amber-600 hover:text-amber-500">Voir toutes →</a>
        </div>

        <?php if (count($pendingRequests) > 0) : ?>
        <div class="table-wrap rounded-t-none border-0 rounded-b-xl overflow-hidden">
            <table class="table">
                <thead>
                    <tr>
                        <th>Procédure</th>
                        <th>Client</th>
                        <th>Soumis le</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingRequests as $req) : ?>
                    <tr>
                        <td class="font-medium text-gray-900"><?= h($req->procedure->name ?? '—') ?></td>
                        <td class="text-gray-500"><?= h($req->user->name ?? '—') ?></td>
                        <td class="text-gray-400 text-xs"><?= $req->created ? $req->created->format('d/m/Y') : '—' ?></td>
                        <td>
                            <a href="/agent/requests/firstview/<?= $req->id ?>"
                               class="btn-amber btn-sm">
                                Traiter
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else : ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fa-solid fa-inbox"></i></div>
            <p class="empty-state-title">Tout est traité !</p>
            <p class="empty-state-desc">Aucune demande en attente pour le moment.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Info / guide -->
    <div class="space-y-4">
        <div class="card card-body">
            <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-indigo-400"></i>
                Procédure de traitement
            </h3>
            <ol class="space-y-3">
                <?php foreach ([
                    ['Examiner la demande', 'Vérifier les informations soumises par le client'],
                    ['Contrôler les documents', 'Valider chaque pièce justificative téléversée'],
                    ['Prendre une décision', 'Approuver ou rejeter avec un commentaire'],
                ] as $i => [$step, $desc]) : ?>
                <li class="flex gap-3">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex items-center justify-center"><?= $i + 1 ?></span>
                    <div>
                        <p class="text-sm font-medium text-gray-800"><?= $step ?></p>
                        <p class="text-xs text-gray-500"><?= $desc ?></p>
                    </div>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>

        <?php if ($pendingCount > 0) : ?>
        <div class="rounded-xl bg-amber-50 border border-amber-200 p-4">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5"></i>
                <div>
                    <p class="text-sm font-semibold text-amber-900"><?= $pendingCount ?> demande(s) en attente</p>
                    <p class="text-xs text-amber-700 mt-0.5">Veuillez traiter les dossiers dans les meilleurs délais.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
