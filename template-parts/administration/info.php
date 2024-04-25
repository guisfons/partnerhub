<?php $post_id = get_the_ID(); ?>
<div class="administration__info">
    <div class="card administration__info-contract">
        <div class="card__header"><h3>Contract</h3></div>
        <div class="card__body">
        <?php
        if(!empty(get_field('contract'))) {
            $filename = get_field('contract')['filename'];
            $url = get_field('contract')['url'];
            $key = acf_get_field('contract')['key'];
            // echo
            // '<figure class="administration__info-iframe">
            //     <iframe src="'.get_field('contract')['url'].'" title="'.get_field('contract')['filename'].'" loading="lazy"></iframe>
            //     <span class="remove-file" data-post-id="'.$post_id.'" data-field-key="'.acf_get_field('contract')['key'].'">Remove file</span>
            //     <a href="'.get_field('contract')['url'].'" target="_blank">See full screen</a>
            //     <span class="material-symbols-outlined">share</span>
            // </figure>';

            echo '<table class="single-table"><tr><td>'.$filename.'</td><td><a href="'.$url.'" title="'.$filename.'" target="_blank">View</a><span class="remove-file" data-post-id="'.$post_id.'" data-field-key="'.$key.'">Remove file</span><span class="material-symbols-outlined">share</span></td></tr></table>';
        } else {
            echo
            '<form method="post" data-post-id="'.$post_id.'" data-field-key="'.acf_get_field('contract')['key'].'" class="file-field" enctype="multipart/form-data">
                <h4>Add contract</h4>
                <input type="file" class="file" accept="application/pdf">
                <button type="button" class="upload-file">Upload</button>
            </form>';
        }
        ?>
        </div>
    </div>

    <div class="card administration__info-offers">
        <div class="card__header"><h3>Offers</h3></div>
        <div class="card__body">
        <?php
        if(!empty(get_field('offers'))) {
            $filename = get_field('offers')['filename'];
            $url = get_field('offers')['url'];
            $key = acf_get_field('offers')['key'];
            // echo
            // '<figure class="administration__info-iframe">
            //     <iframe src="'.get_field('offers')['url'].'" title="'.get_field('offers')['filename'].'" loading="lazy"></iframe>
            //     <span class="remove-file" data-post-id="'.$post_id.'" data-field-key="'.acf_get_field('offers')['key'].'">Remove file</span>
            //     <a href="'.get_field('offers')['url'].'" target="_blank">See full screen</a>
            //     <span class="material-symbols-outlined">share</span>
            // </figure>';

            echo '<table class="single-table"><tr><td>'.$filename.'</td><td><a href="'.$url.'" title="'.$filename.'" target="_blank">View</a><span class="remove-file" data-post-id="'.$post_id.'" data-field-key="'.$key.'">Remove file</span><span class="material-symbols-outlined">share</span></td></tr></table>';

        } else {
            echo
            '<form method="post" data-post-id="'.$post_id.'" data-field-key="'.acf_get_field('offers')['key'].'" class="file-field" enctype="multipart/form-data">
                <h4>Add offer</h4>
                <input type="file" class="file" accept="application/pdf">
                <button type="button" class="upload-file">Upload</button>
            </form>';
        }
        ?>
        </div>
    </div>

    <div class="card administration__info-lacarteservices">
        <?php $section_title = 'A La Carte Services'; $repeater_title = 'Services'; $field_name = 'la_carte_services'; $subfield_name = 'service_carte'; ?>
        <div class="card__header"><h3><?= $section_title; ?></h3></div>
        <div class="card__body">
            <?php
            $field_key = acf_get_field($field_name)['key'];
            $file_field_key = acf_get_field($subfield_name)['key'];

            $rows = get_field($field_name);
            if($rows) {
                $last_row = end($rows);
                $last_row_field = $last_row[$subfield_name];
                $last_row_index = count($rows);

                if($last_row_index > 1 && !empty($last_row_field)) {
                    echo
                    '<table class="single-table">
                        <thead><tr><td><h4>New</h4></td><td></td></tr></thead>
                        <tbody>
                            <tr data-row-index="'.$last_row_index.'"><td>'.$last_row_field['filename'].'</td><td><a href="'.$last_row_field['url'].'" title="'.$last_row_field['filename'].'" target="_blank">View</a><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Remove</span><span class="material-symbols-outlined">share</span></td></tr>
                        </tbody>
                    </table>';
                }
            }

            echo
            '<table class="repeater-table">
                <thead><tr><td><h4>'.$repeater_title.'</h4></td><td></td></tr></thead>
                <tbody>';
                if( have_rows($field_name) ):
                    $x = 1;
                    while( have_rows($field_name) ) : the_row();
                        $service = get_sub_field($subfield_name);
                        if(!empty($service)) {
                            if($x == 1 || $x !== $last_row_index) {
                                echo '<tr data-row-index="'.$x.'"><td>'.$service['filename'].'</td><td><a href="'.$service['url'].'" title="'.$service['filename'].'" target="_blank">View</a><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Remove</span><span class="material-symbols-outlined">share</span></td></tr>';
                            }                                        
                        } else {
                            echo
                            '<tr data-row-index="'.$x.'"><td>Add '.substr_replace($repeater_title, '', -1).'</td><td><form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'" class="file-field" enctype="multipart/form-data">
                                <input type="file" class="file" accept="application/pdf">
                                <button type="button" class="upload-file upload-repeater-file">Upload file</button>
                            </form><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Remove</span></td></tr>';
                        }
                        $x++;
                    endwhile;
                endif;
            echo 
                '<tr><td></td><td><span class="add-row" data-post-id="'. $post_id . '" data-field-key="'. $field_key . '" data-file-field-key="'. $file_field_key . '">Add '.substr_replace($repeater_title, '', -1).'</span></td></tr>
                </tbody>
            </table>';
            ?>
        </div>
    </div>

    <div class="card administration__info-invoices">
        <?php $section_title = 'Invoices'; $repeater_title = 'Invoices'; $field_name = 'invoices'; $subfield_name = 'invoice'; ?>
        <div class="card__header"><h3><?= $section_title; ?></h3></div>
        <div class="card__body">
            <?php
            $field_key = acf_get_field($field_name)['key'];
            $file_field_key = acf_get_field($subfield_name)['key'];

            $rows = get_field($field_name);
            if($rows) {
                $last_row = end($rows);
                $last_row_field = $last_row[$subfield_name];
                $last_row_index = count($rows);

                if($last_row_index > 1 && !empty($last_row_field)) {
                    echo
                    '<table class="single-table">
                        <thead><tr><td><h4>New</h4></td><td></td></tr></thead>
                        <tbody>
                            <tr data-row-index="'.$last_row_index.'"><td>'.$last_row_field['filename'].'</td><td><a href="'.$last_row_field['url'].'" title="'.$last_row_field['filename'].'" target="_blank">View</a><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Remove</span><span class="material-symbols-outlined">share</span></td></tr>
                        </tbody>
                    </table>';
                }
            }

            echo
            '<table class="repeater-table">
                <thead><tr><td><h4>'.$repeater_title.'</h4></td><td></td></tr></thead>
                <tbody>';
                if( have_rows($field_name) ):
                    $x = 1;
                    while( have_rows($field_name) ) : the_row();
                        $service = get_sub_field($subfield_name);
                        if(!empty($service)) {
                            if($x == 1 || $x !== $last_row_index) {
                                echo '<tr data-row-index="'.$x.'"><td>'.$service['filename'].'</td><td><a href="'.$service['url'].'" title="'.$service['filename'].'" target="_blank">View</a><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Remove</span><span class="material-symbols-outlined">share</span></td></tr>';
                            }                                        
                        } else {
                            echo
                            '<tr data-row-index="'.$x.'"><td>Add '.substr_replace($repeater_title, '', -1).'</td><td><form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'" class="file-field" enctype="multipart/form-data">
                                <input type="file" class="file" accept="application/pdf">
                                <button type="button" class="upload-file upload-repeater-file">Upload file</button>
                            </form><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Remove</span></td></tr>';
                        }
                        $x++;
                    endwhile;
                endif;
            echo 
                '<tr><td></td><td><span class="add-row" data-post-id="'. $post_id . '" data-field-key="'. $field_key . '" data-file-field-key="'. $file_field_key . '">Add '.substr_replace($repeater_title, '', -1).'</span></td></tr>
                </tbody>
            </table>';
            ?>
        </div>
    </div>
</div>