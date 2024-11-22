$(document).ready(function(){
    var quesionsList = [];
    function getBankInfoById(bankID){
        $.ajax({
            url: 'process.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'requestEditBank',
                bankID: bankID
            },
            success: function(data){
                console.log(data);
            },
            error: function(xhr, status, error){
                console.log(error);
            }
        });
    }
    function addQuestionRequest(bankID){
        window.location.href = 'questionsAddition.php?bankID=' + bankID;
    };
    $('.editQuestionsBank-btn').click(function(){
        let row = $(this).closest('tr');
        questionsBankId = $(row).find('#questionBankID').val();
        getBankInfoById(questionsBankId);
        window.location.href = 'questionsBankForm.php';
    });
    $('#addQuestionBtn').click(function(){
        var question = {
            description: $('#question').val(),
            answerID: $('#correctAnswer').val(),
            level: $('#level').val(),
            listAnswer: []
        };
        question.listAnswer['A'] = $('#optionA').val();
        question.listAnswer['B'] = $('#optionB').val();
        question.listAnswer['C'] = $('#optionC').val();
        question.listAnswer['D'] = $('#optionD').val();
        quesionsList.push(question);
    });
    $("#backToQuestionsBankForm").click(function(){
        window.location.href = 'questionsBankForm.php';
        if(bankMode == 'add'){
            $('#quesBankName').val(newBank.BankName == '' ? '' : newBank.BankName);
            $('#subject').val(newBank.Subject == '' ? '' : newBank.Subject);
        }
    });
    $(".deleteQuestionsBank-btn").click(function(){
        let row = $(this).closest('tr');
        questionsBankId = $(row).find('#questionBankID').val();
        $.ajax({
            url: 'process.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'deleteQuestionsBank',
                bankID: questionsBankId
            },
            success: function(data){
                if(data.success){
                    window.location.reload();
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(error);
            }
        });
    });
    $('.addQuestion-btn').click(function(bankID){
        addQuestionRequest(bankID);
    });
});