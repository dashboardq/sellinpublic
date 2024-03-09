(function() {

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
    }

    init();

})();
