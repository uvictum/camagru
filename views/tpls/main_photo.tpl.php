<div class="column">
    <div class="card">
        <div class="card-image">
            <figure class="image is-4by3">
                <a href="<?php echo '/?image='.$img['ID'] ?>"><img class="photo_home" src="<?php echo $img['Link']; ?>"></a>
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <div class="columns">
                        <div class="column">
                            <p class="title is-5">By <?php echo $img['Login']?></p>
                        </div>
                        <div class="column">
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    <p class="level-item">
                                        <?php echo $img['Likes'];?>
                                    </p>
                                    <a class="level-item">
                                <span class="icon is-small">
                                    <svg class="icon like<?php if (in_array($img['ID'], $liked)) { echo 'd'; }?>_symbol" id="img_<?php echo $img['ID']?>">
                                            <use xlink:href="#heart<?php if (!in_array($img['ID'], $liked)) { echo '-1'; }?>" />
                                    </svg>
                                </span>
                                    </a>
                                    <p class="level-item">
                                        <?php echo $img['Comments']?>
                                    </p>
                                    <a class="level-item">
                                <span class="icon is-small">
                                    <svg class="icon">
                                        <use xlink:href="#comment" />
                                    </svg>
                                </span>
                                    </a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>