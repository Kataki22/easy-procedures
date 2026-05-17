<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-white scroll-smooth">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Easy Procedures — Gestion de procédures bancaires</title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?= $this->Html->css(['app']) ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-900" x-data="{ mobileMenuOpen: false }">

<!-- ─────────────────────────────────────────────────────────
     NAVIGATION
──────────────────────────────────────────────────────────── -->
<header class="fixed inset-x-0 top-0 z-50 border-b border-gray-100 bg-white/90 backdrop-blur-md">
    <nav class="mx-auto max-w-7xl flex items-center justify-between px-6 py-4 lg:px-8">

        <!-- Logo -->
        <a href="#" class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-sm">
                <i class="fa-solid fa-building-columns text-white text-sm"></i>
            </div>
            <span class="font-bold text-gray-900">Easy<span class="text-indigo-600">Procedures</span></span>
        </a>

        <!-- Desktop nav -->
        <div class="hidden lg:flex items-center gap-8">
            <a href="#features" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Fonctionnalités</a>
            <a href="#portals"  class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Portails</a>
            <a href="#portals"  class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Contact</a>
        </div>

        <div class="hidden lg:flex items-center gap-3">
            <a href="#portals" class="text-sm font-semibold text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                Se connecter
            </a>
            <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'register']) ?>"
               class="btn-primary btn-sm">
                <i class="fa-solid fa-user-plus text-xs"></i>
                S'inscrire
            </a>
        </div>

        <!-- Mobile burger -->
        <button type="button" class="lg:hidden -m-2 p-2 text-gray-500" @click="mobileMenuOpen = true">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </nav>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" x-cloak class="lg:hidden">
        <div class="fixed inset-0 z-50 bg-white px-6 py-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-building-columns text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-gray-900">Easy<span class="text-indigo-600">Procedures</span></span>
                </div>
                <button type="button" class="-m-2 p-2 text-gray-500" @click="mobileMenuOpen = false">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="space-y-1 mb-8">
                <a href="#features" class="block rounded-lg px-3 py-2.5 text-base font-medium text-gray-700 hover:bg-gray-50" @click="mobileMenuOpen=false">Fonctionnalités</a>
                <a href="#portals"  class="block rounded-lg px-3 py-2.5 text-base font-medium text-gray-700 hover:bg-gray-50" @click="mobileMenuOpen=false">Portails</a>
            </div>
            <div class="space-y-3">
                <a href="#portals" class="block text-center py-2.5 text-sm font-semibold text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50" @click="mobileMenuOpen=false">Se connecter</a>
                <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'register']) ?>"
                   class="block text-center py-2.5 text-sm font-semibold bg-indigo-600 text-white rounded-xl hover:bg-indigo-500">
                    S'inscrire gratuitement
                </a>
            </div>
        </div>
    </div>
</header>

<main>

<!-- ─────────────────────────────────────────────────────────
     HERO
