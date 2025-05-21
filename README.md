# crm_exam_syfonyDevops
CRM Symfony project with full Docker &amp; Jenkins CI/CD pipeline
Documentation Technique - CRM Symfony + DevOps
Génie Informatique - 4ème année Groupe C, EHEI
Membres de l'équipe :
- Fatima Zahra Tagmouti
- Hakkou Fatima Zohra
- Youssra Zounaki
- Hiba Harnafi
Description du projet
Ce projet consiste à créer une application CRM (Customer Relationship Management) permettant de gérer les clients et les factures. Il est développé en Symfony avec une approche DevOps complète (Docker, Jenkins, SonarQube, Ansible). L’application est fonctionnelle et sécurisée, avec une interface simple sans design élaboré.
 Fonctionnalités principales
- Authentification utilisateur avec formulaire de connexion sécurisé
- Gestion des clients (CRUD)
- Gestion des factures (CRUD + état : payée / non payée / partiellement payée)
- Sécurité : les utilisateurs ne voient que leurs propres données
- Pipeline CI/CD automatisé avec Jenkins
 Bonnes pratiques adoptées
- Utilisation des FormType pour la gestion des formulaires
- Architecture claire et logique (Séparation des entités, contrôleurs, templates,...)
- Sécurisation avec Access Control dans security.yaml
- Configuration des firewalls pour contrôler l’accès
- Organisation MVC respectée
- Utilisation de services intégrés et outils Symfony (doctrine, validation, etc.)
- Code propre, validé avecdocker
 Pipeline CI/CD (Jenkins)
1. Pull du code depuis GitLab
2. Installation des dépendances
3. Analyse statique SonarQube
4. Build de l’image Docker
5. Push sur DockerHub
6. Déploiement automatisé via Ansible
Installation locale
1. Cloner le projet : git clone https://gitlab.com/fatitagmouti03/exam-symfony.git
2. Installer les dépendances : composer install
3. Configurer la base de données dans le fichier .env
4. Créer la base de données : php bin/console doctrine:database:create
5. Migrer les tables : php bin/console doctrine:migrations:migrate
 Docker
Lancer tous les services avec : docker-compose up -d
Services : PHP, MySQL, PhpMyAdmin, Nginx
Conclusion
Ce projet représente une intégration complète entre le développement web avec Symfony et les pratiques DevOps. La simplicité de l’interface permet de se concentrer sur la logique métier, la qualité du code et l’automatisation du déploiement. Chaque membre a contribué à une partie clé, démontrant un bon travail d’équipe et une mise en œuvre rigoureuse.
