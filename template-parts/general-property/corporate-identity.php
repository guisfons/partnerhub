<?php $post_id = get_the_ID(); $user_id = get_current_user_id(); ?>
<div class="card general-property__corporate-identity">
    <div class="card__header"><h3>Corporate Identity</h3></div>

    <div class="card__body">
        <table class="repeater-table">
            <thead><tr><td><h4>Colours</h4></td><td></td></tr></thead>
            <tbody>
            <?php
                $field_key = acf_get_field('corporate_identity_colours')['key'];
                $title_field_key = acf_get_field('corporate_identity_colours')['sub_fields'][0]['key'];
                $color_field_key = acf_get_field('corporate_identity_colours')['sub_fields'][1]['key'];

                if( have_rows('corporate_identity_colours') ):
                    $x = 1;
                    while( have_rows('corporate_identity_colours') ) : the_row();
                        $title = get_sub_field('title');
                        $colour = get_sub_field('colour');
                        if(!empty($title)) {
                            echo '<tr data-row-index="'.$x.'"><td><span><input type="text" placeholder="'.$title.'" value="'.$title.'" disabled><span class="color" style="background-color: '.$colour.'"></span></span></td><td><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'">Remove</span></td></tr>';
                        } else {
                            echo
                            '<tr data-row-index="'.$x.'"><td><form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-color-key="'.$color_field_key.'">
                                <input type="text" class="title-field" placeholder="Colour Title" value="Colour Title" required>
                                <input type="color" class="color-field" required>
                                <button type="button" class="upload-items">Submit</button>
                                <span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'">Remove</span>
                            </form></td></tr>';
                        }
                        $x++;
                    endwhile;
                endif;
                ?>
                <tr><td></td><td><span class="add-row add-row--color" data-post-id="<?php echo $post_id; ?>" data-field-key="<?php echo $field_key; ?>" data-title-key="<?php echo $title_field_key; ?>" data-color-key="<?php echo $color_field_key; ?>">Add colour</span></td></tr>
            </tbody>
        </table>

        <table class="repeater-table">
            <thead><tr><td><h4>Fonts</h4></td><td></td></tr></thead>
            <tbody>
            <?php
                $field_key = acf_get_field('corporate_identity_fonts')['key'];
                $title_field_key = acf_get_field('corporate_identity_fonts')['sub_fields'][0]['key'];
                $font_field_key = acf_get_field('corporate_identity_fonts')['sub_fields'][1]['key'];

                if( have_rows('corporate_identity_fonts') ):
                    $x = 1;
                    while( have_rows('corporate_identity_fonts') ) : the_row();
                        $title = get_sub_field('title');
                        $font = get_sub_field('font');
                        if(!empty($title)) {
                            echo '<tr data-row-index="'.$x.'"><td><strong>Font name:</strong> '.$title.' <strong>Font family: </strong>'.$font.'</td><td><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'">Remove</span></td></tr>';
                        } else {
                            echo
                            '<tr data-row-index="'.$x.'"><td><form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-title-key="'.$title_field_key.'" data-font-key="'.$font_field_key.'">
                                <input type="text" class="title-field" placeholder="Font name" value="Font Title" required>
                                <input type="text" class="font-field" placeholder="Font family" value="Font family" required>
                                <button type="button" class="upload-items">Submit</button>
                                <span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'">Remove</span>
                            </form></td></tr>';
                        }
                        $x++;
                    endwhile;
                endif;
                ?>
                <tr><td></td><td></td><td><span class="add-row add-row--font" data-post-id="<?php echo $post_id; ?>" data-field-key="<?php echo $field_key; ?>" data-title-key="<?php echo $title_field_key; ?>" data-font-key="<?php echo $font_field_key; ?>">Add font</span></td></tr>
            </tbody>
        </table>

        <div class="gallery">
            <h4>Logos</h4>
            <?php 
            $images = get_field('corporate_identity_logos');
            $field_key = acf_get_field('corporate_identity_logos')['key'];

            if( $images ):
                echo '<div class="gallery__images gallery__images--noslider">';
                foreach( $images as $image ):
                    $image_title = $image['alt'];
                    $image_url = $image['url'];
                    echo '<figure><img src="'.$image_url.'" alt="'.$image_title.'"></figure>';
                endforeach;
                echo
                    '</div>
                    <div class="gallery__control">
                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                        <form method="post" data-post-id="'.$post_id.'" enctype="multipart/form-data" data-field-key="'.$field_key.'" class="gallery-field">
                            <input type="file" accept="image/*" name="logos[]" multiple required>
                            <button type="button" class="upload-gallery">Submit</button>
                        </form>
                    </div>';
            else:
                echo
                    '<div class="gallery__control">
                        <form method="post" data-post-id="'.$post_id.'" enctype="multipart/form-data" data-field-key="'.$field_key.'" class="gallery-field">
                            <input type="file" accept="image/*" name="logos[]" multiple required>
                            <button type="button" class="upload-gallery">Submit</button>
                        </form>
                    </div>';
            endif;
            ?>
        </div>
    </div>
</div>