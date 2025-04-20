# 🌦️ Météo Info - Site Web

## 📝 Description

**Météo Info** est un site web interactif qui permet de consulter les prévisions météo en France, par ville, département ou région.  
Il intègre des données issues d'API, et propose une expérience utilisateur personnalisée grâce aux cookies.

## 🔧 Technologies utilisées

- **HTML5** : structure du site
- **CSS3** : mise en forme (style)
- **PHP8** : génération dynamique du contenu, enregistrement des consultations
- **Cookies** : gestion des préférences utilisateur (mode jour/nuit, ville consultée)
- **APIs** : récupération des données météo au format JSON ou XML

## 📁 Structure du projet

- `css/` :Dossier avec le document interne
  - `clair.css` : Fichier CSS principal contenant les styles clair du site
  - `sombre.css` : Fichier CSS secondaire contenant les styles sombre du site
- `doc doxygen/` :Dossier avec le document doxygen du site
- `images/` : Dossier contenant les images utilisées dans le site sans conté les images aléatoires
  - `clair.png` : Image indiquant le mode clair du site
  - `favicon.png` : Image du favicon du site
  - `carte_france.jpg` : Image de la carte intéractive
  - `clair_background.jpg` : Image de fond clair
  - `logo.png` : Logo de notre site
  - `sombre.png` : Image indiquant le mode sombre du site
  - `sombre_background.jpg` : Image de fond sombre
- `include/` : dossier possédant tous les includes (ce qui represente en grande partie du back)
  - `footer.inc.php` : Footer du site
  - `header.inc.php` : header du site
  - `functions.inc.php` : fichier avec toute les fonctions du site
  - `forms.inc.php` : fichier qui permet d'importer sur toute les pages les menu de choix pour la météo
  - `randomImage.inc.php` : permet d'afficher des images aléatoire parmis une séléction de celle-ci
- `photos/` : dossier possédant toutes les images aléatoires
- `cities.csv` : Fichier csv qui recense toute les villes de france
- `departments.csv` : Fichier csv qui recense tout les departements de france
- `index.php` : Page principale du site
- `meteodetailled.php` : Page montrant la météo détaillé d'une ville
- `meteoweek.php` : Page montrant la météo sur plusieurs jours d'une ville
- `recherches.php` : Fichier csv qui recense toute les recherches sur le site
- `regions.csv` : Fichier csv qui recense toute les regions de france
- `siteplan.php` : Page plan de site du site web
- `stat.php` : Page affichant les recherches faite sur notre site
- `meteoweekastro.php` : Page affichant la météo astro de la ville
- `readme.md` : Fichier de documentation
 
## 👥 Contributeurs

- **Bertrand, Leopole dit Marie**
