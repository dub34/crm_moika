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
        $.pjax.reload({container: container, history: false, replace: false, timeout: 10000, url: load_url});
    });
    $('.load-tickets').click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var contract_id = $this.attr('data-id');
        var load_url = $this.attr('href');
        var container = $this.attr('data-pjax');
//        $('#payment-contract_id').attr('readonly','readonly').val(contract_id);
        $.pjax.reload({container: container, history: false, replace: false, timeout: 10000, url: load_url});
    });

    $('.print-act').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('#printAct-' + id).modal('show');
    });
   
    $('.printActForm').on('submit',
        function (e) {
            var $this=$(this);
            e.preventDefault();
//            $this.parent().find('.act').load($his.attr("action"), $this.serialize());
            $this.parent().find('.act')[0].height=500;
            $this.parent().find('.act')[0].src=$this.attr("action")+'?'+$this.serialize();
        }
    );
    // listen click, open modal and .load content
//$('#paymentMdlOpen').click(function (){
//    $('#paymentCreateDlg').modal('show')
//        .find('.modalContent')
//        .load($(this).attr('data-url'));
//});
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


function handlePaymentFormActions() {
    //Handle Payment Create Modal
    $('#paymentMdlOpen').click(function () {
        var cid = $('#payment-contract_id').val();
        $('#paymentCreateDlg').modal('show').find('.modal-body').load($(this).attr('data-url'), function () {
            $('#payment_form').on('beforeSubmit', submitForm);
            $('#payment_form').on('submit',
                    function (e) {
                        e.preventDefault();
                    }
            );
        });
        $('#paymentCreateDlg').on('hidden.bs.modal', function () {
            $('.load-payments').filter('a[data-id="' + cid + '"]').click();
        })
    });
    //Handle Ticket Create Modal
    $('#ticketMdlOpen').click(function () {
        $('#ticketCreateDlg').modal('show').find('.modal-body').load($(this).attr('data-url'), function () {
            var saveHandler = function () {
                $('#ticketCreateDlg').modal('hide');
                if ($('#ticket-ticket_count').length > 0)
                    window.open($('#ticketPrintCountForm').attr('data-printurl'));

                setTimeout(function () {
                    var cid = $('#ticket-contract_id').val();
                    $('.load-tickets').filter('a[data-id="' + cid + '"]').click();
                }, 1000);
            }
            $('#ticketPrintCountForm').on('beforeSubmit', {successHndl: saveHandler}, submitForm);
            $('#ticketPrintCountForm').on('submit',
                    function (e) {
                        e.preventDefault();
                    }
            );
        });
//        })
    });
    $('#printTickets').click(function () {
        var url = $(this).attr('data-url');
        window.open(url);
    });

//    $('#').on('hidden.bs.modal',function(){
//            $('.load-payments').filter('a[data-id="'+cid+'"]').click();
//    });


//    $('#ticketMdlOpen').click(function () {
//        $('#ticketCreateDlg').modal('show').find('.modal-body').load($(this).attr('data-url'),function(){
//                var saveHandler = function(){
//                    if ($('#ticket-ticket_count').length>0)
//                    {
//                        window.open($('#ticketPrintCountForm').attr('data-printurl'));
//                    }
//                }
//                $('#ticketPrintCountForm').on('beforeSubmit',{successHndl:saveHandler}, submitForm);
//                $('#ticketPrintCountForm').on('submit',
//                    function (e) {
//                        e.preventDefault();
//                    }
//                );
//        });
//        })
//    });s
}