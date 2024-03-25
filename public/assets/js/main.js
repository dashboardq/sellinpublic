(function() {

    function changeFileProfile(e) {
        // Max size is 1MB
        var max_total_bytes = 1 * 1024 * 1024;
        var $el = e.target;
        var $profile = $el.closest('.profile');
        var $img = $profile.querySelector('img');
        var $node;
        var $parent;
        var $media_id = ao.qs('[name=media_id]');
        var url = '/ajax/upload/create';
        var url_chunked = '';
        var url_completed = '';
        var payload = {};
        var data;
        var file;

        if($el.files && $el.files[0]) {
            file = $el.files[0];
            console.log(file);
            if(file.size > max_total_bytes) {
                _ao.error('The selected file is too large. Files cannot exceed 1MB.');
                $el.value = '';
            } else {
                ao.qs('#processing.overlay').classList.add('show');

                payload.total_bytes = file.size;
                payload.name = file.name;
                payload.extension = '.invalid';
                payload.upload_type = 'profile';
                if(file.type == 'image/png') {
                    payload.extension = '.png';
                } else {
                    payload.name = 'profile';
                    payload.extension = '.jpg';
                }
                ao.post(url, payload, function(err, response) {
                    if(err) {
                        ao.qs('#processing.overlay').classList.remove('show');
                        _ao.error(response);
                        $el.value = '';
                    } else {
                        data = JSON.parse(response);
                        url_chunked = '/ajax/upload/' + data.id + '/chunked';
                        url_completed = '/ajax/upload/' + data.id + '/completed';
                        chunk(url_chunked, file, 0, function(err, response, total_chunks) {
                            if(err) {
                                ao.qs('#processing.overlay').classList.remove('show');
                                _ao.error(response);
                                $el.value = '';
                            } else {
                                payload = {};
                                payload.total_chunks = total_chunks;
                                ao.post(url_completed, payload, function(err, response) {
                                    if(err) {
                                        ao.qs('#processing.overlay').classList.remove('show');
                                        _ao.error(response);
                                        $el.value = '';
                                    } else {
                                        data = JSON.parse(response);
                                        $media_id.value = data.id;
                                        $img.src = data.url;
                                        $node = document.createElement('div');
                                        $node.innerHTML = '<div class="notice warn"><p>Press the update button below to save the uploaded image as your profile image.</p></div>';
                                        $parent = $profile.parentNode;
                                        $parent.insertBefore($node, $profile);
                                        ao.qs('#processing.overlay').classList.remove('show');
                                        $el.value = '';
                                    }
                                });
                            }
                        });
                    }
                });

            }
        }
    }

    function chunk(url, file, index, cb) {
        //var chunk_size = 1024;
        var chunk_size = 1 * 1024 * 1024;
        var size = file.size;
        var sent = index * chunk_size;
        var new_sent = sent + chunk_size;
        var payload = {};
        var blob = file.slice(sent, new_sent);
        var reader = new FileReader();
        var payload = new FormData();
        payload.append('index', index);
        payload.append('chunk', blob);

        //payload.index = index;
        //payload.chunk = reader.readAsBinaryString(blob);

        ao.post(url, payload, function(err, response) {
            if(err) {
                cb(err, response);
            } else {
                if(new_sent < size) {
                    index++
                    chunk(url, file, index, cb);
                } else {
                    // Increase one more time for the total.
                    index++
                    cb(err, response, index);
                }
            }
        });
    }

    function clickAddText(e) {
        var $counter = ao.qs('[name=attachment_count]');
        var attachments = $counter.value;
        var $attachments = ao.qs('.attachments');
        var $div = document.createElement('div');
        $div.innerHTML = '<div class="attachment attachment_type_text"><input type="hidden" name="attachment_type_' + attachments + '" value="text" /><p><button class="remove_attachment">Remove</button></p><textarea name="attachment_text_' + attachments + '" placeholder="Add additional content..."></textarea></div>';

        $attachments.appendChild($div.firstChild);

        attachments++;
        $counter.value = attachments;
    }

    function clickHide(e) {
        var $el = e.target.closest('.shown');
        $el.classList.remove('shown');
        $el.classList.add('hidden');
    }

    function clickRemoveAttachment(e) {
        var $counter = ao.qs('[name=attachment_count]');
        var attachments = $counter.value;
        var $attachment = e.target.closest('.attachment');
        $attachment.remove();

        attachments--;
        $counter.value = attachments;
    }

    function clickShow(e) {
        var $el = e.target.closest('.hidden');
        $el.classList.remove('hidden');
        $el.classList.add('shown');
    }

    function clickUpload(e) {
        e.target.closest('.profile').querySelector('.file');
    }

    function close(e) {
        var $el = e.target.closest('.show');

        if($el) {
            $el.classList.remove('show');
        }
    }

    function copy(e) {
        console.log('clickCopy');       
        var content = e.target.getAttribute('data-copy');
        var holder = document.createElement('textarea');
        holder.value = content;          
        document.body.appendChild(holder);
        holder.select();                
        holder.setSelectionRange(0, 99999); /*For mobile devices*/
        document.execCommand('Copy');   
        holder.remove();
    }

    function inputTextarea(e) {
        var $textarea = e.target;
        var id = $textarea.id;
        var $counter = ao.qs('[data-watch="#' + id + '"]');
        if($counter) {
            var length = $textarea.value.length;
            var max = $counter.getAttribute('data-max');
            var remaining = max - length;
            $counter.innerText = max + ' characters max / ' + remaining + ' characters remaining';
        }
    }

    function postURL(e) {
        var $a;
        var $group;
        if(e.target.matches('a')) {
            $a = e.target;
        } else {
            $a = e.target.closest('a');
        }

        $group = $a.closest('.group');

        //var $a = e.target;
        $a.disabled = true;
        $group.classList.add('process');

        var url = $a.getAttribute('href');

        ao.post(url, {}, function(err, response) {
            var data;
            $a.disabled = false;
            $group.classList.remove('process');

            if(err) {
                _ao.error(response);
            } else {
                // Mark the notification section as unread.
                if($group.classList.contains('flagged')) {
                    $group.classList.remove('flagged');
                    $group.classList.add('unflagged');
                } else if($group.classList.contains('starred')) {
                    $group.classList.remove('starred');
                    $group.classList.add('unstarred');
                } else if($group.classList.contains('unflagged')) {
                    $group.classList.remove('unflagged');
                    $group.classList.add('flagged');
                } else if($group.classList.contains('unstarred')) {
                    $group.classList.remove('unstarred');
                    $group.classList.add('starred');
                }
            }
        });
    }

    function reset(e) {
        var $el = e.target.closest('div');
        var $textarea;

        if($el) {
            $textarea = $el.querySelector('textarea');

            if($textarea) {
                $textarea.value = '';
            }
        }
    }

    function submitAllRead(e) {
        var $form = e.target;
        var $button = $form.querySelector('button');
        var original_content = $button.textContent;
        $button.disabled = true;
        $button.classList.add('process');
        $button.textContent = 'Processing...';

        _ao.submit(e, function(err, response) {
            var data;
            $button.disabled = false;
            $button.classList.remove('process');
            $button.textContent = original_content;

            if(err) {
                _ao.error(response);
            } else {
                // Mark each notification section as read
                ao.qsa('.notification').forEach(function($item) {
                    $item.classList.add('read');
                    $item.classList.remove('unread');
                });

                // Decrease notification count
                var $notification_count = ao.qs('.notification_count');
                var new_count = 0;
                $notification_count.setAttribute('data-count', new_count);
                $notification_count.textContent = '(' + new_count + ')';
            }
        });
    }

    function submitRead(e) {
        var $form = e.target;
        var $button = $form.querySelector('button');
        var original_content = $button.textContent;
        $button.disabled = true;
        $button.classList.add('process');
        $button.textContent = 'Processing...';

        _ao.submit(e, function(err, response) {
            var data;
            $button.disabled = false;
            $button.classList.remove('process');
            $button.textContent = original_content;

            if(err) {
                _ao.error(response);
            } else {
                // Mark the notification section as read.
                $form.closest('.unread').classList.add('read');
                $form.closest('.unread').classList.remove('unread');

                // Decrease notification count
                var $notification_count = ao.qs('.notification_count');
                var new_count = $notification_count.getAttribute('data-count') - 1;
                if(new_count < 0) {
                    new_count = 0;
                }
                $notification_count.setAttribute('data-count', new_count);
                $notification_count.textContent = '(' + new_count + ')';
            }
        });
    }

    function submitUnread(e) {
        var $form = e.target;
        var $button = $form.querySelector('button');
        var original_content = $button.textContent;
        $button.disabled = true;
        $button.classList.add('process');
        $button.textContent = 'Processing...';

        _ao.submit(e, function(err, response) {
            var data;
            $button.disabled = false;
            $button.classList.remove('process');
            $button.textContent = original_content;

            if(err) {
                _ao.error(response);
            } else {
                // Mark the notification section as unread.
                $form.closest('.read').classList.add('unread');
                $form.closest('.read').classList.remove('read');

                // Increase notification count
                var $notification_count = ao.qs('.notification_count');
                var new_count = $notification_count.getAttribute('data-count') - 0 + 1;
                $notification_count.setAttribute('data-count', new_count);
                $notification_count.textContent = '(' + new_count + ')';
            }
        });
    }

    function init() {
        ao.listen('click', '.close', close, reset);
        ao.listen('click', '[data-copy]', copy);

        ao.listen('submit', '.mark_all_read', submitAllRead);
        ao.listen('submit', '.mark_read', submitRead);
        ao.listen('submit', '.mark_unread', submitUnread);

        ao.listen('click', 'a.flag', postURL);
        ao.listen('click', 'a.star', postURL);
        ao.listen('click', 'a.unflag', postURL);
        ao.listen('click', 'a.unstar', postURL);

        ao.listen('click', '.show', clickShow);
        ao.listen('click', '.hide', clickHide);

        ////ao.listen('click', '.page_account .profile button', clickUpload);

        ao.listen('input', 'textarea', inputTextarea);

        ao.listen('change', '.profile [type=file]', changeFileProfile);

        ao.listen('click', '.remove_attachment', clickRemoveAttachment);
        ao.listen('click', '.add_text', clickAddText);
    }

    init();

})();
