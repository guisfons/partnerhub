$( document ).ready(function() {
    $('body').on('click', '.table__row-controls-delete', function(){ 
        if($(this).closest('.table').hasClass('table--gallery')) {
            deleteImageFromGallery($(this))
        } else {
            titleChange($(this))

            if($(this).closest('.table__row').data('row-index') == undefined) {
                deleteSingleFile($(this))
            }

            if($(this).closest('.table__row').data('row-index') !== undefined) {
                deleteRepeater($(this))
            }
        }
    })

    $('body').on('click', '.table__foot-removecategory', function(){
        deleteRepeater($(this))
    })

    $('body').on('click', '.table__gallery-delete', function() { deleteImageFromGallery($(this)) })

    $('body').on('click', '.table__row-upload', function() { uploadFile($(this)) })

    $('.table__foot-addrow').on('click', function() { addRow($(this)) })
    
    $('body').on('click', '.table__row-controls-upload', function() { colorFontAdd($(this)) })

    $('body').on('click', '.gallery-field .upload-gallery', function() { galllery($(this)) })

    $('body').on('click', '.table__foot-removeimages', function() { removeImages($(this)) })

    $('.card__body-room-addroom').on('click', function() { addRoomCategorie($(this)) })
})

function getServiceUrl(url) {
    if (url) {
        var pathParts = url.split('/');
        var uploadsIndex = pathParts.indexOf('uploads');
        if (uploadsIndex !== -1) {
            pathParts.splice(uploadsIndex + 1, 0, $('.breadcrumb span[data-post-name]').data('post-name'));
            return pathParts.join('/');
        }
    }
    return '';
}

