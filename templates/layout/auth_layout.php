<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title') ?> — Easy Procedures</title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?= $this->Html->css(['app']) ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="h-full font-sans antialiased bg-gray-50">

<?php
$prefix = $this->request->getParam('prefix') ?? 'Client';

$panel = match($prefix) {
    'Agent' => [
        'bg'          => 'bg-gradient-to-br from-amber-900 via-amber-800 to-amber-900',
        'blob1'       => 'bg-amber-500',
        'blob2'       => 'bg-orange-500',
        'logoBg'      => 'bg-amber-600',
        'logoAccent'  => 'text-amber-300',
        'badgeIcon'   => 'fa-user-tie',
        'accentText'  => 'text-amber-300',
        'subText'     => 'text-amber-200/70',
        'checkBg'     => 'bg-amber-500/30',
        'checkColor'  => 'text-amber-300',
        'title'       => 'Espace Commercial',
        'subtitle'    => "Traitez les demandes, vérifiez les documents soumis et accompagnez vos clients dans leurs démarches.",
        'features'    => [
            ['Traiter les demandes',        'Gérez les dossiers clients en attente'],
            ['Valider les documents',       'Vérifiez chaque pièce justificative'],
            ['Suivre les dossiers clients', "Gardez un œil sur l'avancement"],
        ],
    ],
    'Admin' => [
        'bg'          => 'bg-gradient-to-br from-red-900 via-red-800 to-red-900',
        'blob1'       => 'bg-red-500',
        'blob2'       => 'bg-rose-500',
        'logoBg'      => 'bg-red-600',
        'logoAccent'  => 'text-red-300',
        'badgeIcon'   => 'fa-shield-halved',
        'accentText'  => 'text-red-300',
        'subText'     => 'text-red-200/70',
        'checkBg'     => 'bg-red-500/30',
        'checkColor'  => 'text-red-300',
        'title'       => 'Administration',
        'subtitle'    => "Gérez les utilisateurs, configurez les procédures et supervisez l'ensemble de l'activité de la plateforme.",
        'features'    => [
            ['Gérer les utilisateurs',    'Créez et gérez les comptes agents'],
            ['Configurer les procédures', 'Définissez les documents requis'],
            ["Superviser l'activité",     'Suivez toutes les demandes en cours'],
        ],
    ],
    default => [ // Client
        'bg'          => 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900',
        'blob1'       => 'bg-indigo-500',
        'blob2'       => 'bg-violet-500',
        'logoBg'      => 'bg-indigo-600',
        'logoAccent'  => 'text-indigo-300',
        'badgeIcon'   => 'fa-user',
        'accentText'  => 'text-indigo-300',
        'subText'     => 'text-slate-400',
        'checkBg'     => 'bg-indigo-500/30',
        'checkColor'  => 'text-indigo-300',
        'title'       => 'Espace Client',
        'subtitle'    => "Déposez vos demandes, transmettez vos documents et suivez l'avancement de vos dossiers en toute autonomie.",
        'features'    => [
            ['Déposer une demande',      'Initiez vos procédures bancaires en ligne'],
            ['Téléverser des documents', 'Envoyez vos pièces justificatives'],
            ['Suivre mes dossiers',      "Consultez l'état de vos demandes à tout moment"],
        ],
    ],
};
?>

<div class="min-h-screen flex">

    <!-- ── Left branding panel ──────────────────────────────── -->
    <div class="hidden lg:flex lg:w-[45%] xl:w-[40%] flex-col justify-between relative overflow-hidden <?= $panel['bg'] ?>">

        <!-- Background blobs -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full <?= $panel['blob1'] ?> blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full <?= $panel['blob2'] ?> blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        </div>

        <div class="relative z-10 p-10 flex flex-col h-full">

            <!-- Logo -->
            <a href="<?= $this->Url->build('/') ?>" class="flex items-center gap-2.5 mb-auto">
                <div class="w-8 h-8 rounded-lg <?= $panel['logoBg'] ?> flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-building-columns text-white text-sm"></i>
                </div>
                <span class="font-bold text-white">Easy<span class="<?= $panel['logoAccent'] ?>">Procedures</span></span>
            </a>

            <!-- Main content -->
            <div class="my-auto">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 mb-6 text-xs font-medium text-white/80">
                    <i class="fa-solid <?= $panel['badgeIcon'] ?>"></i>
                    Plateforme sécurisée
                </div>

                <h2 class="text-3xl xl:text-4xl font-bold text-white leading-tight mb-4">
                    <?= $panel['title'] ?><br>
                    <span class="<?= $panel['accentText'] ?>">bancaires simplement.</span>
                </h2>
                <p class="<?= $panel['subText'] ?> text-sm leading-relaxed mb-10">
                    <?= $panel['subtitle'] ?>
                </p>

                <!-- Features -->
                <ul class="space-y-4">
                    <?php foreach ($panel['features'] as $feature) : ?>
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 flex-shrink-0 w-6 h-6 rounded-full <?= $panel['checkBg'] ?> flex items-center justify-center">
                            <i class="fa-solid fa-check <?= $panel['checkColor'] ?> text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white"><?= $feature[0] ?></p>
                            <p class="text-xs text-white/50 mt-0.5"><?= $feature[1] ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Footer -->
            <p class="text-xs text-white/30 mt-10">© 2026 Easy Procedures · Tous droits réservés</p>
        </div>
    </div>

    <!-- ── Right form panel ──────────────────────────────────── -->
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 sm:px-10">

        <!-- Mobile logo -->
        <div class="lg:hidden mb-8 w-full max-w-sm">
            <a href="<?= $this->Url->build('/') ?>" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-building-columns text-white text-sm"></i>
                </div>
                <span class="font-bold text-gray-900">Easy<span class="text-indigo-600">Procedures</span></span>
            </a>
        </div>

        <div class="w-full max-w-sm">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </div>

</div>

<?= $this->fetch('script') ?>
</body>
</html>
