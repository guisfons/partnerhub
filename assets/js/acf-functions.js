$( document ).ready(function() {
    $('body').on('click', '.upload-file', function() {
        let btn = $(this)
        let formData = new FormData()
        let fileInput = $(this).parent().find('.file')[0]
        let form = $(this).closest('form')

        let postId = form.data('post-id')
        let fieldKey = form.data('field-key')
        let fileFieldKey = form.data('file-field-key')

        let rowId = $(this).closest('tr').data('row-index')

        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0])
            formData.append('postId', postId)
            formData.append('fieldKey', fieldKey)

            if(btn.hasClass('upload-repeater-file')) {
                formData.append('rowId', rowId)
                formData.append('fileFieldKey', fileFieldKey)

                form = btn.closest('tr')
            }

            // Perform AJAX request with jQuery
            $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php?action=upload_and_update_field',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    showLoadingScreen();
                },
                complete: function () {
                    hideLoadingScreen();
                },
                success: function(response) {
                    
                    let fileUrl = response.data.file_url
                    let filename = response.data.file_name
                    
                    // let updatedHtml = '<figure class="administration__info-iframe"><iframe src="'+fileUrl+'" loading="lazy"></iframe><span class="remove-file" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove file</span><a href="'+fileUrl+'" target="_blank">See full screen</a><span class="material-symbols-outlined">share</span></figure>'
                    let updatedHtml = '<table class="single-table"><tr><td>'+filename+'</td><td><a href="'+fileUrl+'" title="'+filename+'" target="_blank">View</a><span class="remove-file" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove file</span><span class="material-symbols-outlined">share</span></td></tr></table>'
                    let updatedRepeaterHtml = '<tr data-row-index="'+rowId+'"><td>'+filename+'</td><td><a href="'+fileUrl+'" target="_blank">View</a><span class="deleteRowBtn" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove</span><span class="material-symbols-outlined">share</span></td></tr>'

                    if(btn.hasClass('upload-repeater-file')) {
                        alert('File uploaded successfully!')
                        form.replaceWith(updatedRepeaterHtml)
                    } else {
                        alert('File uploaded successfully!')
                        form.replaceWith(updatedHtml)
                    }

                    linkUpdate()
                },
                error: function(error) {
                    alert('Error uploading file.')
                }
            })
        } else {
            alert('Please select a file to upload.')
        }
    })

    $('body').on('click', '.remove-file', function() {
        let postId = $(this).data('post-id')
        let fieldKey = $(this).data('field-key')
        let title = $(this).closest('h3').text().toLowerCase()
        let figureEl = $(this).closest('.single-table')

        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php?action=remove_file_from_field',
            data: { postId: postId, fieldKey: fieldKey },
            beforeSend: function () {
                showLoadingScreen();
            },
            complete: function () {
                hideLoadingScreen();
            },
            success: function(response) {
                // Handle the success response
                alert('File removed successfully')
                let updatedHtml = '<form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" class="file-field" enctype="multipart/form-data"><h4>Add '+title+'</h4><input type="file" class="file" accept="application/pdf"><button type="button" class="upload-file">Upload</button></form>'
                figureEl.replaceWith(updatedHtml)
            },
            error: function(error) {
                // Handle the error response
                alert('Error removing file from field.')
            }
        })
    })

    $('.add-row').on('click', function() {
        let addBtn = $(this)
        let postId = $(this).data('post-id')
        let fieldKey = $(this).data('field-key')
        let rowId = parseInt($(this).closest('tbody').find('tr:nth-last-of-type(2)').data('row-index'))
        let rowIdAdded
        let fileFieldKey = $(this).data('file-field-key')

        if($(this).data('file-field-key') !== '') {
            fileFieldKey = $(this).data('file-field-key')
        } else {
            fileFieldKey = fieldKey
        }

        if($(this).closest('tbody').find('tr').length > 1) {
            if(addBtn.hasClass('add-row--color') || addBtn.hasClass('add-row--font')) {
                rowIdAdded = parseInt($(this).closest('tbody').find('tr:nth-last-of-type(2)').data('row-index'))+parseInt(1)
            } else {
                rowIdAdded = parseInt($(this).closest('.card__body').find('.single-table tbody tr').data('row-index'))+parseInt(1)
            }
        } else {
            rowIdAdded = parseInt(1)
        }

        let url = ''

        if(addBtn.hasClass('add-row--items')) {
            url = ''
        } else {
            url = '/wp-admin/admin-ajax.php?action=add_repeater_row'
        }

        let title, color, font
        
        $.ajax({
            type: 'POST',
            url: url,
            data: { postId: postId, fieldKey: fieldKey, rowId: rowId },
            beforeSend: function () {
                showLoadingScreen();
            },
            complete: function () {
                hideLoadingScreen();
            },
            success: function(response) {
                // Update the table after successful addition of a new row
                if(addBtn.hasClass('add-row--color')) {
                    title = addBtn.data('title-key')
                    color = addBtn.data('color-key')
                    addBtn.closest('tbody').find('tr:last-of-type').before('<tr data-row-index="'+rowIdAdded+'"><td><form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-title-key="'+title+'" data-color-key="'+color+'"><input type="text" class="title-field" placeholder="Colour Title" value="Colour Title" required="required"><input type="color" class="color-field" required="required"><button type="button" class="upload-items">Submit</button><span class="deleteRowBtn" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove</span></form></td></tr>')
                } else if(addBtn.hasClass('add-row--font')) {
                    console.log(postId);
                    title = addBtn.data('title-key')
                    font = addBtn.data('font-key')
                    addBtn.closest('tbody').find('tr:last-of-type').before('<tr data-row-index="'+rowIdAdded+'"><td><form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-title-key="'+title+'" data-font-key="'+font+'"><input type="text" class="title-field" placeholder="Font name" value="Font Title" required=""><input type="text" class="font-field" placeholder="Font family" value="Font family" required=""><button type="button" class="upload-items">Submit</button><span class="deleteRowBtn" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove</span></form></td></tr>')
                } else {
                    if(addBtn.closest('.card__body').find('.single-table tbody tr').length == 0) {
                        addBtn.closest('.card__body').prepend('<table class="single-table"><thead><tr><td><h4>New</h4></td><td></td></tr></thead><tbody><tr></tr></tbody></table>')
                    }

                    let oldNew = addBtn.closest('.card__body').find('.single-table tbody tr')
                    addBtn.closest('.card__body').find('.single-table tbody tr').remove()
                    addBtn.closest('.card__body').find('.single-table tbody').prepend('<tr data-row-index="'+rowIdAdded+'"><td>Add file</td><td><form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-file-field-key="'+fileFieldKey+'" class="file-field" enctype="multipart/form-data"><input type="file" class="file" accept="application/pdf"><button type="button" class="upload-file upload-repeater-file">Upload file</button></form><span class="deleteRowBtn" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-file-field-key="'+fileFieldKey+'">Remove</span></td></tr>')
                    addBtn.closest('tbody').prepend(oldNew)

                    linkUpdate()
                }
            },
            error: function(error) {
                console.error('Error adding new row.');
            }
        });

    });
    
    $('body').on('click', '.upload-items', function() {
        let btn = $(this)
        let form = $(this).closest('form')
        let postId = form.data('post-id')
        let fieldKey = form.data('field-key')
        let titleFieldKey = form.data('title-key')
        let colorFieldKey = form.data('color-key')
        let fontFieldKey = form.data('font-key')
        let rowId = $(this).closest('tr').data('row-index')
        let title = $(this).parent().find('.title-field').val()
        let color, font, type = ''

        if(btn.closest('form').find('.color-field').length !== 0) {
            color = btn.parent().find('.color-field').val()
        } else if(btn.closest('form').find('.font-field').length !== 0) {
            font = btn.parent().find('.font-field').val()
        }

        if(typeof colorFieldKey !== 'undefined') {
            type = 'color'
        }
        
        if(typeof fontFieldKey !== 'undefined') {
            type = 'font'
        }


        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php?action=multiple_update_repeater_items',
            data: { postId: postId, fieldKey: fieldKey, titleFieldKey: titleFieldKey, colorFieldKey: colorFieldKey, fontFieldKey: fontFieldKey, rowId: rowId, color: color, font: font, title: title, type: type },
            beforeSend: function () {
                showLoadingScreen();
            },
            complete: function () {
                hideLoadingScreen();
            },
            success: function(response) {
                // Update the table after successful addition of a new row
                if(btn.closest('form').find('.color-field').length !== 0) {
                    btn.closest('tr').html('<td><span><input type="text" placeholder="'+title+'" value="'+title+'" disabled><span class="color" style="background-color: '+color+'"></span></span></td><td><span class="deleteRowBtn" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove</span></td>')
                } else if(btn.closest('form').find('.font-field').length !== 0) {
                    btn.closest('tr').html('<td><strong>Font name:</strong> '+title+' <strong>Font family:</strong> '+font+'</td><td><span class="deleteRowBtn" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove</span></td>')
                }
            },
            error: function(error) {
                console.error('Error adding new row.');
            }
        });
    })
    
    $('body').on('click', '.deleteRowBtn', function() {
        let rmBtn = $(this)
        let postId = $(this).data('post-id')
        let fieldKey = $(this).data('field-key')
        let rowId = parseInt($(this).closest('tr').data('row-index'))
        let userId = $(this).data('user-id')

        // Delete the row via AJAX
        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php?action=delete_repeater_row',
            data: { postId: postId, fieldKey: fieldKey, rowId: rowId, userId: userId },
            beforeSend: function () {
                showLoadingScreen();
            },
            complete: function () {
                hideLoadingScreen();
            },
            success: function(response) {
                let currentRow = rmBtn.closest('tr')
                currentRow.remove()

                let rows = rmBtn.closest('tbody').find('[data-row-index]')
                rows.each(function(i) {
                    $(this).attr('data-row-index', i + 1)
                })

                alert('Row removed.')
            },
            error: function(error) {
                console.error('Error deleting row.');
            }
        });
    });

    $('.gallery-field .upload-gallery').on('click', function() {
        let btn = $(this)
        let formData = new FormData()
        let fileInput = $(this).parent().find('input[type=file]')[0]
        let form = $(this).closest('form')
        let type = $(this).siblings('input[type=file]').attr('name')

        let postId = form.data('post-id')
        let fieldKey = form.data('field-key')
        let fileFieldKey = form.data('file-field-key')
        let nameField = $(this).siblings('input[type=file]').attr('name').replace('[]', '')

        let rowId = $(this).closest('tr').data('row-index')

        if (fileInput.files.length > 0) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append(type, fileInput.files[i]);
            }

            formData.append('postId', postId);
            formData.append('fieldKey', fieldKey);
            formData.append('nameField', nameField);
        
            if (btn.hasClass('upload-repeater-file')) {
                formData.append('rowId', rowId);
                formData.append('fileFieldKey', fileFieldKey);
        
                form = btn.closest('tr');
            }

            // Perform AJAX request with jQuery
            $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php?action=add_images_to_gallery',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    showLoadingScreen();
                },
                complete: function () {
                    hideLoadingScreen();
                },
                success: function(response) {
                    let imageUrls = response.data.imageUrls

                    var filteredImageUrls = imageUrls.filter(function(url) {
                        return url !== false;
                    });

                    if(btn.closest('.gallery__control').find('.remove-images').length == 0) {
                        $('<span class="remove-images" data-field-key="'+fieldKey+'">Remove images</span><span class="download-images"><span class="material-symbols-outlined">download</span></span>').insertBefore(btn.parent())
                    }

                    if(btn.closest('.gallery').find('tbody tr').length == 0) {
                        if(type == 'logos[]') {
                            btn.closest('.gallery').find('h4').after('<div class="gallery__images gallery__images--noslider"></div>')
                            $.each(filteredImageUrls, function(i, value) {
                                btn.closest('.gallery').find('.gallery__images').append('<figure><img src="'+value+'" alt="'+value.split('/').pop()+'"></figure>')
                            })
                        } else {
                            btn.closest('.gallery').find('h4').after('<div class="gallery__images"></div>')
                            $.each(filteredImageUrls, function(i, value) {
                                btn.closest('.gallery').find('tbody').prepend('<tr><td>'+value+'</td><td><a href="'+value+'" title="'+value.split('/').pop()+'" target="_blank">View</a></td></tr>')
                            })
                            
                            // setTimeout(function() {
                            //     btn.closest('.gallery').find('.gallery__images').slick({
                            //         infinite: false,
                            //         slidesToShow: 1,
                            //         arrows: true,
                            //         dots: true,
                            //         adaptiveHeight: true
                            //     })
                            // }, 300)
                        }
                    } else {
                        if(type == 'logos[]') {
                            $.each(filteredImageUrls, function(i, value) {
                                btn.closest('.gallery').find('.gallery__images').append('<figure><a href="'+value+'" target="_blank"><img src="'+value+'" alt="'+value.split('/').pop()+'"></a></figure>')
                            })
                        } else {
                            // btn.closest('.gallery').find('.gallery__images').slick('unslick')
                            $.each(filteredImageUrls, function(i, value) {
                                // btn.closest('.gallery').find('.gallery__images').append('<figure><img src="'+value+'" alt="'+value.split('/').pop()+'"></figure>')
                                btn.closest('.gallery').find('tbody').prepend('<tr><td>'+value+'</td><td><a href="'+value+'" title="'+value.split('/').pop()+'" target="_blank">View</a></td></tr>')
                            })

                            // btn.closest('.gallery').find('.gallery__images').slick({
                            //     infinite: false,
                            //     slidesToShow: 1,
                            //     arrows: true,
                            //     dots: true,
                            //     adaptiveHeight: true
                            // })
                        }         
                        
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error uploading file.');
                }
            })
        } else {
            alert('Please select a file to upload.')
        }
    })

    $('body').on('click', '.remove-images', function() {
        let btn = $(this)
        let postId = $(this).siblings('form').data('post-id')
        let fieldKey = $(this).data('field-key')

        let formData = new FormData()

        formData.append('postId', postId);
        formData.append('fieldKey', fieldKey);

        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php?action=empty_gallery_field',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                showLoadingScreen();
            },
            complete: function () {
                hideLoadingScreen();
            },
            success: function(response) {
                // btn.closest('.gallery').find('.gallery__images').empty()
                btn.closest('.gallery').find('tbody').empty()
                btn.siblings(':not(form)').remove()
                btn.remove()
                alert('Images deleted.')
            },
            error: function(error) {
                // Handle error
                alert(error.responseText);
            }
        });
    })
})