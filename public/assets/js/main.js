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

    function init() {
        ao.listen('click', '.close', close, reset);
        ao.listen('click', '[data-copy]', copy);
    }

    init();

})();
