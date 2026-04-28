<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des livres</title>
</head>
<body>

<h2>Liste des livres</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Année</th>
        <th>Catégorie</th>
    </tr>

    <?php if (!empty($livres)) : ?>
        <?php foreach ($livres as $livre) : ?>
            <tr>
                <td><a href="fiche_livre/<?= $livre['id'] ?>"><?= $livre['id'] ?></a></td>
                <td><?= $livre['titre'] ?></td>
                <td><?= $livre['auteur'] ?></td>
                <td><?= $livre['annee_publication'] ?></td>
                <td><?= $livre['categorie'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="5">Aucun livre trouvé</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html> 