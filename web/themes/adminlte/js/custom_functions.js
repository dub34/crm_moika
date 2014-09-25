$(document).ready(function(){
    
    //activate tab by #anchor on load page
    if (window.location.hash !="" && $('a[href="' + window.location.hash + '"]').length !=0){
        $('a[href="' + window.location.hash + '"]').click()
    }
    
    
    $('.load-contracts').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var contract_id = $this.attr('data-id');
        var load_url = $this.attr('data-url');
        var container = $this.attr('data-container');
        $.pjax.reload({container:'#'+container,history: false,url:load_url,data:{'contract_id':contract_id}});
    });
    
    
    
});