<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du livre</title>
</head>
<body>

<h2>Détail du livre</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Auteur</th>
        <th>ISBN</th>
        <th>Année</th>
        <th>Catégorie</th>
        <th>Résumé</th>
        <th>Couverture</th>
        <th>Statut</th>
        <th>Date création</th>
        <th>Date modification</th>
    </tr>

    <?php if (!empty($livre)) : ?>
<tr>
    <td><?= $livre['id'] ?></td>
    <td><?= $livre['titre'] ?></td>
    <td><?= $livre['auteur'] ?></td>
    <td><?= $livre['ISBN'] ?></td>
    <td><?= $livre['annee_publication'] ?></td>
    <td><?= $livre['categorie'] ?></td>
    <td><?= $livre['resume'] ?></td>
    <td><?= $livre['nom_fichier_couverture'] ?></td>
    <td><?= $livre['statut'] ?></td>
    <td><?= $livre['date_creation'] ?></td>
    <td><?= $livre['date_modification'] ?></td>
</tr>
<?php else : ?>
<tr>
    <td colspan="11">Livre introuvable</td>
</tr>
<?php endif; ?>

</table>

</body>
</html>