function addRow(el) {
    let addBtn = el
    let postId = el.data('post-id')
    let fieldKey = el.data('field-key')
    let rowId, rowIdAdded
    let file = el.closest('.card__body').find('.table form input[type=file]')

    if(file.length !== 0) {
        if(file[0].files.length === 0) {
            alert('Please add a file to upload')
            return false
        } else {
            el.closest('.card__body').find('.table__row-form .table__row-upload').click()
            return false
        }
    }

    if(el.closest('.card__body').find('.table--new').length == 0) {
        if(el.closest('.table').find('.table__row').length > 0) {
            rowId = parseInt(el.closest('.table').find('.table__row:first-of-type').data('row-index'))+parseInt(1)
        } else {
            rowId = parseInt(1)
        }
    } else {
        rowId = parseInt(el.closest('.card__body').find('.table--new .table__row').data('row-index'))+parseInt(1);
    }

    let fileFieldKey = el.data('file-field-key')

    if(el.data('file-field-key') !== '') {
        fileFieldKey = el.data('file-field-key')
    } else {
        fileFieldKey = fieldKey
    }

    if(el.closest('.table').find('.table__body .table__row').length > 1) {
        if(addBtn.hasClass('table__foot-addrow--colour') || addBtn.hasClass('table__foot-addrow--font')) {
            rowIdAdded = parseInt(el.closest('.table').find('.table__row:first-of-type').data('row-index'))+parseInt(1)
        } else {
            rowIdAdded = parseInt(el.closest('.card__body').find('.table--new .table__row').data('row-index'))+parseInt(1)
        }
    } else {
        rowIdAdded = parseInt(1)
    }

    let url = ''

    if(addBtn.hasClass('table__foot-addrow--items')) {
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
            // showLoadingScreen();
        },
        complete: function () {
            // setTimeout(function(){
            //     hideLoadingScreen()
            // }, 1000);
        },
        success: function(response) {
            let tableRowNew =
            '<div data-row-index="'+rowId+'" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-file-field-key="'+fileFieldKey+'" class="table__row">\
                <span class="table__row-title"></span>\
                <div class="table__row-form">\
                    <form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-file-field-key="'+fileFieldKey+'" class="file-field" enctype="multipart/form-data">\
                        <input type="file" class="file" accept=".xls, .xlsm, .pdf, .docx">\
                        <button type="button" class="table__row-upload table__row-upload--repeater">Upload file</button>\
                    </form>\
                </div>\
                <div class="table__row-controls">\
                    <button class="table__row-controls-delete">Remove</button>\
                </div>\
            </div>';

            let tableNew = 
            '<div class="table table--new">\
                <div class="table__header">New</div>\
                <div class="table__body">'+tableRowNew+'</div>\
            </div>';

            if(addBtn.hasClass('table__foot-addrow--colour')) {
                title = addBtn.data('title-key')
                color = addBtn.data('colour-key')
                addBtn.closest('.card__body').find('.table__body').prepend(
                    '<div data-row-index="'+rowIdAdded+'" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-title-key="'+title+'" data-colour-key="'+color+'" class="table__row">\
                        <span class="table__row-title"></span>\
                        <div class="table__row-form">\
                            <form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-title-key="'+title+'" data-colour-key="'+color+'">\
                                <input type="text" class="title-field" placeholder="Colour Title" value="Colour Title" required>\
                                <input type="color" class="color-field" required>\
                                <button type="button" class="table__row-controls-upload">Submit</button>\
                            </form>\
                        </div>\
                        <div class="table__row-controls">\
                            <button class="table__row-controls-delete">Remove</button>\
                        </div>\
                    </div>\
                ')
            } else if(addBtn.hasClass('table__foot-addrow--font')) {
                title = addBtn.data('title-key')
                font = addBtn.data('font-key')
                addBtn.closest('.table').find('.table__body').prepend(
                    '<div data-row-index="'+rowIdAdded+'" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-title-key="'+title+'" data-font-key="'+font+'" class="table__row">\
                        <span class="table__row-title"></span>\
                        <div class="table__row-form table__row-form--font">\
                            <form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-title-key="'+title+'" data-font-key="'+font+'">\
                                <input type="text" class="title-field" placeholder="Font name" value="Font Title" required="">\
                                <input type="text" class="font-field" placeholder="Font family" value="Font family" required="">\
                                <button type="button" class="table__row-controls-upload">Submit</button>\
                            </form>\
                        </div>\
                        <div class="table__row-controls">\
                            <button class="table__row-controls-delete">Remove</button>\
                        </div>\
                    </div>\
                ')
            } else {
                if(addBtn.closest('.card__body').find('.table--new').length == 0) {
                    addBtn.closest('.card__body').prepend(tableNew)
                } else {
                    let oldNew = addBtn.closest('.card__body').find('.table--new .table__row')
                    addBtn.closest('.card__body').find('.table--new .table__row').remove()
                    addBtn.closest('.card__body').find('.table--new .table__body').prepend(tableRowNew)
                    addBtn.closest('.table').find('.table__body').prepend(oldNew)
                }
            }
        },
        error: function(error) {
            alert('Error adding new row.');
        }
    });
}

function deleteSingleFile(el) {
    el = el.closest('.table__row')
    let postId = el.data('post-id')
    let fieldKey = el.data('field-key')
    let fileName = el.closest('.table__row').find('.table__row-title').text()

    $.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php?action=remove_file_from_field',
        data: { postId: postId, fieldKey: fieldKey, fileName: fileName },
        beforeSend: function () {
            showLoadingScreen();
        },
        complete: function () {
            setTimeout(function(){
                hideLoadingScreen()
            }, 1000);
        },
        success: function(response) {
            let updatedHtml =
            '<div class="table__row">\
                <div class="table__row-form">\
                    <form method="post" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" class="file-field" enctype="multipart/form-data">\
                        <input type="file" class="file" accept=".xls, .xlsm, .pdf, .docx">\
                        <button type="button" class="table__row-upload table__row-upload--repeater">Upload file</button>\
                    </form>\
                </div>\
            </div>'

            el.replaceWith(updatedHtml)
        },
        error: function(error) {
            alert('Error removing file from field.')
        }
    })
}

