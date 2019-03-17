$(document).ready(function() {
	$('.start').on('click', function(){
		var sender = $('.sender').val();
		var recipient = $('.recipient').val();
		var sum = $('.sum').val();
        
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
            	alert("Ошибка. Возможно у отправителя недостаточная сумма.");
            }
        })
    });
});

function resultTransaction(data) {
	var str = '';

	str += '<p>Отправитель: ' + data.sender + 
	'</p><p>Баланс: ' + data.sumSend + 
	'</p><p>Получатель: ' + data.recipient + 
	'</p><p>Баланс: ' + data.sumRecipient + '</p>';
	
	$('.result').html(str);
}