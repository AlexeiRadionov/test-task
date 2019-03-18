$(document).ready(function() {
	$('.start').on('click', function(){
		var sender = $('#sender').val();
		var recipient = $('#recipient').val();
		if ($('.sum').val() != '') {
			var sum = $('.sum').val();
		}
        
        $.ajax({
            url: "/startTransaction/",
            type: "POST",
            data:{
                sender: sender,
                recipient: recipient,
                sum: sum
            },
            dataType : "json",
            success: function(answer){
                if(answer.result == 1) {
                    resultTransaction(answer);
                    alert("Перевод успешно совершён!");
                } else
                    alert("Что-то пошло не так...");
            },
            error: function() {
            	alert("Ошибка. Возможно у отправителя недостаточная сумма" + 
            		"\n или не заполнены все поля");
            }
        });
    });

    $('.user').on('change', function() {
        var user = this.value;
        var statusUser = $(this).attr('id');
       
        $.ajax({
            url: "/index/balance/",
            type: "POST",
            data:{
                user: user,
            },
            dataType : "json",
            success: function(answer){
                if(answer.result == 1) {
                    showBalance(answer, statusUser);
                } else
                    alert("Что-то пошло не так...");
            },
            error: function() {
            	alert("Ошибка");
            }
        });
    });
});

function resultTransaction(data) {
	var str = '';
	var balanceSender = '<p>Баланс: ' + data.sumSend + '</p>';
	var balanceRecipient = '<p>Баланс: ' + data.sumRecipient + '</p>';

	str += '<p>Отправитель: ' + data.sender + 
	'</p><p>Баланс: ' + data.sumSend + 
	'</p><p>Получатель: ' + data.recipient + 
	'</p><p>Баланс: ' + data.sumRecipient + '</p>';
	
	$('.result').html(str);
	$('.balanceSender').html(balanceSender);
	$('.balanceRecipient').html(balanceRecipient);
}

function showBalance(data, statusUser) {
	var str = '';

	str += '<p>Баланс: ' + data.balance + '</p>';
	if (statusUser == 'sender') {
		$('.balanceSender').html(str);
	} else if (statusUser == 'recipient') {
		$('.balanceRecipient').html(str);
	}
}