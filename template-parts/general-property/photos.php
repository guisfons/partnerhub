<?php $post_id = get_the_ID(); $user_id = get_current_user_id(); ?>
<div class="card general-property__photos">
    <div class="card__header"><h3>Photos</h3></div>
    <div class="card__body">
        <div class="gallery">
            <table class="repeater-table">
                <thead><tr><td><h4>Exterior Photos</h4></td><td></td></tr></thead>
                <tbody>
                    <?php 
                    $images = get_field('exterior');
                    $field_key = acf_get_field('exterior')['key'];
                    if( $images ):
                        // echo '<tbody class="gallery__images">';
                        foreach( $images as $image ):
                            $image_title = $image['alt'];
                            $image_url = $image['url'];
                            echo
                            '<tr>
                                <td>
                                    '.$image_url.'
                                    <figure style="display: none;"><img style="display: none;" lazy="load" src="'.$image_url.'" alt="'.$image_title.'"></figure>
                                </td>
                                <td><a href="'.$image_url.'" title="'.$image_title.'" target="_blank">View</a></td>
                            </tr>';
                        endforeach;
                        echo
                        '</tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="gallery__control">
                                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                                        <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                            <input type="file" accept="image/*" name="exteriorphotos[]" multiple required>
                                            <button type="button" class="upload-gallery">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>';
                    else:
                        echo
                        '<tfoot>
                            <tr><td>
                            <div class="gallery__control">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                    <input type="file" accept="image/*" name="exteriorphotos[]" multiple required>
                                    <button type="button" class="upload-gallery">Submit</button>
                                </form>
                            </div>
                            </td></tr>
                        </tfoot>';
                    endif;
                    ?>
            </table>
        </div>

        <div class="gallery">
            <table class="repeater-table">
                <thead><tr><td><h4>Interior Photos</h4></td><td></td></tr></thead>
                <tbody>
                    <?php 
                    $images = get_field('interior');
                    $field_key = acf_get_field('interior')['key'];
                    if( $images ):
                        // echo '<tbody class="gallery__images">';
                        foreach( $images as $image ):
                            $image_title = $image['alt'];
                            $image_url = $image['url'];
                            echo
                            '<tr>
                                <td>
                                    '.$image_url.'
                                    <figure style="display: none;"><img style="display: none;" lazy="load" src="'.$image_url.'" alt="'.$image_title.'"></figure>
                                </td>
                                <td><a href="'.$image_url.'" title="'.$image_title.'" target="_blank">View</a></td>
                            </tr>';
                        endforeach;
                        echo
                        '</tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="gallery__control">
                                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                                        <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                            <input type="file" accept="image/*" name="interior-photos[]" multiple required>
                                            <button type="button" class="upload-gallery">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>';
                    else:
                        echo
                        '<tfoot>
                            <tr><td>
                            <div class="gallery__control">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                    <input type="file" accept="image/*" name="interior-photos[]" multiple required>
                                    <button type="button" class="upload-gallery">Submit</button>
                                </form>
                            </div>
                            </td></tr>
                        </tfoot>';
                    endif;
                    ?>
            </table>
        </div>

        <div class="gallery">
            <table class="repeater-table">
                <thead><tr><td><h4>Bedroom Photos</h4></td><td></td></tr></thead>
                <tbody>
                    <?php 
                    $images = get_field('bedrooms');
                    $field_key = acf_get_field('bedrooms')['key'];
                    if( $images ):
                        // echo '<tbody class="gallery__images">';
                        foreach( $images as $image ):
                            $image_title = $image['alt'];
                            $image_url = $image['url'];
                            echo
                            '<tr>
                                <td>
                                    '.$image_url.'
                                    <figure style="display: none;"><img style="display: none;" lazy="load" src="'.$image_url.'" alt="'.$image_title.'"></figure>
                                </td>
                                <td><a href="'.$image_url.'" title="'.$image_title.'" target="_blank">View</a></td>
                            </tr>';
                        endforeach;
                        echo
                        '</tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="gallery__control">
                                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                                        <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                            <input type="file" accept="image/*" name="bedroom-photos[]" multiple required>
                                            <button type="button" class="upload-gallery">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>';
                    else:
                        echo
                        '<tfoot>
                            <tr><td>
                            <div class="gallery__control">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                    <input type="file" accept="image/*" name="bedroom-photos[]" multiple required>
                                    <button type="button" class="upload-gallery">Submit</button>
                                </form>
                            </div>
                            </td></tr>
                        </tfoot>';
                    endif;
                    ?>
            </table>
        </div>

        <div class="gallery">
            <table class="repeater-table">
                <thead><tr><td><h4>Restaurant Photos</h4></td><td></td></tr></thead>
                <tbody>
                    <?php 
                    $images = get_field('restaurants');
                    $field_key = acf_get_field('restaurants')['key'];
                    if( $images ):
                        // echo '<tbody class="gallery__images">';
                        foreach( $images as $image ):
                            $image_title = $image['alt'];
                            $image_url = $image['url'];
                            echo
                            '<tr>
                                <td>
                                    '.$image_url.'
                                    <figure style="display: none;"><img style="display: none;" lazy="load" src="'.$image_url.'" alt="'.$image_title.'"></figure>
                                </td>
                                <td><a href="'.$image_url.'" title="'.$image_title.'" target="_blank">View</a></td>
                            </tr>';
                        endforeach;
                        echo
                        '</tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="gallery__control">
                                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                                        <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                            <input type="file" accept="image/*" name="restaurant-photos[]" multiple required>
                                            <button type="button" class="upload-gallery">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>';
                    else:
                        echo
                        '<tfoot>
                            <tr><td>
                            <div class="gallery__control">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                    <input type="file" accept="image/*" name="restaurant-photos[]" multiple required>
                                    <button type="button" class="upload-gallery">Submit</button>
                                </form>
                            </div>
                            </td></tr>
                        </tfoot>';
                    endif;
                    ?>
            </table>
        </div>

        <div class="gallery">
            <table class="repeater-table">
                <thead><tr><td><h4>Foods & Drinks Photos</h4></td><td></td></tr></thead>
                <tbody>
                    <?php 
                    $images = get_field('food_&_drinks');
                    $field_key = acf_get_field('food_&_drinks')['key'];
                    if( $images ):
                        // echo '<tbody class="gallery__images">';
                        foreach( $images as $image ):
                            $image_title = $image['alt'];
                            $image_url = $image['url'];
                            echo
                            '<tr>
                                <td>
                                    '.$image_url.'
                                    <figure style="display: none;"><img style="display: none;" lazy="load" src="'.$image_url.'" alt="'.$image_title.'"></figure>
                                </td>
                                <td><a href="'.$image_url.'" title="'.$image_title.'" target="_blank">View</a></td>
                            </tr>';
                        endforeach;
                        echo
                        '</tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="gallery__control">
                                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                                        <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                            <input type="file" accept="image/*" name="foods-drinks-photos[]" multiple required>
                                            <button type="button" class="upload-gallery">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>';
                    else:
                        echo
                        '<tfoot>
                            <tr><td>
                            <div class="gallery__control">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                    <input type="file" accept="image/*" name="foods-drinks-photos[]" multiple required>
                                    <button type="button" class="upload-gallery">Submit</button>
                                </form>
                            </div>
                            </td></tr>
                        </tfoot>';
                    endif;
                    ?>
            </table>
        </div>

        <div class="gallery">
            <table class="repeater-table">
                <thead><tr><td><h4>Bar Photos</h4></td><td></td></tr></thead>
                <tbody>
                    <?php 
                    $images = get_field('bar');
                    $field_key = acf_get_field('bar')['key'];
                    if( $images ):
                        // echo '<tbody class="gallery__images">';
                        foreach( $images as $image ):
                            $image_title = $image['alt'];
                            $image_url = $image['url'];
                            echo
                            '<tr>
                                <td>
                                    '.$image_url.'
                                    <figure style="display: none;"><img style="display: none;" lazy="load" src="'.$image_url.'" alt="'.$image_title.'"></figure>
                                </td>
                                <td><a href="'.$image_url.'" title="'.$image_title.'" target="_blank">View</a></td>
                            </tr>';
                        endforeach;
                        echo
                        '</tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="gallery__control">
                                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                                        <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                            <input type="file" accept="image/*" name="bar-photos[]" multiple required>
                                            <button type="button" class="upload-gallery">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>';
                    else:
                        echo
                        '<tfoot>
                            <tr><td>
                            <div class="gallery__control">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                    <input type="file" accept="image/*" name="bar-photos[]" multiple required>
                                    <button type="button" class="upload-gallery">Submit</button>
                                </form>
                            </div>
                            </td></tr>
                        </tfoot>';
                    endif;
                    ?>
            </table>
        </div>

        <div class="gallery">
            <table class="repeater-table">
                <thead><tr><td><h4>Other Photos</h4></td><td></td></tr></thead>
                <tbody>
                    <?php 
                    $images = get_field('other');
                    $field_key = acf_get_field('other')['key'];
                    if( $images ):
                        // echo '<tbody class="gallery__images">';
                        foreach( $images as $image ):
                            $image_title = $image['alt'];
                            $image_url = $image['url'];
                            echo
                            '<tr>
                                <td>
                                    '.$image_url.'
                                    <figure style="display: none;"><img style="display: none;" lazy="load" src="'.$image_url.'" alt="'.$image_title.'"></figure>
                                </td>
                                <td><a href="'.$image_url.'" title="'.$image_title.'" target="_blank">View</a></td>
                            </tr>';
                        endforeach;
                        echo
                        '</tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="gallery__control">
                                        <span class="remove-images" data-field-key="'.$field_key.'">Remove images</span>
                                        <span class="download-images"><span class="material-symbols-outlined">download</span></span>
                                        <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                            <input type="file" accept="image/*" name="other-photos[]" multiple required>
                                            <button type="button" class="upload-gallery">Submit</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>';
                    else:
                        echo
                        '<tfoot>
                            <tr><td>
                            <div class="gallery__control">
                                <form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" class="gallery-field" enctype="multipart/form-data">
                                    <input type="file" accept="image/*" name="other-photos[]" multiple required>
                                    <button type="button" class="upload-gallery">Submit</button>
                                </form>
                            </div>
                            </td></tr>
                        </tfoot>';
                    endif;
                    ?>
            </table>
        </div>
    </div>
</div>