──────────────────────────────────────────────────────────── -->
<section class="relative pt-28 pb-20 sm:pt-36 sm:pb-28 px-6 lg:px-8 overflow-hidden">

    <!-- Background gradient blob -->
    <div class="absolute inset-x-0 -top-40 -z-10 overflow-hidden" aria-hidden="true">
        <div class="relative mx-auto aspect-[1155/678] w-[72rem] -translate-y-1/4 bg-gradient-to-tr from-indigo-300 to-violet-400 opacity-20 blur-3xl"
             style="clip-path:polygon(74.1% 44.1%,100% 61.6%,97.5% 26.9%,85.5% 0.1%,80.7% 2%,72.5% 32.5%,60.2% 62.4%,52.4% 68.1%,47.5% 58.3%,45.2% 34.5%,27.5% 76.7%,0.1% 64.9%,17.9% 100%,27.6% 76.8%,76.1% 97.7%,74.1% 44.1%)"></div>
    </div>

    <div class="mx-auto max-w-3xl text-center">

        <!-- Announcement badge -->
        <div class="inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-4 py-1.5 text-sm text-indigo-700 font-medium mb-8">
            <i class="fa-solid fa-star text-xs text-indigo-400"></i>
            Plateforme de gestion administrative
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </div>

        <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight mb-6">
            Simplifiez vos<br>
            <span class="text-gradient">démarches bancaires</span>
        </h1>

        <p class="text-lg sm:text-xl text-gray-500 leading-relaxed mb-10 max-w-2xl mx-auto">
            Easy Procedures centralise toutes vos demandes administratives en un seul endroit.
            Soumettez, suivez et recevez vos documents — rapidement et en toute sécurité.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'register']) ?>"
               class="btn-primary btn-lg w-full sm:w-auto">
                <i class="fa-solid fa-rocket"></i>
                Commencer gratuitement
            </a>
            <a href="#portals" class="btn-secondary btn-lg w-full sm:w-auto">
                <i class="fa-solid fa-right-to-bracket text-gray-400"></i>
                Accéder aux portails
            </a>
        </div>
    </div>

    <!-- Stats bar -->
    <div class="mx-auto max-w-4xl mt-16 grid grid-cols-2 sm:grid-cols-4 gap-px bg-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <?php
        $stats = [
            ['fa-file-circle-check', '500+', 'Demandes traitées'],
            ['fa-users', '200+', 'Clients actifs'],
            ['fa-clock',  '< 48h', 'Délai moyen'],
            ['fa-shield-halved', '100%', 'Sécurisé'],
        ];
        foreach ($stats as $s) : ?>
        <div class="bg-white px-6 py-5 flex flex-col items-center text-center">
            <i class="fa-solid <?= $s[0] ?> text-indigo-500 text-xl mb-2"></i>
            <p class="text-2xl font-bold text-gray-900"><?= $s[1] ?></p>
            <p class="text-xs text-gray-500 mt-0.5"><?= $s[2] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ─────────────────────────────────────────────────────────
     FEATURES
──────────────────────────────────────────────────────────── -->
<section id="features" class="bg-gray-50 py-24 sm:py-32 px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600 ring-1 ring-indigo-200 mb-4">
                <i class="fa-solid fa-bolt"></i> Fonctionnalités
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Tout ce dont vous avez besoin</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Une plateforme complète pour gérer l'ensemble de votre parcours administratif bancaire.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $features = [
                ['fa-paper-plane', 'bg-indigo-100 text-indigo-600', 'Depot simplifie', 'Soumettez vos dossiers en quelques clics, depuis n\'importe quel appareil.'],
                ['fa-magnifying-glass-chart', 'bg-emerald-100 text-emerald-600', 'Suivi en temps reel', 'Consultez l\'etat d\'avancement de chaque demande a tout moment.'],
                ['fa-file-shield', 'bg-blue-100 text-blue-600', 'Documents securises', 'Vos fichiers sont chiffres et stockes en conformite avec les normes bancaires.'],
                ['fa-bell', 'bg-amber-100 text-amber-600', 'Notifications', 'Soyez alerte a chaque changement de statut de votre dossier.'],
                ['fa-users-gear', 'bg-violet-100 text-violet-600', 'Gestion des roles', 'Clients, Agents et Administrateurs disposent chacun d\'un espace dedie.'],
                ['fa-chart-line', 'bg-rose-100 text-rose-600', 'Tableau de bord', 'Visualisez vos statistiques et votre activite en un coup d\'oeil.'],
            ];
            foreach ($features as $f) : ?>
            <div class="card card-body hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl <?= $f[1] ?> flex items-center justify-center mb-4">
                    <i class="fa-solid <?= $f[0] ?> text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2"><?= $f[2] ?></h3>
                <p class="text-sm text-gray-500 leading-relaxed"><?= $f[3] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─────────────────────────────────────────────────────────
     PORTAILS
