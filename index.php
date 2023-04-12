<?php

    include('config/db_connect.php');

    //write query for particular records
    $sql = 'SELECT title, tags, id FROM reviews ORDER BY created_at';

    //execute query and get result
    $result = mysqli_query($conn, $sql);

    //fetch the results as an array
    $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //free result from memory
    mysqli_free_result($result);

    //close connection
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<h4 class="center grey-text">Reviews</h4>

<div class="container">
    <div class="row">
        <?php foreach($reviews as $review): ?>
            <div class="col s6 md3">
                <div class="card z-depth-0">
                    <img src="img/record.svg" alt="record" class="record">
                    <div class="card-content center">
                        <h6> <?php echo htmlspecialchars($review['title']); ?> </h6>
                        <ul>
                            <?php foreach(explode(',', $review['tags']) as $tag): ?>
                                <li><?php echo htmlspecialchars($tag); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="card-action right-align">
                        <a href="details.php?id=<?php echo $review['id'] ?>" class="brand-text">more info...</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        
    </div>
</div>

<?php include('templates/footer.php'); ?>

</html>