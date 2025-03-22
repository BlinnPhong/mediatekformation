# Mediatekformation
## Présentation
Ce site, développé avec Symfony 6.4, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques et qui sont aussi accessibles sur YouTube.<br> 
Ce site est une version amélioré de ce dépot d'origine https://github.com/CNED-SLAM/mediatekformation ou seule la partie front office a été développée. Voici les nouvelles fonctionnalités (back office) ajoutées :<br>
![use_case_diagram_4](https://github.com/user-attachments/assets/0d57c507-4c45-4bca-9721-e98ba3b9bcbc)
## Les différentes pages
Voici les 4 nouvelles pages nouvelles correspondant aux différents cas d’utilisation.
### Page 1 : l'authentification
Cette page permet de s'authentifier pour accéder à la partie back office du stie.<br>
![image](https://github.com/user-attachments/assets/9220a572-55f2-4d94-ad4f-35ab9199fc40)
### Page 2 : gestion des formations
Cette page présente les formations proposées et permet d'ajouter/éditer/supprimer une formation.<br>
La partie centrale contient un tableau composé de 4 colonnes :<br>
•	La 1ère colonne ("formation") contient le titre de chaque formation.<br>
•	La 2ème colonne ("playlist") contient le nom de la playlist dans laquelle chaque formation se trouve.<br>
•	La 3ème colonne ("catégories") contient la ou les catégories concernées par chaque formation (langage…).<br>
•	La 4ème colonne ("date") contient la date de parution de chaque formation.<br>
Au niveau des colonnes "formation", "playlist" et "date", 2 boutons permettent de trier les lignes en ordre croissant ("<") ou décroissant (">").<br>
Au niveau des colonnes "formation" et "playlist", il est possible de filtrer les lignes en tapant un texte : seuls les lignes qui contiennent ce texte sont affichées. Si la zone est vide, le fait de cliquer sur "filtrer" permet de retrouver la liste complète.<br> 
Au niveau de la catégorie, la sélection d'une catégorie dans le combo permet d'afficher uniquement les formations qui ont cette catégorie. Le fait de sélectionner la ligne vide du combo permet d'afficher à nouveau toutes les formations.<br>
Par défaut la liste est triée sur la date par ordre décroissant (la formation la plus récente en premier).<br>
Le fait de cliquer sur le bouton "Ajouter une nouvelle formation" permet d'accéder à la troisième page d'ajout de formation et le bouton "Editer" méne vers la 4ème page de modifcation d'une formation.<br>
![image](https://github.com/user-attachments/assets/c2012558-1aa4-4c24-b376-96bc62479f00)
### Page 3 : ajout d'une foramtion
Cette page est uniquement accessible en cliquant sur le bouton "Ajouter une nouvelle formation" de la page des gestion des formations.<br>
Pour ajouter une playlist la page impose une date de création, un titre et une playlist. Les autres champs (description, video id, categories) sont facultatif.<br>
Un bouton "Enregistrer" permet de soumettre les modifications et de les enregistrer dans la base de donnée.<br>
![image](https://github.com/user-attachments/assets/d66da689-14bb-46cd-b69c-52ba81e40390)
### Page 4 : modification d'une foramtion
Cette page est uniquement accessible en cliquant sur le bouton "Editer" de la page des gestion des formations.<br>
Elle est similaire à la page d'ajout d'une formation sauf qu'ici les champ sont déjà prérempli avec les informations existantes.<br>
Un bouton "Enregistrer" permet de soumettre les modifications et de les enregistrer dans la base de donnée.<br>
![image](https://github.com/user-attachments/assets/88eb3796-6960-4cc8-9702-ffa35d63ce80)
### Page 5 : gestion des playlists
Cette page présente les playlists et permet d'ajouter/éditer/supprimer une formation.<br>
La partie centrale contient un tableau composé de 3 colonnes :<br>
•	La 1ère colonne ("playlist") contient le nom de chaque playlist.
•	La 2ème colonne ("catégories") contient la ou les catégories concernées par chaque playlist (langage…).
•	La 3ème contient un bouton pour accéder à la page de présentation de la playlist.
Au niveau de la colonne "playlist", 2 boutons permettent de trier les lignes en ordre croissant ("<") ou décroissant (">"). Il est aussi possible de filtrer les lignes en tapant un texte : seuls les lignes qui contiennent ce texte sont affichées. Si la zone est vide, le fait de cliquer sur "filtrer" permet de retrouver la liste complète.<br>
Au niveau de la catégorie, la sélection d'une catégorie dans le combo permet d'afficher uniquement les playlists qui ont cette catégorie. Le fait de sélectionner la ligne vide du combo permet d'afficher à nouveau toutes les playlists.
Par défaut la liste est triée sur le nom de la playlist.<br>
Le fait de cliquer sur le bouton "Ajouter une nouvelle playlist" permet d'accéder à la sixième page d'ajout de playlist et le bouton "Editer" méne vers la 7ème page de modifcation d'une playlist.<br>
![image](https://github.com/user-attachments/assets/72276ad2-80da-4888-beaf-bc79416f12c0)
### Page 6 : ajout d'une playlist
Cette page est uniquement accessible en cliquant sur le bouton "Ajouter une nouvelle playlist" de la page des gestion des playlists.<br>
Pour ajouter une playlist la page impose un titre, la description est facultative.<br>
Un bouton "Enregistrer" permet de soumettre les modifications et de les enregistrer dans la base de donnée.<br>
![image](https://github.com/user-attachments/assets/f3b7da3a-a918-492a-920f-4a83b60f9687)
### Page 7 : modification d'une playlist
Cette page est uniquement accessible en cliquant sur le bouton "Editer" de la page des gestion des playlists.<br>
Elle est similaire à la page d'ajout d'une playlist sauf qu'ici les champ sont déjà prérempli avec les informations existantes.<br>
Un bouton "Enregistrer" permet de soumettre les modifications et de les enregistrer dans la base de donnée.<br>
![image](https://github.com/user-attachments/assets/548317ab-e70b-4f2a-84cd-ac0e9af8ae43)
### Page 8 : gestion des catégories
Cette page présente les catégories et permet d'ajouter/supprimer une catégorie.<br>
![image](https://github.com/user-attachments/assets/af47d830-b8fd-4172-bf07-dd4b9996ae61)

## Test de l'application en local
- Vérifier que Composer, Git et Wamserver (ou équivalent) sont installés sur l'ordinateur.
- Télécharger le code et le dézipper dans www de Wampserver (ou dossier équivalent) puis renommer le dossier en "mediatekformation".<br>
- Ouvrir une fenêtre de commandes en mode admin, se positionner dans le dossier du projet et taper "composer install" pour reconstituer le dossier vendor.<br>
- Dans phpMyAdmin, se connecter à MySQL en root sans mot de passe et créer la BDD 'mediatekformation'.<br>
- Récupérer le fichier mediatekformation.sql en racine du projet et l'utiliser pour remplir la BDD (si vous voulez mettre un login/pwd d'accès, il faut créer un utilisateur, lui donner les droits sur la BDD et il faut le préciser dans le fichier ".env" en racine du projet).<br>
- De préférence, ouvrir l'application dans un IDE professionnel. L'adresse pour la lancer est : http://localhost/mediatekformation/public/index.php<br>
