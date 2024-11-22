$(document).ready(function(){
    // Lấy tất cả các ngân hàng câu hỏi
    var questionsBankId = '';
    $.ajax({
        url: 'process.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'getQuestionsByQuestionBankID',
            questionBankID: questionsBankId
        },
        success: function(data){
            console.log(data);
            $('#questionsTable tbody').empty();
            if(data.length > 0){
                $.each(data, function(index, question){
                    var questionNumber = index + 1;
                    var questionDescription = question.QuestionDescription;
                    var questionAnswerID = question.QuestionAnswerID;
                    var questionLevel = question.Level;
                    var listAnswer = question.ListAnswer;
                    let tr = "<tr>" + 
                    "<td scope='col'>" + questionNumber + "</td>" +
                    "<td scope='col'><textarea class='form-control' rows='3' readonly>" + questionDescription + "</textarea></td>" +
                    listAnswer.map(answer => "<td scope='col'><textarea class='form-control' rows='3' key=" + answer.AnswerID + " readonly>" + answer.AnswerDescription + "</textarea></td>").join('') +
                    "<td scope='col'>" + questionLevel + "</td>" +
                    "</tr>";
                    $('#questionsTable tbody').append(tr);
                });
                $("#questionsTable").find($('input').attr('key') == questionAnswerID).css('color', 'red');

            }else{
                $('#questionsTable tbody').append("<tr><td colspan='7' class='text-center'>Chưa có câu hỏi nào trong ngân hàng</td></tr>");
            }
        },
        error: function(xhr, status, error){
            console.log(error);
        }
    });


});