function deleteRepeater(el) {
    let rmBtn = el
    let postId, fieldKey, rowId, fileName
    if(!rmBtn.hasClass('table__foot-removecategory')) {
        postId = rmBtn.closest('.table__row').data('post-id')
        fieldKey = rmBtn.closest('.table__row').data('field-key')
        rowId = parseInt(rmBtn.closest('.table__row').data('row-index'))
        fileName = rmBtn.closest('.table__row').find('.table__row-title').text()
    } else {
        postId = rmBtn.closest('.table').data('post-id')
        fieldKey = rmBtn.closest('.table').data('repeater-field-key')
        rowId = parseInt(rmBtn.closest('.table').data('row'))
        fileName = rmBtn.closest('.table').find('.table__row-title').text()
    }

    $.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php?action=delete_repeater_row',
        data: { postId: postId, fieldKey: fieldKey, rowId: rowId, fileName: fileName },
        beforeSend: function () {
            showLoadingScreen();
        },
        complete: function () {
            setTimeout(function(){
                hideLoadingScreen()
            }, 700);
        },
        success: function(response) {
            let currentRow, rows
            if(!rmBtn.hasClass('table__foot-removecategory')) {
                currentRow = rmBtn.closest('.table__row')

                if(rmBtn.closest('.table').hasClass('table--new')) {
                    currentRow.closest('.table--new').remove()
                } else {
                    currentRow.remove()
                }

                rows = rmBtn.closest('.table__body').find('[data-row-index]')
                rows.each(function(i) {
                    el.attr('data-row-index', i + 1)
                })
            } else {
                rows = rmBtn.closest('.content').find('.card.photos:not(#add-room-category)')

                currentRow = rmBtn.closest('.card')
                currentRow.remove()

                let row = rmBtn.closest('.content').find('.card.photos:not(#add-room-category)').data('row')
                rows.each(function(i) {
                    $(this).find('[data-row]').attr('data-row', i)
                })
            }

        },
        error: function(error) {
            alert('Error deleting row.');
        }
    })
}

function deleteImageFromGallery(el) {
    let imageID = el.data('image-id');
    let postID = el.data('post-id');
    let fieldKey = el.data('field-key');
    let rowId = el.closest('[data-row]').data('row')
    let repeaterFieldKey = el.closest('[data-repeater-field-key]').data('repeater-field-key')

    $.ajax({
        url: '/wp-admin/admin-ajax.php?action=delete_gallery_image',
        type: 'POST',
        data: { image_id: imageID, post_id: postID, field_key: fieldKey, repeater_field_key: repeaterFieldKey, row_id: rowId },
        beforeSend: function () {
            showLoadingScreen();
        },
        complete: function () {
            setTimeout(function(){
                hideLoadingScreen()
            }, 1000);
        },
        success: function(response) {
            if(el.hasClass('table__gallery-delete')) {
                el.closest('figure').remove()
            } else {
                el.closest('.table__row').remove()
            }
        },
        error: function(error) {
            alert('Error deleting image.');
        }
    });
}

