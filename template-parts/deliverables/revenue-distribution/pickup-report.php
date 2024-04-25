<?php $post_id = get_the_ID(); ?>
<div class="card regiotels-deliverables__pickup-report">
    <?php $section_title = 'Pickup Report'; $repeater_title = 'Pickup Report'; $field_name = 'pickup_report_document'; $subfield_name = 'file'; ?>
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
            <thead><tr><td></td><td></td></tr></thead>
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
                        '<tr data-row-index="'.$x.'"><td>Add '.$repeater_title.'</td><td><form method="post" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'" class="file-field" enctype="multipart/form-data">
                            <input type="file" class="file" accept="application/pdf">
                            <button type="button" class="upload-file upload-repeater-file">Upload file</button>
                        </form><span class="deleteRowBtn" data-post-id="'.$post_id.'" data-field-key="'.$field_key.'" data-file-field-key="'.$file_field_key.'">Remove</span></td></tr>';
                    }
                    $x++;
                endwhile;
            endif;
        echo 
            '<tr><td></td><td><span class="add-row" data-post-id="'. $post_id . '" data-field-key="'. $field_key . '" data-file-field-key="'. $file_field_key . '">Add '.$repeater_title.'</span></td></tr>
            </tbody>
        </table>';
        ?>
    </div>
</div>