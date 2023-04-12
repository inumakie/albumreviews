<?php

    #configuracion de base de datos
    include('config/db_connect.php');

    #inicializacion de variables a usar
    $email = $title = $tags = $review = $image = '';
    $errors = array('email' => '', 'title' => '', 'tags' => '', 'review' => '', 'image' => '');

    #codigo a ejecutar en submit
    if(isset($_POST['submit'])){

        # validacion de email
        if(empty($_POST['email'])){
            $errors['email'] = 'An email is required.';
        } else {
            $email = $_POST['email'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'e-mail must be a valid address';
            }
        }

        # validacion de title
        if(empty($_POST['title'])){
            $errors['title'] = 'A title is required.';
        } else {
            $title = $_POST['title'];

            if(!preg_match('/^.*$/', $title)){
                $errors['title'] = 'Title must be letters and spaces only';
            }
        }

        # validacion de tags
        if(empty($_POST['tags'])){
            $errors['tags'] = 'At least one ingredient is required.';
        } else {
            $tags = $_POST['tags'];

            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $tags)){
                $errors['tags'] = 'tags should be a comma separated list';
            }
        }

        # validacion de review
        if(empty($_POST['review'])){
            $errors['review'] = 'Write a review.';
        } else {
            $review = htmlspecialchars($_POST['review']);
        }

        # validacion de imagen
        if(empty($_POST['image'])){
            $errors['iamge'] = 'Upload an image.';
        } else {
            $image = htmlspecialchars($_POST['image']);
        }

        # revisa si hay errores antes de enviar datos
        if(!array_filter($errors)){

            $email = mysqli_real_escape_string($conn, $email);
            $title = mysqli_real_escape_string($conn, $title);
            $tags = mysqli_real_escape_string($conn, $tags);
            $review = mysqli_real_escape_string($conn, $review);
            $image = mysqli_real_escape_string($conn, $image);

            # crea query
            $sql = "INSERT INTO reviews (title, email, tags, review, img) VALUES('$title', '$email', '$tags', '$review', '$image')";

            # envia query y redirige
            if(mysqli_query($conn, $sql)){
                header('Location: index.php');
            } else {
                echo 'query error: ' . mysqli_error($conn);
            }
            
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Add a review</h4>

    <form class="white" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <label>Your email:
            <input type="text" name="email" value="<?php echo $email; ?>">
        </label>
        <div class="red-text">
            <?php echo $errors['email'] ?>
        </div>

        <label>Album title:
            <input type="text" name="title" value="<?php echo $title; ?>">
        </label>
        <div class="red-text">
            <?php echo $errors['title'] ?>
        </div>

        <label>Tags (comma separated):
            <input type="text" name="tags" value="<?php echo $tags; ?>">
        </label>
        <div class="red-text">
            <?php echo $errors['tags'] ?>
        </div>

        <label>Write your review:
            <input type="text" name="review" value="<?php echo $review; ?>">
        </label>
        <div class="red-text">
            <?php echo $errors['review'] ?>
        </div>

        <label>Link to album image:
            <input type="text" name="image" value="<?php echo $image; ?>">
        </label>
        <div class="red-text">
            <?php echo $errors['image'] ?>
        </div>

        <div class="center">
            <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php'); ?>

</html>