function uploadFile(el) {
    let btn = el
    let formData = new FormData()
    let fileInput = el.parent().find('.file')[0]
    let form = el.closest('form')
    let sectionName = el.closest('.card').find('h3').text()

    let postId = form.data('post-id')
    let fieldKey = form.data('field-key')
    let fileFieldKey = form.data('file-field-key')

    let rowId = el.closest('.table__row').data('row-index')

    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0])
        formData.append('postId', postId)
        formData.append('fieldKey', fieldKey)
        formData.append('sectionname', sectionName)

        if(btn.hasClass('table__row-upload--repeater')) {
            formData.append('rowId', rowId)
            formData.append('file_field_Key', fileFieldKey)

            form = btn.closest('.table__row')

            titleChange(el)
        }

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
                setTimeout(function(){
                    hideLoadingScreen()
                }, 1000);
            },
            success: function(response) {
                let fileUrl = response.data.file_url
                let filename = response.data.file_name
                let icon = getFileIcon(fileUrl)

                fileUrl = getServiceUrl(fileUrl);
                
                let updatedHtml =
                '<div data-post-id="'+postId+'" data-field-key="'+fieldKey+'" class="table__row">\
                    <span class="table__row-title">'+icon+filename+'</span>\
                    <div class="table__row-controls">\
                        <button class="table__row-controls-view" data-url="'+fileUrl+'">View</button>\
                        <button class="table__row-controls-delete">Remove</button>\
                        <button class="table__row-controls-share"><span class="material-symbols-outlined">share</span></button>\
                    </div>\
                </div>';
                let updatedRepeaterHtml =
                    '<div data-row-index="'+rowId+'" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-file-field-key="'+fileFieldKey+'" class="table__row">\
                        <span class="table__row-title">'+icon+filename+'</span>\
                        <div class="table__row-controls">\
                            <button class="table__row-controls-view" data-url="'+fileUrl+'">View</button>\
                            <button class="table__row-controls-delete">Remove</button>\
                            <button class="table__row-controls-share"><span class="material-symbols-outlined">share</span></button>\
                        </div>\
                    </div>';

                if(btn.hasClass('table__row-upload--repeater')) {
                    form.find('.table__row-controls').remove()
                    form.replaceWith(updatedRepeaterHtml)
                } else {
                    form.replaceWith(updatedHtml)
                }
            },
            error: function(error) {
                alert('Error uploading file.')
            }
        })
    } else {
        alert('Please select a file to upload.')
    }
}

function colorFontAdd(el) {
    let btn = el
    let form = el.closest('form')
    let postId = form.data('post-id')
    let fieldKey = form.data('field-key')
    let titleFieldKey = form.data('title-key')
    let colorFieldKey = form.data('colour-key')
    let fontFieldKey = form.data('font-key')
    let rowId = el.closest('.table__row').data('row-index')
    let title = el.parent().find('.title-field').val()
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
            setTimeout(function(){
                hideLoadingScreen()
            }, 1000);
        },
        success: function(response) {
            if(btn.closest('form').find('.color-field').length !== 0) {
                btn.closest('.table__row-form').html(
                '<span class="table__row-title">\
                    <span>\
                        <input type="text" placeholder="'+title+'" value="'+title+'" disabled>\
                        <span class="table__row-colour color-field" style="background-color: '+color+'"></span>\
                    </span>\
                </span>')
            } else if(btn.closest('form').find('.font-field').length !== 0) {
                btn.closest('.table__row-form').html(
                '<div data-row-index="'+rowId+'" data-post-id="'+postId+'" data-field-key="'+fieldKey+'" data-title-key="'+titleFieldKey+'" data-colour-key="'+fontFieldKey+'" class="table__row">\
                    <span class="table__row-title">\
                        <span>\
                            <strong>Font name:</strong> '+title+' <strong>Font family: </strong>'+font+'\
                        </span>\
                    </span>\
                </div>')
            }
        },
        error: function(error) {
            alert('Error adding new row.');
        }
    });
}

