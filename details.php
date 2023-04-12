<?php

    include('config/db_connect.php');

    if(isset($_POST['delete'])){

        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM reviews WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)){
            header('Location: index.php');
        } else {
            echo 'Query error: ' . mysqli_error($conn);
        }
    }

    # revisa parametro id en GET
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        # se crea query
        $sql = "SELECT * FROM reviews WHERE id = $id";

        # guarda resultados
        $result = mysqli_query($conn, $sql);

        # procesa resultado como array asociativo
        $review = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container center">
    <?php if($review): ?>

        <h4> <?php echo htmlspecialchars($review['title']); ?> </h4>
        <img src="<?php echo htmlspecialchars($review['img']) ?>" alt="" class="container image">
        
        <h5>Tags:</h5>
        <p> <?php echo htmlspecialchars($review['tags']); ?> </p>
        <p class="container"> <?php echo html_entity_decode($review['review']); ?> </p>
        <br/>
        <p>Created by: <?php echo htmlspecialchars($review['email']); ?> </p>
        <p> <?php echo date($review['created_at']); ?> </p>


        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $review['id']; ?>">
            <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
        </form>

    <?php else: ?>
        <h5>No such item exists!</h5>
    <?php endif; ?>
</div>

<?php include('templates/footer.php'); ?>

</html>