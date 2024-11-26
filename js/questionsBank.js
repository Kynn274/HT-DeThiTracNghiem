$(document).ready(function(){
    var quesionsList = [];

    function addQuestionRequest(bankID){
        console.log(bankID);
        $.ajax({
            url: 'process.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'requestAddQuestion',
                bankID: bankID
            },      
            success: function(data){
                if(data.success){
                    window.location.href = 'questionsAddition.php';
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(error, status, xhr);
            }
        });
    };
    // Form questionsAddition
    $(".editQuestion").hide();
    $('.editQuestionBtn').click(function(){
        let questionItem = $(this).closest('.questionItem');
        
        let editRow = questionItem.next('.editQuestion');
        
        $('.editQuestion').not(editRow).hide();
        
        editRow.slideToggle();
    });
    $('.saveEditBtn').click(function(){
        let editRow = $(this).closest('.editQuestion');
        let questionID = $(editRow).find('#editQuestionID').val();
        let questionDescription = $(editRow).find('#editQuestionDescription').val();
        let level = $(editRow).find('#editLevel').val();
        let optionA = $(editRow).find('#editOptionA').val();
        let optionB = $(editRow).find('#editOptionB').val();
        let optionC = $(editRow).find('#editOptionC').val();
        let optionD = $(editRow).find('#editOptionD').val();
        let correctAnswer = $(editRow).find('#editCorrectAnswer').val();
        let answerIDA = $(editRow).find('#editAnswerIDA').val();
        let answerIDB = $(editRow).find('#editAnswerIDB').val();
        let answerIDC = $(editRow).find('#editAnswerIDC').val();
        let answerIDD = $(editRow).find('#editAnswerIDD').val();
        
        $.ajax({
            url: 'process.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'editQuestion',
                questionID: questionID,
                questionDescription: questionDescription,
                level: level,
                optionA: optionA,
                optionB: optionB,
                optionC: optionC,
                optionD: optionD,
                correctAnswer: correctAnswer,
                answerIDA: answerIDA,
                answerIDB: answerIDB,
                answerIDC: answerIDC,
                answerIDD: answerIDD
            },
            success: function(data){
                if(data.success){
                    window.location.reload();
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(error, status, xhr);
            }
        });
    });
    $('.deleteQuestionBtn').click(function(){
        let row = $(this).closest('tr');
        let questionID = $(row).find('#questionID').val();
        console.log(questionID);
        $.ajax({
            url: 'process.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'deleteQuestion',
                questionID: questionID
            },
            success: function(data){
                if(data.success){
                    window.location.reload();
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(error, status, xhr);
            }
        });
    });
    $("#addQuestionBtn").click(function(){
        const questionBankID = $('#questionBankID_add').val();
        const question = $('#question').val();
        const optionA = $('#optionA').val();
        const optionB = $('#optionB').val();
        const optionC = $('#optionC').val();
        const optionD = $('#optionD').val();
        const correctAnswer = $('#correctAnswer').val();
        const level = $('#level').val();
        console.log(questionBankID, question, optionA, optionB, optionC, optionD, correctAnswer, level);
        $.ajax({
            url: 'process.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'addQuestionToBank',
                bankID: questionBankID,
                question: question,
                optionA: optionA,
                optionB: optionB,
                optionC: optionC,
                optionD: optionD,
                correctAnswer: correctAnswer,
                level: level
            },
            success: function(data){
                if(data.success){
                    window.location.reload();
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(error, status, xhr);
            }
        });
    });

    // Form questionsBank
    $('.editQuestionsBank-btn').click(function(){
        let row = $(this).closest('tr');
        questionsBankId = $(row).find('#questionBankID').val();
        $.ajax({
            url: 'process.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'requestEditBank',
                bankID: questionsBankId
            },
            success: function(data){
                if(data.success){
                    window.location.href = 'questionsBankForm.php';
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(error);
            }
        });
    });
    $("#addQuestionsBank").click(function(){
        $.ajax({
            url: 'process.php',
            type: 'GET',
            dataType: 'json',
            data: {
                action: 'requestAddBank'
            },
            success: function(data){
                console.log(data);
                if(data.success){
                    window.location.href = 'questionsBankForm.php';
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error){
                console.log(error, status, xhr);
            }
        });
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
    $('.addQuestion-btn').click(function(){
        let row = $(this).closest('tr');
        let questionsBankId = $(row).find('#questionBankID').attr('value');
        addQuestionRequest(questionsBankId);
    });
    $("#backToQuestionsBank").click(function(){
        window.location.href = 'questionsBank.php';
        
    });
});