function galllery(el) {
    let btn = el
    let formData = new FormData()
    let fileInput = el.parent().find('input[type=file]')[0]
    let form = el.closest('form')
    let type = el.siblings('input[type=file]').attr('name')

    let postId = form.data('post-id')
    let fieldKey = form.data('field-key')
    let fileFieldKey = form.data('file-field-key')
    let nameField = el.siblings('input[type=file]').attr('name').replace('[]', '')
    let rowId = el.closest('.table').data('row')

    if (fileInput.files.length > 0) {
        for (let i = 0; i < fileInput.files.length; i++) {
            formData.append(type, fileInput.files[i]);
        }

        formData.append('post_id', postId);
        formData.append('field_key', fieldKey);
        formData.append('name_field', nameField);
    
        formData.append('row_id', rowId);
        formData.append('file_field_Key', fileFieldKey);

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
                setTimeout(function(){
                    hideLoadingScreen()
                }, 1000);
            },
            success: function(response) {
                let imageUrls = response.data.imageUrls
                let attatchIds = response.data.attach_ids

                var filteredImageUrls = imageUrls.filter(function(url) {
                    return url !== false;
                });

                btn.closest('.table').find('.table__modal').removeClass('table__modal--active')
                btn.closest('.table').find('.table__body').css('display', 'flex')

                $.each(filteredImageUrls, function(i, value) {
                    if(btn.closest('.table--gallery').find('.table__body .simplebar-content').length) {
                        btn.closest('.table--gallery').find('.table__body .simplebar-content').append(
                        '<div class="table__row">\
                            <span class="table__row-title">\
                                <figure data-image-id="'+attatchIds[i]+'"><img src="'+window.location.origin+'/wp-content/themes/partnerhub/assets/img/photo-icon.svg" alt="'+value.split('/').pop()+'"></figure>\
                                '+value.split('/').pop()+'\
                            </span>\
                            <div class="table__row-controls">\
                                <a href="'+value+'" title="'+value.split('/').pop()+'" target="_blank">View</a>\
                                <span class="table__row-controls-delete" data-image-id="'+attatchIds[i]+'" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove</span>\
                            </div>\
                        </div>')
                    } else {
                        btn.closest('.table--gallery').find('.table__body').append(
                        '<div class="table__row">\
                            <span class="table__row-title">\
                                <figure data-image-id="'+attatchIds[i]+'"><img src="'+window.location.origin+'/wp-content/themes/partnerhub/assets/img/photo-icon.svg" alt="'+value.split('/').pop()+'"></figure>\
                                '+value.split('/').pop()+'\
                            </span>\
                            <div class="table__row-controls">\
                                <a href="'+value+'" title="'+value.split('/').pop()+'" target="_blank">View</a>\
                                <span class="table__row-controls-delete" data-image-id="'+attatchIds[i]+'" data-post-id="'+postId+'" data-field-key="'+fieldKey+'">Remove</span>\
                            </div>\
                        </div>')
                    }
                })

                btn.parent().find('input[type=file]').val('')
            },
            error: function(xhr, status, error) {
                alert('Error uploading file.');
            }
        })
    } else {
        alert('Please select a file to upload.')
    }
}

function removeImages(el) {
    let btn = el
    let postId = el.closest('.table').data('post-id')
    let fieldKey = el.closest('.table').data('field-key')
    let repeaterFieldKey = el.closest('.table').data('repeater-field-key')
    let rowId = el.closest('.table').data('row')

    let formData = new FormData()

    formData.append('post_id', postId)
    formData.append('fieldKey', fieldKey)
    formData.append('repeater_field_Key', repeaterFieldKey)
    formData.append('row_id', rowId)

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
            setTimeout(function(){
                hideLoadingScreen()
            }, 1000);
        },
        success: function(response) {
            // btn.closest('.gallery').find('.gallery__images').empty()
            btn.closest('.table--gallery').find('.table__body').empty().hide()
            btn.siblings('span:not(.table__foot-addgallery)').remove()
            btn.remove()
        },
        error: function(error) {
            alert(error.responseText);
        }
    })
}

