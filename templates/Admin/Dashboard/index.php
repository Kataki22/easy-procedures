<?php
$this->assign('title', 'Tableau de bord');

$requestsTable   = \Cake\ORM\TableRegistry::getTableLocator()->get('Requests');
$proceduresTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Procedures');
$usersTable      = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');

$totalRequests  = $requestsTable->find()->where(['Requests.deleted' => 0, 'status !=' => 'Draft'])->count();
$pendingCount   = $requestsTable->find()->where(['Requests.deleted' => 0, 'status' => 'pending'])->count();
$approvedCount  = $requestsTable->find()->where(['Requests.deleted' => 0, 'status' => 'success'])->count();
$procedures     = $proceduresTable->find()->where(['deleted' => 0])->count();
$users          = $usersTable->find()->where(['deleted' => 0, 'id_role' => 2])->count();
$rejectedCount  = $requestsTable->find()->where(['Requests.deleted' => 0, 'status' => 'rejected'])->count();

$recentRequests = $requestsTable->find()
    ->contain(['Procedures', 'Users'])
    ->where(['Requests.deleted' => 0])
    ->order(['Requests.created' => 'DESC'])
    ->limit(5)
    ->all();
?>

<!-- Page header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Administrateur</h1>
        <p class="page-subtitle">Vue d'ensemble de la plateforme Easy Procedures</p>
    </div>
    <div class="flex items-center gap-2 text-xs text-gray-400">
        <i class="fa-solid fa-circle text-emerald-400 text-[8px]"></i>
        Mis à jour à <?= date('H:i') ?>
    </div>
</div>

<!-- Stat cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <?php
    $stats = [
        ['fa-folder-open',    'bg-indigo-100', 'text-indigo-600',  $totalRequests,  'Total demandes',    null],
        ['fa-clock',          'bg-amber-100',  'text-amber-600',   $pendingCount,   'En attente',        '/admin/requests/pending'],
        ['fa-circle-check',   'bg-emerald-100','text-emerald-600', $approvedCount,  'Approuvées',        null],
        ['fa-circle-xmark',   'bg-red-100',    'text-red-600',     $rejectedCount,  'Rejetées',          null],
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
    </div>
    <?php endforeach; ?>
</div>

<!-- Secondary stats -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
    <div class="card card-body flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-diagram-project text-violet-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Procédures actives</p>
            <p class="text-2xl font-bold text-gray-900"><?= $procedures ?></p>
        </div>
        <a href="/admin/procedures" class="ml-auto text-xs text-indigo-600 hover:underline flex-shrink-0">Gérer →</a>
    </div>
    <div class="card card-body flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-users text-blue-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Utilisateurs</p>
            <p class="text-2xl font-bold text-gray-900"><?= $users ?></p>
        </div>
        <a href="/admin/users" class="ml-auto text-xs text-indigo-600 hover:underline flex-shrink-0">Gérer →</a>
    </div>
    <div class="card card-body flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-chart-line text-emerald-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Taux d'approbation</p>
            <p class="text-2xl font-bold text-gray-900">
                <?= $totalRequests > 0 ? round(($approvedCount / $totalRequests) * 100) : 0 ?>%
            </p>
        </div>
    </div>
</div>

<!-- Recent requests + Quick actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Recent requests -->
    <div class="lg:col-span-2 card">
        <div class="card-header">
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Dernières demandes</h2>
                <p class="text-xs text-gray-500 mt-0.5">5 demandes les plus récentes</p>
            </div>
            <a href="/admin/requests/request" class="text-xs font-medium text-indigo-600 hover:text-indigo-500">Voir tout →</a>
        </div>
        <div class="table-wrap rounded-t-none border-t-0 border-x-0 border-b-0 rounded-b-xl overflow-hidden">
            <table class="table">
                <thead>
                    <tr>
                        <th>Procédure</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentRequests as $req) : ?>
                    <tr>
                        <td class="font-medium text-gray-900"><?= h($req->procedure->name ?? '—') ?></td>
                        <td class="text-gray-500"><?= h($req->user->name ?? '—') ?></td>
                        <td>
                            <?php
                            $statusClass = match($req->status) {
                                'success'  => 'badge-green',
                                'rejected' => 'badge-red',
                                'pending'  => 'badge-amber',
                                default    => 'badge-gray',
                            };
                            $statusLabel = match($req->status) {
                                'success'  => 'Approuvée',
                                'rejected' => 'Rejetée',
                                'pending'  => 'En attente',
                                'Draft'    => 'Brouillon',
                                default    => h($req->status),
                            };
                            ?>
                            <span class="<?= $statusClass ?>"><?= $statusLabel ?></span>
                        </td>
                        <td class="text-gray-400 text-xs"><?= $req->created ? $req->created->format('d/m/Y') : '—' ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (!count($recentRequests)) : ?>
                    <tr><td colspan="4" class="text-center py-8 text-gray-400 text-sm">Aucune demande</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="card card-body">
        <h2 class="text-sm font-semibold text-gray-900 mb-4">Actions rapides</h2>
        <div class="space-y-2">
            <a href="/admin/procedures/add" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-colors group">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-200 transition-colors">
                    <i class="fa-solid fa-plus text-indigo-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Nouvelle procédure</p>
                    <p class="text-xs text-gray-400">Créer un type de demande</p>
                </div>
            </a>
            <a href="/admin/requirements/add" class="flex items-center gap-3 p-3 rounded-xl hover:bg-violet-50 transition-colors group">
                <div class="w-9 h-9 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-200 transition-colors">
                    <i class="fa-solid fa-list-check text-violet-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Ajouter un pré-requis</p>
                    <p class="text-xs text-gray-400">Définir un document requis</p>
                </div>
            </a>
            <a href="/admin/users/add" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors group">
                <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition-colors">
                    <i class="fa-solid fa-user-plus text-blue-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Ajouter un utilisateur</p>
                    <p class="text-xs text-gray-400">Créer un compte</p>
                </div>
            </a>
            <a href="/admin/requests/pending" class="flex items-center gap-3 p-3 rounded-xl hover:bg-amber-50 transition-colors group">
                <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-200 transition-colors">
                    <i class="fa-solid fa-clock text-amber-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Demandes en attente</p>
                    <p class="text-xs text-gray-400"><?= $pendingCount ?> demande(s) à traiter</p>
                </div>
            </a>
        </div>
    </div>
</div>
