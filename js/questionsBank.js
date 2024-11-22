$(document).ready(function(){
    // Chọn chế độ ngân hàng câu hỏi
    let bankMode = '';
    // ID ngân hàng câu hỏi
    let questionsBankId = '';
    let newBank = {
        BankName: '',
        Subject: '',
        QuestionList: []
    };
    let editBank = {
        BankName: '',
        Subject: '',
        QuestionList: []
    };
    var quesionsListTmp = [];
    // function addQuestion(){
    //     $('#addQuestionBtn').click(function(){
    //         var question = {
    //             QuestionDescription: $('textarea').val(),
    //             Level: $('select').val(),
    //             QuestionAnswerID: $('select').val(),
    //             ListAnswer: []
    //         }
    //         question.ListAnswer['A'] = $('textarea[name="optionA"]').val();
    //         question.ListAnswer['B'] = $('textarea[name="optionB"]').val();
    //         question.ListAnswer['C'] = $('textarea[name="optionC"]').val();
    //         question.ListAnswer['D'] = $('textarea[name="optionD"]').val();
            
    //         quesionsListTmp.push(question);
    //     });
    // }

    // function loadQuestions(quesionsList){
    //     $('#questionsTable tbody').empty();
    //     if(quesionsList.length > 0){
    //         $.each(data, function(index, question){
    //             var questionNumber = index + 1;
    //             var questionDescription = question.QuestionDescription;
    //             var questionAnswerID = question.QuestionAnswerID;
    //             var questionLevel = question.Level;
    //             var listAnswer = question.ListAnswer;
    //             let tr = "<tr value='" + question.QuestionID + "'>" + 
    //             "<td scope='col' >" + questionNumber + "</td>" +
    //             "<td scope='col'><textarea class='form-control' rows='3' readonly>" + questionDescription + "</textarea></td>" +
    //             "<td scope='col'>" + questionLevel + "</td>" +
    //             listAnswer.map(answer => "<td scope='col'><textarea class='form-control' rows='3' key=" + answer.AnswerID + " readonly>" + answer.AnswerDescription + "</textarea></td>").join('') +
    //             "</tr>";
    //             $('#questionsTable tbody').append(tr);
    //         });
    //         $("#questionsTable").find($('input').attr('key') == questionAnswerID).css('color', 'red');

    //     }else{
    //         $('#questionsTable tbody').append("<tr><td colspan='7' class='text-center'>Chưa có câu hỏi nào trong ngân hàng</td></tr>");
    //     }
    // }

    // function getQuestionByBankID(bankID){
    //     $.ajax({
    //         url: 'process.php',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {
    //             action: 'getQuestionsByQuestionBankID',
    //             questionBankID: questionsBankId
    //         },
    //         success: function(data){
    //             console.log(data);
    //             return data;
    //         },
    //         error: function(xhr, status, error){
    //             console.log(error);
    //         }
    //     });
    // }

    // var questionList = getQuestionByBankID(questionsBankId);
    // loadQuestions(questionList);
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

    $('#addQuestionsBank').click(function(){
        $.ajax({
            url: 'process.php',
            type: 'GET',
            dataType: 'json',
            data: {
                action: 'requestAddBank',
            },
            success: function(data){
                console.log(data);
            },
            error: function(xhr, status, error){
                console.log(error);
            }
        });
        window.location.href = 'questionsBankForm.php';
    });
    $('.editQuestionsBank-btn').click(function(){
        let row = $(this).closest('tr');
        questionsBankId = $(row).find('#questionBankID').val();
        getBankInfoById(questionsBankId);
        window.location.href = 'questionsBankForm.php';
    });
    $('#addQuestionBtn').click(function(){
        if(bankMode == 'add'){
            var question = {
                description: $('textarea[name="question"]').val(),
                answerID: $('select[name="correctAnswer"]').val(),
                level: $('select[name="level"]').val(),
                listAnswer: []
            };
            question.listAnswer['A'] = $('input[name="optionA"]').val();
            question.listAnswer['B'] = $('input[name="optionB"]').val();
            question.listAnswer['C'] = $('input[name="optionC"]').val();
            question.listAnswer['D'] = $('input[name="optionD"]').val();
            Bank.QuestionList.push(question);
        }
    });
    $("#backToQuestionsBankForm").click(function(){
        window.location.href = 'questionsBankForm.php';
        if(bankMode == 'add'){
            $('#quesBankName').val(newBank.BankName == '' ? '' : newBank.BankName);
            $('#subject').val(newBank.Subject == '' ? '' : newBank.Subject);
        }
    });
    
});