──────────────────────────────────────────────────────────── -->
<section id="portals" class="py-24 sm:py-32 px-6 lg:px-8 bg-white">
    <div class="mx-auto max-w-7xl">

        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600 ring-1 ring-gray-200 mb-4">
                <i class="fa-solid fa-door-open"></i> Accès
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Choisissez votre portail</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Chaque rôle dispose d'un espace dédié et sécurisé.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Client -->
            <div class="relative rounded-2xl border-2 border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-8 hover:border-indigo-400 hover:shadow-lg transition-all group">
                <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-md mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user text-white text-2xl"></i>
                </div>
                <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-semibold text-indigo-700 mb-3">Client</span>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Espace Client</h3>
                <p class="text-sm text-gray-500 leading-relaxed mb-6">
                    Déposez vos demandes, transmettez vos documents et suivez l'avancement de vos dossiers en toute autonomie.
                </p>
                <ul class="space-y-2 mb-8 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-500 text-xs"></i> Déposer une demande</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-500 text-xs"></i> Téléverser des documents</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-500 text-xs"></i> Suivre mes dossiers</li>
                </ul>
                <div class="flex flex-col gap-2">
                    <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'login']) ?>"
                       class="btn-primary w-full justify-center">
                        <i class="fa-solid fa-right-to-bracket"></i> Se connecter
                    </a>
                    <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'register']) ?>"
                       class="btn-secondary w-full justify-center">
                        Créer un compte
                    </a>
                </div>
            </div>

            <!-- Agent -->
            <div class="relative rounded-2xl border-2 border-amber-100 bg-gradient-to-br from-amber-50 to-white p-8 hover:border-amber-400 hover:shadow-lg transition-all group">
                <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center shadow-md mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-tie text-white text-2xl"></i>
                </div>
                <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 mb-3">Agent</span>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Espace Commercial</h3>
                <p class="text-sm text-gray-500 leading-relaxed mb-6">
                    Traitez les demandes, vérifiez les documents soumis et accompagnez vos clients dans leurs démarches.
                </p>
                <ul class="space-y-2 mb-8 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Traiter les demandes</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Valider les documents</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Suivre les dossiers clients</li>
                </ul>
                <a href="<?= $this->Url->build(['prefix' => 'Agent', 'controller' => 'Auth', 'action' => 'login']) ?>"
                   class="btn-amber w-full justify-center">
                    <i class="fa-solid fa-right-to-bracket"></i> Accès Agent
                </a>
            </div>

            <!-- Admin -->
            <div class="relative rounded-2xl border-2 border-red-200 bg-gradient-to-br from-red-600 to-red-700 p-8 hover:border-red-400 hover:shadow-lg transition-all group">
                <div class="w-14 h-14 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center shadow-md mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-shield-halved text-white text-2xl"></i>
                </div>
                <span class="inline-flex items-center rounded-full bg-white/20 px-2.5 py-0.5 text-xs font-semibold text-white mb-3">Admin</span>
                <h3 class="text-xl font-bold text-white mb-3">Administration</h3>
                <p class="text-sm text-red-100 leading-relaxed mb-6">
                    Gérez les utilisateurs, configurez les procédures et supervisez l'ensemble de l'activité de la plateforme.
                </p>
                <ul class="space-y-2 mb-8 text-sm text-red-100">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-red-200 text-xs"></i> Gérer les utilisateurs</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-red-200 text-xs"></i> Configurer les procédures</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-red-200 text-xs"></i> Superviser l'activité</li>
                </ul>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Auth', 'action' => 'login']) ?>"
                   class="btn w-full justify-center bg-white/20 text-white border border-white/30 hover:bg-white/30 transition-colors">
                    <i class="fa-solid fa-lock text-xs"></i> Accès restreint
                </a>
            </div>

        </div>
    </div>
</section>

</main>

<!-- ─────────────────────────────────────────────────────────
     FOOTER
──────────────────────────────────────────────────────────── -->
<footer class="bg-gray-50 border-t border-gray-200">
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-building-columns text-white text-xs"></i>
                </div>
                <span class="font-semibold text-gray-700 text-sm">EasyProcedures</span>
            </div>
            <div class="flex items-center gap-6 text-xs text-gray-400">
                <a href="#" class="hover:text-gray-600 transition-colors">Conditions d'utilisation</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Contact</a>
            </div>
            <p class="text-xs text-gray-400">© 2026 Easy Procedures. Tous droits réservés.</p>
        </div>
    </div>
</footer>

</body>
</html>
