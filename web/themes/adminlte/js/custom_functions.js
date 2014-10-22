$(document).ready(function () {

    //activate tab by #anchor on load page
    if (window.location.hash != "" && $('a[href="' + window.location.hash + '"]').length != 0) {
        $('a[href="' + window.location.hash + '"]').click()
    }
    
    $('.load-payments').click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var contract_id = $this.attr('data-id');
        var load_url = $this.attr('href');
        var container = $this.attr('data-pjax');
        $('#payment-contract_id').attr('readonly', 'readonly').val(contract_id);
        $(container).attr('data-grid-selector',$this.attr('class'));
        
        $('tr').removeClass('bg-success');
        $('tr[data-key="'+contract_id+'"]').addClass('bg-success');
        $.pjax.reload({container: container, history: false, replace: false, timeout: 10000, url: load_url});
    });
    $('.load-tickets').click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var contract_id = $this.attr('data-id');
        var load_url = $this.attr('href');
        var container = $this.attr('data-pjax');
        $(container).attr('data-grid-selector',$this.attr('class'));
        $('tr').removeClass('bg-success');
        $('tr[data-key="'+contract_id+'"]').addClass('bg-success');
        $.pjax.reload({container: container, history: false, replace: false, timeout: 10000, url: load_url});
    });

    $('.printActForm').on('submit',
        function (e) {
            var $this=$(this);
            e.preventDefault();
            $this.parent().find('iframe')[0].height=500;
            $this.parent().find('iframe')[0].src=$this.attr("action")+'?'+$this.serialize();
        }
    );
});
// serialize form, render response and close modal
    function submitForm(e) {
        var $this = $(this);
        $.post($this.attr("action"), $this.serialize())
            .done(function (result) {
                if (typeof result == 'object')
                {
                    $this.parent().html(result.data);
                } else
                    $this.parent().html(result);
            }).success(function (data) {
            setTimeout(function () {
                $('.alert button[class="close"]').click();
            }, 3000);
            if (typeof data == 'object' && data.hasOwnProperty('message') && data.message == "success")
            {
                if (typeof e.data === "object" && e.data.hasOwnProperty('successHndl') && $.isFunction(e.data.successHndl))
                {
                    e.data.successHndl.call();
                }
            }
        }).fail(function () {
            console.log("server error");
            $this.replaceWith('SERVER ERROR').fadeOut()
        });
        return false;
    }

    function reloadGrid(selector,id){
        $(selector).filter('a[data-id="' + id + '"]').click();
        reloadBalance(id);
    }

    function reloadBalance(id)
    {
        if (!id) return;
        else {
            $('#balance-'+id).load($("#contract_grid table").attr('data-balanceloadurl')+'/'+id);
        }
    }

function handlePaymentFormActions() {
    
    
    //Handle Payment Create Modal
    $('#paymentMdlOpen').click(function () {
        var cid = $('#payment-contract_id').val();
        var sel_payment = $('input[name="payments"]:checked').val();
        $('#paymentCreateDlg').modal('show').find('.modal-body').load($(this).attr('data-url'),{id:sel_payment}, function () {
            var saveHandler=function(){
                 $('#paymentCreateDlg').modal('hide');
                 setTimeout(function () {
                   reloadGrid('.load-payments',cid);
                }, 2000);
            }
            $('#payment_form').on('beforeSubmit', {successHndl: saveHandler}, submitForm);
            $('#payment_form').on('submit',
                    function (e) {
                        e.preventDefault();
                    }
            );
        });
        $('#paymentCreateDlg').on('hidden.bs.modal', function () {
            reloadGrid('.load-payments',cid);
        })
    });
    
    //Handle Ticket Create Modal
    $('#ticketMdlOpen').click(function () {
         var cid = $('#ticket-contract_id').val();
        $('#ticketCreateDlg').modal('show').find('.modal-body').load($(this).attr('data-url'),function () {
            var saveHandler = function () {
                $('#ticketCreateDlg').modal('hide');
                if ($('#ticket-ticket_count').length > 0)
                    window.open($('#ticketPrintCountForm').attr('data-printurl'));
                //reload ticket grid
                setTimeout(function () {
                   reloadGrid('.load-tickets',cid);
                }, 1000);
            }
            $('#ticketPrintCountForm').on('beforeSubmit', {successHndl: saveHandler}, submitForm);
            $('#ticketPrintCountForm').on('submit',
                    function (e) {
                        e.preventDefault();
                    }
            );
        });
    });
    
    $('#printTickets').click(function () {
        var url = $(this).attr('data-url');
        window.open(url);
    });
    
    //Handle invoice actions
    $('#printInvoiceForm').on('beforeSubmit', function (e) {
            var $this=$(this);
            e.preventDefault();
            $('#invoicePrintBtn').show();
            $this.parent().find('iframe')[0].height=500;
            $this.parent().find('iframe')[0].src=$this.attr("action")+'?'+$this.serialize();
        });
    $('#printInvoiceForm').on('submit',
        function (e) {
            e.preventDefault();
        }
    );
    $('#printInvoice').on('hidden.bs.modal', function () {
        var cid = $('#payment-contract_id').val();
        reloadGrid('.load-payments',cid);
    })
    $('#printInvoice').on('shown.bs.modal', function (e) {
        if ($('input[name="payments"]:checked').length >0)
            {
                $(this).find('.modal-body').load($(this).attr('data-url')+' #frame',{id:$('input[name="payments"]:checked').val()},function(data){
                    $(this).find('iframe')[0].src= $(this).find('iframe')[0].src;
                    $('#invoicePrintBtn').show();
                    $('#invoicePrintBtn').click(function(){
                        window.frames["invoicePrintFrame"].print();
                    })
                });
            }
    })
    
    $('#invoicePrintBtn').click(function(){
        window.frames["invoicePrintFrame"].print();
    })
    
    
    //Handle delete button
$('.deleteBtn').on('shown.bs.popover', function () {
    $('.confirm-delete').on('click',
        function (e) {
            e.preventDefault();
            var data = JSON.parse($(this).parents('tr').attr('data-key'));
            var grid_selector = $(this).closest('.pjax-wrapper').attr('data-grid-selector');
            $.get($(this).attr('href'),{},function(){
                reloadGrid('.'+grid_selector,data.contract_id);
            });
        }
    );
})
    
    
}