function getFileIcon(url) {
    if (!url) {
        return ''
    }

    const extension = url.split('.').pop().toLowerCase()
    let color = '#434343'

    switch (extension) {
        case 'pdf':
            color = '#fc5f4c'
            break
        case 'xls':
        case 'xlsx':
        case 'xlsm':
            color = '#107c41'
            break
        case "docx":
        case "doc":
            color = "#285395";
            break
    }

    const svgIcon = `
        <figure>
            <svg id="eB0JEjPqx6d1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 49" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">
                <path d="M4.615079,2.653579L27.5022,2.570655l8.872906,10.531393v32.920968h-31.760027v-43.369437Z" fill="none" stroke="#434343" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M26.38157,2.570652v10.531393h9.993536L27.5022,2.570652h-1.12063Z" transform="translate(0 0.000003)" fill="#434343" stroke="#434343" stroke-width="0.5" stroke-linejoin="round"/>
                <path d="M2.031101,24.296836L31.958601,24.5v14.422172h-29.9275v-14.625336Z" fill="${color}" stroke="${color}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </figure>
    `

    return svgIcon
}

function titleChange(el) {
    let title = el.closest('.card').find('.card__header h3').text()

    if(title == 'A La Carte Services') {
        title = 'Services'
    }

    el.closest('.card__body').find('.table__foot-addrow').text('Add ' + title)
}

function addRoomCategorie (el) {
    if(el.siblings('input').val() == '') {
        if(!el.hasClass('card__body-room-addroom--custom')) {
            alert('Type the room category.')
        } else {
            alert('Type the custom gallery name.')
        }

        el.siblings('input').focus().css('border', '1px solid #fd604c')
        return
    }

    let btn = el
    let postId = el.data('post-id')
    let fieldKey = el.data('field-key')
    let galleryFieldKey = el.data('gallery-field-key')
    let category = el.closest('.card__body').find('.card__body-room input').val()
    let rowId
    let cardTable

    if(!el.hasClass('card__body-room-addroom--custom')) {
        cardTable = el.closest('.content').find('.card.photos:last-of-type .table')
    } else {
        cardTable = el.closest('.content').find('.content__customrooms .card.photos:last-of-type .table')
    }

    if(cardTable.length > 0) {
        rowId = parseInt(cardTable.data('row') + 1)
    } else {
        rowId = 1
    }

    let formData = new FormData()
    formData.append('post_id', postId)
    formData.append('field_key', fieldKey)
    formData.append('category', category)

    $.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php?action=add_room_category',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            showLoadingScreen();
        },
        complete: function () {
            setTimeout(function(){
                hideLoadingScreen()
            }, 1000);
        },
        success: function(response) {
            let btnAppend
            btn.siblings().val('')

            if(!el.hasClass('card__body-room-addroom--custom')) {
                btnAppend = btn.closest('.content')
            } else {
                btnAppend = btn.closest('.content').find('.content__customrooms')
            }

            btnAppend.append(`
            <div class="card photos" id="">
                <div class="card__header"><h3>${category}</h3></div>
                <div class="card__body">
                    <div class="table table--gallery" data-post-id="${postId}" data-repeater-field-key="${fieldKey}" data-field-key="${galleryFieldKey}" data-row="${rowId}">
                        <div class="table__header"></div>
                        <div class="table__body" data-simplebar="init"></div>
                        <div class="table__modal">
                            <form method="post" data-post-id="${postId}" data-field-key="${galleryFieldKey}" class="gallery-field"
                                enctype="multipart/form-data">
                                <input type="file" accept="image/*" name="${category.replace(/\s/g, '')}[]" multiple="" required="">
                                <button type="button" class="upload-gallery">Submit</button>
                            </form>
                        </div>
                        <div class="table__foot">
                            <span class="table__foot-back">Go back</span>
                            <span class="table__foot-removecategory">Remove room category</span>
                            <span class="table__foot-removeimages" data-field-key="${fieldKey}">Remove images</span>
                            <span class="table__foot-viewgallery">View in gallery</span>
                            <span class="table__foot-addgallery">Upload new picture</span>
                        </div>
                    </div>
                </div>
            </div>`)

            btn.closest('.content').find('.card:last-of-type').get(0).scrollIntoView({behavior: 'smooth'})
        },
        error: function(error) {
            alert(error.responseText);
        }
    });
}