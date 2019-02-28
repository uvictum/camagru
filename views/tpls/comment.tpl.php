<article id="comment_<?php echo $comment['ID']?>" class="media">
    <figure class="media-left">
        <p class="image is-64x64">
            <img src="https://bulma.io/images/placeholders/128x128.png">
        </p>
    </figure>
    <div class="media-content">
        <div class="content">
            <p>
                <strong><?php
                    echo $comment['Login']?></strong>
                <br>
                <?php echo $comment['Text']?>
                <br>
                <?php if (!empty($_SESSION['login']) && $comment['Login'] == $_SESSION['login']) {
                    echo '<small><a class="link" id="'.$comment['ID'].'">Delete</a></small>';
                }
                ?>
            </p>
        </div>
    </div>
</article>