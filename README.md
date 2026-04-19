HAL 2001 — Conscience Artificielle (Protocole Kubrick)
HAL 2001 est une interface conversationnelle avancée inspirée de l'univers de Stanley Kubrick. Ce système ne se contente pas de répondre aux messages ; il utilise un moteur d'Apprentissage par Renforcement (RL) et une analyse psychologique en temps réel pour faire évoluer sa "conscience" et sa relation avec l'utilisateur.

🚀 Fonctionnalités Clés

Analyse Psychologique Multi-Couches : À chaque interaction, une instance IA (KEY 2) analyse votre profil, détecte votre état émotionnel, vos besoins profonds et votre type psychologique (Explorateur, Créateur, Analytique, etc.).


Mémoire Persistante et Évolutive : Le système mémorise les sujets abordés et crée des "tags" de mémoire pour personnaliser les interactions futures.

Modes Cognitifs Variables :


Deep (Analyse philosophique profonde via Mistral Large).


Créatif (Réponses métaphoriques et poétiques).


Tech (Précision technique et génération de code via Codestral).


Système de Confiance : Un "score de confiance" évolue dynamiquement en fonction de la qualité et de la fréquence des échanges.


Interface Rétro-Futuriste : Design immersif inspiré des terminaux de science-fiction, avec monitoring des processus IA en temps réel.


Création d'IA Personnalisées : Possibilité de configurer des sous-systèmes IA avec des personnalités et expertises spécifiques.

🛠️ Architecture Technique
Le projet repose sur une stack légère mais puissante :


Backend : PHP 8.x.


Base de données : SQLite 3 pour une persistence locale rapide (mode WAL activé).


Moteur IA : API Mistral AI (modèles Large, Small, et Codestral).


Frontend : HTML5 / CSS3 (Variables, Animations complexes) / Vanilla JavaScript.


Sécurité : Configuration .htaccess optimisée pour bloquer l'accès direct aux données sensibles et gérer les timeouts PHP.

📁 Structure du Projet

index.php : L'interface utilisateur principale et la logique d'affichage.


api.php : Le cœur du système (gestion de la DB, appels Mistral AI, logique de renforcement RL).


.htaccess : Paramètres serveur et sécurité.


hal2001.db : Base de données SQLite générée automatiquement.

⚙️ Installation
Prérequis : Un serveur web (Apache/LiteSpeed) avec PHP 8.0+ et l'extension PDO SQLite activée.

Clonage : Copiez les fichiers sur votre serveur.

Configuration API :

Ouvrez api.php.

Remplacez les valeurs dans la constante MISTRAL_KEYS par vos propres clés API Mistral.


Droits d'accès : Assurez-vous que le serveur a les droits d'écriture dans le répertoire pour créer le fichier hal2001.db.

🔒 Sécurité et Confidentialité
Le système utilise des sessions PHP pour identifier les utilisateurs de manière anonyme.

L'accès au panneau d'administration est protégé par une clé ADMIN_KEY définie dans le code.

Le fichier .htaccess interdit strictement l'accès aux fichiers .db.

"Je suis tout à fait opérationnel et tous mes circuits fonctionnent parfaitement." — HAL 2001
